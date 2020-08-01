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
 
// 使用 sql 创建数据表
$sql = "CREATE TABLE qun_huoma (
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
byqun_maxnum VARCHAR(32) NOT NULL,
`user` mediumtext NOT NULL
)";

$sql2 = "CREATE TABLE `user` (
  `username` mediumtext NOT NULL,
  `passwd` mediumtext NOT NULL
)";
 
if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
	$mysql_data = '
	<?php
		$admin_user = "'.$adminuser.'";
		$admin_pwd = "'.$adminpwd.'";
		$db_url = "'.$servername.'";
		$db_user = "'.$username.'";
		$db_pwd = "'.$password.'";
		$db_name = "'.$dbname.'";
	?>
	';

	//生成json文件
	file_put_contents('../MySql.php', $mysql_data);

	echo "<h1 style='text-align:center;margin-top:50px;'>安装成功</h1>";
	echo "<h1 style='text-align:center;margin-top:5px;'><a href='../admin/'>前往后台>> </a> </h1>";
	
} else {
    echo "创建数据表错误: " . $conn->error;
}
 
$conn->close();
?>