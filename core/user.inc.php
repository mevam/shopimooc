<?php
/**
 * Created by PhpStorm.
 * User: melonydi
 * Date: 2016/7/18
 * Time: 20:16
 */
/**
 * 登陆
 * @return string
 */
function login(){
    $username=$_POST['username'];
    //转移一个字符串使之可以用于安全的mysql_query
    $username=mysql_real_escape_string($username);
    $password=md5($_POST['password']);
    $sql="select * from imooc_user where username='{$username}' and password='{$password}'";
    echo $sql;exit();
    $row=fetchOne($sql);
    if ($row){
        $_SESSION['loginFlag']=$row['id'];
        $_SESSION['username']=$row['username'];
        $mes="登陆成功！<br/>3秒钟后跳转到首页<meta http-equiv='refresh' content='3;url=index.php'/>";
    }else{
        $mes="登陆失败！<br/><a href='login.php'>请重新登陆</a> ";
    }
    return $mes;
}

/**
 * 注册
 * @return string
 */
function reg(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    $arr['regTime']=time();
    $uploadFile=uploadFile();

    //print_r($uploadFile);
    if($uploadFile&&is_array($uploadFile)){
        $arr['face']=$uploadFile[0]['name'];
    }else{
        return "注册失败";
    }
//	print_r($arr);exit;
    if(insert("imooc_user", $arr)){
        $mes="注册成功!<br/>3秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='3;url=login.php'/>";
    }else{
        $filename="uploads/".$uploadFile[0]['name'];
        if(file_exists($filename)){
            unlink($filename);
        }
        $mes="注册失败!<br/><a href='reg.php'>重新注册</a>|<a href='index.php'>查看首页</a>";
    }
    return $mes;
}

function userOut(){
    $_SESSION=array_rand();
    if (isset($_COOKIE[session_name()])){
        setcookie(session_name(),null,time()-1);
    }
    session_destroy();
    header("location:login.php");
}