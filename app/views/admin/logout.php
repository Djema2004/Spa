<?php
// logout.php - Spa Dream Admin

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();

// 🛑 CHANJMAN AN ISIT LA: Redirije sou rout login an (san .php ak app/views)
header("Location: /spa/login?logout=success"); 
// Oswa header("Location: /spa/admin/login?logout=success"); selon jan wout la ye nan routes/web.php
exit();