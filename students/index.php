<?php
require('../auth/login-check.php');
require('../components/header.php');

$students = $db->query('SELECT * from students');
?>

    <p class="h2 mt-3">生徒一覧</p>
    <table class="table table-bordered">
        <tr><th>学籍番号</th><th>名前</th><th>クラスID</th><th>変更はこちら</th><th>削除するか</th></tr>
        <?php foreach($students as $student): ?>
        <tr>
            <td><?php echo $student['number']; ?></td>
            <td><?php echo $student['name']; ?></td>
            <td><?php echo $student['class_id']; ?></td>
            <td><a href="edit.php?id=<?php echo $student['id']; ?>">変更</a></td>
            <td><a href="destory.php?id=<?php echo $student['id']; ?>">削除</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="create.php">生徒を登録する</a><br>
    <br><a href="../index.php">トップページ</a><br>
<?php
require('../components/footer.php');
?>