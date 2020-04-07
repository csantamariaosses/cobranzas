<?php
session_start();
$accion = $_POST['accion'];
//echo "<br>accion:".$accion;


if( strcmp($accion,"salir") == 0) {
    //echo "salir";
    $_SESSION['rutusu'] = null;
    header('Location: index.php');
    exit();
}