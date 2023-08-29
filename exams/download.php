<!-- <?php
session_start();
require('../db/dbconnect.php');

$test_id = $_GET['id'];
$rank = $_GET['rank'];

$sql = 'SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
from exams as ex
inner join tests as te
on ex.test_id = te.id
    inner join students as st
    on ex.student_id = st.id
where ex.test_id=?';

$stmt = $db->prepare($sql);
$stmt->execute(array($test_id));

$csv = '学籍番号,生徒名,国語,数学,英語,理科,社会,合計';
$csv .= "\n";

while(true){
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if($rec == false){
        break;
    }
    $csv .= $rec['number'];
    $csv .= ',';
    $csv .= $rec['student_name'];
    $csv .= ',';
    $csv .= $rec['kokugo'];
    $csv .= ',';
    $csv .= $rec['sugaku'];
    $csv .= ',';
    $csv .= $rec['eigo'];
    $csv .= ',';
    $csv .= $rec['rika'];
    $csv .= ',';
    $csv .= $rec['shakai'];
    $csv .= ',';
    $csv .= $rec['goukei'];
    $csv .= "\n";
}

// echo nl2br($csv);

$file = fopen('./exam.csv','w');
fputs($file,$csv);
fclose($file);

?> -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成績管理アプリ</title>
</head>
<body>
<?php
session_start();
require('../db/dbconnect.php');

$test_id = $_GET['id'];
$rank = $_GET['rank'];

$sql = 'SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
from exams as ex
inner join tests as te
on ex.test_id = te.id
    inner join students as st
    on ex.student_id = st.id
where ex.test_id=?';

$stmt = $db->prepare($sql);
$stmt->execute(array($test_id));

$csv = '学籍番号,生徒名,国語,数学,英語,理科,社会,合計';
$csv .= "\n";

while(true){
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if($rec == false){
        break;
    }
    $csv .= $rec['number'];
    $csv .= ',';
    $csv .= $rec['student_name'];
    $csv .= ',';
    $csv .= $rec['kokugo'];
    $csv .= ',';
    $csv .= $rec['sugaku'];
    $csv .= ',';
    $csv .= $rec['eigo'];
    $csv .= ',';
    $csv .= $rec['rika'];
    $csv .= ',';
    $csv .= $rec['shakai'];
    $csv .= ',';
    $csv .= $rec['goukei'];
    $csv .= "\n";
}

// echo nl2br($csv);

$file = fopen('./exam.csv','w');
fputs($file,$csv);
fclose($file);

?>

<a href="exam.csv">成績のダウンロードはこちら</a><br><br>
<a href="ranking.php?id=<?php echo $test_id; ?>&rank=<?php echo $rank; ?>">戻る</a>
</body>
</html>