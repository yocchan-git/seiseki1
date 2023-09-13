<?php
require('../auth/login-check.php');
require('../components/header.php');

// 権限によって、表示するテスト結果を変えている
if($_SESSION['post'] == 1){
    // 一般の時は自分の担当のクラスだけ

    $stmt = $db->prepare('SELECT class_id from teacher_classes where teacher_id=?');
    $stmt->execute(array(
        $_SESSION['id']
    ));
    $class = $stmt->fetch();
    // 検索機能をつける
    if(!empty($_POST)){
        $examsPreare = $db->prepare(
        'SELECT st.name as student_name,st.number,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei,ex.id
        from exams as ex
        inner join tests as te
        on ex.test_id = te.id
            inner join students as st
            on ex.student_id = st.id
            where st.name=? and st.number=? and st.class_id=?');

        $examsPreare->execute(array(
            $_POST['student-name'],
            $_POST['student-num'],
            $class['class_id']
        ));

        $exams = $examsPreare->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $examsStmt = $db->prepare('SELECT st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei,ex.id
        from exams as ex
        inner join tests as te
        on ex.test_id = te.id
            inner join students as st
            on ex.student_id = st.id
            where st.class_id=?');
        $examsStmt->execute(array(
            $class['class_id']
        ));
        $exams = $examsStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}elseif($_SESSION['post'] == 2){
    // 学年主任は入力された担当のクラスだけ

    // 検索機能をつける
    if(!empty($_POST)){
        $examsPreare = $db->prepare(
        'SELECT st.name as student_name,st.number,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei,ex.id
        from exams as ex
        inner join tests as te
        on ex.test_id = te.id
            inner join students as st
            on ex.student_id = st.id
            where st.name=? and st.number=? and ex.year=?');

        $examsPreare->execute(array(
            $_POST['student-name'],
            $_POST['student-num'],
            $_SESSION['shuninYear']
        ));

        $exams = $examsPreare->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $examsStmt = $db->prepare('SELECT st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei,ex.id
        from exams as ex
        inner join tests as te
        on ex.test_id = te.id
            inner join students as st
            on ex.student_id = st.id
            where ex.year=?');
        $examsStmt->execute(array(
            $_SESSION['shuninYear']
        ));
        $exams = $examsStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}else{
    // 校長先生は全生徒の成績が見れる

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
}

$tests = $db->query('SELECT id,name from tests');
$students = $db->query('SELECT id,name from students');
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

                <input class="btn btn-primary mb-3" type="submit" value="検索する">
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
                        <tr id="examContent<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>">
                            <td><?php echo htmlspecialchars($exam['test_name'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($exam['student_name'],ENT_QUOTES); ?></td>
                            <td id="examKokugoTd<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($exam['kokugo'],ENT_QUOTES); ?></td>
                            <td id="examSugakuTd<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($exam['sugaku'],ENT_QUOTES); ?></td>
                            <td id="examEigoTd<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($exam['eigo'],ENT_QUOTES); ?></td>
                            <td id="examRikaTd<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($exam['rika'],ENT_QUOTES); ?></td>
                            <td id="examShakaiTd<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($exam['shakai'],ENT_QUOTES); ?></td>
                            <td id="examGoukeiTd<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($exam['goukei'],ENT_QUOTES); ?></td>
                            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#examUpdateModal<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>">変更</button></td>
                            <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#examDeleteModal<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>">削除</button></td>
                        </tr>

                        <!-- 更新用のモーダルを作る -->
                        <div class="modal fade" id="examUpdateModal<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                
                                <!-- モーダルのヘッダ -->
                                <div class="modal-header">
                                    <h5 class="modal-title">変更内容</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                
                                <!-- モーダルの本文 -->
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <p class="mt-3 mb-0 p-0">テスト名は変更できません</p><br>

                                        <p class="mt-0 mb-0 p-0">生徒名は変更できません</p><br>

                                        <p>各教科の点数を入力してください</p>
                                        <label for="kokugo">国語</label>
                                        <input class="mb-3" name="kokugo" type="text" id="kokugo<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($exam['kokugo'],ENT_QUOTES); ?>" onKeyup="calcTotal(<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>)"><br>

                                        <label for="sugaku">数学</label>
                                        <input class="mb-3" name="sugaku" type="text" id="sugaku<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($exam['sugaku'],ENT_QUOTES); ?>" onKeyup="calcTotal(<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>)"><br>

                                        <label for="eigo">英語</label>
                                        <input class="mb-3" name="eigo" type="text" id="eigo<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($exam['eigo'],ENT_QUOTES); ?>" onKeyup="calcTotal(<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>)"><br>

                                        <label for="rika">理科</label>
                                        <input class="mb-3" name="rika" type="text" id="rika<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($exam['rika'],ENT_QUOTES); ?>" onKeyup="calcTotal(<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>)"><br>

                                        <label for="shakai">社会</label>
                                        <input class="mb-4" name="shakai" type="text" id="shakai<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($exam['shakai'],ENT_QUOTES); ?>" onKeyup="calcTotal(<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>)"><br>

                                        <label for="goukei">合計</label>
                                        <input type="text" name="goukei" id="goukei<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($exam['goukei'],ENT_QUOTES); ?>" readonly><br><br>
                                    </form>
                                </div>
                                
                                <!-- モーダルのフッタ -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                    <button type="button" class="btn btn-primary" onclick="updateExam(<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>)">変更</button>
                                </div>
                                
                                </div>
                            </div>
                        </div>

                        <!-- 削除用のモーダルを作る -->
                        <div class="modal fade" id="examDeleteModal<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                
                                <!-- モーダルのヘッダ -->
                                <div class="modal-header">
                                    <h5 class="modal-title">削除内容</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                
                                <!-- モーダルの本文 -->
                                <div class="modal-body">
                                    <p>テスト名:<?php echo htmlspecialchars($exam['test_name'],ENT_QUOTES); ?></p>
                                    <p>名前:<?php echo htmlspecialchars($exam['student_name'],ENT_QUOTES); ?></p>
                                    <p>合計点:<?php echo htmlspecialchars($exam['goukei'],ENT_QUOTES); ?></p>
                                </div>
                                
                                <!-- モーダルのフッタ -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteExam(<?php echo htmlspecialchars($exam['id'],ENT_QUOTES); ?>)">削除</button>
                                </div>
                                
                                </div>
                            </div>
                        </div>
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

        <div class="col-6">
            <div class="card p-3">
                <a href="../index.php">トップページ</a>
            </div>
        </div>
    </div>

<?php
require('../components/footer.php');
?>