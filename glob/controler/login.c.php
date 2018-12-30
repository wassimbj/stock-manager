<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
	$username 	= filter_var($_POST['user'], FILTER_SANITIZE_STRING);
	$pass 		= filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
	include '../app/init.php';
	$login = new Login();
	$login->setInput($username, $pass);
    $result = $login->DisplayError();
    if($result === TRUE){
    	header('location: ../index.php');
    }else{
    	header('location: ../login.php');
    }
}else{
    header('location: ../login.php');
}

?>