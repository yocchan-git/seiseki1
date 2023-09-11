<?php
require('../auth/login-check.php');
require('../components/header.php');

$test_id = $_GET['id'];
$year = $_GET['year'];

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
<div class="container">
    <div class="mt-3 mb-3">
        <p>ダウンロードできるのは選んだテストの結果だけです（ランキングではない）</p>
    </div>
    <a href="exam.csv">成績のダウンロードはこちら</a><br><br>
    <a class="btn btn-secondary" href="ranking.php?id=<?php echo $test_id; ?>&year=<?php echo $year; ?>">戻る</a>
</div>

<?php
require('../components/footer.php');
?>