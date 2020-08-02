<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.admin"])){

	// 数据库配置
	include '../MySql.php';

	// 创建连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

	// 获得表单POST过来的数据
	$yuming = $_POST["yuming"];

	// 验证是否携带http
	$http_check = "%**#".$yuming;

	if(empty($yuming)){
		$result = array(
			"result" => "101",
			"msg" => "域名不得为空"
		);
	}else if (strpos($http_check,"http") > 0) {
		// 插入数据库
		$sql = "INSERT INTO qun_huoma_yuming (yuming) VALUES ('$yuming')";
		if ($conn->query($sql) === TRUE) {
		    $result = array(
				"result" => "100",
				"msg" => "添加成功"
			);
		} else {
		    $result = array(
				"result" => "103",
				"msg" => "添加失败，数据库发生错误"
			);
		}
		// 断开数据库连接
		$conn->close();
	}else{
		$result = array(
			"result" => "104",
			"msg" => "请携带http://或https://"
		);
	}
	// 返回结果
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
}else{
	$result = array(
		"result" => "102",
		"msg" => "未登录"
	);
	// 未登录
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
}

?>