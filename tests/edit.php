<?php
session_start();
require('../db/dbconnect.php');

$id = $_GET['id'];

if(!empty($_POST)){
    $_SESSION['join'] = $_POST;

    if(preg_match( '/^[0-9]+$/', $_POST['year']) == 0){
        $error['year'] = 'hankaku';
    }

    if($_POST['year'] == ''){
        $error['year'] = 'blank';
    }

    if($_POST['name'] == ''){
        $error['name'] = 'blank';
    }

    if(empty($error)){
        $stmt = $db->prepare('update tests set year=?, name=?, create_at=NOW() where id=?');
        echo $ret = $stmt->execute(array(
            $_SESSION['join']['year'],
            $_SESSION['join']['name'],
            $id
        ));

        unset($_SESSION['join']);

        header('Location:index.php');
        exit();
    }
    
}

$prepare = $db->prepare('SELECT * from tests where id=?');
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
        <label for="year">学年（1〜３の数字で入力）</label><br>
        <input type="text" name="year" id="year" value="<?php echo $edit['year']; ?>">
        <?php if($error['year'] == 'hankaku'): ?>
            <p style="color:red;">半角数字で入力してください</p>
        <?php endif; ?>

        <?php if($error['year'] == 'blank'): ?>
            <p style="color:red;">入力してください</p>
        <?php endif; ?>
        <br><br>

        <label for="name">テスト名</label><br>
        <input type="text" name="name" id="name" value="<?php echo $edit['name']; ?>">
        <?php if($error['name'] == 'blank'): ?>
            <p style="color:red;">入力してください</p>
        <?php endif; ?>
        <br><br>

        <input type="submit" value="更新する">
    </form>
    <a href="index.php">戻る</a>
</body>
</html>