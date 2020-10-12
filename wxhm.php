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
	<link rel="icon" href="../images/xiaotubiao.png" type="image/x-icon" />
	<script src="js/jquery-3.1.1.min.js"></script>
</head>
<body style="background: #fff;">

	<?php
	$wxid = $_GET["wxid"];
	// 验证是否有参数，没有参数直接跳转后台登陆界面
	if (trim(empty($wxid))) {
		echo "参数错误";
	}else{
		// 数据库配置
		include './MySql.php';

		// 创建连接
		$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

		if ($conn->connect_error) {
		    die("连接失败: " . $conn->connect_error);
		} 
		 
		$sql = "SELECT * FROM qun_huoma_wx WHERE wx_id =".$wxid;
		$result = $conn->query($sql);

		// 更新访问量
		mysqli_query($conn,"UPDATE qun_huoma_wx SET wx_pageview=wx_pageview+1 WHERE wx_id =".$wxid);
		
		// 验证该页面是否存在
		if ($result->num_rows > 0) {
		    // 遍历数据
		    while($row = $result->fetch_assoc()) {
			    $wx_title  = $row["wx_title"];
			    $wx_qrcode  = $row["wx_qrcode"];
			    $wx_nummber  = $row["wx_nummber"];
			    $wx_status  = $row["wx_status"];
		    }// 遍历数据结束

		    // 验证活码启动状态
		    if ($wx_status == 0) {
		    	echo "<div style='width:150px;margin:50px auto 10px;'><img src='images/pause.png' width='150'/></div>";
		    	echo "<p style='text-align:center;'><b>该二维码已被管理员暂停使用</b></p>";
		    }else{
		    	// 页面标题
		    	echo "<title>".$wx_title."</title>";

		    	// 顶部安全提示
				echo '<div id="safety-tips" style="position:fixed;top:0;">
				<div class="safety-icon">
				<img src="images/safety-icon.png" />
				</div>
				<div class="safety-title">此二维码已通过安全认证，可以放心扫码</div>
				</div>';

				// 展示二维码
				echo "<div style='width:100%;height:60px;'></div>";
				echo "<div id='tips-text' style='text-align:center;font-size:17px;'><b>请长按下方二维码加微信</b></div>";
				echo "<div id='ewmcon' style='box-shadow:0 0 15px #eee;width:280px;'><img src=".$wx_qrcode." /></div>";
				echo "<div id='tips-text' style='text-align:center;font-size:17px;'><b>微信号：".$wx_nummber."</b></div>";
		    }
		} else {
		    echo "<div style='width:150px;margin:50px auto 10px;'><img src='images/notfound.png' width='150'/></div>";
		    echo "<p style='text-align:center;'><b>该二维码不存在或已被管理员删除</b></p>";
		}// 验证该页面是否存在结束
		$conn->close();
	}// 验证是否有参数结束
	?>
</body>
</html>