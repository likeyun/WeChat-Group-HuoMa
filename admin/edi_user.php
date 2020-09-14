<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 用户账号编辑</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.bootcdn.net/ajax/libs/open-iconic/1.0.0/font/css/open-iconic.min.css" rel="stylesheet">
  <link href="https://cdn.bootcdn.net/ajax/libs/open-iconic/1.0.0/font/css/open-iconic-bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="icon" href="../images/xiaotubiao.png" type="image/x-icon" />
  <style type="text/css">
    .modal .modal-dialog .modal-content .modal-body .btn{
      position: relative;
    }

    .modal .modal-dialog .modal-content .modal-body .file_btn{
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
    }
  </style>
</head>
<body style="background:#fff;">
<div class="container">
  <h2>活码管理系统 - 用户账号编辑</h2>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">用户账号编辑</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.php">返回首页</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="tab-pane active"><br>
	    <?php
      header("Content-type:text/html;charset=utf-8");
	    session_start();
			if(isset($_SESSION["huoma.admin"])){

        // 数据库配置
        include '../MySql.php';

        // 创建连接
        $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);
				
				// 检查连接
				if ($conn->connect_error) {
				    die("连接失败: " . $conn->connect_error);
				}
				 
				$sql = "SELECT * FROM qun_huoma_user WHERE user_id =".$_GET["userid"];
				$result = $conn->query($sql);
				 
				if ($result->num_rows > 0) {
				    // 输出数据
				    while($row = $result->fetch_assoc()) {

				    $id  = $row["id"];
            $user_id  = $row["user_id"];
            $user_name  = $row["user_name"];
            $user_password  = $row["user_password"];
            $user_guoqidate  = $row["user_guoqidate"];
            $user_status  = $row["user_status"];
            $user_email  = $row["user_email"];
            $user_regtime  = $row["user_regtime"];

					 echo '<form role="form" action="##" onsubmit="return false" method="post" id="user_update" enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">用户名(账号)</span>
                  </div>
                  <input type="text" class="form-control" value="'.$user_name.'" name="user_name" placeholder="请输入用户名">
                </div>

                <div class="input-group mb-3" style="display:none;">
                  <div class="input-group-prepend">
                    <span class="input-group-text">用户ID</span>
                  </div>
                  <input type="text" class="form-control" for="disabledTextInput" value="'.$user_id.'" name="user_id" placeholder="请输入用户ID（系统生成，不要改动）">
                </div>';

                echo '<select class="form-control" style="margin-bottom:15px;" name="user_status">';
                      if ($user_status == 0) {
                        echo "<option value=\"0\">正常使用</option><option value=\"1\">暂停使用</option>";
                      }else if ($user_status == 1) {
                        echo "<option value=\"1\">暂停使用</option><option value=\"0\">正常使用</option>";
                      }
                      echo '</select>';
                     

                echo '<div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">用户登陆密码</span>
                  </div>
                  <input type="text" class="form-control" value="'.$user_password.'" name="user_password" placeholder="请输入用户登陆密码">
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">注册时间</span>
                  </div>
                  <input type="text" class="form-control" value="'.$user_regtime.'" name="user_regtime"">
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">到期时间</span>
                  </div>
                  <input type="text" class="form-control" value="'.$user_guoqidate.'" name="user_guoqidate" placeholder="请设置过期时间，格式：xxxx-xx-xx (例如2020-09-18)">
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">邮箱</span>
                  </div>
                  <input type="text" class="form-control" value="'.$user_email.'" name="user_email" placeholder="请输入用户邮箱">
                </div>

                <button type="button" class="btn btn-dark" onclick="updateuser()">更新用户信息</button>
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
function updateuser(){
  $.ajax({
      type: "POST",
      url: "edi_user_do.php",
      data: $('#user_update').serialize(),
      success: function (data) {
          if (data.result == '100') {
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
            location.href='user.php';
          }else{
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
          }
      },
      error : function() {
          $(".container .Result").css('display','block');
          $(".container .Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
      }
  });
  setTimeout('closesctips()', 2000);
}
</script>
</body>
</html>