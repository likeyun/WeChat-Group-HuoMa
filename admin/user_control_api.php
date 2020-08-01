<?php
session_start();
if (!isset($_SESSION["huoma.admin"])) {
  $result = array(
    "code" => "105",
    "msg" => "未登录"
  );
} else {
  // 数据库配置
  include '../MySql.php';
  $method = $_POST['method'];
  $username = $_POST['username'];
  $passwd = $_POST['passwd'];
  $max = $_POST['max'];
  switch ($method) {
    case 'changePasswd':
      $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);
      mysqli_query($conn,"UPDATE `user` SET `passwd`='$passwd',`max`='$max' WHERE username='$username'");
      $result = array(
        "code" => "200",
        "msg" => "修改成功"
      );
      break;
    case 'delUser':
      $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);
      mysqli_query($conn,"DELETE FROM `user` WHERE username='$username'");
      $result = array(
        "code" => "200",
        "msg" => "删除成功"
      );
    break;
  }
}
header("Content-type:application/json");
echo json_encode($result,JSON_UNESCAPED_UNICODE);