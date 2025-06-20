<?php
require_once 'conf/conexion.php';
require_once 'conf/functions.php';

verificar_sesion(true); // solo admin

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['user']);
    $nombre = trim($_POST['nombre']);
    $clave = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $perfil = $_POST['perfil'];

    $conn = conectarSQL();
    $sql = "INSERT INTO usuarios (username, password, nombre, perfil, estatus) VALUES (?, ?, ?, ?, 1)";
    $stmt = sqlsrv_query($conn, $sql, [$usuario, $clave, $nombre, $perfil]);

    $mensaje = $stmt ? "Usuario registrado correctamente." : "Error al registrar usuario.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<div class="container mt-5">
    <h3>Registrar Nuevo Usuario</h3>
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Usuario</label>
            <input type="text" name="user" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control">
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Perfil</label>
            <select name="perfil" class="form-control" required>
                <option value="usuario">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <button class="btn btn-success" type="submit">Registrar</button>
                </div>
                <div class="col">
                    <div class="col">
                        <a href="home.php" class="btn btn-primary">
                            <i class="fa fa-home"></i> Home
                        </a>
                    </div>
                </div>
                <div class="col">
                    <a href="salir.php" class="btn btn-danger">
                        <i class="fa fa-sign-out"></i> Salir
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>