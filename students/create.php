<?php
require('../auth/login-check.php');
require('../components/header.php');

if($_SESSION['post'] == 1){
    // 担当のクラスしか生徒の登録はできない
    $stmt = $db->prepare('SELECT class_id from teacher_classes where teacher_id=?');
    $stmt->execute(array(
        $_SESSION['id']
    ));
    $class = $stmt->fetch();
}

if($_SESSION['post'] == 2){
    $stmt = $db->prepare('SELECT id,class_name from classes where class_year=?');
    $stmt->execute(array(
        $_SESSION['shuninYear']
    ));
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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

    // 学年主任の場合、選択されたクラスIDが有効かどうかを確認
    if ($_SESSION['post'] == 2 && !in_array($_POST['class_id'], array_column($classes, 'id'))) {
        $error['class_id'] = 'invalid';
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

        <?php 
        if($_SESSION['post'] == 1):
        ?>
        <label for="class_id">クラスID（担当のクラスの生徒しか追加できません）</label><br>
        <input type="text" id="class_id" name="class_id" value="<?php echo htmlspecialchars($class['class_id'],ENT_QUOTES); ?>" readonly><br><br>

        <?php elseif($_SESSION['post'] == 2): ?>
        <label for="class_id">クラスを選択してください</label><br>
        <select id="class_id" name="class_id">
            <option value="">選択してください</option>
            <?php foreach ($classes as $classItem): ?>
                <option value="<?php echo htmlspecialchars($classItem['id'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($classItem['class_name'], ENT_QUOTES); ?></option>
            <?php endforeach; ?>
        </select>
            <?php if($error['class_id'] == 'blank'): ?>
                <span style="color:red;">入力してください</span>
            <?php endif; ?>
            <?php if ($error['class_id'] == 'invalid'): ?>
            <span style="color:red;">有効なクラスを選択してください</span>
            <?php endif; ?>
            <br><br>

        <?php else: ?>

        <label for="class_id">クラスID</label><br>
        <input type="text" id="class_id" name="class_id">
            <?php if($error['class_id'] == 'blank'): ?>
                <span style="color:red;">入力してください</span>
            <?php endif; ?>
            <br><br>
        <?php endif; ?>

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