<!DOCTYPE html>
<html>
<head>
  <title>微信活码管理系统 - 首页</title>
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
</head>
<body style="background:#fff;">
<div class="container">
  <h2>活码管理系统</h2>
  <p>系统版本：v5.0.1</p>
  <br>
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#home">群活码管理</a>
    </li>
    <li>
      <a href="qudao.php" class="nav-link">渠道码管理</a>
    </li>
    <li>
      <a href="user.php" class="nav-link">用户管理</a>
    </li>
    <li>
      <a href="yqm.php" class="nav-link">邀请码</a>
    </li>
     <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#menu1">域名设置</a>
    </li>
    <li>
      <a href="exitlogin.php" class="nav-link">退出登录</a>
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
				$user = $_SESSION["huoma.admin"];

        // 数据库配置
        include '../MySql.php';

        // 创建连接
        $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);
				
		// 检查连接
		if ($conn->connect_error) {
		    die("连接失败: " . $conn->connect_error);
		} 

		//计算总活码数量
        $sql_huoma = "SELECT * FROM qun_huoma";
        $result_huoma = $conn->query($sql_huoma);
        $allhuoma_num = $result_huoma->num_rows;

        //每页显示的活码数量
        $lenght = 5;

        //当前页码
        @$page = $_GET['page']?$_GET['page']:1;

        //每页第一行
        $offset = ($page-1)*$lenght;

        //总数页
        $allpage = ceil($allhuoma_num/$lenght);

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
		 
		$sql = "SELECT * FROM qun_huoma ORDER BY ID DESC limit {$offset},{$lenght}";
		$result = $conn->query($sql);
		 
		if ($result->num_rows > 0) {
		    // 输出数据
		    while($row = $result->fetch_assoc()) {

		    $id  = $row["id"];
		    $hm_id  = $row["hm_id"];
		    $title  = $row["title"];
		    $update_time  = $row["update_time"];
		    $qun_qrcode  = $row["qun_qrcode"];
		    $wx_qrcode  = $row["wx_qrcode"];
		    $wxid  = $row["wxid"];
		    $page_view  = $row["page_view"];
    		$biaoqian  = $row["biaoqian"];
    		$wxstatus  = $row["wxstatus"];
    		$huoma_status  = $row["huoma_status"];
		    $byqun_status  = $row["byqun_status"];
		    $add_user  = $row["add_user"];

			echo '<div class="card" style="margin-bottom:15px;">
			    <div class="card-body">
			      <h4 class="card-title">'.$title.'</h4>
			      <a href="edi_qun.php?hmid='.$hm_id.'" class="card-link" style="color:#333;">编辑</a>
        		<a href="#" class="card-link" data-toggle="modal" data-target="#del-huoma" id="'.$hm_id.'" onclick="getdelid(this);" style="outline:none;color:#333;">删除</a>
			      <a href="#" class="card-link" data-toggle="modal" data-target="#share-huoma" id="'.$hm_id.'" onclick="share(this);" style="outline:none;color:#333;">分享</a>
			      <span class="badge badge-secondary" style="float: right;"><span class="oi oi-eye"></span> '.$page_view.'</span>
			      <span class="badge badge-secondary" style="float: right;margin-right:10px;">'.$update_time.'</span>
        		<span class="badge badge-warning" style="float: right;margin-right:10px;">'.$biaoqian.'</span>';
	        if ($wxstatus == 0) {
	          echo "<span class=\"badge badge-danger\" style=\"float: right;margin-right:10px;\"><span class=\"oi oi-circle-x\"></span> 微信</span>";
	        }else if ($wxstatus == 1) {
	          echo "<span class=\"badge badge-success\" style=\"float: right;margin-right:10px;\"><span class=\"oi oi-circle-check\"></span> 微信</span>";
	        }
	        if ($byqun_status == 0) {
	          echo "<span class=\"badge badge-danger\" style=\"float: right;margin-right:10px;\"><span class=\"oi oi-circle-x\"></span> 备用群</span>";
	        }else if ($byqun_status == 1) {
	          echo "<span class=\"badge badge-success\" style=\"float: right;margin-right:10px;\"><span class=\"oi oi-circle-check\"></span> 备用群</span>";
	        }
	        if ($huoma_status == 0) {
	          echo "<span class=\"badge badge-danger\" style=\"float: right;margin-right:10px;\"><span class=\"oi oi-circle-x\"></span> 暂停使用</span>";
	        }else if ($huoma_status == 1) {
	          echo "<span class=\"badge badge-success\" style=\"float: right;margin-right:10px;\"><span class=\"oi oi-circle-check\"></span> 正常使用</span>";
	        }
	        echo "<span class=\"badge badge-success\" style=\"float: right;margin-right:10px;\"><span class=\"oi oi-circle-person\"></span>账号:".$add_user."</span>";
		    echo "</div>";
  			echo "</div>";
		    }
		    echo "<ul class=\"pagination\">";
                    if ($page == 1) {
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:;\" style=\"color:#333;font-size:14px;\">当前是第".$page."页</a></li>";
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=".$nextpage."\" style=\"color:#333;font-size:14px;\">下一页</a></li>";
                    }else if ($page == $allpage) {
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=".$prepage."\" style=\"color:#333;font-size:14px;\">上一页</a></li>";
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:;\" style=\"color:#333;font-size:14px;\">当前是第".$page."页，已经是最后一页</a></li>";
                    }else{
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=".$prepage."\" style=\"color:#333;font-size:14px;\">上一页</a></li>";
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:;\" style=\"color:#333;font-size:14px;\">当前是第".$page."页</a></li>";
                      echo "<li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=".$nextpage."\" style=\"color:#333;font-size:14px;\">下一页</a></li>";
                    }
                  echo "</ul>";
            echo "<p style=\"color:#666;font-size:14px;\">开源：<a href=\"http://www.likeyun.cn\" style=\"text-decoration:none;color:#666;\">www.likeyun.cn</a><a href=\"https://github.com/likeyun/WeChat-Group-HuoMa\" style=\"text-decoration:none;color:#666;float:right;\">Github</a></p>";
				} else {
				    echo "暂无用户创建群活码，你也可以前往<a href='../user'>用户后台</a>创建";
				}
				$conn->close();
			}else{
				// 未登录
				echo "<script>location.href='login.php';</script>";
			}
		?>

    </div>
    
    <!-- 域名设置 -->
    <div id="menu1" class="container tab-pane fade"><br>
      <h3>设置落地页域名</h3>
      <p>落地页即展示二维码的页面，在设置之前，你需要做好域名解析，然后在下方进行绑定域名，然后在创建群活码的时候，选择你要使用的域名即可。要求以http或https开头，结束不能有“/”符号，正确填写例如 <span class="badge badge-secondary">https://www.baidu.com</span></p>
      <?php
      // 数据库配置
      include '../MySql.php';

      // 创建连接
      $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

      // 检查连接
      if ($conn->connect_error) {
          die("连接失败: " . $conn->connect_error);
      } 
       
      $ym_sql = "SELECT * FROM qun_huoma_yuming";
      $ym_result = $conn->query($ym_sql);
       
      if ($ym_result->num_rows > 0) {
        // 输出数据
        while($ym_row = $ym_result->fetch_assoc()) {
          $yuming = $ym_row["yuming"];
          $ymid = $ym_row["id"];
          echo '<div class="card" style="margin-bottom:15px;">
          <div class="card-body">
          <h4 class="card-title">'.$yuming.'</h4>
          <a href="#" class="card-link" id="'.$ymid.'" onclick="delym(this);" style="outline:none;color:#333;">删除</a>
          </div>
          </div>';
        }
      }else{
        echo "暂无域名";
        echo "<br/><br/>";
      }
      ?>

      <form role="form" action="##" onsubmit="return false" method="post" id="set_domain_name">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">域名</span>
          </div>
          <input type="text" class="form-control" name="yuming" placeholder="请输入域名">
        </div>
        <button type="button" class="btn btn-dark" onclick="set_domain_name()">添加域名</button>
      </form>
      <!-- Result -->
      <div class="Result" style="margin-top: 30px;display: none;"></div>
    </div>
  </div>
