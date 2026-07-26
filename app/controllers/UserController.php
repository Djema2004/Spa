<?php

class UserController {
    private $db;

    // 🛠️ Fè argiman an opsyonèl ($db = null) pou Router la ka instansye klas la san erè
    public function __construct($db = null) {
        if ($db !== null) {
            $this->db = $db;
        } else {
            // Si Router a pa voye $db, nou chaje l otomatikman
            require_once __DIR__ . '/../../config/connect.php';
            if (class_exists('Connect')) {
                $dbConnect = new Connect();
                $this->db = $dbConnect->pdo;
            } else {
                global $pdo, $conn;
                $this->db = $pdo ?? $conn ?? null;
            }
        }
    }

    // 📋 Afiche lis itilizatè yo
    public function index() {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $users = [];

        if ($this->db) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM utilisateurs ORDER BY id DESC");
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Si tab la rele 'users' olye 'utilisateurs'
                try {
                    $stmt = $this->db->prepare("SELECT * FROM users ORDER BY id DESC");
                    $stmt->execute();
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $ex) {
                    echo "Erè SQL: " . $ex->getMessage();
                    exit;
                }
            }
        }

        $viewFile = __DIR__ . '/../views/admin/utilisateurs.php';
        if (!file_exists($viewFile)) {
            $viewFile = __DIR__ . '/../views/admin/users.php';
        }

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Erè: Fichye view la pa egziste nan chemen sa a: " . $viewFile;
        }
    }
}