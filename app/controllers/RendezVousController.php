<?php

class RendezvousController {

    public function __construct($db = null) {}

    private function getDbConnection() {
        require_once __DIR__ . '/../../config/connect.php';

        if (class_exists('Connect')) {
            $dbConnect = new Connect();
            if (isset($dbConnect->pdo) && $dbConnect->pdo !== null) {
                return $dbConnect->pdo;
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

        $db = $this->getDbConnection();
        $rendezvous = [];

        if (isset($_GET['delete'])) {
            $this->delete($_GET['delete']);
        }

        if (isset($_GET['toggle_status'])) {
            $this->toggleStatus($_GET['toggle_status']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            if ($action === 'add_rendezvous') {
                $this->store();
            } elseif ($action === 'edit_rendezvous') {
                $this->update();
            }
        }

        $search = $_GET['search'] ?? '';
        $statut_filter = $_GET['statut_filter'] ?? '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        try {
            // Liaison avec la table services (s) et la table users (u pour client, e pour estheticienne)
            $sql_base = "FROM appointments r
                        LEFT JOIN users u ON r.user_id = u.id
                        LEFT JOIN services s ON r.service_id = s.id
                        LEFT JOIN users e ON r.estheticienne_id = e.id AND e.role = 'estheticienne'
                        WHERE 1=1";
            $params = [];

            if (!empty($search)) {
                $sql_base .= " AND (u.lastname LIKE ? OR u.firstname LIKE ? OR r.status LIKE ? OR s.name LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            if (!empty($statut_filter)) {
                $sql_base .= " AND r.status = ?";
                $params[] = $statut_filter;
            }

            $count_stmt = $db->prepare("SELECT COUNT(*) " . $sql_base);
            $count_stmt->execute($params);
            $filtered_total = $count_stmt->fetchColumn();
            $total_pages = ceil($filtered_total / $limit);

            $sql = "SELECT r.*, 
                           COALESCE(CONCAT(u.firstname, ' ', u.lastname), r.nom_client) AS client_nom, 
                           u.email AS client_phone,
                           COALESCE(s.name, 'Service non spécifié') AS service_nom,
                           COALESCE(s.price, 0) AS service_tarif,
                           CONCAT(e.firstname, ' ', e.lastname) AS estheticienne_nom
                    " . $sql_base . " ORDER BY r.appointment_date DESC LIMIT $limit OFFSET $offset";

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $rendezvous = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            // Récupération des listes pour les formulaires (clients, services et esthéticiennes)
            $clients = $db->query("SELECT id, CONCAT(firstname, ' ', lastname) AS nom_complet FROM users WHERE role = 'client' ORDER BY lastname ASC")->fetchAll();
            $services = $db->query("SELECT id, name, price FROM services ORDER BY name ASC")->fetchAll();
            $estheticiennes = $db->query("SELECT id, CONCAT(firstname, ' ', lastname) AS nom_complet FROM users WHERE role = 'estheticienne' ORDER BY lastname ASC")->fetchAll();

        } catch (PDOException $e) {
            echo "Erè SQL: " . $e->getMessage();
            exit;
        }

        $viewFile = __DIR__ . '/../views/admin/rendezvous.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Erè: Fichye view la pa egziste nan chemen sa a: " . $viewFile;
        }
    }

    public function recu($id = null) {
        $id = $id ?? ($_GET['id'] ?? null);

        if (!$id) {
            header('Location: /spa/rendezvous');
            exit;
        }

        $db = $this->getDbConnection();

        try {
            $sql = "SELECT r.*, 
                           COALESCE(CONCAT(u.firstname, ' ', u.lastname), r.nom_client) AS client_nom, 
                           u.email AS client_email,
                           COALESCE(s.name, 'Service non spécifié') AS service_nom,
                           COALESCE(s.price, 0) AS service_tarif,
                           CONCAT(e.firstname, ' ', e.lastname) AS estheticienne_nom
                    FROM appointments r
                    LEFT JOIN users u ON r.user_id = u.id
                    LEFT JOIN services s ON r.service_id = s.id
                    LEFT JOIN users e ON r.estheticienne_id = e.id AND e.role = 'estheticienne'
                    WHERE r.id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $rendezvous = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$rendezvous) {
                header('Location: /spa/rendezvous');
                exit;
            }

            $recuView = __DIR__ . '/../views/admin/recu.php';
            if (file_exists($recuView)) {
                require_once $recuView;
            } else {
                $altView = __DIR__ . '/../views/recu.php';
                if (file_exists($altView)) {
                    require_once $altView;
                } else {
                    echo "Erè: Fichye view resi la (recu.php) pa jwenn nan dosye views a.";
                }
            }

        } catch (PDOException $e) {
            echo "Erè SQL pandan chajman resi an: " . $e->getMessage();
            exit;
        }
    }

