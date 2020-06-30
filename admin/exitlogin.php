<?php
// 里客云科技开发
// www.likeyun.cn
// 作者：TANKING
// 请保留版权信息
// 仅用于学习用途
// 基于php5.6开发
// 前端使用Bootstrap4.0
header("Content-type:text/html;charset=utf-8");
session_start();
unset($_SESSION["huoma.admin"]);
echo "<script>location.href=\"index.php\";</script>";
?>