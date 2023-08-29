<?php
session_start();
require('../db/dbconnect.php');

$test_id = $_GET['id'];
$rank = $_GET['rank'];

// 選択画面に必要な処理
if(!isset($test_id)){
    $if_tests = $db->query('SELECT id,name from tests');
}

// テスト名を表示するため
if(isset($test_id)){
    $tests = $db->prepare('SELECT name from tests where id=?');
    $tests->execute(array($test_id));
}

// ランキング用のコード
if($rank == 'gakuseki'){
    $stmt = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=?
    order by st.number');
}elseif($rank == 'kokugo'){
    $stmt = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=?
    order by ex.kokugo desc');
}elseif($rank == 'sugaku'){
    $stmt = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=?
    order by ex.sugaku desc');
}elseif($rank == 'eigo'){
    $stmt = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=?
    order by ex.eigo desc');
}elseif($rank == 'rika'){
    $stmt = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=?
    order by ex.rika desc');
}elseif($rank == 'shakai'){
    $stmt = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=?
    order by ex.shakai desc');
}elseif($rank == 'goukei'){
    $stmt = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=?
    order by ex.goukei desc');
}else{
    $stmt = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=?
    order by st.number');
}

$stmt->execute(array($test_id));
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成績管理アプリ</title>
    <script src="https://kit.fontawesome.com/4aa12ef06a.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        if(!isset($test_id)){
            foreach($if_tests as $if_test){
                echo '<a style="text-decoration: none;" href="ranking.php?id='.$if_test['id'].'">  '.$if_test['name'].'     </a>/';
            }
        }
        echo '<br>'
    ?>

    <?php if(isset($test_id)): ?>
        <?php 
            foreach($tests as $test){
                echo $test['name'];
            }
        ?>
        <table border=1>
            <tr>
                <th>学籍番号<a href="ranking.php?id=<?php echo $test_id; ?>&rank=<?php echo 'gakuseki'; ?>"><i class="fas fa-caret-down"></i></a></th>
                <th>生徒名</th>
                <th>国語<a href="ranking.php?id=<?php echo $test_id; ?>&rank=<?php echo 'kokugo'; ?>"><i class="fas fa-caret-down"></i></a></th>
                <th>数学<a href="ranking.php?id=<?php echo $test_id; ?>&rank=<?php echo 'sugaku'; ?>"><i class="fas fa-caret-down"></i></a></th>
                <th>英語<a href="ranking.php?id=<?php echo $test_id; ?>&rank=<?php echo 'eigo'; ?>"><i class="fas fa-caret-down"></i></a></th>
                <th>理科<a href="ranking.php?id=<?php echo $test_id; ?>&rank=<?php echo 'rika'; ?>"><i class="fas fa-caret-down"></i></a></th>
                <th>社会<a href="ranking.php?id=<?php echo $test_id; ?>&rank=<?php echo 'shakai'; ?>"><i class="fas fa-caret-down"></i></a></th>
                <th>合計<a href="ranking.php?id=<?php echo $test_id; ?>&rank=<?php echo 'goukei'; ?>"><i class="fas fa-caret-down"></i></a></th>
            </tr>

            <?php foreach($stmt as $result): ?>
                <tr>
                    <td><?php echo $result['number']; ?></td>
                    <td><?php echo $result['student_name']; ?></td>
                    <td><?php echo $result['kokugo']; ?></td>
                    <td><?php echo $result['sugaku']; ?></td>
                    <td><?php echo $result['eigo']; ?></td>
                    <td><?php echo $result['rika']; ?></td>
                    <td><?php echo $result['shakai']; ?></td>
                    <td><?php echo $result['goukei']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table><br>
        <a href="ranking.php">テスト選択に戻る</a><br><br>
        <a href="download.php?id=<?php echo $test_id; ?>&rank=<?php echo 'gakuseki'; ?>">ダウンロードする</a><br>
    <?php endif; ?>
    <br><a href="../index.php">トップページ</a><br>
</body>
</html>