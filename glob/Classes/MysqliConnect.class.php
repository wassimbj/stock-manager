<?php
abstract class MysqliConnect implements DatabaseConnect{
    private $dbhost  , $dbuser , $dbpass , $error , $stmt , $dbh;
    protected $option, $con;
    
    public function __construct() {
        $this->dbhost = DB_HOST;
        $this->dbuser = DB_USER;
        $this->dbpass = DB_PASS;
        $this->option = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );

        try {
            $this->con = new PDO($this->dbhost, $this->dbuser, $this->dbpass, $this->option);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }
    public function query($colum , $table , $other = null) {
        $this->stmt = $this->con->prepare("SELECT {$colum} FROM `{$table}` {$other}");
    }
    public function execute() {
        return $this->stmt->execute();
    }
    public function fetch() {
        return $this->stmt->fetch();
    }
    public function fetchAll() {
        return $this->stmt->fetchAll();
    }
    public function rowCount() {
        return $this->stmt->rowCount();
    }
    public function insert($table , $colum , $value) {
        $this->stmt = $this->con->prepare("INSERT INTO `{$table}` ({$colum}) VALUES ({$value})");
    }
    public function update($table , $data , $colum, $id , $other = null){
        $this->stmt = $this->con->prepare("UPDATE `{$table}` SET {$data} WHERE `{$colum}` = '{$id}' {$other}");
    }
    public function delete($table , $colum , $id , $other = null) {
        $this->stmt = $this->con->prepare("DELETE FROM `{$table}` WHERE `{$colum}` = '{$id}' {$other}");
    }
    
    public function html($string){
        return strip_tags($string);
    }
    
}
?>