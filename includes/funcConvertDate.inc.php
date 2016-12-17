<?php

function convertDate($dateString, $timestamp) {
    $pattern = array(
        ',', '零', '○',
        '一', '二', '三', '四', '五', '六', '七', '八', '九',
        '兩', '廿', '卅', '元月',
        '十', '百', '千', '萬',
        '星期天', '禮拜天', '星期', '禮拜', '週末', '即日', '來年',
        '([0-9])\[10\]([0-9])', '\[([123])0\]([0-9])', '([0-9])\[[123](0)\]', '\[10\]'
    );

    foreach ($pattern as $k => $v) {
        $pattern[$k] = '/' . $v . '/u';
    }

    $replace = array(
        '', '0', '0',
        '1', '2', '3', '4', '5', '6', '7', '8', '9',
        '2', '[20]', '[30]', '1月',
        '[10]', '00', '000', '0000',
        '周日', '周日', '周', '周', '周6', '今天', '明年',
        '$1$2', '$1$2', '$1$2', '10'
    );

    $dateReplaced = preg_replace($pattern, $replace, $dateString);
    $match = array();

    $cnt = 0;

    if (!preg_match('/[大今明昨前後去這上下個本周週禮拜]/u', $dateReplaced)) {
        $cnt = preg_match_all('/(?P<type>[中華民國公西元國曆農曆]+)?((?P<num>[0-9]+)(?P<unit>[年月日]))/u', $dateReplaced, $match);
    } else {
        $cnt = preg_match_all('/(?P<shift>[大今明昨前後去這上下個本]{1,2})??(?P<shiftunit>[年月日天周週早午晚]{1}上?)((?P<month>[0-9]{1,2})月)??((?P<day>[0-9]{1,2})日)??(?P<weekday>[1-6日])??(?P<shiftdir>[前後])??/Uu', $dateReplaced, $match);
    }

    if (0 === $cnt) {
        return $dateString;
    }

    $output = '';

    if (isset($match['num'])) {
        $tmp = array(
               '年' => -1,
               '月' => -1,
               '日' => -1,
        );
        foreach ($match['num'] as $k => $v) {
            if ((isset($match['type'][$k]) && false !== strstr($match['type'][$k], '民'))
                || ('年' === $match['unit'][$k] && $v <= 100)) {
                $v += 1911;
            }
            $tmp[$match['unit'][$k]] = $v;
        }

        if (-1 === $tmp['年'] && -1 ===  $tmp['月']) {
            $tmp['年'] = date('Y', $timestamp);
            $tmp['月'] = date('m', $timestamp);
            $thisMonth = strtotime($tmp['年'] . '-' . $tmp['月'] . '-' . $tmp['日']);
            $nextMonth = strtotime($tmp['年'] . '-' . ($tmp['月'] + 1) . '-' . $tmp['日']);
            $lastMonth = strtotime($tmp['年'] . '-' . ($tmp['月'] - 1) . '-' . $tmp['日']);
            if (abs($nextMonth - $timestamp) < abs($thisMonth - $timestamp)) {
                $tmp['月']++;
            }
            if (abs($lastMonth - $timestamp) < abs($thisMonth - $timestamp)) {
                $tmp['月']--;
            }
            $tmp['年'] += intval($tmp['月'] / 12);
            $tmp['月'] %= 12;
        }

        if (-1 === $tmp['年']) {
            $tmp['年'] = date('Y', $timestamp);
            if (-1 === $tmp['日']) {
                $tmp['日'] = 1;
            }
            $thisYear = strtotime($tmp['年'] . '-' . $tmp['月'] . '-' . $tmp['日']);
            $nextYear = strtotime(($tmp['年'] + 1) . '-' . $tmp['月'] . '-' . $tmp['日']);
            $lastYear = strtotime(($tmp['年'] - 1) . '-' . $tmp['月'] . '-' . $tmp['日']);
            if (abs($nextYear - $timestamp) < abs($thisYear - $timestamp)) {
                $tmp['年']++;
            }
            if (abs($lastYear - $timestamp) < abs($thisYear - $timestamp)) {
                $tmp['年']--;
            }
        }

        if (-1 === $tmp['月']) {
            $tmp['月'] = 1;
        }

        if (-1 === $tmp['日']) {
            $tmp['日'] = 1;
        }

        //print_r($tmp);

        $output = strtotime($tmp['年'] . '-' . $tmp['月'] . '-' . $tmp['日']);
    } else {
        $convStr = '';
        $sub = array(
            '大前' => '-3 ',
            '大後' => '+3 ',
            '今' => 'this ',
            '明' => 'next ',
            '昨' => 'last ',
            '前' => '-',
            '後' => '+',
            '去' => 'last ',
            '這' => 'this ',
            '上' => 'last ',
            '下' => 'next ',
            '個' => ' ',
            '本' => 'this ',
        );
        $convStr .= str_replace(array_keys($sub), array_values($sub), $match['shift'][0]);
        $sub = array(
            '年' => 'year ',
            '月' => 'month ',
            '日' => 'day ',
            '天' => 'day ',
            '周' => 'week ',
            '週' => 'week ',
            '禮拜' => 'week ',
            '早' => '1 day ',
            '午' => '1 day ',
            '晚' => '1 day ',
        );
        $convStr .= str_replace(array_keys($sub), array_values($sub), $match['shiftunit'][0]);
        $sub = array(
            '1' => 'Jan ',
            '2' => 'Fab ',
            '3' => 'Mar ',
            '4' => 'Api ',
            '5' => 'May ',
            '6' => 'Jun ',
            '7' => 'Jul ',
            '8' => 'Aug ',
            '9' => 'Sep ',
            '10' => 'Oct ',
            '11' => 'Nov ',
            '12' => 'Dec ',
        );
        $convStr .= str_replace(array_keys($sub), array_values($sub), $match['month'][0]);
        $sub = array(
            '1' => 'Mon',
            '2' => 'Tue',
            '3' => 'Wed',
            '4' => 'Thu',
            '5' => 'Fri',
            '6' => 'Sat',
            '日' => 'Sun',
        );
        $convStr .= str_replace(array_keys($sub), array_values($sub), $match['weekday'][0]);
        $sub = array(
            '前' => 'ago',
            '後' => '',
        );
        $convStr .= str_replace(array_keys($sub), array_values($sub), $match['shiftdir'][0]);
        //echo $dateReplaced . ' => "' . $convStr . '"' . PHP_EOL;

        $convStr = preg_replace('/([-+])([a-z]+) (.*)/', '$1 2 $2 $3', $convStr);
        $convStr = preg_replace('/^week/', 'this week', $convStr);
        $convStr = str_replace('last 1', 'last', $convStr);
        $convStr = str_replace('next +', '+', $convStr);
        $convStr = trim($convStr);

        $convTimestamp = $timestamp;
        $lastWord = preg_replace('/^.*(.)$/Uu', '$1', $dateString);
        //echo 'CHECK: ' . $lastWord . PHP_EOL;

        if ('年' === $lastWord) {
            $convTimestamp = strtotime(date('Y-1-1', $timestamp));
        }
        if ('月' === $lastWord) {
            $convTimestamp = strtotime(date('Y-m-1', $timestamp));
        }


        if (isset($match['day'][0]) && strlen($match['day'][0]) > 0) {
            $convStr = preg_replace('/(.*)-(.*)-.*/Uu', '$1-$2-' . $match['day'][0]);
        }

        $output = strtotime($convStr, $convTimestamp);
    }

    if (false === $output) {
        return $dateString;
    }

    $output = date('Y-m-d', $output);

    if (defined('DEBUG')) {
        echo $dateString . ' (' . date('Y-m-d', $timestamp) .  ') => ' . $dateReplaced;
        if (isset($convStr)) {
            echo ' => ' . $convStr . ' (' . date('Y-m-d', $convTimestamp) . ')';
        }
        echo ' => ' . $output . PHP_EOL;
    }
    return $output;
}

