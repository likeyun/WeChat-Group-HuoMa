<?php
header("Content-type:application/json");
// 数据库配置
$mysql = file_get_contents("../admin.json");
$mysql_arr = json_decode($mysql,true);
$servername = $mysql_arr["dbservername"];
$username = $mysql_arr["dbusername"];
$password = $mysql_arr["dbpassword"];
$dbname = $mysql_arr["dbname"];
$adminusername = $mysql_arr["adminuser"];
$adminpassword = $mysql_arr["adminpwd"];

$adminuser = $_POST["user"];
$adminpsw = $_POST["pwd"];

if($adminuser == "" && $adminpsw == ""){
	$result = array(
		"result" => "101",
		"msg" => "账号和密码不得为空"
	);
}else if($adminuser == ""){
	$result = array(
		"result" => "102",
		"msg" => "账号不得为空"
	);
}else if ($adminpsw == "") {
	$result = array(
		"result" => "103",
		"msg" => "密码不得为空"
	);
}else if ($adminuser == $adminusername && $adminpsw == $adminpassword){
	$result = array(
		"result" => "100",
		"msg" => "登录成功"
	);
	session_start();
	$_SESSION["huoma.admin"] = $adminuser;
}else{
	$result = array(
		"result" => "104",
		"msg" => "账号或密码错误，登录失败"
	);
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>