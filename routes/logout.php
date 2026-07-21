<?php
// 1. Kòmanse sesyon an si l pa t ko kòmanse pou nou ka gen aksè ak done yo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Vide tablo sesyon an nèt
$_SESSION = array();

// 3. Efase koutki (cookie) sesyon an nan navigatè a si li egziste pou sekirite
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Detwi sesyon an nèt sou sèvè a
session_destroy();

// 5. Redirije itilizatè a dirèkteman sou paj login lan nan sistèm routaj ou a
header("Location: index.php?route=login");
exit;
?>