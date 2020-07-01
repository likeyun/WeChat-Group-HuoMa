<?php
header("Content-type:text/html;charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
  <title>微信活码管理系统 - 首页</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="icon" href="https://bit-images.bj.bcebos.com/bit-new/file/20200629/3vum.jpg" type="image/x-icon" />
</head>
<body style="background:#fff;">
<div class="container">
  <h2>活码管理系统</h2>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">群活码</a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#menu1">微信活码</a>
    </li> -->
    <!-- <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#menu2">系统设置</a>
    </li> -->
    <li>
      <a href="add_qun.php" class="nav-link">添加群活码</a>
    </li>
    <!-- <li>
      <a href="add_wx.php" class="nav-link">添加微信活码</a>
    </li> -->
    <li>
      <a href="exitlogin.php" class="nav-link">退出登录</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="tab-pane active"><br>
	    <?php
	    	session_start();
			if(isset($_SESSION["huoma.admin"])){
				// 已登录
				// 数据库配置
				require_once("../MySql.php");

				// 创建连接
				$conn = new mysqli($servername, $username, $password, $dbname);
				
				// 检查连接
				if ($conn->connect_error) {
				    die("连接失败: " . $conn->connect_error);
				} 
				 
				$sql = "SELECT * FROM qun_huoma";
				$result = $conn->query($sql);
				 
				if ($result->num_rows > 0) {
				    // 输出数据
				    while($row = $result->fetch_assoc()) {

				    $id  = $row["id"];
				    $hm_id  = $row["hm_id"];
				    $title  = $row["title"];
				    $update_time  = $row["update_time"];
				    $qun_qrcode  = $row["qun_qrcode"];
				    $wx_qrcode  = $row["wx_qrcode"];
				    $wxid  = $row["wxid"];
				    $page_view  = $row["page_view"];
				    $biaoqian  = $row["biaoqian"];

					echo '<div class="card" style="margin-bottom:15px;">
					    <div class="card-body">
					      <h4 class="card-title">'.$title.'</h4>
					      <a href="edi_qun.php?hmid='.$hm_id.'" class="card-link" style="color:#333;">编辑</a>
					      <a href="#" class="card-link" data-toggle="modal" data-target="#del-huoma" id="'.$hm_id.'" onclick="getdelid(this);" style="outline:none;color:#333;">删除</a>
					      <a href="#" class="card-link" data-toggle="modal" data-target="#share-huoma" id="'.$hm_id.'" onclick="share(this);" style="outline:none;color:#333;">分享</a>
					      <span class="badge badge-secondary" style="float: right;">访问量：'.$page_view.'</span>
					      <span class="badge badge-secondary" style="float: right;margin-right:10px;">'.$update_time.'</span>
					      <span class="badge badge-warning" style="float: right;margin-right:10px;">'.$biaoqian.'</span>
					    </div>
				  	</div>';
				    }
            echo "<p style=\"color:#666;font-size:14px;\">Power By <a href=\"https://www.likeyun.cn\" style=\"text-decoration:none;color:#666;\">www.likeyun.cn</a></p>";
				} else {
				    echo "0 结果";
				}
				$conn->close();
			}else{
				// 未登录
				echo "<script>location.href='login.php';</script>";
			}
		?>

	  	<!-- 分页 -->
	  	<!-- <br/>
	  	<ul class="pagination">
		    <li class="page-item"><a class="page-link" href="#">上一页</a></li>
		    <li class="page-item"><a class="page-link" href="#">1</a></li>
		    <li class="page-item"><a class="page-link" href="#">2</a></li>
		    <li class="page-item"><a class="page-link" href="#">3</a></li>
		    <li class="page-item"><a class="page-link" href="#">下一页</a></li>
		  </ul> -->

    </div>
  </div>
</div>


<!-- 分享模态框 -->
<div class="modal fade" id="share-huoma">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">分享活码</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
   
      <!-- 模态框主体内容 -->
      <div class="modal-body"></div>
   
      <!-- 模态框底部 -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
      </div>
 
    </div>
  </div>
</div>


<!-- 删除模态框 -->
<div class="modal fade" id="del-huoma">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">删除活码</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
   
      <!-- 模态框主体内容 -->
      <div class="modal-body">确定要删除吗？</div>
   
      <!-- 模态框底部 -->
      <div class="modal-footer"></div>

    </div>
  </div>
</div>


<script type="text/javascript">
  // 分享
  function share(event){
      var shareid = event.id;
      $.ajax({
          type: "GET",
          url: "share.php?hmid="+shareid,
          success: function (data) {
          	if (data.result == "101") {
          		alert(data.msg);
          	}else if (data.result == "102") {
          		alert(data.msg);
          	}else if (data.result == "100") {
          		$("#share-huoma .modal-dialog .modal-body").html("链接："+data.url+"<img src='http://qr.topscan.com/api.php?text="+data.url+"' width='200'/>");
          	}else{
          		alert("未知错误");
          	}
          },
          error : function() {
            alert("error");
          }
      });
  }

  // 删除
  function getdelid(event){
  	var delid = event.id;
  	  $("#del-huoma .modal-dialog .modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" id="+delid+" onclick=\"del(this);\">确定删除</button>");
  }


  function del(event){
  	var deleteid = event.id;
	  $.ajax({
	      type: "GET",
	      url: "delete.php?hmid="+deleteid,
	      success: function (data) {
	      	if (data.result == "101") {
	      		alert(data.msg);
	      	}else if (data.result == "102") {
	      		alert(data.msg);
	      	}else if (data.result == "100") {
	      		// alert(data.msg);
	      		location.reload();
	      	}else{
	      		alert("未知错误");
	      	}
	      },
	      error : function() {
	        alert("error");
	      }
	  });
  }
</script>
</body>
</html>
