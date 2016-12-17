<?php

include 'includes/funcConvertDate.inc.php';

define('DEBUG', 1);

convertDate("一九八八年三月", strtotime("1998-01-17"));

convertDate("周日", strtotime("1999-12-29"));
