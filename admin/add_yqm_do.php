<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.admin"])){
	$lguser = $_SESSION["huoma.admin"];

	// 数据库配置
	include '../MySql.php';

	// 创建连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

	// 获得表单POST过来的数据
	$yqm = $_POST["yqm"];
	$yqm_daynum = $_POST["yqm_daynum"];

	if(empty($yqm)){
		$result = array(
			"result" => "101",
			"msg" => "邀请码不得为空"
		);
	}else if(empty($yqm_daynum)){
		$result = array(
			"result" => "102",
			"msg" => "可用天数不得为空"
		);
	}else{
		mysqli_query($conn, "SET NAMES UTF-8"); //utf8 设为对应的编码
		// 插入数据库
		$sql = "INSERT INTO qun_huoma_yqm (yqm, yqm_status, yqm_daynum) VALUES ('$yqm', '0', '$yqm_daynum')";
		
		if ($conn->query($sql) === TRUE) {
		    $result = array(
				"result" => "100",
				"msg" => "添加成功"
			);
		} else {
		    $result = array(
				"result" => "103",
				"msg" => "添加失败，请检查数据库连接状态"
			);
		}
		
		// 断开数据库连接
		$conn->close();
	}
}else{
	$result = array(
		"result" => "104",
		"msg" => "未登录"
	);
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>