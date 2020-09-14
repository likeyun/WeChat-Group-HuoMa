<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.admin"])){

	// 数据库配置
	include '../MySql.php';

	// 创建连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

	// 获取数据
	$yqm_id = $_GET["yqmid"];

	if(empty($yqm_id)){
		$result = array(
			"result" => "101",
			"msg" => "非法请求"
		);
	}else{
		// 删除数据
		mysqli_query($conn,"DELETE FROM qun_huoma_yqm WHERE id=".$yqm_id);
		$result = array(
			"result" => "100",
			"msg" => "已删除"
		);
	}
}else{
	$result = array(
		"result" => "102",
		"msg" => "未登录"
	);
	// 未登录
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>