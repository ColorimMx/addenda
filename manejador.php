<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $username = "Colorim";
    $password = "C%addenda%10";

    // Validación estricta: ambos campos deben estar presentes
    if (!empty($_POST['user']) && !empty($_POST['password'])) {
        $nombre = trim($_POST['user']);
        $pass = trim($_POST['password']);

        // Comparación directa (¡Usa password_verify en producción!)
        if ($nombre === $username && $pass === $password) {
            $_SESSION['username'] = $nombre;
            header("Location: home.php");
            exit;
        } else {
            header("Location: index.php?res=incorrecto");
            exit;
        }
    } else {
        header("Location: index.php?res=incompleto");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}