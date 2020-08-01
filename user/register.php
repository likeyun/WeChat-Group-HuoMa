<!DOCTYPE html>
<html>
<head>
	<title>活码管理系统 - 注册</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="icon" href="https://bit-images.bj.bcebos.com/bit-new/file/20200629/3vum.jpg" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="../css/login.css">
	<style type="text/css">
		.container{
			width: 600px;
		}
	</style>
</head>
<body>
<div class="container mt-3">
  <br/>
  <br/>
  <br/>
  <h3>用户管理</h3>
  <p>里客云群活码/由<a href='https://xsot.cn'>XCSOFT</a>增加用户管理功能</p>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">账号</span>
      </div>
      <input type="text" class="form-control" placeholder="请设置账号" id="username">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">密码</span>
      </div>
      <input type="password" class="form-control" placeholder="请设置密码" id="passwd">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">再输一次密码</span>
      </div>
      <input type="password" class="form-control" placeholder="再输一次密码" id="repasswd">
    </div>
    <button type="button" class="btn btn-secondary"  onclick="register()">注册</button>
    <div style='height:5px'></div>
    <button type="button" class="btn btn-secondary" style='background-color: #77ac98' onclick="window.location.href='login.php'">已有账户?</button>
  <!-- Result -->
  <div class="Result"></div>
</div>
<script>
function closesctips(){
  $(".container .Result").css('display','none');
}
function register(){
    $.ajax({
        type: "POST",
        url: "registercheck.php",
        data: {
          username: $('#username').val(),
          passwd: $('#passwd').val(),
          repasswd: $('#repasswd').val(),
        },
        success: function (data) {
          // 登录成功
          if (data.result !== "200") {
             $(".container .Result").css('display','block');
             $(".container .Result").html('<div class="alert alert-danger"><strong>'+data.msg+'</strong></div>');
          }else{
             $(".container .Result").css('display','block');
             $(".container .Result").html('<div class="alert alert-success"><strong>'+data.msg+'</strong> 正在跳转至登录页面</div>');
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
