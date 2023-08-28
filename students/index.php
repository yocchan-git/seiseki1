<?php
session_start();
require('../db/dbconnect.php');

$students = $db->query('SELECT * from students');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成績管理アプリ</title>
</head>
<body>
    <h1>生徒一覧</h1>
    <table border=1>
        <tr><th>学籍番号</th><th>学年</th><th>クラス</th><th>名前</th><th>変更はこちら</th><th>削除するか</th></tr>
        <?php foreach($students as $student): ?>
        <tr>
            <td><?php echo $student['number']; ?></td>
            <td><?php echo $student['year']; ?></td>
            <td><?php echo $student['class']; ?></td>
            <td><?php echo $student['name']; ?></td>
            <td><a href="edit.php?id=<?php echo $student['id']; ?>">変更</a></td>
            <td><a href="destory.php?id=<?php echo $student['id']; ?>">削除</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="create.php">生徒を登録する</a>
</body>
</html>