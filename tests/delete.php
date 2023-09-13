<?php
// タスク削除処理を書く

require('./Test.php');

if(!empty($_POST)){
    $testClass = new Test();
    echo $testClass->delete($_POST);
}
?>