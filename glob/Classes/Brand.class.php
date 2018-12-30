<?php
class Brand extends MysqliConnect{

    protected $name , $product , $user, $id;
    
    public function setInput($name , $product , $user, $id = null){
        $this->name         = $this->html($name);
        $this->product      = (int)$product;
        $this->user         = (int)$user;
        $this->id         = (int)$id;
    }

    public function getAllBrands(){
        $brand = $this->selectAllBrands();
        if($brand != null){
            return $brand;
        }else{
            return null;
        }
    }

    private function selectAllBrands($others = null){
        $this->query('*', 'brands', $others);
        $this->execute();
        if($this->rowCount() > 0){
            if($others == null){
                $brand = $this->fetchAll();
            }else{
                $brand = $this->fetch();
            }
            return $brand;
        }else{
            return null;
        }
    }

	public function getBrandData($others = null){
        $brand = $this->selectAllBrands($others);
        if($brand != null){
            return $brand;
        }else{
            return null;
        }
    }

    public function addNewBrand(){
        if($this->getBrandData("WHERE brand_name = '$this->name'") == null){
            if($this->insertBrand() == 1){
                return 0;
            }elseif($this->insertBrand() == 0){
                return 2;
            }
        }elseif($this->getBrandData("WHERE brand_name = '$this->name'") != null){
            return 1;
        }
    }

    private function insertBrand(){
        $value = "'$this->name', '$this->product', '$this->user', now()";
        $this->insert('brands','`brand_name`, `brand_product`, `user_add`, `add_date`', $value);
        if($this->execute()){
            return 1;
        }else{
            return 0;
        }

    }

    public function deleteBrand($id){
        $this->query('brand_id', 'brands', "WHERE `brand_id` = '{$id}'");
        if($this->execute() and $this->rowCount() > 0){
            if($this->countProduct($id) == null){
                $this->delete('brands', 'brand_id', $id);
                if($this->execute()){
                    return 0;
                }else{
                    return 1;
                }
            }else{
                return 2;
            }            
        }else{
            return 1;
        }
    }

    public function countProd($id){
        $this->query('product_id', 'product', "WHERE brand_id = '{$id}'");
        $this->execute();
        return $this->rowCount();              
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
        $this->query('brand_name', 'brands', "WHERE brand_name = '$this->name' AND brand_id != '$this->id'");
        $this->execute();
        if($this->rowCount() > 0){
            return 0;
        }else{
            return 1;
        }
    }

    public function DisplayError(){
        if($this->checkInputs() == 2){
            if($this->updateBrand() == 0){
                return 0;
            }elseif($this->updateBrand() == 1){
                return 3;
            }
        }elseif($this->checkInputs() == 0){
            return 1;
        }elseif($this->checkInputs() == 1){
            return 2;
        }
    }

    private function updateBrand(){
        $data = "`brand_name` = '$this->name', `brand_product` = '$this->product', `user_add` = '$this->user'";
        $this->update('brands', $data, 'brand_id', $this->id);
        if($this->execute()){
            return 0;           
        }else{
            return 1;
        }
    }
}