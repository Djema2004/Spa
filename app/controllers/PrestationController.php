<?php

class PrestationController {
    private $db;

    public function __construct($db = null) {
        // Si Router an pase $db nou pran l, sinon nou initialize pwòp koneksyon nou
        if ($db !== null) {
            $this->db = $db;
        } else {
            $this->db = $this->getDbConnection();
        }
    }

    // 🛠️ Helper pou kreye koneksyon an si li pa te pase pa Router la
    private function getDbConnection() {
        // Rechech fichye koneksyon si l egziste
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

        // Si gen yon variable global $pdo oswa $conn
        global $pdo, $conn;
        if (isset($pdo) && $pdo !== null) return $pdo;
        if (isset($conn) && $conn !== null) return $conn;

        // Sinon, kreye yon nouvo PDO dirèkteman ak baz de done dbspa
        try {
            return new PDO("mysql:host=localhost;dbname=dbspa;charset=utf8", "root", "", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Erè koneksyon ak baz de done dbspa: " . $e->getMessage());
        }
    }

    // 📋 Afichage Lis Prestation Yo
    public function index() {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        // Nou sèvi ak $this->db ki toujou gen yon koneksyon ansekirite
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
        $sort_by = $_GET['sort_by'] ?? 'nom_asc';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        try {
            $sql_base = "FROM prestations WHERE 1=1";
            $params = [];

            if (!empty($search)) {
                $sql_base .= " AND (nom_prestation LIKE ? OR categorie LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            if (!empty($cat_filter)) {
                $sql_base .= " AND categorie = ?";
                $params[] = $cat_filter;
            }

            $count_stmt = $db->prepare("SELECT COUNT(*) " . $sql_base);
            $count_stmt->execute($params);
            $filtered_total = $count_stmt->fetchColumn();
            $total_pages = ceil($filtered_total / $limit);

            $order_clause = " ORDER BY nom_prestation ASC";
            if ($sort_by === 'prix_asc') $order_clause = " ORDER BY prix ASC";
            elseif ($sort_by === 'prix_desc') $order_clause = " ORDER BY prix DESC";
            elseif ($sort_by === 'duree_asc') $order_clause = " ORDER BY duree ASC";
            elseif ($sort_by === 'duree_desc') $order_clause = " ORDER BY duree DESC";

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

    // ➕ Ajoute
    public function store() {
        $db = $this->db;

        $uid = 'PRE-' . strtoupper(substr(uniqid(), -8));
        $nom_prestation = $_POST['nom_prestation'] ?? '';
        $categorie = $_POST['categorie'] ?? '';
        $prix = $_POST['prix'] ?? 0;
        $prix_promo = !empty($_POST['prix_promo']) ? $_POST['prix_promo'] : null;
        $duree = $_POST['duree'] ?? 0;
        $description = $_POST['description'] ?? '';
        $statut = $_POST['statut'] ?? 'Actif';

        if (!empty($nom_prestation) && !empty($categorie)) {
            try {
                $stmt = $db->prepare("INSERT INTO prestations (uid, nom_prestation, categorie, prix, prix_promo, duree, description, statut) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$uid, $nom_prestation, $categorie, $prix, $prix_promo, $duree, $description, $statut]);
            } catch (PDOException $ex) {
                try {
                    $stmt = $db->prepare("INSERT INTO prestations (uid, nom_prestation, categorie, prix, duree, description, statut) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$uid, $nom_prestation, $categorie, $prix, $duree, $description, $statut]);
                } catch (PDOException $ex2) {
                    $stmt = $db->prepare("INSERT INTO prestations (uid, nom_prestation, categorie, prix, duree) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$uid, $nom_prestation, $categorie, $prix, $duree]);
                }
            }
        }

        header('Location: /spa/prestations');
        exit;
    }

    // ✏️ Modifye
    public function update() {
        $db = $this->db;

        $id = $_POST['id'] ?? '';
        $nom_prestation = $_POST['nom_prestation'] ?? '';
        $categorie = $_POST['categorie'] ?? '';
        $prix = $_POST['prix'] ?? 0;
        $prix_promo = !empty($_POST['prix_promo']) ? $_POST['prix_promo'] : null;
        $duree = $_POST['duree'] ?? 0;
        $description = $_POST['description'] ?? '';
        $statut = $_POST['statut'] ?? 'Actif';

        if (!empty($id) && !empty($nom_prestation)) {
            try {
                $stmt = $db->prepare("UPDATE prestations SET nom_prestation = ?, categorie = ?, prix = ?, prix_promo = ?, duree = ?, description = ?, statut = ? WHERE id = ?");
                $stmt->execute([$nom_prestation, $categorie, $prix, $prix_promo, $duree, $description, $statut, $id]);
            } catch (PDOException $ex) {
                try {
                    $stmt = $db->prepare("UPDATE prestations SET nom_prestation = ?, categorie = ?, prix = ?, duree = ?, description = ?, statut = ? WHERE id = ?");
                    $stmt->execute([$nom_prestation, $categorie, $prix, $duree, $description, $statut, $id]);
                } catch (PDOException $ex2) {
                    $stmt = $db->prepare("UPDATE prestations SET nom_prestation = ?, categorie = ?, prix = ?, duree = ? WHERE id = ?");
                    $stmt->execute([$nom_prestation, $categorie, $prix, $duree, $id]);
                }
            }
        }

        header('Location: /spa/prestations');
        exit;
    }

    // 🔄 Chanje Statut
    public function toggleStatus($id) {
        $db = $this->db;
        try {
            $stmt = $db->prepare("SELECT statut FROM prestations WHERE id = ?");
            $stmt->execute([$id]);
            $curr = $stmt->fetchColumn();
            $new_status = ($curr === 'Inactif') ? 'Actif' : 'Inactif';

            $updateStmt = $db->prepare("UPDATE prestations SET statut = ? WHERE id = ?");
            $updateStmt->execute([$new_status, $id]);
        } catch (PDOException $ex) {}

        header('Location: /spa/prestations');
        exit;
    }

    // 📥 Export CSV
    public function exportCsv() {
        $db = $this->db;

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prestations_spadream_' . date('Y-m-d') . '.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'UID', 'Nom Prestation', 'Categorie', 'Prix (HTG)', 'Prix Promo', 'Duree (min)', 'Statut', 'Description']);

        $stmt_exp = $db->query("SELECT * FROM prestations ORDER BY id ASC");
        while ($row = $stmt_exp->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $row['id'],
                $row['uid'] ?? 'PRE-'.$row['id'],
                $row['nom_prestation'],
                $row['categorie'],
                $row['prix'],
                $row['prix_promo'] ?? '',
                $row['duree'],
                $row['statut'] ?? 'Actif',
                $row['description'] ?? ''
            ]);
        }
        fclose($output);
        exit();
    }

    // 🗑️ Efase
    public function delete($id = null) {
        $id = $id ?? ($_GET['id'] ?? null);

        if ($id) {
            $db = $this->db;
            try {
                $stmt = $db->prepare("DELETE FROM prestations WHERE id = :id");
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