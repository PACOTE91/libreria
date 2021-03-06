<?php

if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
} else {
    $id = $_GET['id'];
}

session_start();
//Bajar directorio
require dirname(__DIR__, 2) . "/vendor/autoload.php";
//Vamos a usar a Autores

use Libreria\Autores;

$datosAutor = (new Autores)->read_id($id);


function hayError($n, $a, $p)
{
    $error = false;

    if (strlen($n) == 0) {
        $_SESSION['error_nombre'] = "Rellena el campo nombre";
        $error = true;
    }

    if (strlen($a) == 0) {
        $_SESSION['error_apellido'] = "Rellena el campo apellido";
        $error = true;
    }

    if (strlen($p) == 0) {
        $_SESSION['error_pais'] = "Rellena el campo pais";
        $error = true;
    }

    return $error;
}

if (isset($_POST['actualizar'])) {
    $nombre = trim(ucwords($_POST['nombre']));
    $apellidos = trim(ucwords($_POST['apellidos']));
    $pais = trim(ucwords($_POST['pais']));

    var_dump($nombre);


    if (!hayError($nombre, $apellidos, $pais)) {
        (new Autores)->setNombre($nombre)->setApellidos($apellidos)->setPais($pais)->setID($id)->update();
        $_SESSION['mensaje'] = "Autor actualizado con exito";
        header('Location:index.php');
        die();
    } else {
        header("Location:{$_SERVER['PHP_SELF']}?id=$id");
    }
} else {


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

        input:hover {
            background-color: #000000;
        }
    </style>

    <body style="background-color: #80ff00">

        <h4>Actualizar autor</h4>

        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <a class="navbar-brand">Navegaci??n</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="../index.php">P??gina de inicio <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="index.php">Volver a Autores</a>
                    <a class="nav-item nav-link" href="../libro/index.php">Ir a Libros</a>
                </div>
            </div>
        </nav>

        <div class="container w-50">
            <div class="bg-success p-4 text-white rounded shadow-lg m-auto">
                <form name="formulario" action=<?php echo $_SERVER['PHP_SELF'] . "?id=$id"; ?> method="POST">


                    <div class="form-group">
                        <label for="1">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="1" value=<?php echo $datosAutor->nombre ?> placeholder="Introduce tu nombre">
                        <?php
                        if (isset($_SESSION['error_nombre'])) {
                            echo "Error al introducir el nombre";
                            unset($_SESSION['error_nombre']);
                        }
                        ?>

                    </div>

                    <div class="form-group">
                        <label for="2">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" value=<?php echo $datosAutor->apellidos ?> id="2" placeholder="Introduce tu apellido">
                        <?php
                        if (isset($_SESSION['error_apellido'])) {
                            echo "Error al introducir los apellidos";
                            unset($_SESSION['error_apellido']);
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="3">Pais</label>
                        <input type="text" class="form-control" name="pais" id="3" value=<?php echo $datosAutor->pais ?> placeholder="Introduce el pais">
                        <?php
                        if (isset($_SESSION['error_pais'])) {
                            echo "Error al introducir pais";
                            unset($_SESSION['error_pais']);
                        }
                        ?>

                    </div>

                    <div>
                        <button type='submit' name="actualizar" class="btn btn-info"><i class="fas fa-user-edit"></i> Actualizar</button>
                        <a href="index.php" class="btn btn-primary"><i class="fas fa-backward"></i> Volver</a>
                    </div>
                </form>
            </div>

        </div>


    </body>

    </html>



<?php } ?>