</div>


<!-- 分享模态框 -->
<div class="modal fade" id="share-huoma">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">分享活码</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
   
      <!-- 模态框主体内容 -->
      <div class="modal-body"></div>
   
      <!-- 模态框底部 -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
      </div>
 
    </div>
  </div>
</div>


<!-- 删除模态框 -->
<div class="modal fade" id="del-huoma">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">删除活码</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
   
      <!-- 模态框主体内容 -->
      <div class="modal-body">确定要删除吗？</div>
   
      <!-- 模态框底部 -->
      <div class="modal-footer"></div>

    </div>
  </div>
</div>


<script type="text/javascript">
  // 分享
  function share(event){
      var shareid = event.id;
      $.ajax({
          type: "GET",
          url: "share_qunhuoma.php?hmid="+shareid,
          success: function (data) {
          	if (data.result == "101") {
          		alert(data.msg);
          	}else if (data.result == "102") {
          		alert(data.msg);
          	}else if (data.result == "100") {
          		$("#share-huoma .modal-dialog .modal-body").html("链接："+data.url+"<br/><img src='../qrcode.php?content="+data.url+"' width='200'/>");
          	}else{
          		alert("未知错误");
          	}
          },
          error : function() {
            alert("error");
          }
      });
  }

  // 删除
  function getdelid(event){
  	var delid = event.id;
  	  $("#del-huoma .modal-dialog .modal-footer").html("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" id="+delid+" onclick=\"del(this);\">确定删除</button>");
  }


  function del(event){
  	var deleteid = event.id;
	  $.ajax({
	      type: "GET",
	      url: "delete.php?hmid="+deleteid,
	      success: function (data) {
	      	if (data.result == "101") {
	      		alert(data.msg);
	      	}else if (data.result == "102") {
	      		alert(data.msg);
	      	}else if (data.result == "100") {
	      		// alert(data.msg);
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


  function closesctips(){
    $(".container .Result").css('display','none');
  }

  // 添加域名
  function set_domain_name(){
    $.ajax({
        type: "POST",
        url: "set_domain_name_do.php",
        data: $('#set_domain_name').serialize(),
        success: function (data) {
          if (data.result == "101") {
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
            $(".container .Result").css('display','block');
            setTimeout('closesctips()', 2000);
          }else if (data.result == "102") {
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
            $(".container .Result").css('display','block');
            setTimeout('closesctips()', 2000);
          }else if (data.result == "103") {
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
            $(".container .Result").css('display','block');
            setTimeout('closesctips()', 2000);
          }else if (data.result == "104") {
            $(".container .Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
            $(".container .Result").css('display','block');
            setTimeout('closesctips()', 2000);
          }else if (data.result == "100") {
            $(".container .Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
            $(".container .Result").css('display','block');
            setTimeout('closesctips()', 2000);
            // location.href("index.php#menu1");
            location.reload();
          }
        },
        error : function() {
          alert("服务器错误，请检查php版本");
        }
    });
  }

  // 删除
  function delym(event){
    var delymid = event.id;
    $.ajax({
        type: "GET",
        url: "del_ym.php?ymid="+delymid,
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
          alert("服务器错误");
        }
    });
  }
</script>
</body>
</html>
