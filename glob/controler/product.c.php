<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	INCLUDE_ONCE '../app/init.php';
	if(isset($_POST['new-add'])){
		$prod->setInput($_POST['name'], $_POST['quantity'], $_POST['price'], $_POST['brand']);
		$resul = $prod->checkInputs();
		if($resul == 0){
			header('location: ../product.php?action=new-add&err=1');
		}elseif($resul == 1){
			header('location: ../product.php?action=new-add&err=2');
		}elseif($resul == 2){
			$name = $_POST['name'];
			$price = $_POST['price'];
			$brand = $_POST['brand'];
			$quan = $_POST['quantity'];
			$respond = $prod->newAdd("'$name', '$price', '$brand', '$quan'");
			if($respond == 0){
				header('location: ../product.php?action=new-add&err=0');
			}elseif($respond == 1){
				header('location: ../product.php?action=new-add&err=3');
			}
		}
	}elseif(isset($_POST['update']) && isset($_POST['id']) && is_numeric($_POST['id'])){		
		$id = $_POST['id'];
		$prod->setInput($_POST['name'], $_POST['quantity'], $_POST['price'], $_POST['brand'], $_POST['id']);
	    if($prod->DisplayError() == 0){
	    	header('location: ../product.php?action=edit&id=' . $id . '&err=0');
	    }elseif($prod->DisplayError() == 1){
	    	header('location: ../product.php?action=edit&id=' . $id . '&err=1');
	    }elseif($prod->DisplayError() == 2){
	    	header('location: ../product.php?action=edit&id=' . $id . '&err=2');
	    }elseif($prod->DisplayError() == 3){
	    	header('location: ../product.php?action=edit&id=' . $id . '&err=3');
	    }
	}
}elseif($_GET['action'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])){
	include_once '../app/init.php';
	$id = $_GET['id'];
	if($prod->deleteProduct($id) == 0){
	    header('location: ../product.php?result=succ');
    }else{
    	header('location: ../product.php?result=fail');
    }
}