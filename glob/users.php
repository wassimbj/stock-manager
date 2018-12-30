<?php 
include_once 'inc/header.php'; 
if(!isset($_SESSION['user']) or $_SESSION['user']['isAdmin'] != TRUE){
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
                <?php if(isset($_GET['result'])){ 
                    $result = $_GET['result'] == 'succ' ? 'success' : 'danger';
                    $result1 = $_GET['result'] == 'succ' ? 'Modification Enregistre' : 'Votre Modification sont pas Enregistre';
                ?>
                    <div class="col-sm-12 main" style="padding: 0">
                        <div class="alert alert-<?php echo $result; ?> alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <strong><?php echo $result1; ?> </strong>
                        </div>
                    </div>    
                <?php }?>
                <h2 class="text-center">Tableau d'utilisateur</h2>
                <div class="text-right" style="padding-bottom: 15px;"><a href="users.php?action=new-add"><i class="fas fa-fw fa-plus"></i>Ajouter Nouveau Utilisateur</a></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nom </th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Modification</th>
                                <th class="text-center">Suprime</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $Allusers = $users->getAllUsers("ORDER BY `user_id` DESC");
                                $i = 1;
                                foreach ($Allusers as $user):
                            ?>
                            <tr class="text-center">
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $user['username'];?></td>
                                <td><span class="btn btn-sm btn-<?php echo ($user['position'] == TRUE ? 'info' : 'primary') ?>"><?php echo ($user['position'] == TRUE ? 'Admin' : 'Modérateur') ?></span></td>
                                <td><a href="users.php?action=edit&id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-warning btn-sm">Modifie</a></td>
                                <td><a href="controler/users.c.php?action=delete&id=<?php echo $user['user_id']; ?>" class="confirm btn btn-sm btn-danger btn-sm">Suprime</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php 
            }elseif($_GET['action'] == 'edit' && isset($_GET['id'])){
                $id = (int)$_GET['id'];
                $user = $users->checkUserProfile($id);
            ?>
                <h2 class="page-header text-center"><i class="glyphicon glyphicon-user"></i>Modifier</h2>
                <form action="controler/users.c.php?id=<?php echo $_GET['id'] ?>" method="POST" class="form-horizontal center-block" style="padding: 15px;
                    background: #fff;
                    margin-bottom: 15px;
                    border-radius: 5px;
                    border: solid 1px #dadada;">
                    <div class="form-group center-block">
                    <label for="user" class="col-sm-4 control-label">Nom d'utilisateur </label>
                    <div class="col-sm-8">
                        <input type="hidden" name="id" value="<?php echo $user['user_id'] ?>">
                        <input type="text" class="form-control" value="<?php echo isset($_POST['user']) ? $_POST['user']: $user['username']; ?>" name="user" id="user" placeholder="Nome d'utilisateur">
                    </div>
                    </div>
                    <div class="form-group center-block">
                    <label for="password" class="col-sm-4 control-label">Mot De Passe</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" value="<?php echo isset($_POST['password']) ? $_POST['password']: null; ?>" name="password" id="password" placeholder="Mot de pass">
                    </div>
                    </div>

                    <div class="form-group center-block">
                    <label for="confirm" class="col-sm-4 control-label">confirmer mot de passe</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" value="<?php echo isset($_POST['confirm']) ? $_POST['confirm']: null; ?>" name="confirm" id="confirm" placeholder="confirme mot de pass">
                    </div>
                    </div>
                        
                    <div class="form-group center-block">
                    <label for="role" class="col-sm-4 control-label">Role</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="role" id="role">
                            <option value="1" <?php echo ($user['position'] == TRUE ? 'selected' : NULL) ?>>Admin</option>
                            <option value="0" <?php echo ($user['position'] == FALSE ? 'selected' : NULL) ?>>Moderature</option>
                        </select>
                    </div>
                    </div>
                        
                        
                    <div class="form-group center-block">
                    <div class="col-sm-8">
                        <button type="submit" name="update" class="btn btn-success btn-block" style="margin-top: 40px;">Enregistre</button>
                    </div>
                    </div>
                </form>

        <?php 
            }elseif($_GET['action'] == 'new-add'){ 
                if(isset($_GET['err'])){
                    $val = $_GET['err'];
                    $info = $_GET['err'] == 0 ? 'success' : 'danger';
                    $texts = '';
                    switch ($val) {
                        case '0':
                            $texts = 'Utilisateur Ajouter';
                            break;
                        case '1':
                            $texts = 'Entre Le Nom d\'utilisateur';
                            break;
                        case '2':
                            $texts = 'Entre Le mot de pass';
                            break;
                        case '3':
                            $texts = 'Le Nom d\'utilisateur Exist';
                            break;
                        case '4':
                            $texts = 'Local Probleme';
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

                <h2 class="page-header text-center"><i class="glyphicon glyphicon-user">Ajouter Nouveau Utilisateur</i></h2>
                <form action="controler/users.c.php" method="POST" class="form-horizontal center-block" style="padding: 15px;
                    background: #fff;
                    margin-bottom: 15px;
                    border-radius: 5px;
                    border: solid 1px #dadada;">
                    <div class="form-group center-block">
                    <label for="user" class="col-sm-4 control-label">Nom d'utilisateur </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="username" id="user" placeholder="Nome d'utilisateur">
                    </div>
                    </div>
                    <div class="form-group center-block">
                    <label for="password" class="col-sm-4 control-label">Mot de passe</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de pass">
                    </div>
                    </div>
                        
                    <div class="form-group center-block">
                    <label for="role" class="col-sm-4 control-label">Role</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="role" id="role">
                            <option value="1">Admin</option>
                            <option value="0">Moderateur</option>
                        </select>
                    </div>
                    </div>
                        
                        
                    <div class="form-group center-block">
                    <div class="col-sm-8">
                        <button type="submit" name="new-add" class="btn btn-success btn-block" style="margin-top: 40px;">Enregistre les modéfication</button>
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