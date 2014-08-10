<?php

function normText($string) {
    $fullwidth = file(BASEDIR . '/dict/fullwidth.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    $halfwidth = file(BASEDIR . '/dict/halfwidth.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

    $string = str_replace($fullwidth, $halfwidth, $string);
    $string = preg_replace('/  +/i', ' ', $string);
    $string = ltrim(rtrim($string));

    $string = preg_replace('/ [^0-9a-z]/u', '', $string);

    return $string;
}
