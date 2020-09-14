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
	$title = $_POST["title"];
	$qun_qrcode = $_POST["qun_qrcode"];
	$wx_qrcode = $_POST["wx_qrcode"];
	$wxid = $_POST["wxid"];
	$biaoqian = $_POST["biaoqian"];
	$wxstatus = $_POST["wxstatus"];
	$byqun_status = $_POST["byqun_status"];
	$hm_id = rand(10000,99999);
	$yuming = $_POST["yuming"];
	$huoma_status = $_POST["huoma_status"];
	$byqun_maxnum = $_POST["byqun_maxnum"];
	$byqun_qrcode = $_POST["byqun_qrcode"];

	if(empty($title)){
		$result = array(
			"result" => "101",
			"msg" => "标题不得为空"
		);
	}else if(empty($qun_qrcode)){
		$result = array(
			"result" => "102",
			"msg" => "微信群二维码还没上传"
		);
	}else if(empty($wx_qrcode)){
		$result = array(
			"result" => "103",
			"msg" => "微信二维码还没上传"
		);
	}else if(empty($wxid)){
		$result = array(
			"result" => "104",
			"msg" => "微信号不得为空"
		);
	}else if(empty($biaoqian)){
		$result = array(
			"result" => "105",
			"msg" => "标签不得为空"
		);
	}else if(empty($yuming)){
		$result = array(
			"result" => "106",
			"msg" => "请选择落地页域名"
		);
	}else{
		// 当前时间
		$date = date("Y-m-d");
		mysqli_query($conn, "SET NAMES UTF-8"); //utf8 设为对应的编码
		// 插入数据库
		$sql = "INSERT INTO qun_huoma (title, qun_qrcode, wx_qrcode, wxid, hm_id, biaoqian, update_time, wxstatus, byqun_status, page_view, yuming, add_user, huoma_status, qun_maxnum, byqun_qrcode) VALUES ('$title', '$qun_qrcode', '$wx_qrcode', '$wxid', '$hm_id', '$biaoqian', '$date', '$wxstatus', '$byqun_status', '0', '$yuming', '$user', '$huoma_status', '$byqun_maxnum', '$byqun_qrcode')";
		
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