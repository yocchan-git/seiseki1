<?php
require('../auth/login-check.php');
require('../components/header.php');

if(!empty($_POST)){
    $_SESSION['shuninYear'] = $_POST['year'];

    var_dump($_SESSION['shuninYear']);

    header('Location:index.php');
    exit();
}
?>
<div class="form-position">
        <p class="h4">担当学年入力</p>

        <form action="" method="post">
            <label for="year">自分の担当の学年を入力してください<br>（半角数字1文字）</label><br>
            <input type="text" name="year" id="year"><br><br>

            <input class="mt-3 btn btn-primary" type="submit" value="登録する">
        </form>
<?php
require('../components/footer.php');
?>