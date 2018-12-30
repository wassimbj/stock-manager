<?php

include_once '../app/init.php';

$result = $prod->getProduct($_POST['model']);
$result1 = $result['price'];
return $result1;

