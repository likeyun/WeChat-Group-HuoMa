<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="color-scheme" content="light dark">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
	<link rel="shortcut icon" type="image/x-icon" href="//res.wx.qq.com/a/wx_fed/assets/res/NTI4MWU5.ico">
	<link rel="mask-icon" href="//res.wx.qq.com/a/wx_fed/assets/res/MjliNWVm.svg" color="#4C4C4C">
	<link rel="apple-touch-icon-precomposed" href="//res.wx.qq.com/a/wx_fed/assets/res/OTE0YTAw.png">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
</head>
<body>
	<!-- 顶部安全提示 -->
	<div id="safety-tips">
		<!-- 安全图标 -->
		<div class="safety-icon">
			<img src="images/safety-icon.png" />
		</div>
		
		<!-- 安全提示标题 -->
		<div class="safety-title">此二维码已通过安全认证，可以放心扫码</div>
	</div>

	<?php
	// 数据库配置
	require_once("MySql.php");

	$hmid = $_GET["hmid"];
	 
	// 创建连接
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("连接失败: " . $conn->connect_error);
	} 
	 
	$sql = "SELECT * FROM qun_huoma WHERE hm_id =".$hmid;
	$result = $conn->query($sql);

	// 更新访问量
	mysqli_query($conn,"UPDATE qun_huoma SET page_view=page_view+1 WHERE hm_id =".$hmid);
	 
	if ($result->num_rows > 0) {
	    // 输出数据
	    while($row = $result->fetch_assoc()) {
		   
		    $title  = $row["title"];
		    $update_time  = $row["update_time"];
		    $qun_qrcode  = $row["qun_qrcode"];
		    $wx_qrcode  = $row["wx_qrcode"];
		    $wxid  = $row["wxid"];

		    echo "<title>".$title."</title>";

			echo '<div id="ewmcon">
				<img src="'.$qun_qrcode.'" />
			</div>

			<div id="tips-text">若群二维码提示"该群已开启群验证，只可通过邀请进群"或"群聊人数超过200人，只可通过邀请进群"，可以联系下方微信，我们会邀请你入群。</div>

			<div id="grwx">
				<img src="'.$wx_qrcode.'" />
			</div>

			<div id="wechatid">微信号：'.$wxid.'</div>';
	    }
	} else {
	    echo "不存在该页面";
	}
	$conn->close();
	?>

	<!-- 底部占位 -->
	<div id="zhanwei"></div>
</body>
</html>
