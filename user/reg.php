<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 用户注册</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="icon" href="../images/xiaotubiao.png" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>

<div class="container mt-3">
  <br/><h1>活码管理系统 - 用户注册</h1><br/>
  <form role="form" action="##" onsubmit="return false" method="post" id="reg">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">账号</span>
      </div>
      <input type="text" class="form-control" name="hm_user" placeholder="请输入账号">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">密码</span>
      </div>
      <input type="password" class="form-control" name="hm_pwd" placeholder="请输入密码">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">重复密码</span>
      </div>
      <input type="password" class="form-control" name="hm_cpwd" placeholder="请再次输入密码">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">邮箱</span>
      </div>
      <input type="email" class="form-control" name="hm_email" placeholder="请输入邮箱">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">邀请码</span>
      </div>
      <input type="text" class="form-control" name="hm_yqm" placeholder="请输入邀请码">
    </div>
    <button type="button" class="btn btn-secondary" onclick="reg()">注册账号</button>
  </form>

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
function reg(){
    $.ajax({
        type: "POST",
        url: "regcheck.php",
        data: $('#reg').serialize(),
        success: function (data) {
          // 注册成功
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
        error : function(data) {
          // 注册失败
           $(".container .Result").css('display','block');
           $(".container .Result").html('<div class="alert alert-danger"><strong>服务器错误，请检查配置文件</strong></div>');
           setTimeout('closesctips()', 2000);
           console.log(data);
        }
    });
        }
</script>
</body>
</html>