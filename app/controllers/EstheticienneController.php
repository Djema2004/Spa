<?php

require_once dirname(__DIR__) . '/models/Estheticienne.php';
// Correction du chemin : on remonte de app/controllers vers app/ puis vers la racine pour atteindre core/Database.php
require_once dirname(__DIR__) . '/../core/Database.php';

class EstheticienneController {
    private $db;
    private $estheticienneModel;

    public function __construct() {
        // Utilisation du Singleton Database::getInstance() défini dans core/Database.php
        $this->db = Database::getInstance();
        $this->estheticienneModel = new Estheticienne($this->db);
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: index.php?url=login');
            exit();
        }

        $estheticiennes = $this->estheticienneModel->getAll();
        include dirname(__DIR__) . '/views/admin/estheticiennes.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $specialite = trim($_POST['specialite'] ?? '');
            $disponibilite = $_POST['disponibilite'] ?? 1;

            $photoName = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileName = $_FILES['photo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $uploadFileDir = dirname(__DIR__) . '/../public/uploads/estheticiennes/';
                    
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    
                    $dest_path = $uploadFileDir . $newFileName;
                    if(move_uploaded_file($fileTmpPath, $dest_path)) {
                        $photoName = $newFileName;
                    }
                }
            }

            $data = [
                'nom' => $nom,
                'prenom' => $prenom,
                'telephone' => $telephone,
                'email' => $email,
                'specialite' => $specialite,
                'photo' => $photoName,
                'disponibilite' => $disponibilite
            ];

            $this->estheticienneModel->create($data);
            header('Location: index.php?url=estheticiennes');
            exit();
        }
    }

    public function edit() {
        $uid = $_GET['uid'] ?? $_GET['id'] ?? null;
        if (!$uid) {
            header('Location: index.php?url=estheticiennes');
            exit();
        }

        $estheticienne = $this->estheticienneModel->getByUid($uid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $specialite = trim($_POST['specialite'] ?? '');
            $disponibilite = $_POST['disponibilite'] ?? 1;

            $photoName = $estheticienne['photo'] ?? null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileName = $_FILES['photo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $uploadFileDir = dirname(__DIR__) . '/../public/uploads/estheticiennes/';
                    
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    
                    $dest_path = $uploadFileDir . $newFileName;
                    if(move_uploaded_file($fileTmpPath, $dest_path)) {
                        $photoName = $newFileName;
                    }
                }
            }

            $data = [
                'nom' => $nom,
                'prenom' => $prenom,
                'telephone' => $telephone,
                'email' => $email,
                'specialite' => $specialite,
                'photo' => $photoName,
                'disponibilite' => $disponibilite
            ];

            $this->estheticienneModel->update($uid, $data);
            header('Location: index.php?url=estheticiennes');
            exit();
        }

        include dirname(__DIR__) . '/views/admin/estheticienne_edit.php';
    }

    public function delete() {
        $uid = $_GET['uid'] ?? $_GET['id'] ?? null;
        if ($uid) {
            $this->estheticienneModel->delete($uid);
        }
        header('Location: index.php?url=estheticiennes');
        exit();
    }
}