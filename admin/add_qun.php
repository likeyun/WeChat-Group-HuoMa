<?php
header("Content-type:text/html;charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 添加群活码</title>
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
  <h2>活码管理系统 - 添加群活码</h2>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">添加群活码</a>
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
          echo '<form role="form" action="##" onsubmit="return false" method="post" id="update">
                <div class="form-group">
                  <label style="font-size:16px;" class="badge badge-secondary">活码标题</label>
                  <input type="text" class="form-control" name="title" placeholder="请输入群活码标题">
                </div>
                <div class="form-group">
                  <label style="font-size:16px;" class="badge badge-secondary">群二维码URL</label> <a href="http://upload.likeyunba.com/" target="blank" style="cursor:pointer;"><label style="font-size:16px;" class="badge badge-secondary">上传图片</label></a>
                  <input type="text" class="form-control" name="qun_qrcode" placeholder="请粘贴群二维码URL">
                </div>
                <div class="form-group">
                  <label style="font-size:16px;" class="badge badge-secondary">微信二维码URL</label> <a href="http://upload.likeyunba.com/" target="blank" style="cursor:pointer;"><label style="font-size:16px;" class="badge badge-secondary">上传图片</label></a>
                  <input type="text" class="form-control" name="wx_qrcode" placeholder="请粘贴微信二维码URL">
                </div>
                <div class="form-group">
                  <label style="font-size:16px;" class="badge badge-secondary">微信号</label>
                  <input type="text" class="form-control" name="wxid" placeholder="请输入微信号">
                </div>
                <div class="form-group">
                  <label style="font-size:16px;" class="badge badge-secondary">标签</label>
                  <input type="text" class="form-control" name="biaoqian" placeholder="请输入标签，用于识别或查找">
                </div>
                <button type="button" class="btn btn-dark" onclick="addqun()">添加群活码</button>
              </form>';
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
function addqun(){
    $.ajax({
        type: "POST",
        url: "add_qun_do.php",
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
          }else if (data.result == "106") {
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
          }else if (data.result == "107") {
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
          }else if (data.result == "100") {
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
            location.href='index.php';
          }else{
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>添加失败，发生错误</strong></div>");
          }
          // 关闭提示
          setTimeout('closesctips()', 2000);
        },
        error : function() {
          // 更新失败
          $(".container .Result").css('display','block');
          $(".container .Result").html("<div class=\"alert alert-danger\"><strong>添加失败，服务器发生错误</strong></div>");
          setTimeout('closesctips()', 2000);
        }
    });
  }
</script>
</body>
</html>
