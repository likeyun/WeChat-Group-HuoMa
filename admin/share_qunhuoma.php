<?php
header("Content-type:application/json");
session_start();
if(isset($_SESSION["huoma.admin"])){

	// 数据库配置
	include '../MySql.php';

	// 创建连接
	$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

	// 获取数据
	$hm_id = $_GET["hmid"];

	if(empty($hm_id)){
		$result = array(
			"result" => "101",
			"msg" => "非法请求"
		);
	}else{
		// 生成网址
		if ($conn->connect_error) {
		    die("连接失败: " . $conn->connect_error);
		} 
		 
		$sql = "SELECT * FROM qun_huoma WHERE hm_id = '$hm_id'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// 输出数据
			while($row = $result->fetch_assoc()) {
				$ym = $row["yuming"];
				$SERVER="$ym".$_SERVER["REQUEST_URI"];
				$url = dirname(dirname($SERVER))."/index.php?hmid=".$hm_id;
			}
		}else{
			$SERVER='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
			$url = dirname(dirname($SERVER))."/index.php?hmid=".$hm_id;
		}
		
		// 数组
		$result = array(
			"result" => "100",
			"msg" => "生成成功",
			"url" => $url
		);
	}
}else{
	$result = array(
		"result" => "102",
		"msg" => "未登录"
	);
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>