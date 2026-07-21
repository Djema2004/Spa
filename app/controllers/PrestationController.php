<?php
class PrestationController {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function index() {
        $prestations = $this->db->query("SELECT * FROM prestation")->fetchAll(PDO::FETCH_ASSOC);
        include 'views/prestations.php'; // Chaje vi a
    }
}