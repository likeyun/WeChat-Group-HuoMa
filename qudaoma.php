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
	<style type="text/css">
		#content{
			width: 80%;
			margin:20px auto 0;
			font-size: 16px;
			text-align: justify;
			line-height: 30px;
			border:2px solid #333;
			padding:10px 10px;
		}
	</style>
</head>
<body style="background: #fff;">

	<?php
	$qudao_id = $_GET["qudaoid"];
	if (trim(empty($qudao_id))) {
		header("Location:admin");
	}else{

		// 数据库配置
		include './MySql.php';

		// 创建连接
		$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

		if ($conn->connect_error) {
		    die("连接失败: " . $conn->connect_error);
		} 
		 
		$sql = "SELECT * FROM qun_huoma_qudao WHERE qudao_id =".$qudao_id;
		$result = $conn->query($sql);

		// 更新访问量
		mysqli_query($conn,"UPDATE qun_huoma_qudao SET qudao_pageview=qudao_pageview+1 WHERE qudao_id =".$qudao_id);
		 
		if ($result->num_rows > 0) {
		    // 输出数据
		    while($row = $result->fetch_assoc()) {

				$id  = $row["id"];
				$qudao_id  = $row["qudao_id"];
				$qudao_title  = $row["qudao_title"];
				$qudao_yuming  = $row["qudao_yuming"];
				$qudao_type  = $row["qudao_type"];
				$qudao_content  = $row["qudao_content"];
				$qudao_biaoqian  = $row["qudao_biaoqian"];
				$qudao_pageview  = $row["qudao_pageview"];
				$qudao_update_time  = $row["qudao_update_time"];

				// 渠道标题
			    echo "<title>".$qudao_title."</title>";
			    // 渠道内容
			    if ($qudao_type == 1) {
			    	// 如果渠道类型是文本，就显示文本
			    	echo "<h2 style='text-align:center;margin-top:50px;'>扫描结果</h2>";
			    	echo "<div id='content'>".$qudao_content."</div>";
			    }else if ($qudao_type == 2) {
			    	// 如果渠道类型是链接，就跳转链接
			    	header("Location:".$qudao_content);
			    }else{
			    	echo "非法请求";
			    }
		    }
		} else {
		    echo "<div style='width:150px;margin:50px auto 10px;'><img src='images/notfound.png' width='150'/></div>";
		    echo "<p style='text-align:center;'><b>该二维码不存在或已被管理员删除</b></p>";
		}
		$conn->close();
	}
	?>
</body>
</html>