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
	  <script src="https://player.love119.icu/js/yzmplayer.js"></script>
</head>
<body>

	<?php
	$hmid = $_GET["hmid"];
	if (empty($hmid)) {
		echo "<h2 style='text-align:center;margin-top:50px;'>请在管理后台添加活码后，点击分享，微信扫码即可查看你的活码</h2>";
	}else{
		echo '';

		// 数据库配置
		include './MySql.php';

		// 创建连接
		$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

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
			    $page_view  = $row["page_view"];
			    $wxstatus  = $row["wxstatus"];
			    $byqun_status  = $row["byqun_status"];
			    $byqun_qrcode  = $row["byqun_qrcode"];
			    $byqun_maxnum  = $row["byqun_maxnum"];

			    echo "<title>".$title."</title>";

			    if ($byqun_status == 0) {
			    	// 未开启备用群
					echo '<div id="ewmcon">
					<img src="'.$qun_qrcode.'" />
					</div>';
			    }else if ($byqun_status == 1) {
			    	// 开启备用群
			    	// 判断峰值
			    	if ($page_view >= $byqun_maxnum) {
			    		// 如果当前访问量大于或等于峰值，则显示备用二维码
						echo '<div id="ewmcon">
						<img src="'.$byqun_qrcode.'" />
						</div>';
			    	}else{
			    		// 否则不启用备用群
			    		echo '<div id="ewmcon">
						<img src="'.$qun_qrcode.'" />
						</div>';
			    	}
			    }

		
				
				if ($wxstatus == 0) {
					//隐藏
				}else if ($wxstatus == 1) {
					echo '<div id="grwx">
						 <img src="'.$wx_qrcode.'" />
						 </div>
						  <div id="footer">
        <p><font color="#696969">© 2020 | <a href="https://xsot.cn"> 星辰科技  </a> | <a href="#"> 快抖科技  </a></font></p>
    </div>	

				 <div id="copy"><div class="img" id="img"><img src="https://kyun.ltyuanfang.cn/tc/2020/07/31/bfc5c00123573.png" style="width:auto;height:auto;max-width:100%;max-height:100%;"></div>
							<div class="wxid" id="wxid">'.$wxid.'</div>
							<div class="copybtn" id="cpwxid">关注</div>
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
     //  $("#copytips .success").css("display","block");
      // $("#tkl .copy").text("已复制");
     //  setTimeout('hide()', 2000);
     // alert("已复制微信号,点确定立即跳转到微信！");
     y = document.getElementById("cpwxid")
    y.innerHTML = "复制成功"
        window.location.href='weixin://';
    }
    window.onload = function () {
      var obt = document.getElementById("copy");
      obt.addEventListener('click', copyArticle, false);
    }
    </script>
</body>
</html>