<?php
session_start();
$question_tree = require 'questions_data.php';

if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'answer') {
    $answer = $_POST['answer'];
    $current_question_key = $_POST['current_question'];

    $_SESSION['chat_history'][] = [
        'question' => $question_tree[$current_question_key]['question'],
        'answer' => $answer
    ];

    $next_question_key = $question_tree[$current_question_key]['options'][$answer] ?? 'start';

    if (!isset($question_tree[$next_question_key])) {
        $next_question_key = 'start';
    }

    echo json_encode([
        'question' => $question_tree[$next_question_key]['question'],
        'options' => $question_tree[$next_question_key]['options'],
        'key' => $next_question_key,
        'lastQuestion' => $question_tree[$current_question_key]['question'],
        'lastAnswer' => $answer
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
    exit;
}

$current_question = $question_tree['start'];
$current_question_key = 'start';

require 'chat_view.php';
