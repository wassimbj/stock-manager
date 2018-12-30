<?php

class Users extends MysqliConnect{
	protected $farstname , $lastname , $email , $password , $confirm , $id , $admin;
    
    public function setInput($username , $password , $confirm = null , $id = null , $admin = null){
        $this->username     = $this->html($username);
        $this->password     = $this->html($password);
        $this->confirm      = $this->html($confirm);
        $this->id           = (int)$id;
        $this->admin        = $admin;
    }
    
    public function checkUserProfile($id){
        if($_SESSION['user']['id'] != $id){
            if($_SESSION['user']['isAdmin'] == TRUE){
                return $this->getUserData($id);
            }
            header("Location: index.php");
        }else{
            return $this->getUserData($id);
        }
    }

    public function newAdd($usere, $value){
        if($this->checktUserExist($usere) == 1){            
            if($this->insertuser($value) == 1){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 2;
        }
    }

    private function insertuser($value){
        $this->insert('users', 'username, password, position', $value);
        if($this->execute()){
            return 1;
        }else{
            return 0;
        }
    }

    private function checktUserExist($usere){
        $this->query('user_id', 'users', "WHERE username = '{$usere}'");
        $this->execute();
        if($this->rowCount() > 0){
            return 0;
        }else{
            return 1;
        }
        
    }

    public function getUserById($id){
        $user = $this->getUserData($id);
        return $user;
    }
    
    private function getUserData($id){
        $this->query('user_id, username, password, position', 'users', "WHERE `user_id` = '{$id}'");
        $this->execute();
        if($this->rowCount() > 0){
            $user = $this->fetch();
        }else{
            $user = null;
        }
        return $user;
    }

    public function checkNewadd($usere, $password){
        if(empty($usere)){
            return 2;
        }else if(empty($password)){            
            return 3;
        }
    }

    public function checkInput(){
        if(empty($this->username)){
            Messages::setMsg('error', 'ecrir votre nome d\'utilisateur', 'danger');
            echo Messages::getMsg();
        }else if(!empty($this->password) or !empty ($this->confirm)){
            if($this->password !== $this->confirm){
                Messages::setMsg('error', 'mot de pass incorect', 'danger');
                echo Messages::getMsg();
            }
            return TRUE;
        }   
        else{
            return TRUE;
        }
        return FALSE;
    }

    public function DisplayError(){
        if($this->checkInput()){
            if($this->updateUser()){
                return TRUE;
            }
        }
    }
    
    private function updateUser(){
        $admin = ($this->admin != NULL and $this->admin == 1 ? 1 : 0);
        if($this->password != NULL){
        $password = md5(sha1($this->password));
            $data = "`username`='$this->username',`password`='$password' , `position` = '$admin'";
        }else{
            $data = "`username`='$this->username',`position` = '$admin'";
        }
        if($this->id == NULL){
            $id = $_SESSION['user']['id'];
        }else{
            $id = $this->id;
        }
        $this->update('users', $data, 'user_id', $id);
        if($this->execute()){
            if($this->id == NULL || $this->id == $_SESSION['user']['id']){
                unset($_SESSION['user']['username']);     
                $_SESSION['user']['username'] = $this->username;
            }
            return TRUE;
        }
    }
    
    public function getAllUsers($other = null){
        $this->query('user_id, username , position', "users" , $other);
        if($this->execute() and $this->rowCount() > 0){
            while ($users = $this->fetch()){
                $user[] = $users;
            }
            return $user;
        }
        return NULL;
    }
    
    public function deleteUser($id){
        $this->query('user_id', 'users', "WHERE `user_id` = '{$id}'");
        if($this->execute() and $this->rowCount() > 0){
            $this->delete('users', 'user_id', $id);
            if($this->execute()){
                return TREU;
            }
        }else{
            header("location: users.php");
        }
    }
    
    public function usersCount(){
        $this->query('id', 'users');
        $this->execute();
        return $this->rowCount();
    }
}