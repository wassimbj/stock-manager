<?php 
include_once 'inc/header.php'; 
if(!isset($_SESSION['user'])){
  header('location: login.php');
}else{

?>

  <body id="page-top">

    <?php include_once 'inc/navbar.php' ?>

    <div id="wrapper">

      <?php include_once 'inc/sidbar.php' ?>

      <div id="content-wrapper">

        <div class="container-fluid">
          
         
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
<?php include_once 'inc/footer.php';
}
?>        
