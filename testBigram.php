<?php

include 'includes/funcBase.inc.php';
include 'includes/funcPos.inc.php';

testString('今天 Facebook 出現了超過了 2000 筆關於 祭止兀 的貼文');
testString('我的編號是 9527-001，你呢？');
testString('「BJ4」到底是甚麼意思？');
testString('陶(吉吉)今日在西門舉辦簽唱會');
testString("Abandon entour é d'abandon,\nTendresse touchant aux tendresses...");
testString("踏まれた花の　名前も知らずに\n地に堕ちた鳥は　風を待ち侘びる");

function testString($string) {
    echo implode(' ', getBigramArray($string)) . PHP_EOL;
}
