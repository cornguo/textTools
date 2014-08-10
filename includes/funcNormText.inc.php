<?php

function normText($string) {
    $fullwidth = file(BASEDIR . '/dict/fullwidth.txt', FILEOPT);
    $halfwidth = file(BASEDIR . '/dict/halfwidth.txt', FILEOPT);

    $string = str_replace($fullwidth, $halfwidth, $string);
    $string = preg_replace('/  +/i', ' ', $string);
    $string = ltrim(rtrim($string));

    $string = preg_replace('/ [^0-9a-z]/u', '', $string);

    return $string;
}
