<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 创建微信活码</title>
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
  <h2>活码管理系统 - 创建微信活码</h2>
  <p>因个人微信号的扫码次数有限，一旦上限，别人扫码就无法加你微信，通过创建个人微信活码，方便随时切换个人微信号！</p>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" href="#home">创建微信活码</a>
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
        if(isset($_SESSION["huoma.user.admin"])){
          echo '<form role="form" action="##" onsubmit="return false" method="post" id="addwx" enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">微信活码标题</span>
                  </div>
                  <input type="text" class="form-control" name="wx_title" placeholder="请输入微信活码标题">
                </div>';

                echo '<select class="form-control" style="margin-bottom:15px;" name="wx_yuming">';
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

                echo '<div class="upload_wx input-group mb-3">
                  <input type="text" class="form-control" name="wx_qrcode" placeholder="请上传微信二维码">
                  <div class="input-group-append" style="cursor:pointer;">
                    <span class="input-group-text" data-toggle="modal" data-target="#select_wx_model">上传微信二维码</span>
                  </div>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">微信号</span>
                  </div>
                  <input type="text" class="form-control" name="wx_nummber" placeholder="请输入微信号">
                </div>';

                echo '<label for="sel1">活码状态</label>
                <select class="form-control" id="sel1" style="margin-bottom:15px;" name="wx_status">
                  <option value="1">正常使用</option>
                  <option value="0">暂停使用</option>
                </select>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">标签</span>
                  </div>
                  <input type="text" class="form-control" name="wx_biaoqian" placeholder="请输入标签，用于识别或查找">
                </div>
                <button type="button" class="btn btn-dark" onclick="addwx()">创建微信活码</button>
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


<!-- 上传微信二维码控件 -->
<div class="modal fade" id="select_wx_model">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
 
      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">上传微信二维码</h4>
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
<!-- 提交 -->
<script type="text/javascript">
  function addwx(){
    $.ajax({
        type: "POST",
        url: "add_wx_do.php",
        data: $('#addwx').serialize(),
        success: function (data) {
          // 创建成功
          if (data.result == "100") {
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
            window.setTimeout("window.location='weixin.php'",1800);
          }else{
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
          }
          // 关闭提示
          setTimeout('closesctips()', 2000);
        },
        error : function() {
          // 创建失败
          $(".container .Result").css('display','block');
          $(".container .Result").html("<div class=\"alert alert-danger\"><strong>添加失败，服务器发生错误</strong></div>");
          setTimeout('closesctips()', 2000);
        }
    });
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