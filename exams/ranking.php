<?php
require('../auth/login-check.php');
require('../components/header.php');

$test_id = $_GET['id'];
$year = $_GET['year'];

// 選択画面に必要な処理
if(!isset($test_id)){
    $if_tests = $db->query('SELECT id,name from tests');
}

// テスト名を表示するため
if(isset($test_id)){
    $tests = $db->prepare('SELECT name from tests where id=?');
    $tests->execute(array($test_id));
}

// ランキング順位取得のコード
// 合計の上位５名
$goukei = $db->prepare(
    'SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
     from exams as ex
     inner join tests as te
     on ex.test_id = te.id
         inner join students as st
         on ex.student_id = st.id
     where ex.test_id=? and ex.year=?
     order by ex.goukei desc
     LIMIT 5');
// 国語の上位５名
    $kokugo = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=? and ex.year=?
    order by ex.kokugo desc
    LIMIT 5');
// 数学の上位５名
    $sugaku = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=? and ex.year=?
    order by ex.sugaku desc
    LIMIT 5');
// 英語の上位５名
    $eigo = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=? and ex.year=?
    order by ex.eigo desc
    LIMIT 5');
// 理科の上位５名
    $rika = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=? and ex.year=?
    order by ex.rika desc
    LIMIT 5');
// 社会の上位５名
    $shakai = $db->prepare('SELECT st.number,st.name as student_name,te.name as test_name,ex.kokugo,ex.sugaku,ex.eigo,ex.rika,ex.shakai,ex.goukei
    from exams as ex
    inner join tests as te
    on ex.test_id = te.id
        inner join students as st
        on ex.student_id = st.id
    where ex.test_id=? and ex.year=?
    order by ex.shakai desc
    LIMIT 5');
?>
    <?php
        if(!isset($test_id)){
            foreach($if_tests as $if_test){
                echo '<a style="text-decoration: none;" href="ranking.php?id='.$if_test['id'].'">  '.$if_test['name'].'     </a>/';
            }
        }
        echo '<br>'
    ?>

    <a href="ranking.php?id=<?php echo $test_id; ?>&year=1">1年生</a>/
    <a href="ranking.php?id=<?php echo $test_id; ?>&year=2">2年生</a>/
    <a href="ranking.php?id=<?php echo $test_id; ?>&year=3">3年生</a><br><br>

    <?php if(isset($test_id)): ?>
        <?php foreach($tests as $test): ?>
                <p>テスト種類:<?php echo $test['name']; ?></p>
        <?php endforeach; ?>
        <?php
            if(isset($year)){
                echo "<p>選択学年:".$year."</p>";
            }else{
                echo "<p>学年を選択してください</p>";
            }
        ?>

        <?php if(isset($year)): ?>
            <?php
            $goukei->execute(array($test_id,$year));
            $kokugo->execute(array($test_id,$year));
            $sugaku->execute(array($test_id,$year));
            $eigo->execute(array($test_id,$year));
            $rika->execute(array($test_id,$year));
            $shakai->execute(array($test_id,$year));
            ?>
            <div>
                <p class="h2">総合TOP5</p>
                <table class="table table-bordered">
                    <tr>
                        <th>順位</th>
                        <th>生徒名</th>
                        <th>国語</th>
                        <th>数学</th>
                        <th>英語</th>
                        <th>理科</th>
                        <th>社会</th>
                        <th>合計</th>
                    </tr>

                    <?php 
                        $rank = 1;
                        foreach($goukei as $result): 
                    ?>
                        <tr>
                            <td><?php echo $rank; ?></td>
                            <td><?php 
                                if($rank == 1){
                                    echo "<i class='fa-solid fa-crown'></i>";
                                }
                                echo $result['student_name']; 
                            ?></td>
                            <td><?php echo $result['kokugo']; ?></td>
                            <td><?php echo $result['sugaku']; ?></td>
                            <td><?php echo $result['eigo']; ?></td>
                            <td><?php echo $result['rika']; ?></td>
                            <td><?php echo $result['shakai']; ?></td>
                            <td><?php echo $result['goukei']; ?></td>
                        </tr>
                    <?php
                        $rank++;
                        endforeach; 
                    ?>
                </table>
            </div><br>

            <div>
                <p class="h2">国語TOP5</p>
                <table class="table table-bordered">
                    <tr>
                        <th>順位</th>
                        <th>生徒名</th>
                        <th>国語</th>
                        <th>数学</th>
                        <th>英語</th>
                        <th>理科</th>
                        <th>社会</th>
                        <th>合計</th>
                    </tr>

                    <?php 
                        $rank = 1;
                        foreach($kokugo as $result): 
                    ?>
                        <tr>
                            <td><?php echo $rank; ?></td>
                            <td><?php
                                if($rank == 1){
                                    echo "<i class='fa-solid fa-crown'></i>";
                                }
                                echo $result['student_name']; 
                            ?></td>
                            <td><?php echo $result['kokugo']; ?></td>
                            <td><?php echo $result['sugaku']; ?></td>
                            <td><?php echo $result['eigo']; ?></td>
                            <td><?php echo $result['rika']; ?></td>
                            <td><?php echo $result['shakai']; ?></td>
                            <td><?php echo $result['goukei']; ?></td>
                        </tr>
                    <?php
                        $rank++;
                        endforeach; 
                    ?>
                </table>
            </div><br>

            <div>
                <p class="h2">数学TOP5</p>
                <table class="table table-bordered">
                    <tr>
                        <th>順位</th>
                        <th>生徒名</th>
                        <th>国語</th>
                        <th>数学</th>
                        <th>英語</th>
                        <th>理科</th>
                        <th>社会</th>
                        <th>合計</th>
                    </tr>

                    <?php 
                        $rank = 1;
                        foreach($sugaku as $result): 
                    ?>
                        <tr>
                            <td><?php echo $rank; ?></td>
                            <td><?php
                                if($rank == 1){
                                    echo "<i class='fa-solid fa-crown'></i>";
                                }
                                echo $result['student_name']; 
                            ?></td>
                            <td><?php echo $result['kokugo']; ?></td>
                            <td><?php echo $result['sugaku']; ?></td>
                            <td><?php echo $result['eigo']; ?></td>
                            <td><?php echo $result['rika']; ?></td>
                            <td><?php echo $result['shakai']; ?></td>
                            <td><?php echo $result['goukei']; ?></td>
                        </tr>
                    <?php
                        $rank++;
                        endforeach; 
                    ?>
                </table>
            </div><br>

            <div>
                <p class="h2">英語TOP5</p>
                <table class="table table-bordered">
                    <tr>
                        <th>順位</th>
                        <th>生徒名</th>
                        <th>国語</th>
                        <th>数学</th>
                        <th>英語</th>
                        <th>理科</th>
                        <th>社会</th>
                        <th>合計</th>
                    </tr>

                    <?php 
                        $rank = 1;
                        foreach($eigo as $result): 
                    ?>
                        <tr>
                            <td><?php echo $rank; ?></td>
                            <td><?php
                                if($rank == 1){
                                    echo "<i class='fa-solid fa-crown'></i>";
                                }
                                echo $result['student_name']; 
                            ?></td>
                            <td><?php echo $result['kokugo']; ?></td>
                            <td><?php echo $result['sugaku']; ?></td>
                            <td><?php echo $result['eigo']; ?></td>
                            <td><?php echo $result['rika']; ?></td>
                            <td><?php echo $result['shakai']; ?></td>
                            <td><?php echo $result['goukei']; ?></td>
                        </tr>
                    <?php
                        $rank++;
                        endforeach; 
                    ?>
                </table>
            </div><br>

            <div>
                <p class="h2">理科TOP5</p>
                <table class="table table-bordered">
                    <tr>
                        <th>順位</th>
                        <th>生徒名</th>
                        <th>国語</th>
                        <th>数学</th>
                        <th>英語</th>
                        <th>理科</th>
                        <th>社会</th>
                        <th>合計</th>
                    </tr>

                    <?php 
                        $rank = 1;
                        foreach($rika as $result): 
                    ?>
                        <tr>
                            <td><?php echo $rank; ?></td>
                            <td><?php
                                if($rank == 1){
                                    echo "<i class='fa-solid fa-crown'></i>";
                                }
                                echo $result['student_name']; 
                            ?></td>
                            <td><?php echo $result['kokugo']; ?></td>
                            <td><?php echo $result['sugaku']; ?></td>
                            <td><?php echo $result['eigo']; ?></td>
                            <td><?php echo $result['rika']; ?></td>
                            <td><?php echo $result['shakai']; ?></td>
                            <td><?php echo $result['goukei']; ?></td>
                        </tr>
                    <?php
                        $rank++;
                        endforeach; 
                    ?>
                </table>
            </div><br>

            <div>
                <p class="h2">社会TOP5</p>
                <table class="table table-bordered">
                    <tr>
                        <th>順位</th>
                        <th>生徒名</th>
                        <th>国語</th>
                        <th>数学</th>
                        <th>英語</th>
                        <th>理科</th>
                        <th>社会</th>
                        <th>合計</th>
                    </tr>

                    <?php 
                        $rank = 1;
                        foreach($shakai as $result): 
                    ?>
                        <tr>
                            <td><?php echo $rank; ?></td>
                            <td><?php
                                if($rank == 1){
                                    echo "<i class='fa-solid fa-crown'></i>";
                                }
                                echo $result['student_name']; 
                            ?></td>
                            <td><?php echo $result['kokugo']; ?></td>
                            <td><?php echo $result['sugaku']; ?></td>
                            <td><?php echo $result['eigo']; ?></td>
                            <td><?php echo $result['rika']; ?></td>
                            <td><?php echo $result['shakai']; ?></td>
                            <td><?php echo $result['goukei']; ?></td>
                        </tr>
                    <?php
                        $rank++;
                        endforeach; 
                    ?>
                </table>
            </div><br>
        <?php endif; ?>

        <a href="ranking.php">テスト選択に戻る</a><br><br>
        <a href="download.php?id=<?php echo $test_id; ?>&year=<?php echo $year; ?>">ダウンロードする</a><br>
    <?php endif; ?>
    <br><a href="index.php">テスト結果へ戻る</a><br>
    <br><a href="../index.php">トップページ</a><br>
<?php
require('../components/footer.php');
?>