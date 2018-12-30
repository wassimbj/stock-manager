<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	include_once '../app/init.php';
	if(isset($_POST['new-add'])){
		$brand->setInput($_POST['name'], 0, $_POST['user_id']);
		$result = $brand->addNewBrand();
		if($result == 0){
			header('location: ../brand.php?action=new-add&err=0');
		}elseif($result == 1){
			header('location: ../brand.php?action=new-add&err=1');
		}elseif($result == 2){
			header('location: ../brand.php?action=new-add&err=2');
		}

	}elseif(isset($_POST['edit']) && isset($_POST['id']) && is_numeric($_POST['id'])){
		$id = $_POST['id'];
		$brand->setInput($_POST['name'], $_POST['product'], $_POST['user_id'], $_POST['id']);
		if($brand->DisplayError() == 0){
	    	header('location: ../brand.php?action=edit&id=' . $id . '&err=0');
	    }elseif($brand->DisplayError() == 1){
	    	header('location: ../brand.php?action=edit&id=' . $id . '&err=1');
	    }elseif($brand->DisplayError() == 2){
	    	header('location: ../brand.php?action=edit&id=' . $id . '&err=2');
	    }elseif($brand->DisplayError() == 3){
	    	header('location: ../brand.php?action=edit&id=' . $id . '&err=3');
	    }
	}else{
		header('location: ../brand.php');
	}
}elseif($_GET['action'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])){
	include_once '../app/init.php';
	$id = $_GET['id'];
	if($brand->deleteBrand($id) == 0){
	    header('location: ../brand.php?result=succ');
    }elseif($brand->deleteBrand($id) == 2){
    	header('location: ../brand.php?result=faild');
    }elseif($brand->deleteBrand($id) == 1){
    	header('location: ../brand.php?result=fail');
    }
}else{	
	header('location: ../brand.php');
}