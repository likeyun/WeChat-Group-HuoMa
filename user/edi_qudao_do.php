<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.user.admin"])){

	$user = $_SESSION["huoma.user.admin"];

	// 数据库配置
	include '../MySql.php';

	// 创建连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

	// 获得表单POST过来的数据
	$qudao_title = $_POST["qudao_title"];
	$qudao_type = $_POST["qudao_type"];
	$qudao_content = $_POST["qudao_content"];
	$qudao_biaoqian = $_POST["qudao_biaoqian"];
	$qudao_id = $_POST["qudao_id"];
	$qudao_yuming = $_POST["qudao_yuming"];

	if(empty($qudao_title)){
		$result = array(
			"result" => "101",
			"msg" => "渠道标题不得为空"
		);
	}else if(empty($qudao_type)){
		$result = array(
			"result" => "102",
			"msg" => "请选择渠道类型"
		);
	}else if(empty($qudao_content)){
		$result = array(
			"result" => "103",
			"msg" => "请输入渠道内容"
		);
	}else if(empty($qudao_biaoqian)){
		$result = array(
			"result" => "104",
			"msg" => "请填写渠道标签"
		);
	}else if($qudao_yuming == ""){
		$result = array(
			"result" => "106",
			"msg" => "请选择渠道域名"
		);
	}else{
		// 当前时间
		$date = date('Y-m-d');
		mysqli_query($conn, "SET NAMES UTF-8"); //utf8 设为对应的编码
		// 更新数据库
		mysqli_query($conn,"UPDATE qun_huoma_qudao SET qudao_title='$qudao_title',qudao_yuming='$qudao_yuming',qudao_type='$qudao_type',qudao_content='$qudao_content',qudao_biaoqian='$qudao_biaoqian',qudao_update_time='$date' WHERE qudao_id='$qudao_id' AND qudao_adduser ='$user'");
		$result = array(
			"result" => "100",
			"msg" => "更新成功"
		);
	}
}else{
	$result = array(
		"result" => "105",
		"msg" => "未登录"
	);
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>