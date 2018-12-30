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
          <?php if(!isset($_GET['action'])){ ?>

            <h2 class="text-center">Tablau de produit</h2>
            <div class="text-right" style="padding-bottom: 15px;"><a href="product.php?action=new-add"><i class="fas fa-fw fa-plus"></i>Ajouter Nouvaue Produit</a></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Nome </th>
                        <th class="text-center">Marque</th>                      
                        <th class="text-center">prix</th>
                        <th class="text-center">Quantitie</th>
                        <th class="text-center">Modification</th>                       
                        <th class="text-center">Suprime</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $Allprod = $prod->getAllProduct("ORDER BY `product_id` DESC");
                        $i = 1;
                        foreach ($Allprod as $product):
                            $bid = $product['brand_id'];
                            $brands = $brand->getBrandData("WHERE `brand_id` = '{$bid}'");
                    ?>
                        <tr class="text-center">
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $product['product_name'];?></td>
                            <td><?php echo $brands['brand_name'];?></td>
                            <td><?php echo $product['price'];?>.00 DA</td>
                            <td><?php echo $product['quantity'];?> P</td>                            
                            <td><a href="product.php?action=edit&id=<?php echo $product['product_id']; ?>" class="btn btn-sm btn-warning btn-sm">Modifie</a></td>
                            <td><a href="controler/product.c.php?action=delete&id=<?php echo $product['product_id']; ?>" class="confirm btn btn-sm btn-danger btn-sm">Suprime</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

          <?php }elseif($_GET['action'] == 'new-add'){
                  $brands = $brand->getBrandData();
                  $cats = $cat->getCatData();   
                  if(isset($_GET['err'])){
                    $val = $_GET['err'];
                    $info = $_GET['err'] == 0 ? 'success' : 'danger';
                    $texts = '';
                    switch ($val) {
                        case '0':
                            $texts = 'Produit Ajouter';
                            break;
                        case '1':
                            $texts = 'Entre Le Nom de produit';
                            break;
                        case '2':
                            $texts = 'Le Nom De Produit Exist';
                            break;
                        case '3':
                            $texts = 'Probleme Local';
                            break; }?>

                    <div class="col-sm-12 main" style="padding: 0">
                        <div class="alert alert-<?php echo $info; ?> alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <strong><?php echo $texts; ?> </strong>
                        </div>
                    </div>

                <?php } ?>

                <!--New-add Form-->

                <h2 class="page-header text-center"><i class="glyphicon glyphicon-user">Modifie Le Produit</i></h2>
                <form action="controler/product.c.php" method="POST" class="form-horizontal center-block" style="padding: 15px;
                    background: #fff;
                    margin-bottom: 15px;
                    border-radius: 5px;
                    border: solid 1px #dadada;">
                    <div class="form-group center-block">
                    <label for="user" class="col-sm-4 control-label">Nom de Produit </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required="required" name="name" id="user" placeholder="Nom de Produit">
                    </div>
                    </div>
                    <div class="form-group center-block">
                    <label for="user" class="col-sm-4 control-label">La Quantitie </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="quantity" value="0" placeholder="Quantitie">
                    </div>
                    </div>
                    <div class="form-group center-block">
                    <label for="user" class="col-sm-4 control-label">Prix </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="price" value="0" placeholder="Prix">
                    </div>
                    </div>
                    <div class="form-group center-block" style="float: left; width: 33.5%">
                    <label for="role" class="col-sm-4 control-label">La Marque</label>
                    <div class="col-sm-12">
                        <select class="form-control" name="brand" id="role">
                            <?php foreach ($brands as $brande) {
                                echo '<option value="' . $brande['brand_id'] . '">' . $brande['brand_name'] . '</option>';
                            } ?>
                        </select>
                    </div>
                    </div>
                    <div style="clear: both;"></div>    
                        
                    <div class="form-group center-block">
                    <div class="col-sm-8">
                        <button type="submit" name="new-add" class="btn btn-success btn-block" style="margin-top: 20px;">Enregistre</button>
                    </div>
                    </div>
                </form>
          <?php 
            }elseif($_GET['action'] == 'edit' && isset($_GET['id']) && is_numeric($_GET['id'])){ 
                $id = $_GET['id'];
                $brands = $brand->getBrandData();
                $prode = $prod->getProduct($id);
                $bid = $prode['brand_id'];
                if(isset($_GET['err'])){
                    $val = $_GET['err'];
                    $info = $_GET['err'] == 0 ? 'success' : 'danger';
                    $texts = '';
                    switch ($val) {
                        case '0':
                            $texts = 'Produit Ajouter';
                            break;
                        case '1':
                            $texts = 'Entre Le Nom de produit';
                            break;
                        case '2':
                            $texts = 'Le Nom De Produit Exist';
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

                <!--New-add Form-->

                <h2 class="page-header text-center"><i class="glyphicon glyphicon-user">Ajouter Nouveau Produit</i></h2>
                <form action="controler/product.c.php" method="POST" class="form-horizontal center-block" style="padding: 15px;
                    background: #fff;
                    margin-bottom: 15px;
                    border-radius: 5px;
                    border: solid 1px #dadada;">
                    <div class="form-group center-block">
                    <label for="user" class="col-sm-4 control-label">Nom de Produit </label>
                    <div class="col-sm-8">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="text" class="form-control" name="name" value="<?php echo $prode['product_name']; ?>">
                    </div>
                    </div>
                    <div class="form-group center-block">
                    <label for="user" class="col-sm-4 control-label">La Quantitie </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="quantity" value="<?php echo $prode['quantity']; ?>">
                    </div>
                    </div>
                    <div class="form-group center-block">
                    <label for="user" class="col-sm-4 control-label">Prix </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="price" value="<?php echo $prode['price']; ?>">
                    </div>
                    </div>
                    <div class="form-group center-block" style="float: left; width: 33.5%">
                    <label for="role" class="col-sm-4 control-label">La Marque</label>
                    <div class="col-sm-12">
                        <select class="form-control" name="brand">
                            <?php foreach ($brands as $brande) {?>
                                <option value="<?php echo $brande['brand_id'];?>" <?php if($brande['brand_id']==$bid){ echo 'selected'; } ?>><?php echo $brande['brand_name'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    </div>
                    <div style="clear: both;"></div>    
                        
                    <div class="form-group center-block">
                    <div class="col-sm-8">
                        <button type="submit" name="update" class="btn btn-success btn-block" style="margin-top: 20px;">Enregistre</button>
                    </div>
                    </div>
                </form>    
          <?php  
            } ?>
         
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
<?php include_once 'inc/footer.php';
}
?>    