<?php

class Login extends MysqliConnect {
	private $username , $password , $md5;
    
    public function setInput($username , $password){
        $this->username = $this->html($username);
        $this->password = $this->html($password);
        $this->md5  = md5(sha1($this->password));
    }
    
    private function checkInput(){
        if(empty($this->username)){
            Messages::setMsg('error', 'entre le nom d\'utilisateur', 'danger');
            echo Messages::getMsg();
        }else if(empty ($this->password)){
            Messages::setMsg('error', 'entre le mot de pass ', 'danger');
            echo Messages::getMsg();
        }else if(!$this->checkUser()){
            Messages::setMsg('error', 'mot de pass ou nom d\'utilisateur incorect', 'danger');
            echo Messages::getMsg();
        }
        else{
            return TRUE;
        }
        return FALSE;
    }
    
    private function checkUser(){
        $this->query('user_id', 'users', "WHERE `username` = '$this->username' AND `password` = '$this->md5'");
        $this->execute();
        if($this->rowCount() > 0){
            return TRUE;
        }
        return FALSE;
    }
    
    private function makeUserLogged(){
        if($this->checkUser()){
            $this->query('*', 'users', "WHERE `username` = '$this->username' AND `password` = '$this->md5'");
            $this->execute();
            $user = $this->fetch();
            $admin = ($user['position'] == 1 ? TRUE : FALSE);
            $_SESSION['is_logged'] = true;
            $_SESSION['user'] = [
                                'id' => $user['user_id'],
                                'username' => $user['username'],
                                'isAdmin' => $admin
            ];
            return TRUE;
        }
        return FALSE;
    }

    public function DisplayError(){
        if($this->checkInput()){
            if($this->makeUserLogged()){
            	return TRUE;
            }else{
                Messages::setMsg('error', 'il y a un problème essayez une autre fois ', 'danger');
                echo Messages::getMsg();
            }
        }
    }
    
    public function setEditProfile($fname , $lname , $username , $password , $confirm){
        $this->fname    = $this->html($fname);
        $this->lname    = $this->html($lname);
        $this->username = $this->html($username);
        $this->password = $this->html($password);
        $this->confirm  = $this->html($confirm);
    }
    
    private function checkEditProfile(){
        if(!empty($this->password) or !empty($this->confirm)){
            echo "ياا ليه كدا ليه";
        }
    }
    public function dl(){
        if($this->checkEditProfile()){
            echo 'eww';
        }
    }
}