<?php
// データファイルの読み込み
$question_tree = include 'questions_data.php';

// データ追加
if (isset($_POST['add'])) {
    $key = $_POST['key'];
    $question = $_POST['question'];
    $options_raw = $_POST['options'];

    // オプションの処理
    $options = [];
    $lines = explode("\n", $options_raw);
    foreach ($lines as $line) {
        $parts = explode(':', $line, 2);
        if (count($parts) == 2) {
            $options[trim($parts[0])] = trim($parts[1]);
        }
    }

    $question_tree[$key] = [
        'question' => $question,
        'options' => $options
    ];
    saveQuestionTree($question_tree);
}

// データ削除
if (isset($_POST['delete'])) {
    $key = $_POST['delete'];
    unset($question_tree[$key]);
    saveQuestionTree($question_tree);
}

// データ全体の更新
if (isset($_POST['update_all'])) {
    $new_data = json_decode($_POST['tree_data'], true);
    if ($new_data !== null) {
        $question_tree = $new_data;
        saveQuestionTree($question_tree);
    }
}

// データ保存関数
function saveQuestionTree($data)
{
    $content = "<?php\nreturn " . var_export($data, true) . ";\n";
    file_put_contents('questions_data.php', $content);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>質問ツリー管理</title>
</head>

<body>
    <h1>質問ツリー管理</h1>

    <h2>データ一覧</h2>
    <table border="1" style="border-collapse: collapse;border-color:#666;">
        <tr>
            <th>キー</th>
            <th>質問</th>
            <th>選択肢</th>
            <th>操作</th>
        </tr>
        <?php foreach ($question_tree as $key => $data): ?>
            <tr>
                <td><?php echo htmlspecialchars($key); ?></td>
                <td><?php echo htmlspecialchars($data['question']); ?></td>
                <td>
                    <?php foreach ($data['options'] as $option_key => $option_value): ?>
                        <?php echo htmlspecialchars($option_key) . " => " . htmlspecialchars($option_value) . "<br>"; ?>
                    <?php endforeach; ?>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="delete" value="<?php echo htmlspecialchars($key); ?>">
                        <input type="submit" value="削除">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>データ追加</h2>
    <form method="post">
        <input type="hidden" name="add" value="1">
        キー: <input type="text" name="key" required><br>
        質問: <input type="text" name="question" required><br>
        選択肢 (キー:値の形式で、1行に1つずつ):<br>
        <textarea name="options" rows="5" cols="50" required></textarea><br>
        <input type="submit" value="追加">
    </form>

    <h2>ツリー全体の編集</h2>
    <form method="post">
        <textarea name="tree_data" rows="20" cols="80"><?php echo htmlspecialchars(json_encode($question_tree, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></textarea><br>
        <input type="submit" name="update_all" value="更新">
    </form>
</body>

</html>