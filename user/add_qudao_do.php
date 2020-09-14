<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.user.admin"])){
	$lguser = $_SESSION["huoma.user.admin"];

	// 数据库配置
	include '../MySql.php';

	// 创建连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

	// 获得表单POST过来的数据
	$qudao_title = $_POST["qudao_title"];
	$qudao_type = $_POST["qudao_type"];
	$qudao_content = $_POST["qudao_content"];
	$qudao_biaoqian = $_POST["qudao_biaoqian"];
	$qudao_id = rand(10000,99999);
	$qudao_yuming = $_POST["qudao_yuming"];

	if(empty($qudao_title)){
		$result = array(
			"result" => "101",
			"msg" => "标题不得为空"
		);
	}else if($qudao_yuming == ""){
		$result = array(
			"result" => "107",
			"msg" => "请选择渠道域名"
		);
	}else if(empty($qudao_type)){
		$result = array(
			"result" => "102",
			"msg" => "请选择渠道码类型"
		);
	}else if(empty($qudao_content)){
		$result = array(
			"result" => "103",
			"msg" => "请输入内容"
		);
	}else if(empty($qudao_biaoqian)){
		$result = array(
			"result" => "104",
			"msg" => "标签不得为空"
		);
	}else{
		mysqli_query($conn, "SET NAMES UTF-8"); //utf8 设为对应的编码
		// 当前时间
		$date = date("Y-m-d");
		// 插入数据库
		$sql = "INSERT INTO qun_huoma_qudao (qudao_title,qudao_type,qudao_biaoqian,qudao_content,qudao_yuming,qudao_id,qudao_pageview,qudao_update_time,qudao_adduser) VALUES ('$qudao_title', '$qudao_type', '$qudao_biaoqian', '$qudao_content', '$qudao_yuming', '$qudao_id', '0', '$date', '$lguser')";
		
		if ($conn->query($sql) === TRUE) {
		    $result = array(
				"result" => "100",
				"msg" => "添加成功"
			);
		} else {
		    $result = array(
				"result" => "106",
				"msg" => "添加失败，请检查数据库连接状态"
			);
		}
		
		// 断开数据库连接
		$conn->close();
	}
}else{
	$result = array(
		"result" => "105",
		"msg" => "未登录"
	);
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>