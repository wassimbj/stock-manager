<?php
include_once 'inc/header.php';
if(isset($_SESSION['user'])){
  header('location: index.php');
}

 ?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Conexion</div>
        <div class="card-body">
          <form action="controler/login.c.php" method="POST">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="inputEmail" name="user" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                <label for="inputEmail">Nom d'utilisateur</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Password" required="required">
                <label for="inputPassword">Mot De Pass</label>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me">
                  Remember Password
                </label>
              </div>
            </div>
            <input type="submit" class="btn btn-primary btn-block" name="login" value="Conexion">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="register.php">Créer Un Compte</a>
            <a class="d-block small" href="forgot-password.php">Mot de passe oublié?</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="libs/vendor/jquery/jquery.min.js"></script>
    <script src="libs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="libs/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="libs/vendor/chart.js/Chart.min.js"></script>
    <script src="libs/vendor/datatables/jquery.dataTables.js"></script>
    <script src="libs/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="libs/js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="libs/js/demo/datatables-demo.js"></script>
    <script src="libs/js/demo/chart-area-demo.js"></script>

  </body>

</html>