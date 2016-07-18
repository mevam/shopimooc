<?php
/**
 * Created by PhpStorm.
 * User: melonydi
 * Date: 2016/7/12
 * Time: 22:20
 */
function connect(){
    $link= mysql_connect(DB_HOST,DB_USER,DB_PWD) or die("数据库连接失败Error".mysql_errno().":".mysql_error());
    mysql_set_charset(DB_CHARSET);
    mysql_select_db(DB_DBNAME) or die("指定数据库打开失败");
    return $link;
}

/**
 * 完成记录插入的操作
 * @param string $table
 * @param array $array
 * @return number
 */
function insert($table,$array){
    $keys=join(",",array_keys($array));
    $vals="'".join("','",array_values($array))."'";
    $sql="insert into {$table}({$keys}) values({$vals})";
    mysql_query($sql);
    return mysql_insert_id();
}


/**
 * 记录的更新操作
 * update imooc_admin set username='king' where id=1
 * @param $table
 * @param $array
 * @param $where
 * @return int
 */
function update($table,$array,$where){
    $str=null;
    foreach ($array as $key=>$val){
        if ($str==null){
            $sep="";
        }else{
            $sep=",";
        }
        $str.=$sep.$key."='".$val."'";
    }
    $sql="update {$table} set {$str} ".($where==null?null:" where ".$where);
    mysql_query($sql);
    //返回影响的记录条数
    return mysql_affected_rows();
}

/**
 * 删除记录
 * @param $table
 * @param null $where
 * @return int
 */
function delete($table,$where=null){
    $where=$where==null?null:" where ".$where;
    $sql="delete from {$table}{$where}";
    mysql_query($sql);
    return mysql_affected_rows();
}

/**
 *得到指定一条记录
 * @param string $sql
 * @param string $result_type
 * @return multitype:
 */
function fetchOne($sql,$result_type=MYSQL_ASSOC){
    $result=mysql_query($sql);
    $row=@mysql_fetch_array($result,$result_type);
    return $row;
}

/**
 * 得到结果集中的所有记录
 * @param $sql
 * @param int $result_type
 * @return array
 */
function fetchAll($sql,$result_type=MYSQL_ASSOC){
    $result=mysql_query($sql);
    while($row=mysql_fetch_array($result,$result_type)){
        $rows[]=$row;
    }
    return $rows;
}

/**
 * 得到结果集的记录条数
 * @param $sql
 * @return int
 */
function getResultNum($sql){
    $result=mysql_query($sql);
    return mysql_numrows($result);
}

/**
 * 得到上一步插入记录的ID号
 * @return int
 */
function getInsertId(){
    return mysql_insert_id();
}