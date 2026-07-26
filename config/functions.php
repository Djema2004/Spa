<?php
// config/functions.php

// Demare session si li poko demare
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Netwaye done kont atak XSS
function e($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Verifye si itilizatè a konekte (redirije l si l pa konekte)
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
}

// Pwoteksyon CSRF
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("Erreur de sécurité : Token CSRF invalide.");
    }
}
?>