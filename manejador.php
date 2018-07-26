<?php
/**
 * Created by PhpStorm.
 * User: pabloamador
 * Date: 24/07/18
 * Time: 16:39
 */

session_start();
include 'functions.php';
verificar_sesion();

if (isset($_POST['submit'])) {
    $username = "Colorim";
    $password = "123";
    if ( (isset($_POST['user'])) || (isset($_POST['password']) ) ){

        $nombre = $_POST['user'];
        $pass = $_POST['password'];

        if (($nombre == $username) && ($pass == $password)) {
            //crear nuestra sesion
            $_SESSION['username'] = $nombre;
            header("location: home.php");

        }else{
            header("location: index.php?res=incorrecto");
        }



    }else{
        header("location: index.php");
    }

}else{
    header("location: index.php");
}



?>