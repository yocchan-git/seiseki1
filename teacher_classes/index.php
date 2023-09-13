<?php
require('../auth/login-check.php');
require('../components/header.php');

$classes = $db->query('SELECT * from classes');
$teachers = $db->query('SELECT * from teachers where post=1');

$teacher_classes = $db->query(
    'SELECT te.name,cl.class_name,te.id as teacher_id,cl.id as class_id
    from teacher_classes as tc
    inner join teachers as te
    on tc.teacher_id = te.id
        inner join classes as cl
        on cl.id = tc.class_id'
    );
// エラー用にもう一つ作っておく
$teachers_id = $db->query(
    'SELECT te.name,cl.class_name,te.id as teacher_id,cl.id as class_id
    from teacher_classes as tc
    inner join teachers as te
    on tc.teacher_id = te.id
        inner join classes as cl
        on cl.id = tc.class_id'
    );


    if(!empty($_POST)){
        foreach($teachers_id as $teacher_class){
            if($teacher_class['teacher_id'] == $_POST['teacherId']){
                $error['sameName'] = 'same';
            }
        }

        if(empty($error)){
            $stmt = $db->prepare('INSERT into teacher_classes set teacher_id=?,class_id=?');
            $stmt->execute(array(
                $_POST['teacherId'],
                $_POST['classId']
            ));

            header('Location:index.php');
            exit();
        }
    }

?>

<div class="card p-3 mt-3">
    <div class="container">
        <p class="mt-3 h2">担当クラス一覧</p>
        <table class="table table-bordered">
                <tr><th>クラスID</th><th>教師名</th><th>クラス名</th></tr>
                <?php foreach($teacher_classes as $teacher_class): ?>
                <tr>
                    <td><?php echo htmlspecialchars($teacher_class['class_id'],ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($teacher_class['name'],ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($teacher_class['class_name'],ENT_QUOTES); ?></td>
                </tr>
                <?php endforeach; ?>
        </table>
    </div>
</div>

<div class="card p-3 mt-3">
    <div class="container">
        <p class="h3">担当クラス登録画面</p>

        <form action="" method="post">
            <p class="mb-1 mt-3">クラスを選択してください<?php if($error['sameName'] == 'same'): ?>
                <span class="text-danger">先生1人が担当できるクラスは1つです</span>
            <?php endif; ?></p>

            <select name="classId" id="">
                <?php foreach($classes as $class): ?>
                    <option value="<?php echo htmlspecialchars($class['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($class['class_name'],ENT_QUOTES); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <p class="mb-1">先生を選択してください</p>
            <select name="teacherId" id="">
                <?php foreach($teachers as $teacher): ?>
                    <option value="<?php echo htmlspecialchars($teacher['id'],ENT_QUOTES); ?>"><?php echo htmlspecialchars($teacher['name'],ENT_QUOTES); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <input class="btn btn-primary" type="submit" value="登録する">
        </form>

    </div>
</div>

<div class="row mt-4 mb-4">
    <div class="col-6">
        <div class="card p-3">
            <a href="../teachers/index.php">トップページへ</a>  
        </div>
    </div>
</div>

<?php
require('../components/footer.php');
?>