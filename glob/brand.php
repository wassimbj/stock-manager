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
          <!-- Content -->
          <?php $link = isset($_GET['action']) ? $_GET['action'] : 'table'; 
          if($link == 'table'){  ?>
            <?php if(isset($_GET['result'])){ 
                $result = $_GET['result'] == 'succ' ? 'success' : 'danger';
                $result2 = $_GET['result'] == 'faild' ? 'vous ne pouvez pas supprimer cette marque (il existe un produit de cette marque)' : 'Modification pas Enregistre';
                $result1 = $_GET['result'] == 'succ' ? 'Modification Enregistre' : $result2;
                
            ?>
                <div class="col-sm-12 main" style="padding: 0">
                    <div class="alert alert-<?php echo $result; ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <strong><?php echo $result1; ?> </strong>
                    </div>
                </div>    
            <?php }?>
            <h2 class="text-center">Tableau des Marques</h2>
            <div class="text-right" style="padding-bottom: 15px;"><a href="brand.php?action=new-add"><i class="fas fa-fw fa-plus"></i>Ajouter Nouveau Marque</a></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Nom </th>
                            <th class="text-center">Number du Model</th>
                            <th class="text-center">Ajouter par</th>
                            <th class="text-center">La Date D'ajouter</th>
                            <th class="text-center">Modification</th>
                            <th class="text-center">Suprime</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $Allbrands = $brand->getAllBrands("ORDER BY `user_id` DESC");
                    $i = 1;
                    foreach ($Allbrands as $brand):
                    $user = $users->getUserById($brand['user_add']); 
                    ?>
                      <tr class="text-center">
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $brand['brand_name'];?></td>
                          <td><?php echo $brand['brand_product'];?></td>
                          <td><?php echo $user['username'];?></td>
                          <td><?php echo $brand['add_date'];?></td>
                          <td><a href="brand.php?action=edit&id=<?php echo $brand['brand_id']; ?>" class="btn btn-sm btn-warning btn-sm">Modifie</a></td>
                          <td><a href="controler/brand.c.php?action=delete&id=<?php echo $brand['brand_id']; ?>" class="confirm btn btn-sm btn-danger btn-sm">Suprime</a></td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
          <?php }elseif($link == 'new-add'){ 
            if(isset($_GET['err'])){
              $val = $_GET['err'];
              $info = $_GET['err'] == 0 ? 'success' : 'danger';
              $texts = '';
              switch ($val) {
                  case '0':
                      $texts = 'Marque Ajouter';
                      break;
                  case '1':
                      $texts = 'Le Nom de Marque Exist';
                      break;
                  case '3':
                      $texts = 'Entre Le Nom de Marque';
                      break;
                  case '2':
                      $texts = 'Problame de conexion';
                      break; } ?>

              <div class="col-sm-12 main" style="padding: 0">
                  <div class="alert alert-<?php echo $info; ?> alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                      <strong><?php echo $texts; ?> </strong>
                  </div>
              </div>

            <?php } ?>

            <h2 class="page-header text-center"><i class="glyphicon glyphicon-user"></i>Ajouter une nouvelle Marques</h2>
            <form action="controler/brand.c.php" method="POST" class="form-horizontal center-block" style="padding: 15px;
                background: #fff;
                margin-bottom: 15px;
                border-radius: 5px;
                border: solid 1px #dadada;">
                <div class="form-group center-block">
                <label for="user" class="col-sm-4 control-label">Nom de Marque </label>
                <div class="col-sm-8">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id']; ?>">
                    <input type="text" class="form-control" name="name" placeholder="Nom de marque">
                </div>
                </div>
              
                <div class="form-group center-block">
                <div class="col-sm-8">
                    <button type="submit" name="new-add" class="btn btn-success btn-block" style="margin-top: 40px;">Enregistre</button>
                </div>
                </div>
            </form>

          <?php }elseif($link == 'edit'){ 
            $id = (int)$_GET['id'];
            $brande = $brand->getBrandData("WHERE brand_id = '{$id}'");
            $count = $brand->countProd($id);
            if(isset($_GET['err'])){
              $val = $_GET['err'];
              $info = $_GET['err'] == 0 ? 'success' : 'danger';
              $texts = '';
              switch ($val) {
                  case '0':
                      $texts = 'Modification Enregistre';
                      break;
                  case '1':
                      $texts = 'Entre Le Nom de Marque';
                      break;
                  case '2':
                      $texts = 'Le Nom De Marque Exist';
                      break;
                  case '3':
                      $texts = 'Probleme Local';
                      break; } ?>

              <div class="col-sm-12 main" style="padding: 0">
                  <div class="alert alert-<?php echo $info; ?> alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                      <strong><?php echo $texts; ?> </strong>
                  </div>
              </div>
          <?php } ?>
            <h2 class="page-header text-center"><i class="glyphicon glyphicon-user"></i>Modifier la Marques</h2>
            <form action="controler/brand.c.php?id=<?php echo $_GET['id'] ?>" method="POST" class="form-horizontal center-block" style="padding: 15px;
                background: #fff;
                margin-bottom: 15px;
                border-radius: 5px;
                border: solid 1px #dadada;">
                <div class="form-group center-block">
                <label for="user" class="col-sm-4 control-label">Nom de Marque </label>
                <div class="col-sm-8">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id']; ?>">
                    <input type="hidden" name="product" value="<?php echo $count; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="text" class="form-control" value="<?php echo isset($_POST['name']) ? $_POST['name']: $brande['brand_name']; ?>" name="name">
                </div>
                </div>
              
                <div class="form-group center-block">
                <div class="col-sm-8">
                    <button type="submit" name="edit" class="btn btn-success btn-block" style="margin-top: 40px;">Enregistre</button>
                </div>
                </div>
            </form>

          <?php }else{ header('location: index.php'); } ?>  
         
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
<?php include_once 'inc/footer.php';
}
?> 