<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'conf/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $usuario = trim($_POST['user']);
    $clave = trim($_POST['password']);

    if (!empty($usuario) && !empty($clave)) {
        $conn = conectarSQL();

        $sql = "SELECT id, username, password, perfil, estatus FROM usuarios WHERE username = ?";
        $stmt = sqlsrv_query($conn, $sql, [$usuario]);

        if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['estatus'] != 1) {
                header("Location: index.php?res=bloqueado");
                exit;
            }

            if (password_verify($clave, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['perfil'] = $row['perfil'];
                header("Location: home.php");
                exit;
            } else {
                header("Location: index.php?res=incorrecto");
                exit;
            }
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