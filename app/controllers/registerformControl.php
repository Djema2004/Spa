<?php
require_once __DIR__ .'/../controllers/controllerUsers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/register.php');
    exit();
}

$firstName = trim($_POST['firstname'] ?? '');
$lastName = trim($_POST['lastname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
    die("Tous les champs sont requis.");
    
}

if ($password !== $password_confirm) {
    die("Les mots de passe ne correspondent pas.");
    
}

$controller = new ControllerUsers();
$result = $controller->addUser($firstName, $lastName, $email, $password);

if($result) {
    header('Location: ../views/login.php');
    exit();
} else {
    die("Erreur lors de l'inscription.");
}


?>