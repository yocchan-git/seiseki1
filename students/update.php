<?php
// 生徒の更新処理を書く

require('./Student.php');

if(!empty($_POST)){
    $studentClass = new Student();
    echo $studentClass->update($_POST);
}
?>