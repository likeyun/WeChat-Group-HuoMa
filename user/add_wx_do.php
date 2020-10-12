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
	$wx_title = $_POST["wx_title"];
	$wx_qrcode = $_POST["wx_qrcode"];
	$wx_nummber = $_POST["wx_nummber"];
	$wx_biaoqian = $_POST["wx_biaoqian"];
	$wx_status = $_POST["wx_status"];
	$wx_id = rand(10000,99999);
	$wx_yuming = $_POST["wx_yuming"];

	if(empty($wx_title)){
		$result = array(
			"result" => "101",
			"msg" => "标题不得为空"
		);
	}else if(empty($wx_qrcode)){
		$result = array(
			"result" => "102",
			"msg" => "微信二维码还没上传"
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
	}else if(empty($wx_yuming)){
		$result = array(
			"result" => "105",
			"msg" => "请选择落地页域名"
		);
	}else{
		// 当前时间
		$date = date("Y-m-d");
		mysqli_query($conn, "SET NAMES UTF-8");
		// 插入数据库
		$sql = "INSERT INTO qun_huoma_wx (wx_title, wx_qrcode, wx_nummber, wx_id, wx_biaoqian, wx_update_time, wx_status, wx_pageview, wx_yuming, add_user) VALUES ('$wx_title', '$wx_qrcode', '$wx_nummber', '$wx_id', '$wx_biaoqian', '$date', '$wx_status', '0', '$wx_yuming', '$user')";
		
		if ($conn->query($sql) === TRUE) {
		    $result = array(
				"result" => "100",
				"msg" => "创建成功，正在返回首页..."
			);
		} else {
		    $result = array(
				"result" => "107",
				"msg" => "添加失败，数据库配置发生错误"
			);
		}
		// 断开数据库连接
		$conn->close();
	}
}else{
	$result = array(
		"result" => "108",
		"msg" => "未登录"
	);
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>