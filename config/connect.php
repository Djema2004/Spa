<?php
class Connect{
private $DB_HOST = 'localhost';
private $DB_USER = 'root';
private $DB_PASS = '';
private $DB_NAME = 'dbspa';

public $pdo;
public function __construct(){
    try {
        $this->pdo = new PDO("mysql:host=".$this->DB_HOST.";dbname=".$this->DB_NAME, 
        $this->DB_USER, $this->DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }



}
}
?>