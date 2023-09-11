<?php 
require('../db/dbconnection.php');
session_start();

// セッションに登録されてなかったら登録画面へ
if(!isset($_SESSION['join'])){
    header('Location: register.php');
    exit();
}
// 登録するボタンが押されたらデータを受け取る
if(!empty($_POST)){
    $db = Database::dbConnect();
    $stmt = $db->prepare('INSERT into teachers set login_id=?, password=?, name=?, post=?');
    $stmt->execute(array(
        $_SESSION['join']['login_id'],
        sha1($_SESSION['join']['password']),
        $_SESSION['join']['name'],
        $_SESSION['join']['post']
    ));
    unset($_SESSION['join']);
    header('Location:complete.php');
    exit();
}
require('../components/header.php');
?>

<!-- 新規登録の確認画面を表示する -->
<div class="offset-4 text-center card mt-5 col-4 p-3">
    <form action="" method="post">
    <input type="hidden" name="action" value="submit">
        <dl>
            <dt>
                <dd class="fw-bold">お名前</dd>
                <dd class="mb-3">
                    <?php echo htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES); ?>
                </dd>
            </dt>

            <dt>
                <dd class="fw-bold">ログインID</dd>
                <dd class="mb-3">
                    <?php echo htmlspecialchars($_SESSION['join']['login_id'],ENT_QUOTES); ?>
                </dd>
            </dt>

            <dt>
                <dd class="fw-bold">パスワード</dd>
                <dd class="mb-3">
                    【表示されません】
                </dd>
            </dt>

            <dt>
                <dd class="fw-bold">役職</dd>
                <?php 
                    switch ($_SESSION['join']['post']) {
                        case 1:
                            echo "<dd>一般</dd>";
                            break;
                        case 2:
                            echo "<dd>学年主任</dd>";
                            break;
                        default:
                            echo "<dd>校長</dd>";
                            break;
                    }
                ?>

            </dt>
        </dl>

        <div>
            <a class="btn btn-secondary me-3" href="register.php?action=rewrite">戻る</a>
            <input class="btn btn-primary" type="submit" value="登録する">
        </div>
    </form>
</div>
<?php
require('../components/footer.php');
?>