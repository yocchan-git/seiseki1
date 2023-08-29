<?php
session_start();
require('../db/dbconnect.php');

$id = $_GET['id'];

if(!empty($_POST)){
    $_SESSION['student'] = $_POST;

    if(preg_match( '/^[0-9]+$/', $_POST['number']) == 0){
        $error['number'] = 'hankaku';
    }

    if($_POST['number'] == ''){
        $error['number'] = 'blank';
    }

    if(preg_match( '/^[0-9]+$/', $_POST['year']) == 0){
        $error['year'] = 'hankaku';
    }

    if($_POST['year'] == ''){
        $error['year'] = 'blank';
    }

    if($_POST['class'] == ''){
        $error['class'] = 'blank';
    }

    if($_POST['name'] == ''){
        $error['name'] = 'blank';
    }

    if(empty($error)){
        $stmt = $db->prepare('update students set year=?, class=?, number=?, name=?, create_at=NOW() where id=?');
        echo $ret = $stmt->execute(array(
            $_SESSION['student']['year'],
            $_SESSION['student']['class'],
            $_SESSION['student']['number'],
            $_SESSION['student']['name'],
            $id
        ));

        unset($_SESSION['student']);

        header('Location:index.php');
        exit();
    }
    
}

$prepare = $db->prepare('SELECT * from students where id=?');
$prepare->execute(array($id));
$edit = $prepare->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成績管理アプリ</title>
</head>
<body>
    <form method="post" action="">
        <label for="number">学籍番号</label><br>
        <input type="text" id="number" name="number" value="<?php echo $edit['number']; ?>">
            <?php if($error['number'] == 'hankaku'): ?>
                <span style="color:red;">半角で入力してください</span>
            <?php endif; ?>

            <?php if($error['number'] == 'blank'): ?>
                <span style="color:red;">入力してください</span>
            <?php endif; ?>
            <br><br>

        <label for="year">学年（1〜３の数字で入力）</label><br>
        <input type="text" name="year" id="year" value="<?php echo $edit['year']; ?>">
            <?php if($error['year'] == 'hankaku'): ?>
                <span style="color:red;">半角で入力してください</span>
            <?php endif; ?>

            <?php if($error['year'] == 'blank'): ?>
                <span style="color:red;">入力してください</span>
            <?php endif; ?>
            <br><br>

        <label for="class">クラス</label><br>
        <input type="text" id="class" name="class" value="<?php echo $edit['class']; ?>">
            <?php if($error['class'] == 'blank'): ?>
                <span style="color:red;">入力してください</span>
            <?php endif; ?>
            <br><br>

        <label for="name">テスト名</label><br>
        <input type="text" name="name" id="name" value="<?php echo $edit['name']; ?>">
            <?php if($error['name'] == 'blank'): ?>
                <span style="color:red;">入力してください</span>
            <?php endif; ?>
            <br><br>

        <input type="submit" value="更新する">
    </form>
    <a href="index.php">戻る</a>
</body>
</html>