<?php
require('../auth/login-check.php');
require('../components/header.php');

if($_SESSION['post'] == 2){
    if(empty($_SESSION['shuninYear'])){
        header('Location:shunin-year.php');
        exit();
    }
}
?>
    <h1>トップページ</h1><br><br>

    <div class="row">
        <div class="col-6">
            <div class="card p-3">
                <a href="../tests/index.php">テスト</a>  
            </div>
        </div>
        
        <div class="col-6">
            <div class="card p-3">
                <a href="../students/index.php">生徒</a>
            </div>
        </div>

        <div class="col-6">
            <div class="card p-3">
                <a href="../exams/index.php">テスト結果</a>
            </div>
        </div>

        <div class="col-6">
            <div class="card p-3">
                <a href="../classes/index.php">クラス一覧</a>
            </div>
        </div>

        <div class="col-6">
            <div class="card p-3">
                <a href="../auth/logout.php">ログアウト</a>
            </div>
        </div>

        <?php if($_SESSION['post'] == 1): ?>
            <div class="col-6">
                <div class="card p-3">
                    <a href="../teacher_classes/index.php">担当学年を変える</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if($_SESSION['post'] == 2): ?>
            <div class="col-6">
                <div class="card p-3">
                    <a href="shunin-year.php">担当学年を変える</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php
require('../components/footer.php');
?>