<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 微信活码编辑</title>
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
  <h2>活码管理系统 - 微信活码编辑</h2>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">微信活码编辑</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="weixin.php">返回上一页</a>
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
         
        $sql = "SELECT * FROM qun_huoma_wx WHERE wx_id =".$_GET["wxid"];
        $result = $conn->query($sql);
         
        if ($result->num_rows > 0) {
            // 输出数据
            while($row = $result->fetch_assoc()) {

            $id  = $row["id"];
            $wx_id  = $row["wx_id"];
            $wx_title  = $row["wx_title"];
            $wx_update_time  = $row["wx_update_time"];
            $wx_qrcode  = $row["wx_qrcode"];
            $wx_pageview  = $row["wx_pageview"];
            $wx_biaoqian  = $row["wx_biaoqian"];
            $wx_status  = $row["wx_status"];
            $wx_yuming  = $row["wx_yuming"];
            $wx_nummber  = $row["wx_nummber"];

            echo '<form role="form" action="##" onsubmit="return false" method="post" id="updatewx">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">微信活码标题</span>
                  </div>
                  <input type="text" class="form-control" name="wx_title" value="'.$wx_title.'" placeholder="请输入微信活码标题">
                </div>';

                 echo '<select class="form-control" id="wx_status" style="margin-bottom:15px;" name="wx_yuming">';
                 echo '<option value="'.$wx_yuming.'">当前域名：'.$wx_yuming.'</option>';
                 echo '<option value="http://'.$_SERVER['HTTP_HOST'].'">http://'.$_SERVER['HTTP_HOST'].'</option>';
                  // 获取落地域名列表
                  $sql_ldym = "SELECT * FROM qun_huoma_yuming";
                  $result_ldym = $conn->query($sql_ldym);
                  if ($result_ldym->num_rows > 0) {
                      // 输出数据
                      while($row_ldym = $result_ldym->fetch_assoc()) {
                        $ldym = $row_ldym["yuming"];
                         echo '<option value="'.$ldym.'">'.$ldym.'</option>';
                      }
                  } else {
                     // echo '<option value="http://'.$_SERVER['HTTP_HOST'].'/">http://'.$_SERVER['HTTP_HOST'].'</option>';
                  }
                echo "</select>";

                echo '<div class="upload_wx input-group mb-3">
                  <input type="text" class="form-control" name="wx_qrcode" value="'.$wx_qrcode.'" placeholder="请上传微信二维码">
                  <div class="input-group-append" style="cursor:pointer;">
                    <span class="input-group-text" data-toggle="modal" data-target="#select_wx_model">上传微信二维码</span>
                  </div>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">微信号</span>
                  </div>
                  <input type="text" class="form-control" name="wx_nummber" value="'.$wx_nummber.'" placeholder="请输入微信号">
                </div>';

                echo "</select>";
                echo '<label for="sel1">活码状态</label>';
                echo "<select class=\"form-control\" id=\"sel1\" style=\"margin-bottom:15px;\" name=\"wx_status\">";
                if ($wx_status == 0) {
                  echo "<option value=\"0\">暂停使用</option>";
                  echo "<option value=\"1\">正常使用</option>";
                }else if ($wx_status == 1) {
                   echo "<option value=\"1\">正常使用</option>";
                   echo "<option value=\"0\">暂停使用</option>";
                }
                echo "</select>";
                echo '<div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">标签</span>
                  </div>
                  <input type="text" class="form-control" name="wx_biaoqian" value="'.$wx_biaoqian.'" placeholder="请输入标签，用于识别或查找">
                </div>
                <input type="hidden" name="wx_id" value="'.$wx_id.'">
                <button type="button" class="btn btn-dark" onclick="updatewx()">更新微信活码</button>
              </form>';
            }
        } else {
            echo "发生错误";
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

<!-- 上传微信二维码控件 -->
<div class="modal fade" id="select_wx_model">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
 
      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">请上传微信二维码</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
 
      <!-- 模态框主体 -->
      <div class="wxbody modal-body">
        <form id="addwx_qrcode" enctype="multipart/form-data">
          <button type="button" class="btn btn-dark">
            <input type="file" id="select_wx" class="file_btn" name="file"/>
            选择图片
          </button>
        </form>
      </div>
 
      <!-- 模态框底部 -->
      <div class="wx_footer modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消上传</button>
      </div>
 
    </div>
  </div>
</div>

<script>
function closesctips(){
  $(".container .Result").css('display','none');
}
</script>
<!-- 编辑提交 -->
<script type="text/javascript">
function updatewx(){
    $.ajax({
        type: "POST",
        url: "edi_wx_do.php",
        data: $('#updatewx').serialize(),
        success: function (data) {
          // 更新成功
          if (data.result == "100") {
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
            location.href='weixin.php';
          }else{
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
          }
        },
        error : function() {
          // 更新失败
          $(".container .Result").css('display','block');
          $(".container .Result").html("<div class=\"alert alert-danger\"><strong>更新失败，服务器发生错误</strong></div>");
          
        }
    });
    setTimeout('closesctips()', 2000);
  }

  // 上传微信二维码
  var wx_lunxun = setInterval("upload_wx()",2000);
    function upload_wx() {
    var wx_filename = $("#select_wx").val();
    if (wx_filename) {
      clearInterval(wx_lunxun);
      var wxform = new FormData(document.getElementById("addwx_qrcode"));
      $.ajax({
        url:"upload.php",
        type:"post",
        data:wxform,
        cache: false,
        processData: false,
        contentType: false,
        success:function(data){
          if (data.res == "400") {
            $("#home .upload_wx").html("<input type=\"text\" class=\"form-control\" name=\"wx_qrcode\" value=\""+data.path+"\"><div class=\"input-group-append\"><span class=\"input-group-text\">已上传</span></div>");
            $(".modal .modal-dialog .modal-content .wxbody").html("<h3>上传成功</h3>");
            $(".modal .modal-dialog .wx_footer").html("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">完成上传</button>");
            console.log("上传成功");
          }
        },
        error:function(data){
          alert("上传失败");
        },
        beforeSend:function(data){
          $(".modal .modal-dialog .modal-content .wxbody").html("<h3>正在上传中...</h3>");
        }
      })
    }else{
      // console.log("等待上传");
    }
  }
</script>
</body>
</html>