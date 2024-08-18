<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat-site</title>
    <link rel="stylesheet" href="css/chat.css">
    <style>
        .article {
            height: 1000px;
            width: 100vw;
            margin: 70px 0;
        }

        .article-wrapper {
            height: 100%;
            width: 100%;
            background-color: #777;
        }
    </style>
</head>

<body>
    <div class="article">
        <div class="article-wrapper">
            <?php require "questions.php" ?>
        </div>
    </div>
</body>

</html>