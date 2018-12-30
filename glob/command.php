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
          <h2 class="text-center">Commande</h2>
          <form style="padding: 20px;border: 1px solid #aaa;border-radius: 4px;background-color: #f9f9f9;overflow: hidden;height: 100%">

            <div class="form1" id="form1">
              <div class="col-md-2" style="float: left;">
                <label>Nomber Produit :</label>
                <input type="text" name="choose" class="form-control" id="choose">
              </div>

              <div class="col-md-3" style="float: left;">
                <label>Nom du Client :</label>
                <input type="text" name="client_name" class="form-control" id="client">
              </div>

              <div class="col-md-2" style="float: left;">
                <label>Numero Client :</label>
                <input type="text" name="client_num" class="form-control" id="client_num">
              </div>

              <div class="col-md-2" style="float: left;">
                <label>type de paiement :</label>
                <select name="type" id="type" class="form-control">
                  <option value="1">Ecpese</option>
                  <option value="2">Check</option>
                </select>
              </div>

              <div class="col-md-3" style="float: left;">
                <label>Date De Vent :</label>
                <input type="date" class="form-control" name="date" id="date">
              </div>

              <div style="clear: both;"></div>

            </div> 
            <hr>
            <div id="result">
              
            </div>      
          </form>
         
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
<?php include_once 'inc/footer.php';
}
?>    