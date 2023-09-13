<?php
require('../db/dbconnection.php');
session_start();
// クッキーが登録されていたら、自動入力する
if (isset($_COOKIE['login_id'])) {
    if ($_COOKIE['login_id'] != '') {
        $_POST['login_id'] = $_COOKIE['login_id'];
        $_POST['password'] = $_COOKIE['password'];
        $_POST['save'] = 'on';
    }
}
// 入力されたPOST通信の内容をチェックする
if(!empty($_POST)){
    if($_POST['login_id'] != '' && $_POST['password'] != ''){
        $db = Database::dbConnect();
        $sql = 'SELECT * from teachers where login_id=? and password=?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array(
            $_POST['login_id'],
            sha1($_POST['password'])
        ));
        $user = $stmt->fetch();

        // ログインの成否を確認する
        if($user){
            $_SESSION['id'] = $user['id'];
            $_SESSION['post'] = $user['post'];
            $_SESSION['login_time'] = date("Y-n-j");
            if($_POST['save'] == 'on'){
                // クッキーにログイン情報を記録
                setcookie('login_id', $_POST['login_id'], time() + 60 * 60 * 24 * 14);
                setcookie('password', $_POST['password'], time() + 60 * 60 * 24 * 14);
            }

            header('Location: ../teachers/index.php');
            exit();
        }else{
            $error['login'] = 'fail';
        }
    }else{
        $error['login'] = 'blank';
    }
}
// 入力内容がOKならログイン完了する(セッションに情報も入れる)

require('../components/header.php');
?>

<div class="form-position">
    <div>
        <p class="h3">ログイン情報の入力</p>
            <?php if (isset($error['login'])): ?>
                <?php if ($error['login'] == 'blank'): ?>
                    <p class="error">※IDとパスワードを入力してください</p>
                <?php endif; ?>
            <?php endif; ?>
    </div>
    
    <div>
        <!-- ログインの情報を入力する画面を作る -->
        <form action="" method="post">
            <div>
                <label for="login_id">ログインID</label><br>
                <input class="mb-3" type="text" name="login_id" id="login_id" value="<?php if(isset($_POST['login_id'])): echo htmlspecialchars($_POST['login_id'],ENT_QUOTES); endif ?>">
            </div>

            <div>
                <label for="password">パスワード</label><br>
                <input class="mb-3" type="password" name="password" id="password" value="<?php if(isset($_POST['password'])): echo htmlspecialchars($_POST['password'],ENT_QUOTES); endif ?>">
            </div>

            <div>
                <?php if (isset($error['login'])): ?>
                    <?php if ($error['login'] == 'fail'): ?>
                        <p class="error">※ 失敗しました</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div>
                <input name="save" id="save" value="on" type="checkbox">
                <label class="mb-3" for="save">次回からは自動的にログインする</label>
            </div>

            <div>
                <input class="mb-3 btn btn-primary" type="submit" value="ログインする">
            </div>
        </form>
    </div>

    <div>
        <!-- 新規登録画面への遷移リンクを作る -->
        <p>教師アカウントを追加する場合は<a href="register.php">こちら</a></p>
    </div>
</div>

<?php
require('../components/footer.php');
?>