<?php
require_once __DIR__ . '/../models/DashboardModel.php';

class DashboardController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new DashboardModel($dbConnection);
    }

    public function index() {
        // Al chèche done yo nan modèl la pou tablodbò a
        $chiffreAffaires = $this->model->getChiffreAffaires();
        $rdvJour         = $this->model->getRdvAujourdhui();
        $clientsActifs   = $this->model->getTotalClients();
        $derniersRdv     = $this->model->getProchainsRdv();
        
        // Ou ka ajoute tou si modèl ou a genyen yo pou lòt pati nan vi a
        $topPrestations  = method_exists($this->model, 'getTopPrestations') ? $this->model->getTopPrestations() : [];

        // Chaje vi a epi pase varyab yo ba li san danje
        $viewPath = __DIR__ . '/../views/admin/index.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            // Ti sekirite si chemen vi a chanje
            die("Erè: Fichye vi pou tablodbò a pa jwenn nan chemen sa a: " . $viewPath);
        }
    }
}
?>