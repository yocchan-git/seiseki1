<?php
// テストの更新処理を書く

require('./Exam.php');

if(!empty($_POST)){
    $examClass = new Exam();
    echo $examClass->update($_POST);
}
?>