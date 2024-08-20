<?php
session_start();

require "config.php";

// ログイン試行回数の制限
$max_attempts = 5;
$lockout_time = 15 * 60; // 15分

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 前回のログイン試行時刻を取得
    $last_attempt_time = isset($_SESSION['last_attempt_time']) ? $_SESSION['last_attempt_time'] : 0;
    $current_time = time();

    // ログイン試行間隔のチェック（5秒以内の連続試行を禁止）
    if ($current_time - $last_attempt_time < 5) {
        $error = '短時間での連続ログイン試行は禁止されています。しばらく待ってから再試行してください。';
    } else {
        $password = $_POST['password'];

        // ログイン試行回数のチェック
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        if ($_SESSION['login_attempts'] >= $max_attempts) {
            if ($current_time - $last_attempt_time < $lockout_time) {
                $error = 'ログイン試行回数の上限に達しました。' . ceil(($lockout_time - ($current_time - $last_attempt_time)) / 60) . '分後に再試行してください。';
            } else {
                $_SESSION['login_attempts'] = 0;
            }
        }

        if (!isset($error)) {
            if (password_verify($password, $hashed_password)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['login_attempts'] = 0;
                header('Location: questions_data_edit.php');
                exit;
            } else {
                $_SESSION['login_attempts']++;
                $error = 'パスワードが正しくありません。残り試行回数: ' . ($max_attempts - $_SESSION['login_attempts']);
            }
        }
    }

    $_SESSION['last_attempt_time'] = $current_time;
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="password"] {
            width: 200px;
            padding: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form method="post">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <label for="password">パスワード：</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="ログイン">
    </form>
</body>

</html>