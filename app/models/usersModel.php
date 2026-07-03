<?php
require_once __DIR__ . '/../../config/connect.php';

class UsersModel{
   private $db;
    public function __construct(){
         $this->db = new Connect();
    }

    private function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

    }

    public function addUsers(Users $user){
        try{
            $uuid = $this->generateUUID();
            $stmt = $this->db->pdo->prepare("INSERT INTO users (id, firstname, lastname, email, password)
             VALUES (:id, :firstname, :lastname, :email, :password)");
         
            $stmt->bindParam(':id', $uuid);
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $email = $user->getEmail();
            $password = $user->getPassword();
            
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
             return $stmt->execute();
        

        } catch (PDOException $error) {
            die("Error adding user: " . $error->getMessage());
        }
    }

}
?>