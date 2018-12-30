<?php

include_once '../app/init.php';
if(isset($_POST['model']) && !empty($_POST['model'])) {
	$result = $prod->getProduct($_POST['model']);
	$result1 = $result['price'];
	echo $result1;
}
