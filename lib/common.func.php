<?php
/**
 * Created by PhpStorm.
 * User: melonydi
 * Date: 2016/7/12
 * Time: 22:20
 */
function alertMes($mes,$url){
   echo "<script>alert('{$mes}');</script>";
    echo "<script>window.location='{$url}';</script>";
}