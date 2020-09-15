<!DOCTYPE html>
<html>
<head>
  <title>活码管理系统 - 添加邀请码</title>
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
  <h2>活码管理系统 - 添加邀请码</h2>
  <p>添加用户注册所需的邀请码，邀请码不限位数，自行创建。</p>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" href="add_qudao.php">添加邀请码</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="yqm.php">返回上一页</a>
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

        session_start();
        if(isset($_SESSION["huoma.admin"])){
          echo '<form role="form" action="##" onsubmit="return false" method="post" id="addyqm" enctype="multipart/form-data">
                <div class="input-group mb-3" id="yqminput">
                  <div class="input-group-prepend">
                    <span class="input-group-text">邀请码</span>
                  </div>
                  <input type="text" class="form-control" name="yqm" placeholder="请输入邀请码">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">可用天数</span>
                  </div>
                  <input type="text" class="form-control" name="yqm_daynum" placeholder="通过该邀请码注册的账号可以使用的天数">
                </div>
                <button type="button" class="btn btn-dark" onclick="addyqm()">添加邀请码</button>
                <button type="button" class="btn btn-dark" onclick="creatyqm()">随机生成</button>
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
  function addyqm(){
    $.ajax({
        type: "POST",
        url: "add_yqm_do.php",
        data: $('#addyqm').serialize(),
        success:function(data){
			if(data.result == '100'){
				$(".container .Result").css('display','block');
				$(".container .Result").html("<div class=\"alert alert-success\"><strong>添加成功</strong>！您可以继续添加或<a href=\"yqm.php\">返回上一页</a></div>");
			}else{
				$(".container .Result").css('display','block');
            	$(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
			}
			setTimeout('closesctips()', 3000);
        },
        error : function() {
          $(".container .Result").css('display','block');
          $(".container .Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
          setTimeout('closesctips()', 2000);
        }
    });
  }

  // 随机生成邀请码
	var str = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
	function generateMixed(n) {
	 var res = "";
	 for(var i = 0; i < n ; i ++) {
	    var id = Math.ceil(Math.random()*59);
	    res += str[id];
	 }
	 return res;
	}

	// 绑定button按钮
	function creatyqm(){
		var yqm = generateMixed(9);
		$("#yqminput").html("<div class=\"input-group-prepend\"><span class=\"input-group-text\">邀请码</span></div><input type=\"text\" class=\"form-control\" name=\"yqm\" value=\""+yqm+"\" placeholder=\"请输入邀请码\">")
	}
</script>
</body>
</html>