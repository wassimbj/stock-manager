<?php
if(isset($_POST['choose']) && !empty($_POST['choose'])){
	include_once '../app/init.php';
	$num = $_POST['choose'];
	$i = 1;
	while ($i <= $num) {
		$products = $prod->getAllProduct(); ?>
	    <div class="form2" style="padding-top: 20px;" id='_<?php echo $i?>'>
	      <div class="col-md-3" style="float: left;">
	        <label>Model <?php echo $i; ?> :</label>
	        <select name="model" class="form-control model" data-id='_<?php echo $i?>'>
	          <?php foreach($products as $product){ ?>
	                  <option value="<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></option>
	          <?php } ?>
	        </select>
	      </div>
	      <div class="col-md-3" style="float: left;">
	        <label>Quantitie :</label>
	        <input type="text" name="quant" class="form-control">
	      </div>
	      <div class="col-md-3" style="float: left;">
	        <label>Prix unitair :</label>
	        <input type="text" name="unitie" class="form-control" id='unitie'>
	      </div>
	      <div class="col-md-3" style="float: left;">
	        <label>Prix :</label>
	        <input type="text" name="prix" class="form-control">
	      </div>
	        
	      <div style="clear: both;"></div>
	    </div>
	<?php $i++; }
} ?>