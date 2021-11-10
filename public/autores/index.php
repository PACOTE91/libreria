<?php

session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Libreria\Autores;

(new Autores)->generarAutores(50);
$datosAutores = (new Autores)->read();
?>



<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Autores Autores</title>
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

#enviar {
  background-image: url('https://ep00.epimg.net/tecnologia/imagenes/2015/06/25/actualidad/1435248518_445335_1435251285_noticia_normal.jpg');
  background-size: cover;
}
  body {
    margin: 20px;
  }

  
  h4 {
    font-family: 'Anton', sans-serif;
    font-size: 300%;
  }  
 

   form,a,button {
    margin:0.1px;
    padding:0.1px;
    display:inline;

  } 


  tr:hover {
    background-color: #8000ff;
  }
</style>

<body style="background-color: #80ff00">

<h4>Autores</h4>


<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <a class="navbar-brand">Navegación</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="../index.php">Página de inicio <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="crea_autor.php">Crear nuevo autor</a>
                <a class="nav-item nav-link" href="../libro/index.php">Ir a Libros</a>
            </div>
        </div>
    </nav>

  <div class="container">
  <?php

if(isset($_SESSION['mensaje'])){
  echo '<div class="alert alert-success" role="alert">'.$_SESSION['mensaje'].'</div>';
  unset($_SESSION['mensaje']);

}
  ?>

<?php

  ?>

    <table class="table table-striped table-dark">

      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nombre</th>
          <th scope="col">Apellido</th>
          <th scope="col">Pais</th>
          <th scope="col">Acciones</th>

        </tr>
      </thead>
      <tbody>
        <?php
        //Fetch saca filas
        //Fetch_OBJ -> Manera de acceder a los campos en la fila
        //Fetch_ASOC->
        while ($fila = $datosAutores->fetch(PDO::FETCH_OBJ)) {
          echo <<<TEXTO
    <tr>
      <td>{$fila->id}</td>
      <td>{$fila->nombre}</td>
      <td>{$fila->apellidos}</td>
      <td>{$fila->pais}</td>
      <td>

      <div>      
        <form name='s' action='bautor.php' method='POST'>
              <input type='hidden' name='id' value='{$fila->id}'>
              <a href="uautor.php?id={$fila->id}" class="btn btn-warning"><i class="fas fa-user-edit"></i></a>
              <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea Borrar el Autor?')"><i class="fas fa-trash-alt"></i></button>
        </form>     
      </div>  
      
      
      </td>

    </tr>
   
    TEXTO;
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>