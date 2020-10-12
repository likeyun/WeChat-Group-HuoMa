<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 创建群活码</title>
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
  <h2>活码管理系统 - 创建群活码</h2>
  <p>微信群二维码有效期7天，过期后将无法扫码进群，微信群活码可以在不更换二维码的情况下，可以保持微信群二维码的更新！</p>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">创建群活码</a>
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
          echo '<form role="form" action="##" onsubmit="return false" method="post" id="addqun" enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">群活码标题</span>
                  </div>
                  <input type="text" class="form-control" name="title" placeholder="请输入群活码标题">
                </div>';

                echo '<select class="form-control" style="margin-bottom:15px;" name="yuming">';
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

                echo '<div class="upload_qun input-group mb-3">
                  <input type="text" class="form-control" name="qun_qrcode" placeholder="请上传微信群二维码">
                  <div class="input-group-append" style="cursor:pointer;">
                    <span class="input-group-text" data-toggle="modal" data-target="#select_qun_model">上传微信群二维码</span>
                  </div>
                </div>

                <div class="upload_wx input-group mb-3">
                  <input type="text" class="form-control" name="wx_qrcode" placeholder="请上传微信二维码">
                  <div class="input-group-append" style="cursor:pointer;">
                    <span class="input-group-text" data-toggle="modal" data-target="#select_wx_model">上传微信二维码</span>
                  </div>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">微信号</span>
                  </div>
                  <input type="text" class="form-control" name="wxid" placeholder="请输入微信号">
                </div>';

                echo '<label for="byewm_status">是否开启备用群</label>
                <select class="form-control" id="byqun_status" style="margin-bottom:15px;" name="byqun_status">
                  <option value="0">关闭</option>
                  <option value="1">开启</option>
                </select>';

                echo '<div id="byewm_upload" style="display:none;">
                <div class="upload_byqun input-group mb-3">
                <input type="text" class="form-control" name="byqun_qrcode" placeholder="请上传备用群二维码">
                <div class="input-group-append" style="cursor:pointer;">
                <span class="input-group-text" data-toggle="modal" data-target="#select_byqun_model">上传备用群二维码</span>
                </div>
                </div>
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">阈值</span>
                </div>
                <input type="text" class="form-control" name="byqun_maxnum" placeholder="当访问量达到多少，自动切换备用群">
                </div>
                </div>';

                echo '<label for="sel1">是否显示微信二维码和微信号</label>
                <select class="form-control" id="sel1" style="margin-bottom:15px;" name="wxstatus">
                  <option value="1">显示</option>
                  <option value="0">隐藏</option>
                </select>
                <label for="sel1">活码状态</label>
                <select class="form-control" id="sel1" style="margin-bottom:15px;" name="huoma_status">
                  <option value="1">正常使用</option>
                  <option value="0">暂停使用</option>
                </select>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">标签</span>
                  </div>
                  <input type="text" class="form-control" name="biaoqian" placeholder="请输入标签，用于识别或查找">
                </div>
                <button type="button" class="btn btn-dark" onclick="addqun()">创建群活码</button>
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


<!-- 上传微信群二维码控件 -->
<div class="modal fade" id="select_qun_model">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
 
      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">上传微信群二维码</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
 
      <!-- 模态框主体 -->
      <div class="qunbody modal-body">
        <form id="addqun_qrcode" enctype="multipart/form-data">
          <button type="button" class="btn btn-dark">
            <input type="file" id="select_qun" class="file_btn" name="file"/>
            选择图片
          </button>
        </form>
      </div>
 
      <!-- 模态框底部 -->
      <div class="qun_footer modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消上传</button>
      </div>
 
    </div>
  </div>
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


<!-- 上传备用微信群二维码控件 -->
<div class="modal fade" id="select_byqun_model">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
 
      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">上传备用微信群二维码</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
 
      <!-- 模态框主体 -->
      <div class="byqunbody modal-body">
        <form id="addbyqun_qrcode" enctype="multipart/form-data">
          <button type="button" class="btn btn-dark">
            <input type="file" id="select_byqun" class="file_btn" name="file"/>
            选择图片
          </button>
        </form>
      </div>
 
      <!-- 模态框底部 -->
      <div class="byqun_footer modal-footer">
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
  function addqun(){
    $.ajax({
        type: "POST",
        url: "add_qun_do.php",
        data: $('#addqun').serialize(),
        success: function (data) {
          // 创建成功
          if (data.result == "100") {
            $(".container .Result").css('display','block');
            $(".container .Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
            window.setTimeout("window.location='index.php'",1800); 
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

  // 上传微信群二维码
  var qun_lunxun = setInterval("upload_qun()",2000);
    function upload_qun() {
    var qun_filename = $("#select_qun").val();
    if (qun_filename) {
      clearInterval(qun_lunxun);
      var qunform = new FormData(document.getElementById("addqun_qrcode"));
      $.ajax({
        url:"upload.php",
        type:"post",
        data:qunform,
        cache: false,
        processData: false,
        contentType: false,
        success:function(data){
          if (data.res == "400") {
            $("#home .upload_qun").html("<input type=\"text\" class=\"form-control\" name=\"qun_qrcode\" value=\""+data.path+"\"><div class=\"input-group-append\"><span class=\"input-group-text\">已上传</span></div>");
            $(".modal .modal-dialog .modal-content .qunbody").html("<h3>上传成功</h3>");
            $(".modal .modal-dialog .qun_footer").html("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">完成上传</button>");
            console.log("上传成功");
          }
        },
        error:function(data){
          alert("上传失败");
        },
        beforeSend:function(data){
          $(".modal .modal-dialog .modal-content .qunbody").html("<h3>正在上传中...</h3>");
        }
      })
    }else{
      // console.log("等待上传");
    }
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


  // 上传微信群二维码
  var byqun_lunxun = setInterval("upload_byqun()",2000);
    function upload_byqun() {
    var byqun_filename = $("#select_byqun").val();
    if (byqun_filename) {
      clearInterval(byqun_lunxun);
      var qunform = new FormData(document.getElementById("addbyqun_qrcode"));
      $.ajax({
        url:"upload.php",
        type:"post",
        data:qunform,
        cache: false,
        processData: false,
        contentType: false,
        success:function(data){
          if (data.res == "400") {
            $("#home .upload_byqun").html("<input type=\"text\" class=\"form-control\" name=\"byqun_qrcode\" value=\""+data.path+"\"><div class=\"input-group-append\"><span class=\"input-group-text\">已上传</span></div>");
            $(".modal .modal-dialog .modal-content .byqunbody").html("<h3>上传成功</h3>");
            $(".modal .modal-dialog .byqun_footer").html("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">完成上传</button>");
            console.log("上传成功");
          }
        },
        error:function(data){
          alert("上传失败");
        },
        beforeSend:function(data){
          $(".modal .modal-dialog .modal-content .byqunbody").html("<h3>正在上传中...</h3>");
        }
      })
    }else{
      // console.log("等待上传");
    }
  }


  //监听备用二维码的启用状态
  $("#byqun_status").bind('input propertychange',function(e){
    //获取当前点击的状态
    var byewm_status = $(this).val();
    //如果开启备用群，则需要显示上传二维码和设置最大值
    if (byewm_status == 1) {
      $("#byewm_upload").css("display","block");
    }else if (byewm_status == 0) {
      //否则隐藏，不显示
      $("#byewm_upload").css("display","none");
    }
  })
</script>
</body>
</html>