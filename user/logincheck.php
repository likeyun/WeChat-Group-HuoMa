<?php
header("Content-type:application/json");
session_start();
// 数据库配置
include '../MySql.php';

$username = $_POST["username"];
$passwd = $_POST["passwd"];
if ($username == 'admin') {
  $result = array(
    "result" => "2001",
    "msg" => "密码错误"
  );
} else {
  if ($username == "" || $passwd == "") {
    $result = array(
      "result" => "101",
      "msg" => "账号和密码不得为空"
    );
 } else {
    $conn = mysqli_connect($db_url, $db_user, $db_pwd, $db_name);
    $arr = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `user` WHERE `username` ='$username'"));
    if (empty($arr['passwd'])) {
      $result = array(
        "result" => "2001",
        "msg" => "用户未注册"
      );
    } else {
      if($passwd == $arr['passwd'])
      {
        $_SESSION['username'] = $username;
        $result = array(
        "result" => "200",
        "msg" => "登陆成功"
      );
      }else{
        $result = array(
        "result" => "2001",
        "msg" => "密码错误"
      );
      }
  }
}
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>