<?php
header("Content-type:text/html;charset=utf-8");

//获得配置
$adminuser = $_POST["adminuser"];
$adminpwd = $_POST["adminpwd"];
$servername = $_POST["dbservername"];
$username = $_POST["dbusername"];
$password = $_POST["dbpassword"];
$dbname = $_POST["dbname"];
 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
// 创建qun_huoma数据表
$sql_qun_huoma = "CREATE TABLE qun_huoma (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
hm_id VARCHAR(32) NOT NULL,
add_user VARCHAR(32) NOT NULL,
title VARCHAR(32) NOT NULL,
qun_qrcode TEXT(1000) NOT NULL,
wx_qrcode TEXT(1000) NOT NULL,
creat_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
update_time VARCHAR(32) NOT NULL,
wxid VARCHAR(32) NOT NULL,
page_view VARCHAR(32) NOT NULL,
biaoqian VARCHAR(32) NOT NULL,
wxstatus VARCHAR(32) NOT NULL,
byqun_qrcode TEXT(1000) NOT NULL,
byqun_status VARCHAR(32) NOT NULL,
yuming VARCHAR(32) NOT NULL,
qun_maxnum VARCHAR(32) NOT NULL,
huoma_status VARCHAR(32) NOT NULL
)";


// 创建qun_huoma_yuming数据表
$sql_qun_huoma_yuming = "CREATE TABLE qun_huoma_yuming (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
creat_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
yuming VARCHAR(32) NOT NULL
)";


// 创建qun_huoma_qudao数据表
$sql_qun_huoma_qudao = "CREATE TABLE qun_huoma_qudao (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
qudao_id VARCHAR(32) NOT NULL,
qudao_adduser VARCHAR(32) NOT NULL,
qudao_title VARCHAR(32) NOT NULL,
qudao_type VARCHAR(32) NOT NULL,
qudao_content TEXT(1000) NOT NULL,
qudao_biaoqian VARCHAR(32) NOT NULL,
qudao_creat_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
qudao_update_time VARCHAR(32) NOT NULL,
qudao_pageview VARCHAR(32) NOT NULL,
qudao_yuming VARCHAR(32) NOT NULL
)";


// 创建qun_huoma_user数据表
$sql_qun_huoma_user = "CREATE TABLE qun_huoma_user (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
user_id VARCHAR(32) NOT NULL,
user_regtime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
user_name VARCHAR(32) NOT NULL,
user_password VARCHAR(32) NOT NULL,
user_guoqidate VARCHAR(32) NOT NULL,
user_status VARCHAR(32) NOT NULL,
user_quanxian VARCHAR(32) NOT NULL,
user_email VARCHAR(32) NOT NULL
)";

// 创建qun_huoma_yqm数据表
$sql_qun_huoma_yqm = "CREATE TABLE qun_huoma_yqm (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
yqm VARCHAR(32) NOT NULL,
yqm_status VARCHAR(32) NOT NULL,
use_time VARCHAR(32) NOT NULL,
yqm_daynum VARCHAR(32) NOT NULL
)";

// 创建qun_huoma_wx数据表
$sql_qun_huoma_wx = "CREATE TABLE qun_huoma_wx (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
wx_title VARCHAR(32) NOT NULL,
add_user VARCHAR(32) NOT NULL,
wx_id VARCHAR(32) NOT NULL,
wx_qrcode TEXT(1000) NOT NULL,
wx_yuming TEXT(1000) NOT NULL,
wx_nummber VARCHAR(32) NOT NULL,
wx_status VARCHAR(32) NOT NULL,
wx_biaoqian VARCHAR(32) NOT NULL,
wx_pageview VARCHAR(32) NOT NULL,
wx_creat_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
wx_update_time VARCHAR(32) NOT NULL
)";


// 判断是否创建成功
if ($conn->query($sql_qun_huoma) === TRUE) {
	if ($conn->query($sql_qun_huoma_yuming) === TRUE) {
		if ($conn->query($sql_qun_huoma_qudao) === TRUE) {
			if ($conn->query($sql_qun_huoma_user) === TRUE) {
				// 注册管理员
				$user_id = rand(1000000,9999999);// 生成uid
				$sql_creat_admin = "INSERT INTO qun_huoma_user (user_id, user_name, user_password, user_guoqidate, user_email, user_quanxian, user_status) VALUES ('$user_id', '$adminuser', '$adminpwd', '2025-12-31', 'admin@qq.com', '777', '0')";
				if ($conn->query($sql_creat_admin) === TRUE) {
					// echo "管理员注册成功";
				}else{
					// echo "管理员注册失败";
				}
				if ($conn->query($sql_qun_huoma_yqm) === TRUE) {
					if ($conn->query($sql_qun_huoma_wx) === TRUE) {
						// 所有都创建成功
						$db_file = "../MySql.php";
						if(file_exists($db_file)){
							echo "请勿重复安装！";
						}else{
							//开始创建本地配置文件
							$mysql_data = '<?php
							$db_url = "'.$servername.'";
							$db_user = "'.$username.'";
							$db_pwd = "'.$password.'";
							$db_name = "'.$dbname.'";
							?>';
							//生成json文件
							file_put_contents('../MySql.php', $mysql_data);
							//输出结果
							echo "<div style='width:300px;margin:50px auto 5px;'><img src='http://p1.pstatp.com/large/2b2940002fb725ed482f6' width='300'/></div>";
							echo "<h2 style='text-align:center;margin-top:50px;'>安装成功！！</h2>";
							echo "<h2 style='text-align:center;margin-top:5px;'><a href='../admin/' style='text-decoration:underline;color:#333;'>前往管理端>> </a>&nbsp;&nbsp;&nbsp;<a href='../user/' style='text-decoration:underline;color:#333;'>前往客户端>> </a> </h2>";
						}
					}else{
						echo $conn->error."<br/>";
					}
				}else{
					echo $conn->error."<br/>";
				}
			}else{
				echo $conn->error."<br/>";
			}
		}else{
			echo $conn->error."<br/>";
		}
	}else{
		echo $conn->error."<br/>";
	}
} else {
    echo $conn->error."<br/>";
}

//断开数据库连接
$conn->close();
?>
