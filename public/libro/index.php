<?php

session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Libreria\Libros;
use Milon\Barcode\DNS1D;
$cb=new DNS1D();
$cb->setStorPath(__DIR__.'/cache/');



(new Libros)->generarLibros(150);
$stmt = (new Libros)->readAll();


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Autores</title>
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
    }

    button {
        margin-bottom: 20px;
    }
</style>

<body style="background-color: #80ff00">

    <body style="background-color: #d02f6b">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Navegación</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="../index.php">Página de inicio <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="../autores/index.php">Autores</a>
                </div>
            </div>
        </nav>

        <?php 
        
        if(isset($_SESSION['mensaje'])){
            echo '<div class="alert alert-success" role="alert">'.$_SESSION['mensaje'].'</div>';
            unset($_SESSION['mensaje']);
          
          }
        
        ?>

        <div style="margin-top: 8pt; margin-bottom:8pt">
            <a href="clibro.php" class="btn btn-info"><i class="fas fa-book-medical"></i>Crear Libro</a>
        </div>

        <table class="table table-sm table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Detalle</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Sinopsis</th>
                    <th scope="col">Autor ID</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $item=$fila->isbn;
                    $titulo=$fila->titulo;
                    $sinopsis=$fila->sinopsis;
                    $autor_id=$fila->autor_id;
                echo <<<TXT

                <tr>
                    <th style='padding: 15pt;' scope="row"><a href="dlibro.php?id={$fila->id}" style="text-decoration:none">{$cb->getBarcodeHTML("$item",'EAN13',2,66,'white', true)}</a></th>
                    <td>{$titulo}</td>
                    <td>{$sinopsis}</td>
                    <td>{$autor_id}</td>
                    <td>
                        <div>      
                            <form name='s' action='blibro.php' method='POST'>
                                <input type='hidden' name='id' value='{$fila->id}'>
                                <a href="ulibro.php?id={$fila->id}" class="btn btn-warning"><i class="fas fa-user-edit"></i></a>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea Borrar el Autor?')"><i class="fas fa-trash-alt"></i></button>
                            </form>     
                        </div>  
                    
                    </td>
                </tr>

                
                
            
                TXT;
            }
             ?>   
            </tbody>
            
        </table>

       





    </body>

</html>