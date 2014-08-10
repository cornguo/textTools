<?php

include 'includes/funcBase.inc.php';
include 'funcNormText.inc.php';

$fullwidth = file(BASEDIR . '/dict/fullwidth.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
shuffle($fullwidth);
$string = implode('', $fullwidth);

echo 'Before: ' . PHP_EOL . $string . PHP_EOL;
echo 'After: ' . PHP_EOL . normText($string) . PHP_EOL;

