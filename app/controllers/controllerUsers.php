<?php
require_once __DIR__ . '/../controllers/Users.php';
require_once __DIR__ . '/../models/usersModel.php';

class ControllerUsers {
    private $model;

    public function __construct() {
        $this->model = new UsersModel();
    }

    public function addUser($firstname, $lastname, $email, $password) {
        $user = new Users($firstname, $lastname, $email, $password);
        return $this->model->addUsers($user);

    }
   
    }
?>