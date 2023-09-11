<?php
try{
    $db = new PDO('mysql:dbname=rkmcl_school;host=mysql93.conoha.ne.jp;charset=utf8mb4','rkmcl_school','school&2525');
}catch(PDOException $e){
    echo 'DB接続エラー:'.$e->getMessage();
}
?>