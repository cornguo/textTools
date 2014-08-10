<?php
ini_set('memory_limit', '1024M');
define('BASEDIR', getBaseDir());
define('FILEOPT', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function getBaseDir() {
    $basedir = '.';
    $pre = '';
    for ($i = 0; $i < 5; $i++) {
        if (is_dir("{$pre}includes") && is_file("{$pre}includes/funcBase.inc.php")) {
            $basedir = "{$pre}includes";
            break;
        } else {
            $pre .= '../';
        }
    }
    return $basedir;
}

getBaseDir();

ini_set('include_path', ini_get('include_path') . ':' . BASEDIR);
