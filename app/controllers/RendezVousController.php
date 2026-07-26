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
            $sql_base = "FROM rendezvous r
                        LEFT JOIN clients c ON r.id_client = c.id_client
                        LEFT JOIN estheticiennes e ON r.id_estheticienne = e.id
                        WHERE 1=1";
            $params = [];

            if (!empty($search)) {
                $sql_base .= " AND (c.nom LIKE ? OR c.prenom LIKE ? OR r.service LIKE ? OR r.mode_paiement LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            if (!empty($statut_filter)) {
                $sql_base .= " AND r.statut = ?";
                $params[] = $statut_filter;
            }

            $count_stmt = $db->prepare("SELECT COUNT(*) " . $sql_base);
            $count_stmt->execute($params);
            $filtered_total = $count_stmt->fetchColumn();
            $total_pages = ceil($filtered_total / $limit);

            $sql = "SELECT r.*, 
                           CONCAT(c.prenom, ' ', c.nom) AS client_nom, c.telephone AS client_phone,
                           CONCAT(e.prenom, ' ', e.nom) AS estheticienne_nom
                    " . $sql_base . " ORDER BY r.date_rendezvous DESC LIMIT $limit OFFSET $offset";

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $rendezvous = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            $clients = $db->query("SELECT id_client AS id, CONCAT(prenom, ' ', nom) AS nom_complet FROM clients ORDER BY nom ASC")->fetchAll();
            $prestations = $db->query("SELECT id, nom_prestation, prix FROM prestations ORDER BY nom_prestation ASC")->fetchAll();
            $estheticiennes = $db->query("SELECT id, CONCAT(prenom, ' ', nom) AS nom_complet FROM estheticiennes ORDER BY nom ASC")->fetchAll();

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

    // 📄 Metòd recu() pou afiche/imprime resi an
    public function recu($id = null) {
        $id = $id ?? ($_GET['id'] ?? null);

        if (!$id) {
            header('Location: /spa/rendezvous');
            exit;
        }

        $db = $this->getDbConnection();

        try {
            $sql = "SELECT r.*, 
                           CONCAT(c.prenom, ' ', c.nom) AS client_nom, 
                           c.telephone AS client_phone,
                           c.email AS client_email,
                           CONCAT(e.prenom, ' ', e.nom) AS estheticienne_nom
                    FROM rendezvous r
                    LEFT JOIN clients c ON r.id_client = c.id_client
                    LEFT JOIN estheticiennes e ON r.id_estheticienne = e.id
                    WHERE r.id_rendezvous = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $rendezvous = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$rendezvous) {
                header('Location: /spa/rendezvous');
                exit;
            }

            // Chaje view pou resi an (recu.php)
            $recuView = __DIR__ . '/../views/admin/recu.php';
            if (file_exists($recuView)) {
                require_once $recuView;
            } else {
                // Si paj la nan yon lòt pati nan ka kote w gen yon fichye dirèk
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

    // ✏️ Metòd edit
    public function edit($id = null) {
        $id = $id ?? ($_GET['id'] ?? null);

        if (!$id) {
            header('Location: /spa/rendezvous');
            exit;
        }

        $db = $this->getDbConnection();

        try {
            $sql = "SELECT r.*, 
                           CONCAT(c.prenom, ' ', c.nom) AS client_nom, 
                           CONCAT(e.prenom, ' ', e.nom) AS estheticienne_nom
                    FROM rendezvous r
                    LEFT JOIN clients c ON r.id_client = c.id_client
                    LEFT JOIN estheticiennes e ON r.id_estheticienne = e.id
                    WHERE r.id_rendezvous = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $rendezvous_single = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$rendezvous_single) {
                header('Location: /spa/rendezvous');
                exit;
            }

            $clients = $db->query("SELECT id_client AS id, CONCAT(prenom, ' ', nom) AS nom_complet FROM clients ORDER BY nom ASC")->fetchAll();
            $prestations = $db->query("SELECT id, nom_prestation, prix FROM prestations ORDER BY nom_prestation ASC")->fetchAll();
            $estheticiennes = $db->query("SELECT id, CONCAT(prenom, ' ', nom) AS nom_complet FROM estheticiennes ORDER BY nom ASC")->fetchAll();

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

        $id_client = $_POST['id_client'] ?? $_POST['client_id'] ?? null;
        $id_estheticienne = $_POST['id_estheticienne'] ?? $_POST['estheticienne_id'] ?? null;
        $service = $_POST['service'] ?? $_POST['nom_prestation'] ?? '';
        $montant = $_POST['montant'] ?? 0;
        $mode_paiement = $_POST['mode_paiement'] ?? 'Carte Bancaire';
        $date_rendezvous = $_POST['date_rendezvous'] ?? $_POST['date_rdv'] ?? date('Y-m-d H:i:s');
        $statut = $_POST['statut'] ?? 'En attente';

        if (!empty($id_client) && !empty($service)) {
            try {
                $stmt = $db->prepare("INSERT INTO rendezvous (id_client, id_estheticienne, service, montant, mode_paiement, date_rendezvous, statut) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$id_client, $id_estheticienne, $service, $montant, $mode_paiement, $date_rendezvous, $statut]);
            } catch (PDOException $ex) {
                die("Erè nan anregistreman: " . $ex->getMessage());
            }
        }

        header('Location: /spa/rendezvous');
        exit;
    }

    public function update() {
        $db = $this->getDbConnection();

        $id_rendezvous = $_POST['id_rendezvous'] ?? $_POST['id'] ?? '';
        $id_client = $_POST['id_client'] ?? $_POST['client_id'] ?? null;
        $id_estheticienne = $_POST['id_estheticienne'] ?? $_POST['estheticienne_id'] ?? null;
        $service = $_POST['service'] ?? '';
        $montant = $_POST['montant'] ?? 0;
        $mode_paiement = $_POST['mode_paiement'] ?? 'Carte Bancaire';
        $date_rendezvous = $_POST['date_rendezvous'] ?? null;
        $statut = $_POST['statut'] ?? 'En attente';

        if (!empty($id_rendezvous) && !empty($id_client)) {
            try {
                $stmt = $db->prepare("UPDATE rendezvous SET id_client = ?, id_estheticienne = ?, service = ?, montant = ?, mode_paiement = ?, date_rendezvous = ?, statut = ? WHERE id_rendezvous = ?");
                $stmt->execute([$id_client, $id_estheticienne, $service, $montant, $mode_paiement, $date_rendezvous, $statut, $id_rendezvous]);
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
            $stmt = $db->prepare("SELECT statut FROM rendezvous WHERE id_rendezvous = ?");
            $stmt->execute([$id]);
            $curr = $stmt->fetchColumn();
            
            $new_status = ($curr === 'Confirmé') ? 'Annulé' : 'Confirmé';

            $updateStmt = $db->prepare("UPDATE rendezvous SET statut = ? WHERE id_rendezvous = ?");
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

        fputcsv($output, ['ID Rendez-vous', 'Client', 'Estheticienne', 'Service', 'Montant (HTG)', 'Mode Paiement', 'Date Rendez-vous', 'Statut']);

        $sql = "SELECT r.id_rendezvous, 
                       CONCAT(c.prenom, ' ', c.nom) AS client_nom, 
                       CONCAT(e.prenom, ' ', e.nom) AS estheticienne_nom, 
                       r.service, r.montant, r.mode_paiement, r.date_rendezvous, r.statut
                FROM rendezvous r
                LEFT JOIN clients c ON r.id_client = c.id_client
                LEFT JOIN estheticiennes e ON r.id_estheticienne = e.id
                ORDER BY r.id_rendezvous ASC";

        $stmt_exp = $db->query($sql);
        while ($row = $stmt_exp->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $row['id_rendezvous'],
                $row['client_nom'] ?? 'N/A',
                $row['estheticienne_nom'] ?? 'N/A',
                $row['service'] ?? 'N/A',
                $row['montant'],
                $row['mode_paiement'] ?? 'N/A',
                $row['date_rendezvous'],
                $row['statut']
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
                $stmt = $db->prepare("DELETE FROM rendezvous WHERE id_rendezvous = :id");
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