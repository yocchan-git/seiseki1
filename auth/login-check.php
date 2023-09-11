<?php
// データベースに接続&セッションをスタートする
require_once('../db/dbconnection.php');
session_start();

// セッションにidが入っていたら取り出して$userに入れる
if(isset($_SESSION['id'])){
    $teacher_id = $_SESSION['id'];

    $db = Database::dbConnect();
    $sql = 'SELECT * from teachers where id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($teacher_id));
    $teacher = $stmt->fetch();
    if(!$teacher){
        header('Location:../auth/login.php');
        exit();
    }
}else{
    header('Location:../auth/login.php');
    exit();
}
?>