<?php
// index.php
session_start();
$res = $_GET['res'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Addendas COLORIM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
        }
        .login-box {
            max-width: 420px;
            margin: 80px auto;
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
        .login-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .login-logo img {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-logo">
        <img src="img/logo-colorim.png" alt="Logo Colorim">
    </div>
    <h3 class="text-center mb-4">Generador Addendas Colorim</h3>

    <?php if ($res === 'incorrecto'): ?>
        <div class="alert alert-danger">Usuario o contraseña incorrectos.</div>
    <?php elseif ($res === 'incompleto'): ?>
        <div class="alert alert-warning">Ingrese usuario y contraseña.</div>
    <?php elseif ($res === 'sesion'): ?>
        <div class="alert alert-info">Debe iniciar sesión primero.</div>
    <?php endif; ?>

    <form method="POST" action="manejador.php" novalidate onsubmit="return validarFormulario();">
        <div class="mb-3">
            <label for="user" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="user" name="user" required>
            <div class="invalid-feedback">Por favor ingrese su usuario.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback">Por favor ingrese su contraseña.</div>
        </div>
        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">Iniciar sesión</button>
        </div>
    </form>
</div>

<script>
    // Validación manual en JS (complementaria al required de HTML5)
    function validarFormulario() {
        const user = document.getElementById('user');
        const password = document.getElementById('password');
        let valido = true;

        if (user.value.trim() === '') {
            user.classList.add('is-invalid');
            valido = false;
        } else {
            user.classList.remove('is-invalid');
        }

        if (password.value.trim() === '') {
            password.classList.add('is-invalid');
            valido = false;
        } else {
            password.classList.remove('is-invalid');
        }

        return valido;
    }
</script>
</body>
</html>