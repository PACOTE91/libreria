<?php

if (!isset($_GET['id'])) {
    header('location:index.php');
    die();
}

require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Libreria\Libros;

$datosLibro = (new Libros)->read($_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle Libro</title>
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
        background: linear-gradient(90deg, rgba(180, 0, 36, 0.6) 0%, rgba(200, 9, 121, 0.6) 35%, rgba(150, 212, 255, 0.6) 100%);
    }

    h1 {
        font-family: 'Bebas Neue', cursive;
        font-size: 500%;
    }

    h3 {
        font-family: 'Bebas Neue', cursive;
        font-size: 250%;        
    }

    h4 {
        font-family: 'Anton', sans-serif;
    }

    button {
        margin-bottom: 20px;
    }

    div {
        margin-left: auto;
        margin-right: auto;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }
</style>
<div class="card w-50" style="border-radius:20px;color:white;padding:10px;background: linear-gradient(90deg, rgba(2,0,36,0.5) 0%, rgba(9,9,121,0.5) 35%, rgba(0,212,255,0.5) 100%);">
    <h1>Detalle Libro <?php echo $datosLibro->id ?></h1>
    <img class="card-img-top" src="https://imagenes.20minutos.es/files/article_amp/uploads/imagenes/2020/04/23/dia-del-libro.jpeg" height=300 alt="Card image cap">
    <div class="card-body">
        <h4><?php echo $datosLibro->titulo ?></h4>
        <p class="card-text">Autor: <?php echo $datosLibro->nombre . " " . $datosLibro->apellidos ?>
            <a href="filtro.php?value=<?php echo $datosLibro->autor_id ?>&campo=autor_id" class="p-1 rounded-pill bg-warning" style="text-decoration:none">Otros Libros de este Autor</a>
        </p>
        <p class="card-text">ISBN: <?php echo $datosLibro->isbn ?></p>
        <p class="card-text">Sinpsis: <?php echo $datosLibro->sinopsis ?></p>
        <p class="card-text">Pais: <?php echo $datosLibro->pais ?>
            <a href="filtro.php?value=<?php echo $datosLibro->pais ?>&campo=pais" class="p-1 rounded-pill bg-danger" style="text-decoration:none">Libros de mismo Pais</a>
        </p>

        <a href="index.php" class="link-primary">Volver a Autores</a>


    </div>
</div>



</body>

</html>