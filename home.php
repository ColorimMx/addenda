<?php

session_start();
include 'functions.php';
verificar_sesion();

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
    <link rel="stylesheet" href="css/animate.css">
      <script   src="https://code.jquery.com/jquery-2.2.4.js"   integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="   crossorigin="anonymous"></script>
      <script src="js/bootstrap.min.js"></script>
      <script type="text/javascript"  src="js/file.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home".php">Colorim</a>
        </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <div class="bounceInRight animated">
          <button type="button" class="btn btn-lacomer navbar-btn " onclick="formComer()">La Comer</button>
          <button type="button" class="btn btn-primary navbar-btn " onclick="formNadro()">Nadro</button>
          <a href="salir.php"><button type="button" class="btn btn-danger navbar-btn ">Salir</button></a>
      </div>
    </div>
  </div>
</nav>
<div class="container">
  <div id="form" class="col-md-4">
  </div>
</div>
  </body>
</html>
