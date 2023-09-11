<?php
require('../auth/login-check.php');
require('../components/header.php');

// テストIDとテスト名をデータベースから取得する
$tests = $db->query('SELECT id,name from tests');
// 生徒のIDと生徒名をデータベースから取得する
$students = $db->query('SELECT id,name from students');
?>

<!-- 上の内容を表示&選択して、生徒の個別ページへリンクを飛ばす（getで送信する） -->
<div class="text-center mt-5">
    <p class="h3">テストの種類と生徒を選択</p>
    <form action="individual.php" method="get">
        <select name="test" id="test">
            <option value="0">全テスト</option>
            <?php foreach($tests as $test): ?>
                <option value="<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($test['name'],ENT_QUOTES); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <select name="student" id="student">
            <?php foreach($students as $student): ?>
                <option value="<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($student['name'],ENT_QUOTES); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input class="btn btn-primary" type="submit" value="個別ページへ移動">
    </form>
    <a class="mt-3 btn btn-secondary" href="index.php">戻る</a>
</div>
<?php
require('../components/footer.php');
?>