<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	include_once '../app/init.php';
	if(isset($_POST['update']) && isset($_POST['id']) && is_numeric($_POST['id'])){		
		$id = $_POST['id'];
		$users->setInput($_POST['user'] ,$_POST['password'] , $_POST['confirm'] , $id , $_POST['role']);
	    $users->DisplayError();
	    if($users->DisplayError() == TRUE){
	    	header('location: ../users.php?result=succ');
	    }else{
	    	header('location: ../users.php?result=fail');
	    }
	}elseif(isset($_POST['new-add'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$role = $_POST['role'];
		$haspass = md5(sha1($password));
		$resul = $users->checkNewadd($username, $password);
		
		if($resul == 2){
			header('location: ../users.php?action=new-add&err=1');
		}elseif($resul == 3){
			header('location: ../users.php?action=new-add&err=2');
		}else{
			$respond = $users->newAdd($username, "'$username', '$haspass', '$role'");
			if($respond == 1){
				header('location: ../users.php?action=new-add&err=0');
			}elseif($respond == 2){
				header('location: ../users.php?action=new-add&err=3');
			}elseif($respond == 0){
				header('location: ../users.php?action=new-add&err=4');
			}
		}
	}
	
}elseif($_GET['action'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])){
	include_once '../app/init.php';
	$id = $_GET['id'];
	if($users->deleteUser($id)){
	    header('location: ../users.php?result=succ');
    }else{
    	header('location: ../users.php?result=fail');
    }
}
?>
