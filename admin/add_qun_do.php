<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.admin"])){

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
	$hm_id = rand(10000,99999);
	$byqun_qrcode = $_POST["byqun_qrcode"];
	$byqun_status = $_POST["byqun_status"];
	$byqun_maxnum = $_POST["byqun_maxnum"];
	$yuming = $_POST["yuming"];

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
			"result" => "107",
			"msg" => "标签不得为空"
		);
	}else if(empty($yuming)){
		$result = array(
			"result" => "108",
			"msg" => "请选择落地页域名"
		);
	}else{
		// 当前时间
		$date = date("Y-m-d G:H:s");
		mysqli_query($conn, "SET NAMES UTF-8"); //utf8 设为对应的编码
		// 插入数据库
		$sql = "INSERT INTO qun_huoma (title, qun_qrcode, wx_qrcode, wxid, hm_id, biaoqian, update_time, wxstatus, byqun_status, byqun_qrcode, byqun_maxnum, page_view, yuming) VALUES ('$title', '$qun_qrcode', '$wx_qrcode', '$wxid', '$hm_id', '$biaoqian', '$date', '$wxstatus', '$byqun_status', '$byqun_qrcode', '$byqun_maxnum', '0', '$yuming')";
		
		if ($conn->query($sql) === TRUE) {
		    $result = array(
				"result" => "100",
				"msg" => "添加成功"
			);
		} else {
		    $result = array(
				"result" => "106",
				"msg" => "添加失败，数据库发生错误"
			);
		}
		
		// 断开数据库连接
		$conn->close();
	}
	// 返回结果
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
}else{
	$result = array(
		"result" => "105",
		"msg" => "未登录"
	);
	// 未登录
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
}

?>