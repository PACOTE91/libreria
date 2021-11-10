<?php
if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}

$id = $_GET['id'];

session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Libreria\{Autores, Libros};
use Isbn\Isbn;

$esteLibro = (new Libros)->read($id);

$autores = (new Autores)->devolverAutores();
function hayError($t, $i, $s)
{
    global $id;
    $error = false;
    $isbn = new Isbn;
    if (strlen($i) == 0 || !$isbn->validation->isbn13($i)) {
        $error = true;
        $_SESSION['error_isbn'] = "Formato ISBN Incorrecto";
    }
    if ((new Libros)->setId($id)->existeIsbn($i)) {
        $error = true;
        $_SESSION['error_isbn'] = "Este ISBN ya está dado de alta !!!!";
    }
    if (strlen($t) == 0) {
        $error = true;
        $_SESSION['error_titulo'] = "Rellene el título !!!";
    }
    if (strlen($s) <= 5) {
        $error = true;
        $_SESSION['error_sinopsis'] = "Este campo debe contener al menos 10 caracteres";
    }
    return $error;
}

if (isset($_POST['btnUpdate'])) {
    $titulo = trim(ucwords($_POST['titulo']));
    $sinopsis = trim(ucfirst($_POST['sinopsis']));
    $isbn = trim($_POST['isbn']);
    $autor_id = $_POST['autor_id'];
    if (!hayError($titulo, $isbn, $sinopsis)) {
        (new Libros)->setTitulo($titulo)
            ->setSinopsis($sinopsis)
            ->setIsbn($isbn)
            ->setAutor_id($autor_id)
            ->update($id);
        $_SESSION['mensaje'] = "Libro Actualizado.";
        header("Location:index.php");
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
        background: linear-gradient(90deg, rgba(256, 0, 36, 0.9) 0%, rgba(180, 9, 121, 0.9) 35%, rgba(0, 212, 255, 0.9) 100%);
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
    img{
        margin:auto;
        width: 50%;
        height: 40%;
    }

    h4 {
        font-family: 'Anton', sans-serif;
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
<div class="card w-50" style="border-radius:20px;color:white;padding:10px;background: linear-gradient(90deg, rgba(2,0,36,0.5) 0%, rgba(6,102,80,0.5) 35%, rgba(0,212,255,0.5) 100%);">
    <h3>Actualizar libro <?php echo $_GET['id'] ?></h3>
    <img  src="https://imagenes.20minutos.es/files/article_amp/uploads/imagenes/2020/04/23/dia-del-libro.jpeg" alt="Card image cap">

    <form name="clibro" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?id=$id" ?>">
                    <div class="mb-3">
                        <label for="t" class="form-label">Título Libro</label>
                        <input type="text" class="form-control" id="t" placeholder="Título" name="titulo" required value="<?php echo $esteLibro->titulo ?>" />
                        <?php
                        if (isset($_SESSION['error_titulo'])) {
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_titulo']}
                            </div>
                            TXT;
                            unset($_SESSION['error_titulo']);
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="s" class="form-label">Resumen Libro</label>
                        <textarea class="form-control" id="s" rows="2" name="sinopsis"><?php echo $esteLibro->sinopsis ?></textarea>
                        <?php
                        if (isset($_SESSION['error_sinopsis'])) {
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_sinopsis']}
                            </div>
                            TXT;
                            unset($_SESSION['error_sinopsis']);
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="i" class="form-label">ISBN Libro</label>
                        <input maxlength=13 type="text" class="form-control" id="i" placeholder="ISBN" name="isbn" required value="<?php echo $esteLibro->isbn ?>">
                        <?php
                        if (isset($_SESSION['error_isbn'])) {
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_isbn']}
                            </div>
                            TXT;
                            unset($_SESSION['error_isbn']);
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="a" class="form-label">Autor</label>
                        <select class="form-select" name="autor_id" id="a">
                            <?php
                            foreach ($autores as $item) {
                                if ($item->id == $esteLibro->autor_id) {
                                    echo "\n<option value='{$item->id}' selected>{$item->apellidos}, {$item->nombre}</option>";
                                } else {
                                    echo "\n<option value='{$item->id}'>{$item->apellidos}, {$item->nombre}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type='submit' name="btnUpdate" class="btn btn-info"><i class="fas fa-edit"></i> Editar</button>
                        <a href="index.php" class="btn btn-primary"><i class="fas fa-backward"></i> Volver</a>
                    </div>

                </form>

    </div>



</div>
</div>



</body>

</html>
<?php } ?>