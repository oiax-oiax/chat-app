<?php
return array (
  'start' => 
  array (
    'question' => 'ご質問は何でしょうか？',
    'options' => 
    array (
      '管理について' => 'kanri',
      '空室について' => 'kushitsu',
    ),
  ),
  'kanri' => 
  array (
    'question' => '管理のご質問内容はなんですか？',
    'options' => 
    array (
      '修繕の問合せ' => 'shuzen',
      'その他の問合せ' => 'sonta',
    ),
  ),
  'shuzen' => 
  array (
    'question' => '水道の修繕については・・・',
    'options' => 
    array (
      'その他の問合せ' => 'sonota',
      '初めに戻る' => 'start',
    ),
  ),
  'sonota' => 
  array (
    'question' => '修繕は・・・、契約関係については・・・',
    'options' => 
    array (
      '空室について' => 'kushitsu',
      '初めに戻る' => 'start',
    ),
  ),
  'kushitsu' => 
  array (
    'question' => '空室は・・・',
    'options' => 
    array (
      '初めに戻る' => 'start',
    ),
  ),
);
