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
            // Sèvi ak tab 'services'
            $sql_base = "FROM services WHERE 1=1";
            $params = [];

            if (!empty($search)) {
                $sql_base .= " AND (name LIKE ? OR description LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            // Si ou pa gen kolòn 'categorie' nan tab services ou a, ou ka retire l oswa ajoute l nan DB
            if (!empty($cat_filter)) {
                $sql_base .= " AND category = ?";
                $params[] = $cat_filter;
            }

            $count_stmt = $db->prepare("SELECT COUNT(*) " . $sql_base);
            $count_stmt->execute($params);
            $filtered_total = $count_stmt->fetchColumn();
            $total_pages = ceil($filtered_total / $limit);

            // Sèvi ak bon non kolon yo pou lòd yo
            $order_clause = " ORDER BY name ASC";
            if ($sort_by === 'prix_asc') $order_clause = " ORDER BY price ASC";
            elseif ($sort_by === 'prix_desc') $order_clause = " ORDER BY price DESC";
            elseif ($sort_by === 'duree_asc') $order_clause = " ORDER BY duration_minutes ASC";
            elseif ($sort_by === 'duree_desc') $order_clause = " ORDER BY duration_minutes DESC";

            $sql = "SELECT * " . $sql_base . $order_clause . " LIMIT $limit OFFSET $offset";
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

    public function store() {
        $db = $this->db;

        $name = $_POST['nom_prestation'] ?? $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $duration_minutes = $_POST['duree'] ?? $_POST['duration_minutes'] ?? 0;
        $price = $_POST['prix'] ?? $_POST['price'] ?? 0;

        if (!empty($name)) {
            try {
                // Afekte nan tab 'services' ak kolon ki koresponn yo
                $stmt = $db->prepare("INSERT INTO services (name, description, duration_minutes, price, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$name, $description, $duration_minutes, $price]);
            } catch (PDOException $ex) {
                echo "Erè pandan anrejistreman an: " . $ex->getMessage();
                exit;
            }
        }

        header('Location: /spa/prestations');
        exit;
    }

    public function update() {
        $db = $this->db;

        $id = $_POST['id'] ?? '';
        $name = $_POST['nom_prestation'] ?? $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $duration_minutes = $_POST['duree'] ?? $_POST['duration_minutes'] ?? 0;
        $price = $_POST['prix'] ?? $_POST['price'] ?? 0;

        if (!empty($id) && !empty($name)) {
            try {
                $stmt = $db->prepare("UPDATE services SET name = ?, description = ?, duration_minutes = ?, price = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$name, $description, $duration_minutes, $price, $id]);
            } catch (PDOException $ex) {
                echo "Erè pandan mizajou a: " . $ex->getMessage();
                exit;
            }
        }

        header('Location: /spa/prestations');
        exit;
    }

    public function toggleStatus($id) {
        // Si tab services ou a pa gen kolòn 'statut', ou ka ajoute l sou phpMyAdmin oubyen kite l konsa
        $db = $this->db;
        try {
            // Tcheke si kolòn statut egziste oswa jere l si sa nesesè
        } catch (PDOException $ex) {}

        header('Location: /spa/prestations');
        exit;
    }

    public function exportCsv() {
        $db = $this->db;

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=services_spadream_' . date('Y-m-d') . '.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Nom Service', 'Description', 'Duree (min)', 'Prix (HTG)', 'Date Creation']);

        $stmt_exp = $db->query("SELECT * FROM services ORDER BY id ASC");
        while ($row = $stmt_exp->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $row['id'],
                $row['name'],
                $row['description'] ?? '',
                $row['duration_minutes'],
                $row['price'],
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
                $stmt = $db->prepare("DELETE FROM services WHERE id = :id");
                $stmt->execute(['id' => $id]);
            } catch (PDOException $e) {
                echo "Erè pandan sipresyon an: " . $e->getMessage();
                exit;
            }
        }

        header('Location: /spa/prestations');
        exit;
    }
}