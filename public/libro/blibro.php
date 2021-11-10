<?php

if(!isset($_POST['id'])){
    header("Location:index.php");
    die();
}

session_start();
require dirname(__DIR__,2)."/vendor/autoload.php";
use Libreria\Libros;
(new Libros)->delete($_POST['id']);
$_SESSION['mensaje']="Libro borrado";
header("Location:index.php");

?>