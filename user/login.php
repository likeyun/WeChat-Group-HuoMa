<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 登录</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="icon" href="https://bit-images.bj.bcebos.com/bit-new/file/20200629/3vum.jpg" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="../css/login.css">
  <link rel="icon" href="../images/xiaotubiao.png" type="image/x-icon" />
</head>
<body>

<div class="container mt-3">
  <br/><h1>登录活码管理系统 - 客户端</h1><br/>
  <form role="form" action="##" onsubmit="return false" method="post" id="login">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">账号</span>
      </div>
      <input type="text" class="form-control" name="user" placeholder="请输入账号">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">密码</span>
      </div>
      <input type="password" class="form-control" name="pwd" placeholder="请输入密码">
    </div>
    <button type="button" class="btn btn-secondary" onclick="login()">登录</button><br/><br/>
  </form>

  <!-- Result -->
  <div class="Result"></div>
  <a href="reg.php" style="margin-top:10px;text-align: center;display: block;color: #666;">没有账号？点击这里注册账号</a>
</div>

<script>
function closesctips(){
  $(".container .Result").css('display','none');
}
</script>
<!-- 登录 -->
<script type="text/javascript">
function login(){
    $.ajax({
        type: "POST",
        url: "logincheck.php",
        data: $('#login').serialize(),
        success: function (data) {
          // 登录成功
          if (data.result == "100") {
             $(".container .Result").css('display','block');
             $(".container .Result").html('<div class="alert alert-success"><strong>'+data.msg+'</strong> 正在跳转至首页</div>');
             location.href='index.php';
          }else{
             $(".container .Result").css('display','block');
             $(".container .Result").html('<div class="alert alert-danger"><strong>'+data.msg+'</strong></div>');
          }
          // 关闭提示
          setTimeout('closesctips()', 2000);
        },
        error : function() {
          // 更新失败
           $(".container .Result").css('display','block');
           $(".container .Result").html('<div class="alert alert-danger"><strong>服务器错误，请检查配置文件</strong></div>');
           setTimeout('closesctips()', 2000);
        }
    });
        }
</script>
</body>
</html>