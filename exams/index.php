<?php
session_start();
require('../db/dbconnect.php');

$exams = $db->query('SELECT st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id');

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成績管理アプリ</title>
</head>
<body>
    <table border=1>
        <tr><th>テスト</th><th>生徒名</th><th>国語</th><th>数学</th><th>英語</th><th>理科</th><th>社会</th><th>合計</th></tr>
            <?php foreach($exams as $exam): ?>
                <tr>
                    <td><?php echo $exam['test_name']; ?></td>
                    <td><?php echo $exam['student_name']; ?></td>
                    <td><?php echo $exam['kokugo']; ?></td>
                    <td><?php echo $exam['sugaku']; ?></td>
                    <td><?php echo $exam['eigo']; ?></td>
                    <td><?php echo $exam['rika']; ?></td>
                    <td><?php echo $exam['shakai']; ?></td>
                    <td><?php echo $exam['goukei']; ?></td>
                </tr>
            <?php endforeach; ?>
    </table>
</body>
</html>