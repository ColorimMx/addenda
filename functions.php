<?php
/**
 * Created by PhpStorm.
 * User: pabloamador
 * Date: 24/07/18
 * Time: 16:27
 */


function verificar_sesion(){
    if (!isset($_SESSION['username'])){
        unset($_SESSION);
        header("location: index.php");
    }
}