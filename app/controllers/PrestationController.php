<?php

class PrestationController {
    private $db;

    public function __construct($db = null) {
        if ($db !== null) {
            $this->db = $db;
        } else {
            $this->db = $this->getDbConnection();
        }
    }

    private function getDbConnection() {
        $connectFile = __DIR__ . '/../../config/connect.php';
        if (file_exists($connectFile)) {
            require_once $connectFile;
            if (class_exists('Connect')) {
                $dbConnect = new Connect();
                if (isset($dbConnect->pdo) && $dbConnect->pdo !== null) {
                    return $dbConnect->pdo;
                }
            }
        }

        global $pdo, $conn;
        if (isset($pdo) && $pdo !== null) return $pdo;
        if (isset($conn) && $conn !== null) return $conn;

        try {
            return new PDO("mysql:host=localhost;dbname=dbspa;charset=utf8", "root", "", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Erè koneksyon ak baz de done dbspa: " . $e->getMessage());
        }
    }

    public function index() {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $db = $this->db;
        $prestations = [];

        if (isset($_GET['delete'])) {
            $this->delete($_GET['delete']);
        }

        if (isset($_GET['toggle_status'])) {
            $this->toggleStatus($_GET['toggle_status']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            if ($action === 'add_prestation') {
                $this->store();
            } elseif ($action === 'edit_prestation') {
                $this->update();
            }
        }

        $search = $_GET['search'] ?? '';
        $cat_filter = $_GET['cat_filter'] ?? '';
        $sort_by = $_GET['sort_by'] ?? 'name_asc';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        try {
            $sql_base = " FROM services WHERE 1=1";
            $params = [];

            if (!empty($search)) {
                $sql_base .= " AND (name LIKE ? OR description LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            if (!empty($cat_filter)) {
                $sql_base .= " AND category = ?";
                $params[] = $cat_filter;
            }

            $count_stmt = $db->prepare("SELECT COUNT(*) " . $sql_base);
            $count_stmt->execute($params);
            $filtered_total = $count_stmt->fetchColumn();
            $total_pages = ceil($filtered_total / $limit);

            $order_clause = " ORDER BY name ASC";
            if ($sort_by === 'prix_asc') $order_clause = " ORDER BY price ASC";
            elseif ($sort_by === 'prix_desc') $order_clause = " ORDER BY price DESC";
            elseif ($sort_by === 'duree_asc') $order_clause = " ORDER BY duration_minutes ASC";
            elseif ($sort_by === 'duree_desc') $order_clause = " ORDER BY duration_minutes DESC";

            // Korije: services.* nan plas services*
            $sql = "SELECT services.*, 
                price as display_price,
                image as display_image 
                " . $sql_base . $order_clause . " LIMIT $limit OFFSET $offset";
            
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $prestations = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        } catch (PDOException $e) {
            echo "Erè SQL: " . $e->getMessage();
            exit;
        }

        $viewFile = __DIR__ . '/../views/admin/prestations.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Erè: Fichye view la pa egziste nan chemen sa a: " . $viewFile;
        }
    }

    public function create() {
        $viewFile = __DIR__ . '/../views/admin/ajout_service.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Erè: Fichye view 'ajout_service.php' la pa jwenn.";
        }
    }

    public function manucure() {
        $db = $this->db;
        $services = [];

        try {
            // Korije: services.* nan plas services*
            $stmt = $db->prepare("SELECT services.*, 
                price as display_price,
                image as display_image 
                FROM services WHERE category LIKE '%Manucure%' OR category LIKE '%Pédicure%' OR name LIKE '%Manucure%' OR name LIKE '%Pédicure%' ORDER BY name ASC");
            $stmt->execute();
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Erè SQL: " . $e->getMessage();
            exit;
        }

        $viewFile = __DIR__ . '/../views/manucure_pedicure.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Erè: Fichye view la pa egziste nan chemen sa a: " . $viewFile;
        }
    }

