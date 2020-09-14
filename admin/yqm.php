<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 邀请码管理</title>
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
  <h2>活码管理系统 - 邀请码管理</h2>
  <p>本面板提供邀请码添加、删除管理，方便查看注册邀请码的使用状态和使用时间。</p>
  <br/>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">邀请码</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="add_yqm.php">添加邀请码</a>
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
        $sql_yqm = "SELECT * FROM qun_huoma_yqm";
        $result_yqm = $conn->query($sql_yqm);
        $allyqm_num = $result_yqm->num_rows;

        //每页显示的邀请码数量
        $lenght = 5;

        //当前页码
        @$page = $_GET['page']?$_GET['page']:1;

        //每页第一行
        $offset = ($page-1)*$lenght;

        //总数页
        $allpage = ceil($allyqm_num/$lenght);

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
                // 遍历所有邀请码
                $sql_allyqm = "SELECT * FROM qun_huoma_yqm ORDER BY ID DESC limit {$offset},{$lenght}";
                $result_allyqm = $conn->query($sql_allyqm);
                if ($result_allyqm->num_rows > 0) {
                  while($row_allyqm = $result_allyqm->fetch_assoc()) {
                    $id  = $row_allyqm["id"];
                    $yqm  = $row_allyqm["yqm"];
                    $yqm_daynum  = $row_allyqm["yqm_daynum"];
                    $use_time  = $row_allyqm["use_time"];
                    $yqm_status  = $row_allyqm["yqm_status"];

                    echo '<div class="card" style="margin-bottom:15px;">
                    <div class="card-body">
                    <h4 class="card-title">'.$yqm.'</h4>
                    <a href="#" class="card-link" data-toggle="modal" data-target="#del-user" id="'.$id.'" onclick="get_yqmid(this);" style="outline:none;color:#333;">删除</a>';
                    if ($yqm_status == 0) {
                      echo '<span class="badge badge-success" style="float: right;margin-right:10px;"><span class="oi oi-circle-check"></span> 未使用</span>';
                      echo '<span class="badge badge-secondary" style="float: right;margin-right:10px;">'.$yqm_daynum.'天</span>';
                    }else{
                      // echo '<span class="badge badge-secondary" style="float: right;margin-right:10px;">'..'</span>';
                      echo '<span class="badge badge-danger" style="float: right;margin-right:10px;"><span class="oi oi-circle-x"></span> 已在'.$use_time.'使用</span>';
                      echo '<span class="badge badge-secondary" style="float: right;margin-right:10px;">'.$yqm_daynum.'天</span>';
                    }
                    echo "</div>";
                    echo "</div>";
                  }
                  echo "<ul class=\"pagination\">";
		          if ($page == 1) {
		            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:;\" style=\"color:#333;font-size:14px;\">当前是第".$page."页</a></li>";
		            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"yqm.php?page=".$nextpage."\" style=\"color:#333;font-size:14px;\">下一页</a></li>";
		          }else if ($page == $allpage) {
		            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"yqm.php?page=".$prepage."\" style=\"color:#333;font-size:14px;\">上一页</a></li>";
		            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:;\" style=\"color:#333;font-size:14px;\">当前是第".$page."页，已经是最后一页</a></li>";
		          }else{
		            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"yqm.php?page=".$prepage."\" style=\"color:#333;font-size:14px;\">上一页</a></li>";
		            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:;\" style=\"color:#333;font-size:14px;\">当前是第".$page."页</a></li>";
		            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"yqm.php?page=".$nextpage."\" style=\"color:#333;font-size:14px;\">下一页</a></li>";
		          }
		        echo "</ul>";
                }else{
                  echo "暂无邀请码，请添加";
                }
              }
            }
            
        } else {
            //无法获取到用户信息
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
        <h4 class="modal-title">删除邀请码</h4>
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
  function get_yqmid(event){
    var yqmid = event.id;
      $(".modal .modal-dialog .modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" id="+yqmid+" onclick=\"delyqm(this);\">确定删除</button>");
  }

  function delyqm(event){
    var delete_yqmid = event.id;
    $.ajax({
        type: "GET",
        url: "del_yqm.php?yqmid="+delete_yqmid,
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