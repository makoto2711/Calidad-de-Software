<?php

session_start();
if(!isset($_SESSION['id']) || !isset($_SESSION['rol'])){//verifica si hay logeado
    header("location: ../index.php"); exit;
}

require_once "../config/conectar.php";

$id = $_POST['user'];

$query = "SELECT nombre,apellidos,correo,numero FROM usuario where idUsuario = $id";
$usuario = mysqli_query($conexion, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar datos</title>
    	   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
</head>
<body>
    
<nav class="p-3 bg-dark">
    <a class="btn btn-secondary" href="perfil.php">Regresar</a>
</nav>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
                <form action="edit_dat_proc.php?id=<?php echo $id ?>" method="post">
                <?php foreach ($usuario as $us){ ?> 
                    <label>Nombres: </label>
                    <input class="form-control" type="text" value="<?php echo $us['nombre'] ?>" name="nombre" required>
                    <br>
                    <label>Apellidos: </label>
                    <input class="form-control" type="text" value="<?php echo $us['apellidos'] ?>" name="apellido" required>
                    <br>
                    <label>Correo: </label><br>
                    <label><?php echo $us['correo'] ?></label>
                    <br>
                    <br>
                    <label>Numero: </label>
                    <input class="form-control" type="number" value="<?php echo $us['numero'] ?>" name="numero" required>
                    <br>

                    <div class="text-center">
                        <input type="submit" class="btn btn-success w-100" value="Guardar">
                    </div>

                <?php } ?>

                </form>
        </div>
    </div>
</div>



</body>
</html>