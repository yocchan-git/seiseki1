<?php
require('../auth/login-check.php');
require('../components/header.php');
?>
<div class="text-center mt-4">
    <p>権限がありません。自分の担当の生徒のページを見てください</p>
</div>


<div class="row">
        <div class="col-6">
            <div class="card p-3">
                <a href="index.php">テスト結果に戻る</a>
            </div>
        </div>
        
        <div class="col-6">
            <div class="card p-3">
                <a href="individual-search.php">生徒とテスト選択画面に戻る</a>
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