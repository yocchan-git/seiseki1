<?php
require('../auth/login-check.php');
require('../components/header.php');
?>
<div class="text-center mt-4">
    <p>権限がありません。テストの作成ができるのは校長だけです。</p>
</div>


<div class="row">
        <div class="col-6">
            <div class="card p-3">
                <a href="index.php">テスト一覧に戻る</a>
            </div>
        </div>

        <div class="col-6">
            <div class="card p-3">
                <a href="../teachers/index.php">トップページへ</a>
            </div>
        </div>
</div>
<?php
require('../components/footer.php');
?>