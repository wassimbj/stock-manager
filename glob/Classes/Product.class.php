 <?php
class Product extends MysqliConnect{
    protected $name , $quant , $price , $brand, $id;
    
    public function setInput($name , $quant , $price, $brand, $id = null){
        $this->name         = $this->html($name);
        $this->brand        = (int)($brand);
        $this->quant        = (int)$quant;
        $this->price        = (int)$price;
        $this->id           = (int)$id;
    }

	public function getAllProduct($other = null){
        $this->query('*', 'product' , $other);
        if($this->execute() and $this->rowCount() > 0){
            while ($prod = $this->fetch()){
                $product[] = $prod;
            }
            return $product;
        }
        return NULL;
    }

    public function getProduct($id){
        $this->query('*', 'product',"WHERE product_id = '$id'");
        if($this->execute() and $this->rowCount() > 0){
            $product = $this->fetch();
            return $product;
        }else{
            return null;
        }
    }

    public function checkInputs(){
        if(empty($this->name)){
            return 0;
        }elseif($this->checkName() == 0){
            return 1;
        }else{
            return 2;
        }
    }

    private function checkName(){
        $this->query('product_name', 'product', "WHERE product_name = '$this->name' AND product_id != '$this->id'");
        $this->execute();
        if($this->rowCount() > 0){
            return 0;
        }else{
            return 1;
        }
    }

    public function newAdd($value){
        if($this->insertProduct($value) == 0){
            return 0; 
        }else{
            return 1;
        }
    }

    private function insertProduct($value) {
        $this->insert('product', '`product_name`, `price`, `brand_id`, `quantity`', $value);
        if($this->execute()){
            return 0;
        }else{
            return 1;
        }
    }

    public function DisplayError(){
        if($this->checkInputs() == 2){
            if($this->updateProduct() == 0){
                return 0;
            }elseif($this->updateProduct() == 1){
                return 3;
            }
        }elseif($this->checkInputs() == 0){
            return 1;
        }elseif($this->checkInputs() == 1){
            return 2;
        }
    }

    private function updateProduct(){
        $data = "`product_name` = '$this->name', `price` = '$this->price', `brand_id` = '$this->brand', `quantity` = '$this->quant'";
        $this->update('product', $data, 'product_id', $this->id);
        if($this->execute()){
            return 0;           
        }else{
            return 1;
        }
    }

    public function deleteProduct($id){
        $this->query('product_id', 'product', "WHERE `product_id` = '{$id}'");
        if($this->execute() and $this->rowCount() > 0){
            $this->delete('product', 'product_id', $id);
            if($this->execute()){
                return 0;
            }
        }else{
            header("location: prodect.php");
        }
    }

    
}