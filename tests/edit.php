<?php
require('../auth/login-check.php');
require('../components/header.php');

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

    <form method="post" action="">
        <label for="year">学年（1〜３の数字で入力）</label><br>
        <input type="text" name="year" id="year" value="<?php echo $edit['year']; ?>">
        <?php if($error['year'] == 'hankaku'): ?>
            <span style="color:red;">半角で入力してください</span>
        <?php endif; ?>

        <?php if($error['year'] == 'blank'): ?>
            <span style="color:red;">入力してください</span>
        <?php endif; ?>
        <br><br>

        <label for="name">テスト名</label><br>
        <input type="text" name="name" id="name" value="<?php echo $edit['name']; ?>">
        <?php if($error['name'] == 'blank'): ?>
            <span style="color:red;">入力してください</span>
        <?php endif; ?>
        <br><br>

        <input class="btn btn-primary" type="submit" value="更新する">
    </form>
    <a class="mt-3 btn btn-secondary" href="index.php">戻る</a>
<?php
require('../components/footer.php');
?>