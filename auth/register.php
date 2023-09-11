<?php 
session_start();
// 登録処理
if(!empty($_POST)){
    if($_POST['name'] == ''){
        $error['name'] = 'blank';
    }
    if(preg_match('/^\d{4}$/', $_POST['login_id']) == 0){
        $error['login_id'] = 'number';
    }
    if(strlen($_POST['password']) < 4){
        $error['password'] = 'length';
    }
    if(empty($error)){
        $_SESSION['join'] = $_POST;
        header('Location:confirm.php');
        exit();
    }
}
// 書き直す時の処理
if(isset($_REQUEST['action'])){
    if($_REQUEST['action'] == 'rewrite'){
        $_POST = $_SESSION['join'];
        $error['rewrite'] = true;
    }
}

require('../components/header.php'); 
?>

    <div class="form-position">
        <p class="h3">先生登録画面</p>

        <form action="" method="post">
            <div>
                <label for="name">お名前</label><br>
                <input type="text" name="name" id="name" value="<?php if(isset($_POST)): echo htmlspecialchars($_POST['name'],ENT_QUOTES); endif ?>">
                <?php if($error['name'] == 'blank'): ?>
                    <span>お名前を入力してください</span>
                <?php endif; ?>
            </div>

            <div>
                <label for="login_id">ログインID（半角数字４桁）</label><br>
                <input type="text" name="login_id" id="login_id" value="<?php if(isset($_POST)): echo htmlspecialchars($_POST['login_id'],ENT_QUOTES); endif ?>">
                <?php if($error['login_id'] == 'number'): ?>
                    <span>IDは4文字の半角数字で入力してください</span>
                <?php endif; ?>
            </div>

            <div>
                <label for="password">パスワード</label><br>
                <input type="password" name="password" id="password" value="<?php if(isset($_POST)): echo htmlspecialchars($_POST['password'],ENT_QUOTES); endif ?>">
                <?php if($error['password'] == 'length'): ?>
                    <span>パスワードは4文字以上で入力してください</span>
                <?php endif; ?>
            </div>

            <select class="mt-3" name="post" id="post">
                <option value="1">一般</option>
                <option value="2">学年主任</option>
                <option value="3">校長</option>
            </select><br>

            <input class="mt-3 btn btn-primary" type="submit" value="登録する">
        </form>

        <div>
            <p class="mt-3">ログインしたい人は<a href="login.php">こちら</a></p>
        </div>
    </div>

<?php require('../components/footer.php');