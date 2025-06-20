<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'conexion.php';

if (!function_exists('verificar_sesion')) {
    function verificar_sesion($requerir_admin = false) {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php?res=sesion');
            exit;
        }

        if ($requerir_admin && $_SESSION['perfil'] !== 'admin') {
            header('Location: home.php?res=noadmin');
            exit;
        }
    }
}
?>