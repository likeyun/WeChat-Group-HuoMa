<!-- // 里客云科技开发
// www.likeyun.cn
// 作者：TANKING
// 请保留版权信息
// 仅用于学习用途
// 基于php5.6开发
// 前端使用Bootstrap4.0 -->
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
</head>
<body>

<div class="container mt-3">
  <br/><h1>登录活码用户系统</h1><br/>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">账号</span>
      </div>
      <input type="text" class="form-control" id="username" placeholder="请输入账号">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">密码</span>
      </div>
      <input type="password" class="form-control" id="passwd" placeholder="请输入密码">
    </div>
    <button type="button" class="btn btn-secondary" onclick="login()">登录</button>
    <div style='height:5px'></div>
    <button type="button" class="btn btn-secondary" style='background-color:#77ac98' onclick="window.location.href='register.php'">没有账户?</button>
  <!-- Result -->
  <div class="Result"></div>
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
        data: {
          username: $('#username').val(),
          passwd: $('#passwd').val()
        },
        success: function (data) {
          // 登录成功
          if (data.result !== "200") {
             $(".container .Result").css('display','block');
             $(".container .Result").html('<div class="alert alert-danger"><strong>'+data.msg+'</strong></div>');
          } else {
             $(".container .Result").css('display','block');
             $(".container .Result").html('<div class="alert alert-success"><strong>'+data.msg+'</strong> 正在跳转至首页</div>');
             location.href='index.php';
          }
          // 关闭提示
          setTimeout('closesctips()', 2000);
        },
        error : function() {
          // 更新失败
          alert("error");
        }
    });
        }
</script>
</body>
</html>