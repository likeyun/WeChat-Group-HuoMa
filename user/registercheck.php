<?php
header("Content-type:application/json");

// 数据库配置
include '../MySql.php';

$username = $_POST["username"];
$passwd = $_POST["passwd"];
$repasswd = $_POST["repasswd"];
if ($username == 'admin') {
  $result = array(
    "result" => "2001",
    "msg" => "用户名已注册"
  );
} else {
  if ($username == "" || $passwd == "") {
    $result = array(
      "result" => "101",
      "msg" => "账号和密码不得为空"
    );
  } else if ($repasswd !== $passwd) {
    $result = array(
      "result" => "103",
      "msg" => "两遍密码不一样"
    );
  } else {
    $conn = mysqli_connect($db_url, $db_user, $db_pwd, $db_name);
    $arr = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `user` WHERE `username` ='$username'"));
    if (!empty($arr['passwd'])) {
      $result = array(
        "result" => "2001",
        "msg" => "用户名已注册"
      );
    } else {
      $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);
      $sql = "INSERT INTO `user` VALUES('$username','$passwd','5')";
      if ($conn->query($sql) === TRUE) {
        $result = array(
          "result" => "200",
          "msg" => "注册成功"
        );
      } else {
        $result = array(
          "result" => "102",
          "msg" => "注册失败,数据库处理问题"
        );
      }
    }
  }
}
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>