<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.admin"])){

	$user = $_SESSION["huoma.admin"];

	// 数据库配置
	include '../MySql.php';

	// 创建连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

	// 获得表单POST过来的数据
	$user_name = $_POST["user_name"];
	$user_id = $_POST["user_id"];
	$user_status = $_POST["user_status"];
	$user_password = $_POST["user_password"];
	$user_regtime = $_POST["user_regtime"];
	$user_guoqidate = $_POST["user_guoqidate"];
	$user_email = $_POST["user_email"];

	if(empty($user_name)){
		$result = array(
			"result" => "101",
			"msg" => "账号不得为空"
		);
	}else if(empty($user_password)){
		$result = array(
			"result" => "102",
			"msg" => "密码不得为空"
		);
	}else if(empty($user_guoqidate)){
		$result = array(
			"result" => "103",
			"msg" => "到期时间不得为空"
		);
	}else if(empty($user_email)){
		$result = array(
			"result" => "104",
			"msg" => "邮箱不得为空"
		);
	}else if($user_id == ""){
		$result = array(
			"result" => "106",
			"msg" => "用户ID不得为空"
		);
	}else{
		// 当前时间
		$date = date('Y-m-d');
		mysqli_query($conn, "SET NAMES UTF-8"); //utf8 设为对应的编码
		// 更新数据库
		mysqli_query($conn,"UPDATE qun_huoma_user SET user_name='$user_name',user_status='$user_status',user_password='$user_password',user_guoqidate='$user_guoqidate',user_email='$user_email' WHERE user_id=".$user_id);
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