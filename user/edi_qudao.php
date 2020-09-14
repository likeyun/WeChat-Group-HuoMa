<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 渠道码编辑</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
  <h2>活码管理系统 - 渠道码编辑</h2>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">渠道码编辑</a>
    </li>
     <li class="nav-item">
      <a class="nav-link" href="qudao.php">返回上一页</a>
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
			if(isset($_SESSION["huoma.user.admin"])){

        // 数据库配置
        include '../MySql.php';

        // 创建连接
        $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);
				
				// 检查连接
				if ($conn->connect_error) {
				    die("连接失败: " . $conn->connect_error);
				} 
				 
				$sql = "SELECT * FROM qun_huoma_qudao WHERE qudao_id =".$_GET["qudaoid"];
				$result = $conn->query($sql);
				 
				if ($result->num_rows > 0) {
				    // 输出数据
				    while($row = $result->fetch_assoc()) {

				    $id  = $row["id"];
            $qudao_id  = $row["qudao_id"];
            $qudao_title  = $row["qudao_title"];
            $qudao_yuming  = $row["qudao_yuming"];
            $qudao_type  = $row["qudao_type"];
            $qudao_content  = $row["qudao_content"];
            $qudao_biaoqian  = $row["qudao_biaoqian"];
            $qudao_pageview  = $row["qudao_pageview"];
            $qudao_update_time  = $row["qudao_update_time"];

					 echo '<form role="form" action="##" onsubmit="return false" method="post" id="qudao_update" enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">渠道码标题</span>
                  </div>
                  <input type="text" class="form-control" value="'.$qudao_title.'" name="qudao_title" placeholder="请输入渠道码标题">
                </div>';

                echo '<select class="form-control" style="margin-bottom:15px;" name="qudao_yuming">';
                echo '<option value="'.$qudao_yuming.'">'.$qudao_yuming.'</option>';
                $yuming_sql = "SELECT * FROM qun_huoma_yuming";
                $yuming_result = $conn->query($yuming_sql);
                  if ($yuming_result->num_rows > 0) {
                      // 输出数据
                      while($yuming_row = $yuming_result->fetch_assoc()) {
                        $ym = $yuming_row["yuming"];
                         echo '<option value="'.$ym.'">'.$ym.'</option>';
                      }
                      echo '<option value="http://'.$_SERVER['HTTP_HOST'].'">http://'.$_SERVER['HTTP_HOST'].'</option>';
                  } else {
                     echo '<option value="http://'.$_SERVER['HTTP_HOST'].'">http://'.$_SERVER['HTTP_HOST'].'</option>';
                  }
                echo "</select>";

                echo '<select class="form-control" style="margin-bottom:15px;" name="qudao_type">';
                      if ($qudao_type == 1) {
                        echo "<option value=\"1\">文本</option>";
                      }else if ($qudao_type == 2) {
                        echo "<option value=\"1\">链接</option>";
                      }
                      echo '<option value="1">文本</option>
                      <option value="2">链接</option>
                     </select>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">渠道码内容</span>
                  </div>
                  <input type="text" class="form-control" value="'.$qudao_content.'" name="qudao_content" placeholder="请输入内容（文本、链接）">
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">渠道标签</span>
                  </div>
                  <input type="text" class="form-control" value="'.$qudao_biaoqian.'" name="qudao_biaoqian" placeholder="请输入标签，方便你区分渠道来源">
                </div>

                <div class="input-group mb-3" style="display:none;">
                  <div class="input-group-prepend">
                    <span class="input-group-text">渠道ID</span>
                  </div>
                  <input type="text" class="form-control" value="'.$qudao_id.'" name="qudao_id">
                </div>

                <button type="button" class="btn btn-dark" onclick="updatequdao()">更新渠道码</button>
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
function updatequdao(){
  $.ajax({
      type: "POST",
      url: "edi_qudao_do.php",
      data: $('#qudao_update').serialize(),
      success: function (data) {
          if (data.result == '100') {
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
            location.href='qudao.php';
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