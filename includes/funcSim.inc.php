<?php
function checkDist($sentence, $kw, $query) {
    // FIXME
    $query = str_replace('"', '', $query);
    $sign = 1;
    if (mb_stripos($query, $kw, 0, 'UTF-8') > 0) {
        $sign = -1;
    }
    $kwPos = mb_stripos($sentence, $kw, 0, 'UTF-8');
    if (false === $kwPos) {
        return 99;
    }
    $apStr = str_replace($kw, '', $query);
    if (0 == strlen($apStr)) {
        return 0;
    }
    $apPos = mb_stripos($sentence, $apStr, 0, 'UTF-8');
    if (false === $apPos) {
        return 99;
    }

    $dist = $sign * ($apPos - ($kwPos + mb_strlen($kw, 'UTF-8')));
    //echo "$sentence\n$kw: $kwPos, $apStr: $apPos, sign = $sign, dist = $dist\n";

    return ($dist < 0)? 99:$dist;
}

function cleanSentence($sentence, $query) {
    $query = str_replace('"', '', $query);
    $qRegex = preg_replace('/(.)/u', '$1.?.?', $query);
    $matchN = preg_match("/.*({$qRegex}.*)$/Uui", $sentence, $match);
    $output = '';
    if ($matchN > 0) {
        $output = $match[1];
        $output = preg_replace("/.*({$query}.*)$/Uui", '$1', $output);
    }
    return ltrim(rtrim($output));
}

function biSim($sent1, $sent2, $kw = null, $query = null, $method = 'jaccard') {
    if (NULL !== $kw) {
        $kw = str_replace('"', '', $kw);
        $query = str_replace('"', '', $query);
        $apStr = str_replace($kw, '', $query);
        $pattern = array(
            "/{$kw}.?.?{$apStr}/Uui",
            "/{$apStr}.?.?{$kw}/Uui",
        );
        $sent1 = preg_replace($pattern, ',', $sent1);
        $sent2 = preg_replace($pattern, ',', $sent2);
    }
//    echo "{$sent1}\n{$sent2}\n";
    $bi1 = array_unique(getBigramArray($sent1));
    $bi2 = array_unique(getBigramArray($sent2));
//    print_r($bi1);
//    print_r($bi2);
    if (0 === count($bi1) || 0 === count($bi2)) {
        return -1;
    }
    $intersect = array_intersect($bi1, $bi2);
//    $union = array_merge($bi1, array_diff($bi2, $bi1));
//    echo "sent1: {$sent1}\nsent2: {$sent2}\n";
//    print_r($intersect);
//    print_r($union);
//    echo count($intersect) . "/" . count($union) . "\n";
//    return count($intersect) / count($union);

    switch($method) {
    case 'jaccard':
        return count($intersect)/(count($bi1) + count(array_diff($bi2, $bi1)));
    break;
    case 'dice':
        return 2*count($intersect)/(count($bi1) + count($bi2));
    break;
    case 'cosine':
        return count($intersect)/(sqrt(count($bi1)) * sqrt(count($bi2)));
    break;
    default:
        return NULL;
    break;
    }
}

function cmpSim($simA, $simB) {
    if ($simA['sim'] === $simB['sim']) {
        return 0;
    }
    return ($simA['sim'] > $simB['sim'])? -1 : 1;
}
