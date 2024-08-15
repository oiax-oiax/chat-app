<?php
$question_tree = [
    'start' => [
        'question' => "ご質問は何でしょうか？",
        'options' => [
            '管理について' => 'kanri',
            '空室について' => 'kushitsu'
        ]
    ],
    'kanri' => [
        'question' => "管理のご質問内容はなんですか？",
        'options' => [
            '修繕の問合せ' => 'shuzen',
            'その他の問合せ' => 'sonta',
        ]
    ],
    'shuzen' => [
        'question' => "水道の修繕については・・・",
        'options' => [
            'その他の問合せ' => 'sonota',
            '初めに戻る' => 'start'
        ]
    ],
    'sonota' => [
        'question' => "修繕は・・・、契約関係については・・・",
        'options' => [
            '空室について' => 'kushitsu',
            '初めに戻る' => 'start'
        ]
    ],
    'kushitsu' => [
        'question' => "空室は・・・",
        'options' => [
            '初めに戻る' => 'start'
        ]
    ]
];
