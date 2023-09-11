<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- リセットcss -->
    <link rel="stylesheet" href="https://unpkg.com/modern-css-reset/dist/reset.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/4aa12ef06a.js" crossorigin="anonymous"></script>
    <title>成績管理アプリ</title>
</head>
<body class="container">
    <?php 
    if(isset($teacher)): 
    ?>
        <header>
            <div class="horizontal container">
                <nav class="horizontal-nav">
                    <ul>
                        <li class="top-font"><a href="../teachers/index.php">TOP</a></li>
                        <li><a href="../tests/index.php">テスト</a></li>
                        <li><a href="../students/index.php">生徒</a></li>
                        <li><a href="../exams/index.php">テスト結果</a></li>
                    </ul>
                </nav>

                <nav class="horizontal-nav text-">
                    <ul>
                        <li>ログインユーザー<span class="ms-1 me-1"><?php echo htmlspecialchars($teacher['name'],ENT_QUOTES); ?>/<?php echo htmlspecialchars($_SESSION['login_time'],ENT_QUOTES); ?></span></li>
                        <li><a href="../auth/logout.php">ログアウト</a></li>
                    </ul>
                </nav>
            </div>
        </header>
    <?php 
    endif; 
    ?>