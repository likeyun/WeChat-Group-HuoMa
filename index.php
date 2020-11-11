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
<body>

	<?php
	$hmid = $_GET["hmid"];
	// 验证是否有参数，没有参数直接跳转后台登陆界面
	if (trim(empty($hmid))) {
		header("Location:admin");
	}else{
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
		
		// 验证该页面是否存在
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
			    $huoma_status  = $row["huoma_status"];
			    $byqun_qrcode  = $row["byqun_qrcode"];
			    $byqun_maxnum  = $row["qun_maxnum"];
			    $add_user  = $row["add_user"];

			    echo "<title>".$title."</title>";

				// 验证活码状态
				if ($huoma_status == "0") {
					echo "<div style='width:150px;margin:50px auto 10px;'><img src='images/pause.png' width='150'/></div>";
		    		echo "<p style='text-align:center;'><b>该二维码已被管理员暂停使用</b></p>";
				}else{
					// 顶部安全提示
					echo '<div id="safety-tips">
						<div class="safety-icon">
						<img src="images/safety-icon.png" />
						</div>
						<div class="safety-title">此二维码已通过安全认证，可以放心扫码</div>
						</div>';
					
					// 正常使用
					// 验证是否有开启备用群
					if ($byqun_status == 0) {
						// 未开启备用群，则直接显示默认群
						echo '<div id="ewmcon"><img src="'.$qun_qrcode.'" /></div>';
					}else{
						// 开启了备用群，则验证是否有备用群
						$sql_checkbyqun = "SELECT * FROM qun_huoma WHERE hm_id = '$hmid'";
						$result_byqun = $conn->query($sql_checkbyqun);
						while($row_byqun = $result_byqun->fetch_assoc()) {
							$beiyongqun = $row_byqun["byqun_qrcode"];
						}
						if ($beiyongqun == '') {
							// 没有设置备用群，直接显示默认群
							echo '<div id="ewmcon"><img src="'.$qun_qrcode.'" /></div>';
						}else{
							// 有备用群，用阈值和访问量作对比
							// 当访问量>阈值，就可以切换备用群
							if ($page_view > $byqun_maxnum) {
								echo '<div id="ewmcon"><img src="'.$byqun_qrcode.'" /></div>';
							}else{
								// 当访问量<阈值，就使用默认群
								echo '<div id="ewmcon"><img src="'.$qun_qrcode.'" /></div>';
							}
						}// 验证默认群的访问量是否大于峰值结束

					}// 验证是否有开启备用群结束
					if ($wxstatus == 0) {
					//隐藏
					echo '<div id="tips-text" style="text-align:center;font-size:17px;"><b>请长按上方二维码加入群聊</b></div>';
					}else if ($wxstatus == 1) {
						echo '<div id="tips-text"><b>本页面为二维码更新页面，请再次扫描上方二维码即可加群！</b>若群二维码提示"该群已开启群验证，只可通过邀请进群"或"群聊人数超过200人，只可通过邀请进群"，可以联系下方微信，我们会邀请你入群。</div>';

						echo '<div id="grwx">
							 <img src="'.$wx_qrcode.'" />
							 </div>

							 <div id="copy">
								<div class="wxid" id="wxid">'.$wxid.'</div>
								<div class="copybtn" id="cpwxid">复制微信号</div>
							 </div>';
					}
				}// 验证活码状态结束
		    }// 遍历数据结束
		} else {
		    echo "<div style='width:150px;margin:50px auto 10px;'><img src='images/notfound.png' width='150'/></div>";
		    echo "<p style='text-align:center;'><b>该二维码不存在或已被管理员删除</b></p>";
		}// 验证该页面是否存在结束
		$conn->close();
	}// 验证是否有参数结束
	?>

	<!-- 复制提示 -->
	<div id="copytips" style="display:none;">复制成功</div>

	<!-- 底部占位 -->
	<div id="zhanwei"></div>

	<!-- 复制 -->
    <script>

    function closesctips(){
	  $("#copytips").css('display','none');
	}

    function copyArticle(event){
      const range = document.createRange();
      range.selectNode(document.getElementById('wxid'));
      const selection = window.getSelection();
      if(selection.rangeCount > 0) selection.removeAllRanges();
      selection.addRange(range);
      document.execCommand('copy');
      $("#copytips").css('display','block');
      setTimeout('closesctips()', 2000);
    }
    window.onload = function () {
      var obt = document.getElementById("copy");
      obt.addEventListener('click', copyArticle, false);
    }

    // 检查是否有缓存
    // var huomaStorage = window.localStorage.huoma;

    // if (huomaStorage == null) {
    // 	// 如果没有缓存，那就把当前的二维码缓存到本地
    // 	huomaStorage = '<?php echo $qun_qrcode; ?>';
    // }else{
    // 	// 如果有缓存，那就直接把当前的缓存取出来显示
    // 	var huoma = window.localStorage.huoma;
    // 	$("#ewmcon").html("<img src='"+huoma+"'/>");
    // }
	
    </script>
</body>
</html>
