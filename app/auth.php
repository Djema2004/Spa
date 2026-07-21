<?php
function checkAdminAccess() {
    session_start();
    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
        header("Location: /SPA/login");
        exit();
    }
}
?>