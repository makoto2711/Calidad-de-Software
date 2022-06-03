<?php
session_start();
if(!isset($_SESSION['id']) || !isset($_SESSION['rol'])){//verifica si hay logeado
    header("location: ../index.php"); exit;
}

require_once "../config/conectar.php";
//echo $_SESSION['nombre']; contenedor del nombre

$query = "SELECT nombre,apellidos,correo,numero FROM usuario where usuario = '".$_SESSION['id']."'";
$usuario = mysqli_query($conexion, $query);

$query = "SELECT dir.direccion,
dir.referencia,
de.nombre as departamento,
pr.nombre as provincia,
dis.nombre as distrito,
dir.id
FROM usuario as us
left JOIN direccion as dir on dir.idUsuario = us.idUsuario
LEFT JOIN distrito as dis on dis.id = dir.idDistrito
LEFT JOIN provincia as pr on pr.id = dis.idProvincia
LEFT JOIN departamento as de on de.id = dis.idDepartamento
where us.usuario = '".$_SESSION['id']."'";

$usuario_dir = mysqli_query($conexion, $query);


foreach ($usuario as $us) {
    $nombre = $us['nombre'];
    $apellidos = $us['apellidos'];
    $correo = $us['correo'];
    $numero = $us['numero'];
}


// foreach ($usuario_dir as $us_dir) {
//     $dir = $us_dir['direccion'];
// }
// if($dir==null){
//     echo "vacio";
// }else{
//     echo "no vacio";
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Usuario</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
</head>
<body>
    



<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 ">
                 <h3>Datos</h3>
                    <label class="fw-bolder" >Nombres: </label>
                        <label ><?php echo $nombre ?></label>
                        <br>
                    <label class="fw-bolder" >Apellidos: </label>
                        <label ><?php echo $apellidos ?></label>
                        <br>
                    <label class="fw-bolder" >Correo: </label>
                        <label ><?php echo $correo ?></label>
                        <br>
                    <label class="fw-bolder" >Numero: </label>
                        <label ><?php echo $numero ?></label>
                        <br>

                    <form class="my-3" action="editar_datos.php" method="post">
                        <input value="<?php echo $_SESSION['idUser'] ?>" name="user" hidden>
                        <input class="btn btn-secondary fw-bolder" type="submit" value="Editar">
                    </form>

            </div>

            <div class="col-12 text-center">
                 <h3>Direccion</h3>
                <?php foreach ($usuario_dir as $us_dir) { 
                    if($us_dir['direccion'] != null){?>
                        <label class="fw-bolder"> <?php echo $us_dir['departamento'].", ".$us_dir['provincia'].", ".$us_dir['distrito'].", ".$us_dir['direccion']; ?>  </label>
                        <br>
                        <label class="fw-bolder"> Referencia: <?php echo $us_dir['referencia']; ?> </label>
                        <br>
                        <br>    
                        <a class="btn btn-warning" href="editar_direccion.php?id=<?php echo $us_dir['id']; ?>">Editar</a>
                        <a class="btn btn-danger" href="elim_dir_proc.php?id=<?php echo $us_dir['id']; ?>">Eliminar</a>
                        <br>
                <?php } } ?>
                <form action="registrar_direccion.php" class="mt-5" method="post">
                    <input value="<?php echo $_SESSION['idUser'] ?>" name="user" hidden>
                    <input class="btn btn-primary" type="submit" value="Añadir dirección">
                </form>
            </div>


        </div>
    </div>

    



   
    










</body>
</html>