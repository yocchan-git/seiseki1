<?php
session_start();
require('../db/dbconnect.php');

$tests = $db->query('SELECT * from tests');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成績管理アプリ</title>
</head>
<body>
    <h1>テスト一覧</h1>
    <table border=1>
        <tr><th>番号</th><th>学年</th><th>テスト名</th><th>作成日</th><th>変更はこちら</th><th>削除するか</th></tr>
        <?php foreach($tests as $test): ?>
        <tr>
            <td><?php echo $test['id']; ?></td>
            <td><?php echo $test['year']; ?></td>
            <td><?php echo $test['name']; ?></td>
            <td><?php echo $test['create_at']; ?></td>
            <td><a href="edit.php?id=<?php echo $test['id']; ?>">変更</a></td>
            <td><a href="destory.php?id=<?php echo $test['id']; ?>">削除</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="create.php">テストを作成する</a>
</body>
</html>