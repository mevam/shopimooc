<?php
/**
 * Created by PhpStorm.
 * User: melonydi
 * Date: 2016/7/13
 * Time: 0:17
 */
/**
 * 检查管理员是否存在
 * @param $sql
 * @return multitype
 */
function checkAdmin($sql){
    return fetchOne($sql);
}

/**
 * 检查是否有管理员登录
 */
function checkLogined(){
    //session和cookie中的adminId为空则让其登录
    if ($_SESSION['adminId']==""&&$_COOKIE['adminId']==""){
        alertMes("请先登录","login.php");
    }
}

/**
 * 得到管理员
 * @return string
 */
function addAdmin(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    $res=insert("imooc_admin",$arr);
    if ($res){
        $mes="添加成功！<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员列表</a> ";
    }else{
        $mes="添加失败！<br/><a href='addAdmin.php'>重新添加</a>";
    }
    return $mes;
}

/**
 * 得到所有的管理员
 * @return array
 */
function getAllAdmin(){
    $sql="select id,username,password,email from imooc_admin";
    $rows=fetchAll($sql);
    return $rows;
}

function getAdminByPage($page,$pageSize=2){
    $sql="select * from imooc_admin";

    global  $totalPages;
    $totalRows=getResultNum($sql);
    global $totalPages;
    $totalPages=ceil($totalRows/$pageSize);
    if ($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if ($page>=$totalPages) $page=$totalPages;
    $offset=($page-1)*$pageSize;
    $sql="select id,username,email from imooc_admin limit {$offset},{$pageSize}";
    $rows=fetchAll($sql);
    return $rows;
}

/**
 * 编辑管理员
 * @param $id
 * @return string
 */
function editAdmin($id){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    if (update("imooc_admin",$arr,"id={$id}")){
        $mes="编辑成功！<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes="编辑失败！<a href='listAdmin.php'>请重新修改</a>";
    }
    return $mes;
}

/**
 * 删除管理员的操作
 * @param $id
 * @return string
 */
function delAdmin($id){
    if (delete("imooc_admin","id={$id}")){
        $mes="删除成功！<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes="删除失败！<br/><a href='listAdmin.php'>请重新删除</a>";
    }
    return $mes;
}

/**
 * 注销管理员
 */
function logout(){
    //清除session和cookie中的管理员信息
    $_SESSION=array();
    if (isset($_COOKIE[session_name()])){
        setcookie(session_name(),"",time()-1);
    }
    if (isset($_COOKIE['adminId'])){
        setcookie("adminId","",time()-1);
    }
    if (isset($_COOKIE['adminName'])){
        setcookie("adminName","",time()-1);
    }
    session_destroy();
    header("location:login.php");
}

/**
 * 添加用户
 * @return string
 */
function addUser(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    $arr['regTime']=time();
    $path="../uploads";
    $uploadFile=uploadFile($path);
    if ($uploadFile&&is_array($uploadFile)){
        $arr['face']=$uploadFile[0]['name'];
    }else{
        return "添加失败!<br/><a href='addUser.php'>重新添加</a> ";
    }
    if (insert("imooc_user",$arr)){
        $mes="添加成功!<br/><a href='addUser.php'>继续添加</a>|<a href='listUser.php'>查看列表</a>";
    }else{
        $filename="../uploads/".$uploadFile[0]['name'];
        if (file_exists($filename)){
            unlink($filename);
        }
        $mes="添加失败！<br/><a href='addUser.php'>重新添加</a>|<a href='listUser.php'>查看列表</a> ";
    }
    return $mes;
}

/**
 * 删除用户操作
 * @param $id
 * @return string
 */
function delUser($id){
    //删除用户之前要先删除保存的用户头像
    $sql="select face from imooc_user where id=".$id;
    $row=fetchOne($sql);
    $face=$row['face'];
    if (file_exists("../uploads/".$face)){
        unlink("../uploads/".$face);
    }
    if (delete("imooc_user","id={$id}")){
        $mes="删除成功！<br/><a href='listUser.php'>查看管理员列表</a>";
    }else{
        $mes="删除失败！<br/><a href='listUser.php'>请重新删除</a>";
    }
    return $mes;
}

/**
 * 编辑用户
 * @param $id
 * @return string
 */
function editUser($id){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    if (update("imooc_user",$arr,"id={$id}")){
        $mes="编辑成功！<br/><a href='listUser.php'>查看用户列表</a>";
    }else{
        $mes="编辑失败！<a href='listUser.php'>请重新修改</a>";
    }
    return $mes;
}

