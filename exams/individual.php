<?php
require('../auth/login-check.php');
require('../components/header.php');

$testId = $_GET['test'];
$studentId = $_GET['student'];
?>
<!-- getでテストの種類と生徒のIDを受け取る -->

<!-- そのgetの内容に応じてデータベースからテスト結果を取得＆出力 -->
<?php
$studentStmt = $db->prepare('SELECT name from students where id=?');
$studentStmt->execute(array($studentId));
$studentName = $studentStmt->fetch();
// $_GET['id'] == 0 なら生徒のidにマッチするテスト結果を全て出力
if($testId == 0){
    // studentIdにマッチするテスト結果を全部取得
    $examStmt = $db->prepare('SELECT te.name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei 
    from exams as ex
     inner join tests as te
     on ex.test_id = te.id
    where ex.student_id=?');

    $examStmt->execute(array($studentId));
    $examResults = $examStmt->fetchAll(PDO::FETCH_ASSOC);
}else{
    // testIdとstudentIdにマッチするテスト結果を取得
    $examStmt = $db->prepare('SELECT te.name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei 
    from exams as ex
     inner join tests as te
     on ex.test_id = te.id
    where ex.test_id=? and ex.student_id=?');
    $examStmt->execute(array(
        $testId,
        $studentId
    ));
    $examResults = $examStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<p>生徒名:<?php echo htmlspecialchars($studentName['name'],ENT_QUOTES); ?></p>
<p>選択したテスト:
    <?php
    if($testId == 0){
        echo '全テスト';
    }else{
        foreach($examResults as $testName){
            echo $testName['name'];
        }
    }
    ?>
</p>
<a href="individual-search.php">生徒とテストを選び直す</a>/
<a href="index.php">テスト結果へ戻る</a>
<?php if($testId == 0): ?>
<div>
    <p class="h2">テスト結果</p>
    <table class="table table-bordered">
        <tr>
            <th>テスト名</th>
            <th>国語</th>
            <th>数学</th>
            <th>英語</th>
            <th>理科</th>
            <th>社会</th>
            <th>合計</th>
        </tr>

        <?php 
            foreach($examResults as $index => $result): 
        ?>
            <tr>
                <td><?php echo $result['name']; ?></td>
                <td><?php echo $result['kokugo']; ?></td>
                <td><?php echo $result['sugaku']; ?></td>
                <td><?php echo $result['eigo']; ?></td>
                <td><?php echo $result['rika']; ?></td>
                <td><?php echo $result['shakai']; ?></td>
                <td id="totalScore_<?php echo $index; ?>"><?php echo $result['goukei']; ?></td>
            </tr>
        <?php
            endforeach; 
        ?>
    </table>
</div><br>
<?php else: ?>
    <div>
    <p class="h2">テスト結果</p>
    <table class="table table-bordered">
        <tr>
            <th>テスト名</th>
            <th>国語</th>
            <th>数学</th>
            <th>英語</th>
            <th>理科</th>
            <th>社会</th>
            <th>合計</th>
        </tr>

        <?php 
            foreach($examResults as $result): 
        ?>
            <tr>
                <td><?php echo $result['name']; ?></td>
                <td id="kokugo"><?php echo $result['kokugo']; ?></td>
                <td id="sugaku"><?php echo $result['sugaku']; ?></td>
                <td id="eigo"><?php echo $result['eigo']; ?></td>
                <td id="rika"><?php echo $result['rika']; ?></td>
                <td id="shakai"><?php echo $result['shakai']; ?></td>
                <td><?php echo $result['goukei']; ?></td>
            </tr>
        <?php
            endforeach; 
        ?>
    </table>
</div><br>
<?php endif; ?>

<canvas id="testScoresChart" class="mb-5" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php if($testId == 0): ?>
        const totalScores = [];
        const chartLavel = [];

        <?php foreach ($examResults as $index => $result) { ?>
            const totalScoreElement_<?php echo $index; ?> = document.getElementById('totalScore_<?php echo $index; ?>');
            const totalScore_<?php echo $index; ?> = parseInt(totalScoreElement_<?php echo $index; ?>.textContent);
            totalScores.push(totalScore_<?php echo $index; ?>);
        <?php } ?>

        <?php foreach($examResults as $result) { ?>
            chartLavel.push('<?php echo $result['name']; ?>');
        <?php } ?>

        const ctx = document.getElementById('testScoresChart').getContext('2d');
        const testScoresChart = new Chart(ctx, {
            type: 'bar', // 棒グラフを使用
            data: {
                labels: chartLavel, // ラベルを適切に設定
                datasets: [{
                    label: '生徒Aのテスト合計点',
                    data: totalScores, // 合計点の配列を設定
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 500,
                    }
                }
            }
        });
    <?php else: ?>
        const subjectScores = [];

        const kokugoScore = parseInt(document.getElementById('kokugo').textContent);
        const sugakuScore = parseInt(document.getElementById('sugaku').textContent);
        const eigoScore = parseInt(document.getElementById('eigo').textContent);
        const rikaScore = parseInt(document.getElementById('rika').textContent);
        const shakaiScore = parseInt(document.getElementById('shakai').textContent);

        subjectScores.push(kokugoScore);
        subjectScores.push(sugakuScore);
        subjectScores.push(eigoScore);
        subjectScores.push(rikaScore);
        subjectScores.push(shakaiScore);

        const ctx = document.getElementById('testScoresChart').getContext('2d');
        const testScoresChart = new Chart(ctx, {
            type: 'bar', // 棒グラフを使用
            data: {
                labels: ['国語','数学','英語','理科','社会'], // ラベルを適切に設定
                datasets: [{
                    label: '生徒Aのテスト合計点',
                    data: subjectScores, // 合計点の配列を設定
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                    }
                }
            }
        });
    <?php endif; ?>
</script>
<?php
require('../components/footer.php');
?>