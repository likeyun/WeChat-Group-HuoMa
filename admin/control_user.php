<!DOCTYPE html>
<html>
<head>
  <title>微信活码管理系统 - 用户管理</title>
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
    <h2>活码管理系统 - 用户管理</h2>
    <br>
    <!-- Nav pills -->
    <ul class="nav nav-pills" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="pill" href="#home">用户管理</a>
      </li>
      <li>
        <a href="index.php" class="nav-link">返回首页</a>
      </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div id="home" class="tab-pane active">
        <br>
        <?php
        header("Content-type:text/html;charset=utf-8");
        session_start();
        if (isset($_SESSION["huoma.admin"])) {
          // 已登录

          // 数据库配置
          include '../MySql.php';

          // 创建连接
          $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

          // 检查连接
          if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
          }

          $sql = "SELECT * FROM user";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            // 输出数据
            while ($row = $result->fetch_assoc()) {

              $username = $row["username"];
              $passwd = $row["passwd"];
              $max = $row["max"];
              $max2 = $row["max2"];
              echo '<div class="card" style="margin-bottom:15px;">
					    <div class="card-body">
					      <h4 class="card-title">'.$username.'</h4>
					      <a href="check_user_hm.php?user='.$username.'" class="card-link" style="color:#333;">查看用户创建的活码</a><br/>
					      <a href="check_user_qd.php?user='.$username.'" class="card-link" style="color:#333;">查看用户创建的渠道码</a>
					      <a href="#" class="card-link" data-toggle="modal" data-target="#edit_user" style="outline:none;color:#333;float: right;margin-right:10px;" onclick="edit_user(\''.$username.'\',\''.$passwd.'\',\''.$max.'\',\''.$max2.'\')">编辑用户</a>';
              echo "</div>";
              echo "</div>";
            }
            echo "<p style=\"color:#666;font-size:14px;\">Power By <a href=\"https://www.likeyun.cn\" style=\"text-decoration:none;color:#666;\">www.likeyun.cn</a> && Update By <a href=\"https://xsot.cn\" style=\"text-decoration:none;color:#666;\">xsot.cn</a></p>";
          } else {
            echo "暂无数据，请添加群活码";
          }
          $conn->close();
        } else {
          // 未登录
          echo "<script>location.href='login.php';</script>";
        }
        ?>
      </div>
    </div>
  </div>
  
<div class="modal fade" id="edit_user">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">编辑用户</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
   
      <!-- 模态框主体内容 -->
      <div class="modal-body">
    <div class="input-group mb-3">
        <div class="input-group-prepend"> <span class="input-group-text">账号</span>
        </div>
        <input type="text" class="form-control" id="username" placeholder="账号" disabled="disabled">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend"> <span class="input-group-text">密码</span>
        </div>
        <input type="text" class="form-control" id="passwd" placeholder="密码">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend"> <span class="input-group-text">限制活码个数</span>
        </div>
        <input type="number" class="form-control" id="max" placeholder="5">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend"> <span class="input-group-text">渠道码个数</span>
        </div>
        <input type="number" class="form-control" id="max2" placeholder="5">
    </div>
    <button type="button" class="btn btn-secondary" style="background-color:#00E3E3" onclick="edit()">修改信息</button>
    <button type="button" class="btn btn-secondary" style="background-color:#FF2D2D" onclick="del()">删除用户</button>
</div>
   
      <!-- 模态框底部 -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
      </div>
 
    </div>
  </div>
</div>

  <script>
    function edit_user(username,passwd,max,max2)
    {
      $('#username').val('' + username + '');
      $('#passwd').val('' + passwd + '');
      $('#max').val('' + max + '');
      $('#max2').val('' + max2 + '');
    }
    
    function edit()
    {
      $.ajax({
        method: 'POST',
        url: 'user_control_api.php',
        data: {
          method: 'changePasswd',
          username: $('#username').val(),
          passwd: $('#passwd').val(),
          max: $('#max').val(),
          max2: $('#max2').val()
        },
        success: function(data)
        {
          if(data.code == 200)
          {
            alert(data.msg)
            location.reload();
          }else{
            alert(data.msg)
          }
        }
      });
    }
    
    function del()
    {
      $.ajax({
        method: 'POST',
        url: 'user_control_api.php',
        data: {
          method: 'delUser',
          username: $('#username').val()
        },
        success: function(data)
        {
          if(data.code == 200)
          {
            alert(data.msg)
            location.reload();
          }else{
            alert(data.msg)
          }
        }
      });
    }
  </script>
</body>
</html>