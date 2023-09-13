<?php
require('../auth/login-check.php');
require('../components/header.php');

if(!empty($_POST)){
    if($_POST['class_year'] == ''){
        $error['class_year'] = 'blank';
    }
    if(preg_match( '/^[0-9]+$/', $_POST['class_year']) == 0){
        $error['class_year'] = 'hankaku';
    }

    if($_POST['class_name'] == ''){
        $error['class_name'] = 'blank';
    }

    if(empty($error)){
        $stmt = $db->prepare('INSERT into classes set class_year=?,class_name=?');
        $stmt->execute(array(
            $_POST['class_year'],
            $_POST['class_name']
        ));

        header('Location:index.php');
        exit();
    }
}

$classes = $db->query('SELECT * from classes');

?>

<div class="card p-3 mt-3">
    <div class="container">
        <p class="mt-3 h2">クラス一覧</p>
        <table class="table table-bordered">
                <tr><th>クラスID</th><th>学年</th><th>クラス名</th></tr>
                <?php foreach($classes as $class): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['id'],ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($class['class_year'],ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($class['class_name'],ENT_QUOTES); ?></td>
                    </tr>
                <?php endforeach; ?>
        </table>
    </div>
</div>

<div class="card p-3 mt-3">
    <div class="container">
        <p class="h3">クラス登録画面</p>

        <form action="" method="post">
            <label for="class_year">学年（半角数字1文字）</label><br>
            <input type="text" name="class_year">
                <!-- 入力に不備があった時用 -->
                <?php if($error['class_year'] == 'hankaku'): ?>
                    <span style="color:red;">半角で入力してください</span>
                <?php endif; ?>

                <?php if($error['class_year'] == 'blank'): ?>
                    <span style="color:red;">入力してください</span>
                <?php endif; ?><br><br>

            <label for="class_name">クラス名</label><br>
            <input type="text" name="class_name">
                <!-- 入力に不備があった時用 -->
                <?php if($error['class_name'] == 'blank'): ?>
                    <span style="color:red;">入力してください</span>
                <?php endif; ?><br><br>

            <input class="mt-3 btn btn-primary" type="submit" value="登録する">
        </form>
    </div>
</div>

<div class="row mt-4 mb-4">
    <div class="col-6">
        <div class="card p-3">
            <a href="../teachers/index.php">トップページへ</a>  
        </div>
    </div>
</div>

<?php
require('../components/footer.php');
?>
