<?php
/**
 * Created by PhpStorm.
 * User: melonydi
 * Date: 2016/7/12
 * Time: 23:35
 */
require_once "../include.php";
$username = $_POST['username'];
$password = md5($_POST['password']);
$autoFlag = $_POST['autoFlag'];
$sql = "select * from imooc_admin where username='{$username}' and password='{$password}'";
$row = checkAdmin($sql);
if ($row) {
    //如果一周内选择自动登录
    if ($autoFlag) {
        setcookie("adminId", $row['id'], time() + 7 * 24 * 3600);
        setcookie("adminName", $row['username'], time() + 7 * 24 * 3600);
    }
    $_SESSION['adminName'] = $row['username'];
    $_SESSION['adminId'] = $row['id'];
    alertMes("登陆成功", "index.php");
} else {
    alertMes("登录失败，重新登录", "login.php");
}
