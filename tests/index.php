<?php
require('../auth/login-check.php');
require('../components/header.php');

$tests = $db->query('SELECT * from tests');
?>
    <p class="h2 mt-3">年間のテスト一覧</p>
    <table class="table table-bordered">
        <tr><th>学年</th><th>テスト名</th><th>作成日</th><th>変更はこちら</th><th>削除するか</th></tr>
        <?php foreach($tests as $test): ?>
        <tr id="testContent<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>">
            <td id="testYearTable<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($test['year'],ENT_QUOTES); ?></td>
            <td id="testNameTable<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($test['name'],ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($test['create_at'],ENT_QUOTES); ?></td>
            <!-- <td><a href="edit.php?id=">変更</a></td> -->
            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testUpdateModal<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>">変更</button></td>
            <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#testDeleteModal<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>">削除</button></td>
        </tr>

        <!-- 更新用のモーダル -->
        <div class="modal fade" id="testUpdateModal<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>" tabindex="-1">
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
                        <label for="year">学年（1〜３の数字で入力）</label><br>
                        <input type="text" name="year" id="year<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($test['year'],ENT_QUOTES); ?>"><br><br>

                        <label for="name">テスト名</label><br>
                        <input type="text" name="name" id="name<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($test['name'],ENT_QUOTES); ?>">
                    </form>
                </div>
                
                <!-- モーダルのフッタ -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="button" class="btn btn-primary" onclick="updateTest(<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>)">変更</button>
                </div>
                
                </div>
            </div>
        </div>

        <!-- 削除用のモーダル -->
        <div class="modal fade" id="testDeleteModal<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                
                <!-- モーダルのヘッダ -->
                <div class="modal-header">
                    <h5 class="modal-title">削除内容</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <!-- モーダルの本文 -->
                <div class="modal-body">
                    <p><?php echo htmlspecialchars($test['year'],ENT_QUOTES); ?></p>
                    <p><?php echo htmlspecialchars($test['name'],ENT_QUOTES); ?></p>
                </div>
                
                <!-- モーダルのフッタ -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="button" class="btn btn-danger" onclick="deleteTest(<?php echo htmlspecialchars($test['id'],ENT_QUOTES); ?>)">削除</button>
                </div>
                
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </table>
    <a href="create.php">テストを作成する</a><br>
    <br><a href="../index.php">トップページ</a><br>
<?php
require('../components/footer.php');
?>

<?php
// モーダルを先に全部作っておくforeachを作っておく
// idには識別の番号を入れて対応させておく
?>

