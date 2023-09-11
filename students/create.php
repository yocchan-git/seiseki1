<?php
require('../auth/login-check.php');
require('../components/header.php');

if(!empty($_POST)){
    $_SESSION['student'] = $_POST;

    if(preg_match( '/^[0-9]+$/', $_POST['number']) == 0){
        $error['number'] = 'hankaku';
    }

    if($_POST['number'] == ''){
        $error['number'] = 'blank';
    }

    if($_POST['class_id'] == ''){
        $error['class_id'] = 'blank';
    }

    if($_POST['name'] == ''){
        $error['name'] = 'blank';
    }

    if(empty($error)){
        $stmt = $db->prepare('INSERT into students set class_id=?, number=?, name=?, create_at=NOW()');
        echo $ret = $stmt->execute(array(
            $_SESSION['student']['class_id'],
            $_SESSION['student']['number'],
            $_SESSION['student']['name']
        ));

        unset($_SESSION['student']);

        header('Location:index.php');
        exit();
    }
    
}

?>

    <form method="post" action="">
        <label for="number">学籍番号</label><br>
        <input type="text" id="number" name="number">
            <?php if($error['number'] == 'hankaku'): ?>
                <span style="color:red;">半角で入力してください</span>
            <?php endif; ?>

            <?php if($error['number'] == 'blank'): ?>
                <span style="color:red;">入力してください</span>
            <?php endif; ?>
            <br><br>

        <label for="class_id">クラスID</label><br>
        <input type="text" id="class_id" name="class_id">
            <?php if($error['class_id'] == 'blank'): ?>
                <span style="color:red;">入力してください</span>
            <?php endif; ?>
            <br><br>

        <label for="name">名前</label><br>
        <input type="text" name="name" id="name">
            <?php if($error['name'] == 'blank'): ?>
                <span style="color:red;">入力してください</span>
            <?php endif; ?>
            <br><br>

        <input class="btn btn-primary" type="submit" value="追加する">
    </form>
    <a class="mt-3 mb-3 btn btn-secondary" href="index.php">戻る</a>
<?php
require('../components/footer.php');
?>