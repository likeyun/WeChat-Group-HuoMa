<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.admin"])){

	// 数据库配置
	include '../MySql.php';

	// 创建连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

	// 获得表单POST过来的数据
	$wx_title = $_POST["wx_title"];
	$wx_qrcode = $_POST["wx_qrcode"];
	$wx_id = $_POST["wx_id"];
	$wx_nummber = $_POST["wx_nummber"];
	$wx_biaoqian = $_POST["wx_biaoqian"];
	$wx_status = $_POST["wx_status"];
	$wx_yuming = $_POST["wx_yuming"];

	if(empty($wx_title)){
		$result = array(
			"result" => "101",
			"msg" => "标题不得为空"
		);
	}else if(empty($wx_qrcode)){
		$result = array(
			"result" => "102",
			"msg" => "微信二维码不得为空"
		);
	}else if(empty($wx_nummber)){
		$result = array(
			"result" => "103",
			"msg" => "微信号不得为空"
		);
	}else if(empty($wx_biaoqian)){
		$result = array(
			"result" => "104",
			"msg" => "标签不得为空"
		);
	}else{
		// 当前时间
		$date = date('Y-m-d');
		mysqli_query($conn, "SET NAMES UTF-8");
		// 更新数据库
		mysqli_query($conn,"UPDATE qun_huoma_wx SET wx_title='$wx_title',wx_qrcode='$wx_qrcode',wx_nummber='$wx_nummber',wx_biaoqian='$wx_biaoqian',wx_update_time='$date',wx_status='$wx_status',wx_yuming='$wx_yuming' WHERE wx_id=".$wx_id);
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