<?php

use Libreria\Autores;
use Libreria\Libros;
use Isbn\Isbn;

session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

$autores = (new Autores)->devolverAutores();

function hayError($t,$s,$i){
    $error=false;
    $isbn=new Isbn;
    if(strlen($i)==0 || !$isbn->validation->isbn13($i)){
        $error=true;
        $_SESSION['error_isbn']="Formato ISBN Incorrecto";
    }

    if(strlen($t)==0){
        $error=true;
        $_SESSION['error_titulo']="Campo título vacío";
    }

    if(strlen($s)<10){
        $error=true;
        $_SESSION['error_sinopsis']="Campo vacío o con pocos caracteres";
    }

    if((new Libros)->existeIsbn($i)){
        $error=true;
        $_SESSION['error_isbn']="Este ISBN ya existe!!";
    }

    return $error;
    
}


if(isset($_POST['crear'])){
    $titulo=trim(ucwords($_POST['titulo']));
    $sinopsis=trim(ucwords($_POST['sinopsis']));
    $isbn=trim(ucwords($_POST['isbn']));
    $autor=trim(ucwords($_POST['autor']));

    if(!hayError($titulo,$sinopsis,$isbn)){
    //Guardamos Libro
    (new Libros)->setTitulo($titulo)->setSinopsis($sinopsis)->setIsbn($isbn)->setAutor_id($autor)->create();
    header("Location:index.php");

    }else{
        header("location:clibro.php");

    }
    
}else{

    


?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Index Autores</title>
</head>
<!-- CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">




<style type="text/css">
    body {
        margin: 20px;
        background-color:#80ff80
    }

    h1 {
        font-family: 'Bebas Neue', cursive;
        font-size: 500%;
    }

    h3 {
        font-family: 'Bebas Neue', cursive;
        font-size: 250%;
        margin: 0;
        padding: 0;
    }

    h4 {
        font-family: 'Anton', sans-serif;
        font-size: 250%;

    }

    button {
        margin-bottom: 20px;
    }

    textarea:hover, select:hover, input:hover {
        background-color: #0080ff;
    }
</style>

<body>


    <form name="clibro" method="post" action="clibro.php">

        <div class="container">
        <div class="card w-50" style="border-radius:20px;color:white;padding:10px;background: linear-gradient(90deg, rgba(2,0,36,0.5) 0%, rgba(6,102,80,0.5) 35%, rgba(0,212,255,0.5) 100%);">

            <div class="card-header">
                <h4>Crear Libro</h4>
            </div>
            <div class="card-body">
            <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Titulo</label>
            <input type="text" class="form-control" name="titulo" id="exampleFormControlInput1" placeholder="Titulo">

            <?php 
            if(isset($_SESSION['error_titulo'])){
                echo <<<TXT
                <h5 style="color:red">{$_SESSION['error_titulo']}</h5>
                TXT;
                unset($_SESSION['error_titulo']);
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Resumen Libro</label>
            <textarea class="form-control" name="sinopsis" id="exampleFormControlTextarea1" rows="3"></textarea>
            <?php 

            if(isset($_SESSION['error_sinopsis'])){
                echo <<<TXT
                <h5 style="color:red">{$_SESSION['error_sinopsis']}</h5>
                TXT;
                unset($_SESSION['error_sinopsis']);

            }

            ?>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">ISBN Libro</label>
            <input type="text" class="form-control" name="isbn" id="exampleFormControlInput1" placeholder="ISBN">
            <?php 

            if(isset($_SESSION['error_isbn'])){
                echo <<<TXT
                <h5 style="color:red">{$_SESSION['error_isbn']}</h5>
                TXT;
                unset($_SESSION['error_isbn']);

            }

            ?>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">Selecciona un autor</label>
            <select name="autor" class="form-control form-control-sm">
                <?php
                foreach ($autores as $item) {
                    echo "<option value='{$item->id}'>{$item->apellidos}, {$item->nombre}</option>";
                }
                ?>

            </select>
        </div>
            </div>
            <div class="card-footer text-muted">
            <div>
               <button name="crear" class="btn btn-primary btn-lg" type="submit">Crear</button>
               <button class="btn btn-secondary btn-lg" type="reset">Borrar</button>
            </div>
            </div>
        </div>

        </div>

        

    </form>


</body>

</html>

<?php } ?>