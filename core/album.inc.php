<?php
/**
 * Created by PhpStorm.
 * User: melonydi
 * Date: 2016/7/17
 * Time: 12:33
 */
function addAlbum($arr){
    insert("imooc_album",$arr);
}

/**
 * 根据商品ID得道一个图片
 * @param $id
 * @return multitype
 */
function getProImgById($id){
    $sql="select albumPath from imooc_album where pid={$id}";
    $row=fetchOne($sql);
    return $row;
}
/**
 * 根据商品ID得到所有图片
 * @param $id
 * @return multitype
 */
function getProImgsById($id){
    $sql="select albumPath from imooc_album where pid={$id}";
    $rows=fetchAll($sql);
    return $rows;
}