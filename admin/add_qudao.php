<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 创建渠道码</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="icon" href="https://bit-images.bj.bcebos.com/bit-new/file/20200629/3vum.jpg" type="image/x-icon" />
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
  <h2>活码管理系统 - 创建渠道码</h2>
  <p>什么是渠道码？就是一个二维码，相比于其他二维码，渠道码可以统计访问次数，可以创建不同的渠道码，用于投放在不同的场所，可以统计不同渠道的效果，也可以在不变更二维码的前提下修改文本或跳转的链接，可以理解为文本活码和网址活码。</p>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link" href="qudao.php">管理渠道码</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="add_qudao.php">创建渠道码</a>
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

        // 数据库配置
        include '../MySql.php';

        // 创建连接
        $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

        // 检查连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        } 
         
        $sql = "SELECT * FROM qun_huoma_yuming";
        $result = $conn->query($sql);
         
        
        session_start();
        if(isset($_SESSION["huoma.admin"])){
          echo '<form role="form" action="##" onsubmit="return false" method="post" id="addqudao" enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">渠道码标题</span>
                  </div>
                  <input type="text" class="form-control" name="qudao_title" placeholder="请输入渠道码标题">
                </div>';

                echo '<select class="form-control" style="margin-bottom:15px;" name="qudao_yuming">';
                echo '<option value="">请选择落地页域名</option>';
                  if ($result->num_rows > 0) {
                      // 输出数据
                      while($row = $result->fetch_assoc()) {
                        $ym = $row["yuming"];
                         echo '<option value="'.$ym.'">'.$ym.'</option>';
                      }
                      echo '<option value="http://'.$_SERVER['HTTP_HOST'].'">http://'.$_SERVER['HTTP_HOST'].'</option>';
                  } else {
                     echo '<option value="http://'.$_SERVER['HTTP_HOST'].'">http://'.$_SERVER['HTTP_HOST'].'</option>';
                  }
                echo "</select>";

                echo '<select class="form-control" style="margin-bottom:15px;" name="qudao_type">
                      <option value="">请选择渠道码类型</option>
                      <option value="1">文本</option>
                      <option value="2">链接</option>
                     </select>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">渠道码内容</span>
                  </div>
                  <input type="text" class="form-control" name="qudao_content" placeholder="请输入内容（文本、链接）">
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">标签</span>
                  </div>
                  <input type="text" class="form-control" name="qudao_biaoqian" placeholder="请输入标签，用于识别或查找">
                </div>

                <button type="button" class="btn btn-dark" onclick="addqudao()">创建渠道码</button>
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
<!-- 提交 -->
<script type="text/javascript">
  function addqudao(){
    $.ajax({
        type: "POST",
        url: "add_qudao_do.php",
        data: $('#addqudao').serialize(),
        success:function(data){
			if(data.result == '100'){
				$(".container .Result").css('display','block');
				$(".container .Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
        location.href='qudao.php';
			}else{
				$(".container .Result").css('display','block');
            	$(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
			}
			setTimeout('closesctips()', 2000);
        },
        error : function() {
          $(".container .Result").css('display','block');
          $(".container .Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
          setTimeout('closesctips()', 2000);
        }
    });
  }
</script>
</body>
</html>