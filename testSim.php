<?php

include 'includes/funcBase.inc.php';
include 'includes/funcPos.inc.php';
include 'includes/funcSim.inc.php';

$pairs = array(
    array('你那麼愛她 為什麼不把她留下', '你那麼愛她 為什麼不巴她六下'),
    array('we are the world, we are the children', 'We Are the World'),
    array('無線上網', '無限上綱'),
    array('府院不同調', '不同調府院'),
    array('府院 不同調', '不同調 府院'),
    array('大雄寶殿', '大熊貓寶殿'),
    array('大 雄寶殿', '大 熊貓寶殿'),
);

$methods = array('jaccard', 'dice', 'cosine');

foreach ($pairs as $pair) {
    echo "Pair: [{$pair[0]}], [{$pair[1]}]" . PHP_EOL;
    foreach ($methods as $method) {
        echo "method [{$method}], score = " . biSim($pair[0], $pair[1], NULL, NULL, $method) . PHP_EOL;
    }
    echo PHP_EOL;
}
