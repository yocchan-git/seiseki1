<?php
// テストの更新処理を書く

require('./Student.php');

if(!empty($_POST)){
    $testClass = new Student();
    echo $testClass->update($_POST);
}
?>