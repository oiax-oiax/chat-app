<?php
// データファイルの読み込み
$question_tree = include 'questions_data.php';

// データ追加
if (isset($_POST['add'])) {
    $key = $_POST['key'];
    $question = $_POST['question'];
    $options_raw = $_POST['options'];

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

// ツリー全体の更新
if (isset($_POST['update_all'])) {
    $new_tree = [];
    foreach ($_POST['tree_keys'] as $index => $key) {
        if (!empty($key)) {
            $new_tree[$key] = [
                'question' => $_POST['tree_questions'][$index],
                'options' => []
            ];
            $options_raw = $_POST['tree_options'][$index];
            $lines = explode("\n", $options_raw);
            foreach ($lines as $line) {
                $parts = explode(':', $line, 2);
                if (count($parts) == 2) {
                    $new_tree[$key]['options'][trim($parts[0])] = trim($parts[1]);
                }
            }
        }
    }
    $question_tree = $new_tree;
    saveQuestionTree($question_tree);
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
    <style>
        .edit-area {
            width: 1000px;
            margin: 30px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tree-item {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        input[type="text"] {
            width: 300px;
            margin-bottom: 5px;
        }

        textarea {
            width: 300px;
            height: 100px;
        }

        .tree-container {
            max-width: 500px;
        }
    </style>
</head>

<body>
    <div class="edit-area">

        <h1>質問ツリー管理</h1>


        <h2>データ一覧</h2>
        <table border="1" style="border-collapse:collapse;border-color:#666;">
            <tr>
                <th>質問</th>
                <th style="min-width: 80px;">キー</th>
                <th>選択肢</th>
                <th>操作</th>
            </tr>
            <?php foreach ($question_tree as $key => $data): ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['question']); ?></td>
                    <td><?php echo htmlspecialchars($key); ?></td>
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
            質問: <input type="text" name="question" required><br>
            キー: <input type="text" name="key" required><br>
            選択肢 (値:キーの形式で、1行に1つずつ):<br>
            <textarea name="options" rows="5" cols="50" required></textarea><br>
            <input type="submit" value="追加">
        </form>

        <h2>ツリー全体の編集</h2>
        <form method="post" id="tree-edit-form">
            <div class="tree-container">
                <?php foreach ($question_tree as $key => $data): ?>
                    <div class="tree-item">
                        質問: <input type="text" name="tree_questions[]" value="<?php echo htmlspecialchars($data['question']); ?>" required><br>
                        キー: <input type="text" name="tree_keys[]" value="<?php echo htmlspecialchars($key); ?>" required><br>
                        選択肢 (値:キーの形式で、1行に1つずつ):<br>
                        <textarea name="tree_options[]" required><?php
                                                                    foreach ($data['options'] as $option_key => $option_value) {
                                                                        echo htmlspecialchars($option_key) . ':' . htmlspecialchars($option_value) . "\n";
                                                                    }
                                                                    ?></textarea>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="submit" name="update_all" value="更新">
        </form>

        <p>
            <button onclick="addNewTreeItem()">新しい項目を追加</button>
        </p>

    </div>
    <script>
        function addNewTreeItem() {
            var container = document.querySelector('.tree-container');
            var newItem = document.createElement('div');
            newItem.className = 'tree-item';
            newItem.innerHTML = `
            質問: <input type="text" name="tree_questions[]" required><br>
            キー: <input type="text" name="tree_keys[]" required><br>
                選択肢 (値:キーの形式で、1行に1つずつ):<br>
                <textarea name="tree_options[]" required></textarea>
                `;
            container.appendChild(newItem);
        }
    </script>
</body>

</html>