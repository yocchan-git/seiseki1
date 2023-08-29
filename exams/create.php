<?php
session_start();
require('../db/dbconnect.php');

$tests = $db->query('SELECT id,name from tests');
$students = $db->query('SELECT id,name from students');

if(!empty($_POST)){
    if(preg_match( '/^[0-9]+$/', $_POST['kokugo']) == 0){
        $error['kokugo'] = 'hankaku';
    }
    if(preg_match( '/^[0-9]+$/', $_POST['sugaku']) == 0){
        $error['sugaku'] = 'hankaku';
    }
    if(preg_match( '/^[0-9]+$/', $_POST['eigo']) == 0){
        $error['eigo'] = 'hankaku';
    }
    if(preg_match( '/^[0-9]+$/', $_POST['rika']) == 0){
        $error['rika'] = 'hankaku';
    }
    if(preg_match( '/^[0-9]+$/', $_POST['shakai']) == 0){
        $error['shakai'] = 'hankaku';
    }

    if($_POST['kokugo'] == ''){
        $error['kokugo'] = 'blank';
    }
    if($_POST['sugaku'] == ''){
        $error['sugaku'] = 'blank';
    }
    if($_POST['eigo'] == ''){
        $error['eigo'] = 'blank';
    }
    if($_POST['rika'] == ''){
        $error['rika'] = 'blank';
    }
    if($_POST['shakai'] == ''){
        $error['shakai'] = 'blank';
    }

    if(empty($error)){
        $stmt = $db->prepare('INSERT into exams set test_id=?,student_id=?,kokugo=?,sugaku=?,eigo=?,rika=?,shakai=?,goukei=?,create_at=Now()');
        echo $ret = $stmt->execute(array(
            $_POST['test_id'],
            $_POST['student_id'],
            $_POST['kokugo'],
            $_POST['sugaku'],
            $_POST['eigo'],
            $_POST['rika'],
            $_POST['shakai'],
            $_POST['goukei']
        ));

        unset($_POST);

        header('Location:index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成績管理アプリ</title>
</head>
<body>

    <form action="" method="post">
        <p>テスト名を入力してください</p>
        <select name="test_id" id="test_id">
            <?php foreach($tests as $test): ?>
                <option value="<?php echo $test['id']; ?>"><?php echo $test['name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <p>生徒名を選択してください</p>
        <select name="student_id" id="student_id">
            <?php foreach($students as $student): ?>
                <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <p>各教科の点数を入力してください</p>
        <label for="kokugo">国語</label><br>
        <input name="kokugo" type="text" id="kokugo" value="" onKeyup="calc()"><br><br>

        <label for="sugaku">数学</label><br>
        <input name="sugaku" type="text" id="sugaku" value="" onKeyup="calc()"><br><br>

        <label for="eigo">英語</label><br>
        <input name="eigo" type="text" id="eigo" value="" onKeyup="calc()"><br><br>

        <label for="rika">理科</label><br>
        <input name="rika" type="text" id="rika" value="" onKeyup="calc()"><br><br>

        <label for="shakai">社会</label><br>
        <input name="shakai" type="text" id="shakai" value="" onKeyup="calc()"><br><br>

        <label for="goukei">合計</label><br>
        <input type="text" name="goukei" value="0" readonly><br><br>

        <input type="submit" value="登録する">
    </form>

<script>
const calc = ()=>{
    const kokugo = document.querySelector("input[name=kokugo]");
    const sugaku = document.querySelector("input[name=sugaku]");
    const eigo = document.querySelector("input[name=eigo]");
    const rika = document.querySelector("input[name=rika]");
    const shakai = document.querySelector("input[name=shakai]");
    const goukei = document.querySelector("input[name=goukei]");
    
    goukei.value = Number(kokugo.value) + Number(sugaku.value) + Number(eigo.value) + Number(rika.value) + Number(shakai.value);
}
</script>
</body>
</html>