<?php
// core/Database.php

class Database {
    // Instance unique de la connexion (Singleton)
    private static $instance = null;
    private $pdo;

    // Le constructeur est privé pour empêcher d'instancier plusieurs fois la classe directement
    private function __construct() {
        // Configuration de la base de données - À AJUSTER AVEC TES INFOS
        $host     = 'localhost';
        $dbname   = 'nom_de_ta_base'; // Remplace par le nom de ta base de données (ex: spa_db)
        $username = 'root';          // Ton identifiant (souvent root)
        $password = '';              // Ton mot de passe (vide sur XAMPP/Wamp par défaut)
        $charset  = 'utf8mb4';

        // Si tu utilises PostgreSQL à la place de MySQL, change le début du DSN par : "pgsql:host=$host;..."
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active les erreurs SQL sous forme d'exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retourne les données sous forme de tableau associatif
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation pour une meilleure sécurité (injections SQL)
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            // En cas d'échec de connexion, on affiche un message propre au lieu de dévoiler ton mot de passe
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Méthode statique pour récupérer l'instance unique de PDO
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}