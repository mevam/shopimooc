<?php
/**
 * Created by PhpStorm.
 * User: melonydi
 * Date: 2016/7/12
 * Time: 23:35
 */
require_once "../include.php";
$username=$_POST['username'];
$username=mysql_real_escape_string($username);
$password=md5($_POST['password']);
$verify=$_POST['verify'];
$sess_verify=$_SESSION['verify'];
$autoFlag=$_POST['autoFlag'];
if ($verify==$sess_verify){
    $sql="select * from imooc_admin where username='{$username}' and password='{$password}'";
    $row=checkAdmin($sql);
    if ($row){
        //如果一周内选择自动登录
        if ($autoFlag){
            setcookie("adminId",$row['id'],time()+7*24*3600);
            setcookie("adminName",$row['username'],time()+7*24*3600);
        }
        $_SESSION['adminName']=$row['username'];
        $_SESSION['adminId']=$row['id'];
        alertMes("登陆成功","index.php");
    }else{
        alertMes("登录失败，重新登录","login.php");
    }
}else{
    alertMes("验证码错误","login.php");
}