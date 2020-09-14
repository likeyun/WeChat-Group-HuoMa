<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 用户管理</title>
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
  <h2>活码管理系统 - 用户账号管理</h2>
  <p>本面板提供用户账号管理，当有其他用户注册，本面板会显示已注册的用户，您可以对用户账号进行编辑、删除、修改权限等操作。</p>
  <br/>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">账号管理</a>
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
        // 已登录
        
        // 数据库配置
        include '../MySql.php';

        // 创建连接
        $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);
        
        // 检查连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }

        //计算总邀请码数量
        $sql_user = "SELECT * FROM qun_huoma_user";
        $result_user = $conn->query($sql_user);
        $alluser_num = $result_user->num_rows;

        //每页显示的用户数量
        $lenght = 5;

        //当前页码
        @$page = $_GET['page']?$_GET['page']:1;

        //每页第一行
        $offset = ($page-1)*$lenght;

        //总数页
        $allpage = ceil($alluser_num/$lenght);

        //上一页     
        $prepage = $page-1;
        if($page==1){
          $prepage=1;
        }

        //下一页
        $nextpage = $page+1;
        if($page==$allpage){
          $nextpage=$allpage;
        }
        
        // 获取当前登陆的账号的管理权限
        $sql = "SELECT * FROM qun_huoma_user WHERE user_name = '".$_SESSION["huoma.admin"]."'";
        $result = $conn->query($sql);
         
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            $user_quanxian  = $row["user_quanxian"];
              // 判断管理权限
              if ($user_quanxian == '0') {
                echo "你不是管理员，没有管理权限";
              }else{
                // 遍历所有账号
                $sql_alluser = "SELECT * FROM qun_huoma_user ORDER BY ID DESC limit {$offset},{$lenght}";
                $result_alluser = $conn->query($sql_alluser);
                if ($result_alluser->num_rows > 0) {
                  while($row_alluser = $result_alluser->fetch_assoc()) {
                    $id  = $row_alluser["id"];
                    $user_id  = $row_alluser["user_id"];
                    $user_regtime  = $row_alluser["user_regtime"];
                    $user_name  = $row_alluser["user_name"];
                    $user_guoqidate  = $row_alluser["user_guoqidate"];
                    $user_status  = $row_alluser["user_status"];
                    $user_email  = $row_alluser["user_email"];

                    echo '<div class="card" style="margin-bottom:15px;">
                    <div class="card-body">
                    <h4 class="card-title">'.$user_name.'</h4>
                    <a href="edi_user.php?userid='.$user_id.'" class="card-link" style="color:#333;">编辑</a>
                    <a href="#" class="card-link" data-toggle="modal" data-target="#del-user" id="'.$user_id.'" onclick="get_user_delid(this);" style="outline:none;color:#333;">删除</a>
                    <span class="badge badge-secondary" style="float: right;margin-right:10px;">到期：'.$user_guoqidate.'</span>
                    <span class="badge badge-warning" style="float: right;margin-right:10px;">'.$user_email.'</span>';
                    if ($user_status == 0) {
                      echo '<span class="badge badge-success" style="float: right;margin-right:10px;"><span class="oi oi-circle-check"></span> 正常使用</span>';
                    }else{
                      echo '<span class="badge badge-danger" style="float: right;margin-right:10px;"><span class="oi oi-circle-x"></span> 暂停使用</span>';
                    }
                    echo "</div>";
                    echo "</div>";
                  }
                  echo "<ul class=\"pagination\">";
                    if ($page == 1) {
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:;\" style=\"color:#333;font-size:14px;\">当前是第".$page."页</a></li>";
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"user.php?page=".$nextpage."\" style=\"color:#333;font-size:14px;\">下一页</a></li>";
                    }else if ($page == $allpage) {
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"user.php?page=".$prepage."\" style=\"color:#333;font-size:14px;\">上一页</a></li>";
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:;\" style=\"color:#333;font-size:14px;\">当前是第".$page."页，已经是最后一页</a></li>";
                    }else{
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"user.php?page=".$prepage."\" style=\"color:#333;font-size:14px;\">上一页</a></li>";
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:;\" style=\"color:#333;font-size:14px;\">当前是第".$page."页</a></li>";
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"user.php?page=".$nextpage."\" style=\"color:#333;font-size:14px;\">下一页</a></li>";
                    }
                  echo "</ul>";
                }else{
                  echo "暂无用户";
                }
              }
            }
            
        } else {
            //查询不到用户权限信息
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


<!-- 删除模态框 -->
<div class="modal fade" id="del-user">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">删除用户</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
   
      <!-- 模态框主体内容 -->
      <div class="modal-body">确定要删除吗？</div>
   
      <!-- 模态框底部 -->
      <div class="modal-footer"></div>

    </div>
  </div>
</div>

<script>
 //删除用户
  function get_user_delid(event){
    var userdelid = event.id;
      $(".modal .modal-dialog .modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" id="+userdelid+" onclick=\"deluser(this);\">确定删除</button>");
  }

  function deluser(event){
    var delete_userid = event.id;
    $.ajax({
        type: "GET",
        url: "del_user.php?userid="+delete_userid,
        success: function (data) {
          if (data.result == "101") {
            alert(data.msg);
          }else if (data.result == "102") {
            alert(data.msg);
          }else if (data.result == "100") {
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