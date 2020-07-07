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

	<?php
	$hmid = $_GET["hmid"];
	if (empty($hmid)) {
		echo "<h2 style='text-align:center;margin-top:50px;'>请在管理后台添加活码后，点击分享，微信扫码即可查看你的活码</h2>";
	}else{
		echo '<div id="safety-tips">
			 <div class="safety-icon">
				<img src="images/safety-icon.png" />
			 </div>
			 <div class="safety-title">此二维码已通过安全认证，可以放心扫码</div>
	         </div>';

		// 数据库配置
		require_once("MySql.php");
		 
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
			    $wxstatus  = $row["wxstatus"];

			    echo "<title>".$title."</title>";

				echo '<div id="ewmcon">
					<img src="'.$qun_qrcode.'" />
				</div>

				<div id="tips-text">请再次扫描上方二维码即可加群！若群二维码提示"该群已开启群验证，只可通过邀请进群"或"群聊人数超过200人，只可通过邀请进群"，可以联系下方微信，我们会邀请你入群。</div>';
				
				if ($wxstatus == 0) {
					//隐藏
				}else if ($wxstatus == 1) {
					echo '<div id="grwx">
						 <img src="'.$wx_qrcode.'" />
						 </div>

						 <div id="copy">
							<div class="wxid" id="wxid">'.$wxid.'</div>
							<div class="copybtn" id="cpwxid">复制微信号</div>
						 </div>';
				}
		    }
		} else {
		    echo "不存在该页面";
		}
		$conn->close();
	}
	?>

	<!-- 底部占位 -->
	<div id="zhanwei"></div>

	<!-- 复制 -->
    <script>
    function copyArticle(event){
      const range = document.createRange();
      range.selectNode(document.getElementById('wxid'));
      const selection = window.getSelection();
      if(selection.rangeCount > 0) selection.removeAllRanges();
      selection.addRange(range);
      document.execCommand('copy');
      // $("#copytips .success").css("display","block");
      // $("#tkl .copy").text("已复制");
      // setTimeout('hide()', 2000);
      alert("已复制");
      
    }
    window.onload = function () {
      var obt = document.getElementById("copy");
      obt.addEventListener('click', copyArticle, false);
    }
    </script>
</body>
</html>