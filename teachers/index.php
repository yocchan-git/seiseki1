<?php
require('../auth/login-check.php');
require('../components/header.php');
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
                <a href="../auth/logout.php">ログアウト</a>
            </div>
        </div>
    </div>

<?php
require('../components/footer.php');
?>