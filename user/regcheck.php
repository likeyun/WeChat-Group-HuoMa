<?php
header("Content-type:application/json");

// 数据库配置
include '../MySql.php';

$hm_user = trim($_POST["hm_user"]);
$hm_pwd = trim($_POST["hm_pwd"]);
$hm_cpwd = trim($_POST["hm_cpwd"]);
$hm_email = trim($_POST["hm_email"]);
$hm_yqm = trim($_POST["hm_yqm"]);

//账号不能存在特殊符号
$tsfh = preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$hm_user);

if($hm_user == "" && $hm_pwd == "" && $hm_cpwd == "" && $hm_email == "" && $hm_yqm == ""){
	$result = array(
		"result" => "101",
		"msg" => "所有项不得为空"
	);
}else if($hm_user == ""){
	$result = array(
		"result" => "102",
		"msg" => "账号不得为空"
	);
}else if ($hm_pwd == "") {
	$result = array(
		"result" => "103",
		"msg" => "密码不得为空"
	);
}else if ($hm_cpwd == "") {
	$result = array(
		"result" => "104",
		"msg" => "重复密码不得为空"
	);
}else if ($hm_email == "") {
	$result = array(
		"result" => "105",
		"msg" => "邮箱不得为空"
	);
}else if ($hm_yqm == "") {
	$result = array(
		"result" => "106",
		"msg" => "邀请码不得为空"
	);
}else if ($hm_pwd !== $hm_cpwd) {
	$result = array(
		"result" => "107",
		"msg" => "两次输入的密码不一致"
	);
}else if (strlen($hm_user) < 6) {
	$result = array(
		"result" => "108",
		"msg" => "账号长度不得小于6个字符"
	);
}else if (strlen($hm_pwd) < 8) {
	$result = array(
		"result" => "109",
		"msg" => "密码长度不得小于8个字符"
	);
}else if ($tsfh) {
	$result = array(
		"result" => "110",
		"msg" => "账号不能存在特殊字符"
	);
}else{

	// 创建数据库连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);
	if ($conn->connect_error) {
	    die("连接失败: " . $conn->connect_error);
	} 

	// 验证邀请码
	$sql_checkyqm = "SELECT * FROM qun_huoma_yqm WHERE yqm = '$hm_yqm'";
	$result_yqm = $conn->query($sql_checkyqm);
	 
	if ($result_yqm->num_rows > 0) {
	    // 输出数据
	    while($row_yqm = $result_yqm->fetch_assoc()) {
	    	$yqm_status = $row_yqm["yqm_status"];// 邀请码的使用状态
	    	$yqm_daynum = $row_yqm["yqm_daynum"];// 该邀请码注册后的账号使用时间
	    	$daoqidate = $yqm_daynum+1;// 到期时间需要在使用时间+1天
	    	if ($yqm_status == 1) {
	    		$result = array(
					"result" => "112",
					"msg" => "邀请码已被使用"
				);
	    	}else{
	    		// 验证是否存在该账号
				$sql_checkuser = "SELECT * FROM qun_huoma_user WHERE user_name = '$hm_user'";
				$result_checkuser=mysqli_query($conn,$sql_checkuser);
				// 返回记录
				$row_user=mysqli_num_rows($result_checkuser);
				if ($row_user) {
					// 如果存在，则代表该帐号已经被注册
					$result = array(
						"result" => "113",
						"msg" => "该帐号已被注册"
					);
				}else{
					$user_id = rand(1000000,9999999);// 生成uid
					$daoqi = date("Y-m-d",strtotime("+".$daoqidate." day"));// 过期时间
					$sql_creatuser = "INSERT INTO qun_huoma_user (user_id, user_name, user_password, user_guoqidate, user_email, user_status, user_quanxian) VALUES ('$user_id', '$hm_user', '$hm_pwd', '$daoqi', '$hm_email', '0', '0')";
					// 验证是否成功
					if ($conn->query($sql_creatuser) === TRUE) {
					    $result = array(
							"result" => "100",
							"msg" => "注册成功"
						);

					// 注册成功后，邀请码的状态修改为已使用
					$usetime = date('Y-m-d H:i:s',time());
					mysqli_query($conn,"UPDATE qun_huoma_yqm SET yqm_status='1',use_time='$usetime' WHERE yqm='$hm_yqm'");

					} else {
					    $result = array(
							"result" => "114",
							"msg" => "注册失败，请检查数据库"
						);
					}
				}
	    	} 
	    }
	} else {
	    $result = array(
			"result" => "111",
			"msg" => "邀请码不正确"
		);
	}
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>