<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!function_exists('verificar_sesion')) {
    function verificar_sesion() {
        if (!isset($_SESSION['username'])) {
            header('Location: ../index.php?res=sesion');
            exit;
        }
    }
}
?>