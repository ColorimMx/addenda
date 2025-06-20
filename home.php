<?php
session_start();
include 'conf/functions.php';
verificar_sesion();

$mensaje_exito = $_SESSION['mensaje_exito'] ?? null;
$mensaje_error = $_SESSION['mensaje_error'] ?? null;
$archivo_generado = $_SESSION['archivo_generado'] ?? null;

// Limpiar mensajes para que solo se muestren una vez
unset($_SESSION['mensaje_exito'], $_SESSION['mensaje_error'], $_SESSION['archivo_generado']);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generador de Addendas Colorim</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

    <link rel="stylesheet" href="css/stylo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <script src="https://code.jquery.com/jquery-2.2.4.js"
            integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/file.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">

        <!-- Encabezado y menú colapsable -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#navbar-main" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">
                    <img src="img/logo-colorim-s.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                </a>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbar-main">

            <!-- Botones del sistema (izquierda) -->
            <form class="navbar-form navbar-left">
                <button type="button" class="btn btn-lacomer" onclick="formComer()">
                    <i class="fa fa-shopping-basket"></i> La Comer
                </button>
                <button type="button" class="btn btn-primary" onclick="formNadro()">
                    <i class="fa fa-medkit"></i> Nadro
                </button>
                <button type="button" class="btn btn-isseg" onclick="formIsseg()">
                    <i class="fa fa-hospital-o"></i> Isseg
                </button>
                <button type="button" class="btn btn-superkompras" onclick="formSuperKompras()">
                    <i class="fa fa-truck"></i> Super Kompras
                </button>
            </form>

            <!-- Botones de sesión (derecha) -->
            <div class="navbar-right" style="margin-top: 8px;">
                <div class="container text-center">
                    <div class="row">
                    </div>
                </div>
                <div>
                <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'admin'): ?>
                    <a href="registrar.php" class="btn btn-success" style="margin-right: 10px;">
                        <i class="fa fa-user-plus"></i> Registrar Usr
                    </a>
                <?php endif; ?>
                <a href="salir.php" class="btn btn-danger">
                    <i class="fa fa-sign-out"></i> Salir
                </a>
                </div>
            </div>

        </div>
    </div>
</nav>
<div class="container mt-4">
    <?php if ($mensaje_exito): ?>
        <div class="alert alert-success">
            ✅ <?= htmlspecialchars($mensaje_exito) ?>
            <?php if ($archivo_generado): ?>
                <a href="xml_generados/<?= urlencode($archivo_generado) ?>" class="btn btn-sm btn-success ms-3"
                   download>Descargar ahora</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($mensaje_error): ?>
        <div class="alert alert-danger">
            ❌ <?= htmlspecialchars($mensaje_error) ?>
        </div>
    <?php endif; ?>
</div>

<div class="container">
    <div id="form" class="col-md-4">
        <!-- formulario u otros contenidos -->
    </div>
</div>

</body>
</html>
