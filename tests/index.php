<?php
require('../auth/login-check.php');
require('../components/header.php');

$tests = $db->query('SELECT * from tests');
?>
    <p class="h2 mt-3">年間のテスト一覧</p>
    <table class="table table-bordered">
        <tr><th>学年</th><th>テスト名</th><th>作成日</th><th>変更はこちら</th><th>削除するか</th></tr>
        <?php foreach($tests as $test): ?>
        <tr>
            <td><?php echo $test['year']; ?></td>
            <td><?php echo $test['name']; ?></td>
            <td><?php echo $test['create_at']; ?></td>
            <td><a href="edit.php?id=<?php echo $test['id']; ?>">変更</a></td>
            <td><a href="destory.php?id=<?php echo $test['id']; ?>">削除</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="create.php">テストを作成する</a><br>
    <br><a href="../index.php">トップページ</a><br>
<?php
require('../components/footer.php');
?>