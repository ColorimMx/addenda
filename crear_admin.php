<?php
require_once 'conf/conexion.php';

$usuario = 'admin';
$clave = 'A$colorim%2015'; // tu contraseña deseada
$nombre = 'Administrador';
$perfil = 'admin';
$estatus = 1;

// Hashear la contraseña
$claveHash = password_hash($clave, PASSWORD_DEFAULT);

// Conectar
$conn = conectarSQL();

// Verificar si ya existe
$sqlVerifica = "SELECT id FROM usuarios WHERE username = ?";
$stmt = sqlsrv_query($conn, $sqlVerifica, [$usuario]);

if ($stmt && sqlsrv_fetch_array($stmt)) {
    echo "⚠️ El usuario '$usuario' ya existe.";
} else {
    $sql = "INSERT INTO usuarios (username, password, nombre, perfil, estatus) VALUES (?, ?, ?, ?, ?)";
    $params = [$usuario, $claveHash, $nombre, $perfil, $estatus];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        echo "✅ Usuario administrador creado correctamente.";
    } else {
        echo "❌ Error al crear el usuario: ";
        print_r(sqlsrv_errors());
    }
}
?>