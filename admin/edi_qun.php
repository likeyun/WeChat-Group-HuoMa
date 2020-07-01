<?php
header("Content-type:text/html;charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 群活码编辑</title>
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
  <h2>活码管理系统 - 群活码编辑</h2>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">群活码编辑</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.php">返回首页</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="tab-pane active"><br>
	    <?php
	    	session_start();
			if(isset($_SESSION["huoma.admin"])){

				//数据库配置
				require_once("../MySql.php");

				// 创建连接
				$conn = new mysqli($servername, $username, $password, $dbname);
				
				// 检查连接
				if ($conn->connect_error) {
				    die("连接失败: " . $conn->connect_error);
				} 
				 
				$sql = "SELECT * FROM qun_huoma WHERE hm_id =".$_GET["hmid"];
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

					echo '<form role="form" action="##" onsubmit="return false" method="post" id="update">
						    <div class="form-group">
						      <label style="font-size:16px;" class="badge badge-secondary">活码标题</label>
						      <input type="text" class="form-control" name="title" value="'.$title.'">
						    </div>
						    <div class="form-group">
						      <label style="font-size:16px;" class="badge badge-secondary">群二维码URL</label> <a href="http://upload.likeyunba.com/" target="blank" style="cursor:pointer;"><label style="font-size:16px;" class="badge badge-secondary">上传图片</label></a>
						      <input type="text" class="form-control" name="qun_qrcode" value="'.$qun_qrcode.'">
						    </div>
						    <div class="form-group">
						      <label style="font-size:16px;" class="badge badge-secondary">微信二维码URL</label> <a href="http://upload.likeyunba.com/" target="blank" style="cursor:pointer;"><label style="font-size:16px;" class="badge badge-secondary">上传图片</label></a>
						      <input type="text" class="form-control" name="wx_qrcode" value="'.$wx_qrcode.'">
						    </div>
						    <div class="form-group">
						      <label style="font-size:16px;" class="badge badge-secondary">微信号</label>
						      <input type="text" class="form-control" name="wxid" value="'.$wxid.'">
						    </div>
                <div class="form-group">
                  <label style="font-size:16px;" class="badge badge-secondary">标签</label>
                  <input type="text" class="form-control" name="biaoqian" value="'.$biaoqian.'">
                </div>
						    <div class="form-group" style="display:none;">
						      <label style="font-size:16px;" class="badge badge-secondary">hmid</label>
						      <input type="text" class="form-control" name="hm_id" value="'.$hm_id.'">
						    </div>
						    <button type="button" class="btn btn-dark" onclick="update()">更新</button>
						  </form>';
				    }
				} else {
				    echo "0 结果";
				}
				$conn->close();
			}else{
				// 未登录
				echo "<script>location.href='login.php';</script>";
			}
			
		?>

    </div>
  </div>
  <!-- Result -->
  <div class="Result" style="margin-top: 30px;display: none;"></div>
</div>

<script>
function closesctips(){
	$(".container .Result").css('display','none');
}
</script>
<!-- 编辑提交 -->
<script type="text/javascript">
function update(){
    $.ajax({
        type: "POST",
        url: "edi_qun_do.php",
        data: $('#update').serialize(),
        success: function (data) {
        	// 更新成功
        	if (data.result == "101") {
        		$(".container .Result").css('display','block');
        		$(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
        	}else if (data.result == "102") {
        		$(".container .Result").css('display','block');
        		$(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
        	}else if (data.result == "103") {
        		$(".container .Result").css('display','block');
        		$(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
        	}else if (data.result == "104") {
        		$(".container .Result").css('display','block');
        		$(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
        	}else if (data.result == "105") {
        		$(".container .Result").css('display','block');
        		$(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
        	}else if (data.result == "100") {
        		$(".container .Result").css('display','block');
        		$(".container .Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
        		location.href='index.php';
        	}else{
        		$(".container .Result").css('display','block');
        		$(".container .Result").html("<div class=\"alert alert-danger\"><strong>更新失败，发生错误</strong></div>");
        	}
        	// 关闭提示
        	setTimeout('closesctips()', 2000);
        },
        error : function() {
        	// 更新失败
        	$(".container .Result").css('display','block');
        	$(".container .Result").html("<div class=\"alert alert-danger\"><strong>更新失败，服务器发生错误</strong></div>");
        	setTimeout('closesctips()', 2000);
        }
    });
        }
</script>
</body>
</html>
