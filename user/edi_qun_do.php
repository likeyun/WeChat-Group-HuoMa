<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.user.admin"])){

	// 数据库配置
	include '../MySql.php';

	// 创建连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

	// 获得表单POST过来的数据
	$title = $_POST["title"];
	$qun_qrcode = $_POST["qun_qrcode"];
	$wx_qrcode = $_POST["wx_qrcode"];
	$wxid = $_POST["wxid"];
	$hm_id = $_POST["hm_id"];
	$biaoqian = $_POST["biaoqian"];
	$wxstatus = $_POST["wxstatus"];
	$huoma_status = $_POST["huoma_status"];
	$byqun_status = $_POST["byqun_status"];
	$byqun_maxnum = $_POST["byqun_maxnum"];
	$byqun_qrcode = $_POST["byqun_qrcode"];
	$yuming = $_POST["yuming"];

	if(empty($title)){
		$result = array(
			"result" => "101",
			"msg" => "标题不得为空"
		);
	}else if(empty($qun_qrcode)){
		$result = array(
			"result" => "102",
			"msg" => "群二维码URL不得为空"
		);
	}else if(empty($wx_qrcode)){
		$result = array(
			"result" => "103",
			"msg" => "微信二维码URL不得为空"
		);
	}else if(empty($wxid)){
		$result = array(
			"result" => "104",
			"msg" => "微信号不得为空"
		);
	}else{
		// 当前时间
		$date = date('Y-m-d');
		mysqli_query($conn, "SET NAMES UTF-8"); //utf8 设为对应的编码
		// 更新数据库
		mysqli_query($conn,"UPDATE qun_huoma SET title='$title',qun_qrcode='$qun_qrcode',wx_qrcode='$wx_qrcode',wxid='$wxid',biaoqian='$biaoqian',update_time='$date',wxstatus='$wxstatus',byqun_status='$byqun_status',yuming='$yuming',huoma_status='$huoma_status',qun_maxnum='$byqun_maxnum',byqun_qrcode='$byqun_qrcode' WHERE hm_id=".$hm_id);
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