<?php
require('../auth/login-check.php');
require('../components/header.php');

// 校長先生だけがテストの登録をできるようにする
if($_SESSION['post'] == 3){
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
            $stmt = $db->prepare('INSERT into tests set year=?, name=?, create_at=NOW()');
            echo $ret = $stmt->execute(array(
                $_SESSION['join']['year'],
                $_SESSION['join']['name']
            ));
    
            unset($_SESSION['join']);
    
            header('Location:index.php');
            exit();
        }
        
    }
}else{
    // 一般と学年主任はエラーページへ飛ばす
    if(!empty($_POST)){
        header('Location:error.php');
        exit();
    }
}

?>

    <form method="post" action="">
        <label for="year">学年（1〜３の数字で入力）</label><br>
        <input type="text" name="year" id="year">
        <?php if($error['year'] == 'hankaku'): ?>
            <span style="color:red;">半角で入力してください</span>
        <?php endif; ?>

        <?php if($error['year'] == 'blank'): ?>
            <span style="color:red;">入力してください</span>
        <?php endif; ?>
        <br><br>

        <label for="name">テスト名</label><br>
        <input type="text" name="name" id="name">
        <?php if($error['name'] == 'blank'): ?>
            <span style="color:red;">入力してください</span>
        <?php endif; ?>
        <br><br>

        <input class="btn btn-primary" type="submit" value="追加する">
    </form>
    <a class="mt-3 btn btn-secondary" href="index.php">戻る</a>
<?php
require('../components/footer.php');
?>