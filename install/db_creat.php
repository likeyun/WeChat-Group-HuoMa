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
byqun_maxnum VARCHAR(32) NOT NULL
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
qudao_title VARCHAR(32) NOT NULL,
qudao_type VARCHAR(32) NOT NULL,
qudao_content TEXT(1000) NOT NULL,
qudao_biaoqian VARCHAR(32) NOT NULL,
qudao_creat_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
qudao_update_time VARCHAR(32) NOT NULL,
qudao_pageview VARCHAR(32) NOT NULL,
qudao_yuming VARCHAR(32) NOT NULL
)";


if ($conn->query($sql_qun_huoma) === TRUE) {
	//qun_huoma数据表创建成功
	// echo "<p style='text-align:center;margin-top:10px;'>qun_huoma创建成功</p>";
	if ($conn->query($sql_qun_huoma_yuming) === TRUE) {
		//qun_huoma_yuming数据表创建成功
		// echo "<p style='text-align:center;'>qun_huoma_yuming创建成功</p>";
		if ($conn->query($sql_qun_huoma_qudao) === TRUE) {
			//qun_huoma_qudao数据表创建成功
			// echo "<p style='text-align:center;'>qun_huoma_qudao创建成功</p>";
			//开始创建本地配置文件
			$mysql_data = '<?php
			$admin_user = "'.$adminuser.'";
			$admin_pwd = "'.$adminpwd.'";
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
			echo "<h2 style='text-align:center;margin-top:5px;'><a href='../admin/' style='text-decoration:underline;color:#333;'>前往后台>> </a> </h2>";
			} else {
				//qun_huoma_qudao数据表创建失败
		    	echo $conn->error."<br/>";
			}
		} else {
		//qun_huoma_yuming数据表创建失败
	    echo $conn->error."<br/>";
	}
} else {
	//qun_huoma数据表创建失败
    echo $conn->error."<br/>";
}

//断开数据库连接
$conn->close();
?>