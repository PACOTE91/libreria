<?php

if(!isset($_POST['id'])){
    header("Location:index.php");
    die();
}

var_dump($_POST['id']);
session_start();
require dirname(__DIR__,2)."/vendor/autoload.php";
use Libreria\Autores;
(new Autores)->delete($_POST['id']);
$_SESSION['mensaje']="Autor borrado";
header("Location:index.php");

?>