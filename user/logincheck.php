<?php
header("Content-type:application/json");

// 数据库配置
include '../MySql.php';

$adminuser = trim($_POST["user"]);
$adminpsw = trim($_POST["pwd"]);

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
}else{
	
	// 创建数据库连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);
	if ($conn->connect_error) {
	    die("连接失败: " . $conn->connect_error);
	} 
	
	// 验证账号和密码
	$sql_checkuser = "SELECT * FROM qun_huoma_user WHERE user_name = '$adminuser' AND user_password = '$adminpsw'";
	$result_checkuser=mysqli_query($conn,$sql_checkuser);
	// 返回记录
	$row_user=mysqli_num_rows($result_checkuser);
	if ($row_user) {
		// 如果账号和密码都对上，验证账号状态
		while($row_userstatus = $result_checkuser->fetch_assoc()) {
			$userstatus = $row_userstatus["user_status"];
			$user_daoqidate = $row_userstatus["user_guoqidate"];
		}
		// 计算是否已经到期
		date_default_timezone_set("Asia/Shanghai");
		$thisdate=date("Y-m-d");// 当前日期
		$daoqidate=$user_daoqidate;// 到期日期

		if ($userstatus == 0) {

			// 判断账号是否已到期
			if(strtotime($thisdate)<strtotime($daoqidate)){
				session_start();
				$_SESSION['huoma.user.admin'] = $adminuser;
				$result = array(
					"result" => "100",
					"msg" => "登录成功"
				);
			}else{
				$result = array(
					"result" => "106",
					"msg" => "该账号已到期，请续期"
				);
			}
		}else if ($userstatus == 1){
			$result = array(
				"result" => "105",
				"msg" => "该账号已被暂停使用"
			);
		}
	}else{
		// 否则返回账号或密码错误
		$result = array(
			"result" => "104",
			"msg" => "账号或密码错误"
		);
	}
	// 释放结果集
    mysqli_free_result($result_checkuser);
    // 断开数据库连接
	$conn->close();
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>