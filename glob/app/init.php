<?php

ob_start();
session_start();
include_once __DIR__.'/../core/config.php';
include_once __DIR__.'/../app/interfaces/InterfaceDatabase.php';
spl_autoload_register(function($name){
    require_once __DIR__."/../Classes/{$name}.class.php";
});

if (isset($_GET['logout']) && $_GET['logout'] == 'yes'){
	session_unset();
    session_destroy();
    header("Location: login.php");
}
/* Call Classes */
$users = new Users();
$prod = new Product();
$brand = new Brand();

?>