    public function edit($id = null) {
        $id = $id ?? ($_GET['id'] ?? null);

        if (!$id) {
            header('Location: /spa/rendezvous');
            exit;
        }

        $db = $this->getDbConnection();

        try {
            $sql = "SELECT r.*, 
                           COALESCE(CONCAT(u.firstname, ' ', u.lastname), r.nom_client) AS client_nom, 
                           COALESCE(s.name, 'Service non spécifié') AS service_nom,
                           COALESCE(s.price, 0) AS service_tarif,
                           CONCAT(e.firstname, ' ', e.lastname) AS estheticienne_nom
                    FROM appointments r
                    LEFT JOIN users u ON r.user_id = u.id
                    LEFT JOIN services s ON r.service_id = s.id
                    LEFT JOIN users e ON r.estheticienne_id = e.id AND e.role = 'estheticienne'
                    WHERE r.id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $rendezvous_single = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$rendezvous_single) {
                header('Location: /spa/rendezvous');
                exit;
            }

            $clients = $db->query("SELECT id, CONCAT(firstname, ' ', lastname) AS nom_complet FROM users WHERE role = 'client' ORDER BY lastname ASC")->fetchAll();
            $services = $db->query("SELECT id, name, price FROM services ORDER BY name ASC")->fetchAll();
            $estheticiennes = $db->query("SELECT id, CONCAT(firstname, ' ', lastname) AS nom_complet FROM users WHERE role = 'estheticienne' ORDER BY lastname ASC")->fetchAll();

            $editView = __DIR__ . '/../views/admin/modifier_rendezvous.php';
            if (file_exists($editView)) {
                require_once $editView;
            } else {
                require_once __DIR__ . '/../views/admin/rendezvous.php';
            }

        } catch (PDOException $e) {
            echo "Erè SQL pandan modifikasyon an: " . $e->getMessage();
            exit;
        }
    }

    public function store() {
        $db = $this->getDbConnection();

        $id = uniqid('apt_', true);
        $user_id = $_POST['id_client'] ?? $_POST['client_id'] ?? null;
        $service_id = $_POST['id_service'] ?? $_POST['service_id'] ?? $_POST['id_estheticienne'] ?? null;
        
        $appointment_date = $_POST['appointment_date'] ?? $_POST['date_rendezvous'] ?? $_POST['date_rdv'] ?? date('Y-m-d');
        $appointment_time = $_POST['appointment_time'] ?? $_POST['heure_rdv'] ?? '10:00:00';
        
        $status = $_POST['statut'] ?? 'pending';

        if (!empty($user_id)) {
            try {
                $stmt = $db->prepare("INSERT INTO appointments (id, user_id, service_id, appointment_date, appointment_time, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$id, $user_id, $service_id, $appointment_date, $appointment_time, $status]);
            } catch (PDOException $ex) {
                die("Erè nan anregistreman: " . $ex->getMessage());
            }
        }

        header('Location: /spa/rendezvous');
        exit;
    }

    public function update() {
        $db = $this->getDbConnection();

        $id = $_POST['id_rendezvous'] ?? $_POST['id'] ?? '';
        $user_id = $_POST['id_client'] ?? $_POST['client_id'] ?? null;
        $service_id = $_POST['id_service'] ?? $_POST['service_id'] ?? null;
        
        $appointment_date = $_POST['appointment_date'] ?? $_POST['date_rendezvous'] ?? null;
        $appointment_time = $_POST['appointment_time'] ?? $_POST['heure_rdv'] ?? null;
        $status = $_POST['statut'] ?? 'pending';

        if (!empty($id)) {
            try {
                $stmt = $db->prepare("UPDATE appointments SET user_id = ?, service_id = ?, appointment_date = ?, appointment_time = ?, status = ? WHERE id = ?");
                $stmt->execute([$user_id, $service_id, $appointment_date, $appointment_time, $status, $id]);
            } catch (PDOException $ex) {
                die("Erè nan modifikasyon: " . $ex->getMessage());
            }
        }

        header('Location: /spa/rendezvous');
        exit;
    }

    public function toggleStatus($id) {
        $db = $this->getDbConnection();
        try {
            $stmt = $db->prepare("SELECT status FROM appointments WHERE id = ?");
            $stmt->execute([$id]);
            $curr = $stmt->fetchColumn();
            
            $new_status = ($curr === 'Confirmé' || $curr === 'confirmed') ? 'cancelled' : 'confirmed';

            $updateStmt = $db->prepare("UPDATE appointments SET status = ? WHERE id = ?");
            $updateStmt->execute([$new_status, $id]);
        } catch (PDOException $ex) {}

        header('Location: /spa/rendezvous');
        exit;
    }

    public function exportCsv() {
        $db = $this->getDbConnection();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=rendezvous_spadream_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fputs($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['ID Rendez-vous', 'Client', 'Prestation', 'Tarif', 'Date Rendez-vous', 'Statut']);

        $sql = "SELECT r.id, 
                       COALESCE(CONCAT(u.firstname, ' ', u.lastname), r.nom_client) AS client_nom, 
                       COALESCE(s.name, 'N/A') AS service_nom,
                       COALESCE(s.price, 0) AS service_tarif,
                       r.appointment_date, r.status
                FROM appointments r
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN services s ON r.service_id = s.id
                ORDER BY r.appointment_date ASC";

        $stmt_exp = $db->query($sql);
        while ($row = $stmt_exp->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $row['id'],
                $row['client_nom'] ?? 'N/A',
                $row['service_nom'],
                $row['service_tarif'],
                $row['appointment_date'],
                $row['status']
            ]);
        }
        fclose($output);
        exit();
    }

    public function delete($id = null) {
        $id = $id ?? ($_GET['id'] ?? null);

        if ($id) {
            $db = $this->getDbConnection();
            try {
                $stmt = $db->prepare("DELETE FROM appointments WHERE id = :id");
                $stmt->execute(['id' => $id]);
            } catch (PDOException $e) {
                echo "Erè pandan sipresyon an: " . $e->getMessage();
                exit;
            }
        }

        header('Location: /spa/rendezvous');
        exit;
    }
}