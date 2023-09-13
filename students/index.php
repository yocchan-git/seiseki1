<?php
require('../auth/login-check.php');
require('../components/header.php');

$students = $db->query('SELECT * from students');
?>

    <p class="h2 mt-3">生徒一覧</p>
    <table class="table table-bordered">
        <tr><th>学籍番号</th><th>名前</th><th>クラスID</th><th>変更はこちら</th><th>削除するか</th></tr>
        <?php foreach($students as $student): ?>
        <tr id="studentContent<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>">
            <td id="studentNumberTd<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($student['number'],ENT_QUOTES); ?></td>
            <td id="studentNameTd<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($student['name'],ENT_QUOTES); ?></td>
            <td id="studentClassIdTd<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($student['class_id'],ENT_QUOTES); ?></td>
            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#studentUpdateModal<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>">変更</button></td>
            <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#studentDeleteModal<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>">削除</button></td>
        </tr>

        <!-- 更新用のモーダルを作る -->
        <div class="modal fade" id="studentUpdateModal<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>" tabindex="-1">
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
                        <label for="number">学籍番号</label><br>
                        <input type="text" id="number<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>" name="number" value="<?php echo htmlspecialchars($student['number'],ENT_QUOTES); ?>"><br><br>

                        <label for="name">名前</label><br>
                        <input type="text" name="name" id="name<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($student['name'],ENT_QUOTES); ?>"><br><br>

                        <label for="class_id">クラスID</label><br>
                        <input type="text" id="class_id<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>" name="class_id" value="<?php echo htmlspecialchars($student['class_id'],ENT_QUOTES); ?>">
                    </form>
                </div>
                
                <!-- モーダルのフッタ -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="button" class="btn btn-primary" onclick="updateStudent(<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>)">変更</button>
                </div>
                
                </div>
            </div>
        </div>
        <!-- 削除用のモーダルを作る -->
        <div class="modal fade" id="studentDeleteModal<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                
                <!-- モーダルのヘッダ -->
                <div class="modal-header">
                    <h5 class="modal-title">削除内容</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <!-- モーダルの本文 -->
                <div class="modal-body">
                    <p>学籍番号:<?php echo htmlspecialchars($student['number'],ENT_QUOTES); ?></p>
                    <p>名前:<?php echo htmlspecialchars($student['name'],ENT_QUOTES); ?></p>
                    <p>クラスID:<?php echo htmlspecialchars($student['class_id'],ENT_QUOTES); ?></p>
                </div>
                
                <!-- モーダルのフッタ -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="button" class="btn btn-danger" onclick="deleteStudent(<?php echo htmlspecialchars($student['id'],ENT_QUOTES); ?>)">削除</button>
                </div>
                
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </table>
    <a href="create.php">生徒を登録する</a><br>
    <br><a href="../index.php">トップページ</a><br>
<?php
require('../components/footer.php');
?>