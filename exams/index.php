<?php
require('../auth/login-check.php');
require('../components/header.php');

// 検索機能をつける
if(!empty($_POST)){
    $examsPreare = $db->prepare(
    'SELECT st.name as student_name,st.number,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei,ex.id
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
        where st.name=? and st.number=?');

    $examsPreare->execute(array(
        $_POST['student-name'],
        $_POST['student-num']
    ));

    $exams = $examsPreare->fetchAll(PDO::FETCH_ASSOC);
}else{
    $exams = $db->query('SELECT st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei,ex.id
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id');
}


?>
    <div class="mt-3">
        <h2>テスト結果</h2>
    </div>

    <div class="card p-3 mt-3">
        <div class="container">
            <p class="h3">検索情報</p>
            <form action="" method="post">
                <label for="student-name">お名前</label><br>
                <input type="text" name="student-name" id="student-name"><br><br>

                <label for="student-num">学籍番号</label><br>
                <input type="text" name="student-num" id="student-num"><br><br>

                <input type="submit" value="検索する">
            </form>
            <a href="">検索をクリアする</a>
        </div>
    </div>

    <div class="card p-3">
        <div class="container">
            <p class="h3">テスト結果一覧</p>
            <table class="table table-bordered">
                <tr><th>テスト</th><th>生徒名</th><th>国語</th><th>数学</th><th>英語</th><th>理科</th><th>社会</th><th>合計</th><th>変更</th><th>削除</th></tr>
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
                            <td><a href="edit.php?id=<?php echo $exam['id']; ?>">変更</a></td>
                            <td><a href="destory.php?id=<?php echo $exam['id']; ?>">削除</a></td>
                        </tr>
                    <?php endforeach; ?>
            </table><br>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-6">
            <div class="card p-3">
                <a href="create.php">生徒の成績を入力</a> 
            </div>
        </div>

        <div class="col-6">
            <div class="card p-3">
                <a href="ranking.php">テストごとにランキングで成績を見る</a>
            </div>
        </div>

        <div class="col-6">
            <div class="card p-3">
                <a href="individual-search.php">生徒の個別ページを見る</a>
            </div>
        </div>

        <!-- <div class="col-6">
            <div class="card p-3">
                <a href="download.php">ダウンロードする</a>
            </div>
        </div> -->

        <div class="col-6">
            <div class="card p-3">
                <a href="../index.php">トップページ</a>
            </div>
        </div>
    </div>
<?php
require('../components/footer.php');
?>