    private function handleSingleImageUpload() {
        $imageName = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadFileDir = __DIR__ . '/../../public/image/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $cleanName = preg_replace('/[^\p{L}\p{N}]/u', '_', pathinfo($fileName, PATHINFO_FILENAME));
                $imageName = time() . '_' . $cleanName . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $imageName;
                
                if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imageName = null;
                }
            }
        }
        return $imageName;
    }

    public function store() {
        $db = $this->db;

        $name = $_POST['nom_prestation'] ?? $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $duration_minutes = $_POST['duree'] ?? $_POST['duration_minutes'] ?? 0;
        $price = $_POST['price'] ?? $_POST['prix'] ?? 0;
        $category = $_POST['category'] ?? 'Manucure & Pédicure'; 
        
        $imageName = $this->handleSingleImageUpload();

        if (!empty($name)) {
            try {
                $uuid = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000,
                    mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                );

                $stmt = $db->prepare("INSERT INTO services (uuid, name, description, duration_minutes, price, image, category, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$uuid, $name, $description, $duration_minutes, $price, $imageName, $category]);

            } catch (Exception $ex) {
                echo "Erè pandan anrejistreman an: " . $ex->getMessage();
                exit;
            }
        }

        header('Location: /spa/admin/prestations');
        exit;
    }

    public function update() {
        $db = $this->db;

        $id = $_POST['id'] ?? '';
        $name = $_POST['nom_prestation'] ?? $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $duration_minutes = $_POST['duree'] ?? $_POST['duration_minutes'] ?? 0;
        $price = $_POST['price'] ?? $_POST['prix'] ?? 0;
        $category = $_POST['category'] ?? 'Manucure & Pédicure';

        $imageName = $this->handleSingleImageUpload();

        if (!empty($id) && !empty($name)) {
            try {
                if ($imageName) {
                    $stmt = $db->prepare("UPDATE services SET name = ?, description = ?, duration_minutes = ?, price = ?, image = ?, category = ?, updated_at = NOW() WHERE uuid = ?");
                    $stmt->execute([$name, $description, $duration_minutes, $price, $imageName, $category, $id]);
                } else {
                    $stmt = $db->prepare("UPDATE services SET name = ?, description = ?, duration_minutes = ?, price = ?, category = ?, updated_at = NOW() WHERE uuid = ?");
                    $stmt->execute([$name, $description, $duration_minutes, $price, $category, $id]);
                }
            } catch (Exception $ex) {
                echo "Erè pandan mizajou a: " . $ex->getMessage();
                exit;
            }
        }

        header('Location: /spa/admin/prestations');
        exit;
    }

    public function toggleStatus($id) {
        header('Location: /spa/admin/prestations');
        exit;
    }

    public function exportCsv() {
        $db = $this->db;

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=services_spadream_' . date('Y-m-d') . '.csv');
        $output = fopen('php://output', 'w');
        fputs($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($output, ['UUID', 'Nom Service', 'Kategori', 'Description', 'Prix', 'Duree (min)', 'Date Creation']);

        $stmt_exp = $db->query("SELECT * FROM services ORDER BY name ASC");
        while ($row = $stmt_exp->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $row['uuid'] ?? '',
                $row['name'],
                $row['category'] ?? '',
                $row['description'] ?? '',
                $row['price'] ?? 0,
                $row['duration_minutes'],
                $row['created_at'] ?? ''
            ]);
        }
        fclose($output);
        exit();
    }

    public function delete($id = null) {
        $id = $id ?? ($_GET['id'] ?? null);

        if ($id) {
            $db = $this->db;
            try {
                $stmt = $db->prepare("DELETE FROM services WHERE uuid = :id");
                $stmt->execute(['id' => $id]);
            } catch (PDOException $e) {
                echo "Erè pandan sipresyon an: " . $e->getMessage();
                exit;
            }
        }

        header('Location: /spa/admin/prestations');
        exit;
    }
}