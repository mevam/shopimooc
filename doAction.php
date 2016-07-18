<?php
require_once "include.php";
$act=$_REQUEST['act'];
if ($act==="login"){
    $mes=login();
}elseif($act==="reg"){
    $mes=reg();
}elseif($act==="userOut"){
    userOut();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
if ($mes){
    echo $mes;
}
?>
</body>
</html>
