<?php
session_start();
if(!isset($_SESSION['id']) || !isset($_SESSION['rol'])){//verifica si hay logeado
    header("location: ../index.php"); exit;
}

require_once "../config/conectar.php";

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
   
    <style>
        label 
        {
            font-size: 20px;
            margin: 6px 0;
        }

        #datos_card
        {
            background: antiquewhite;
            box-shadow: 0 0 8px black;
            border-radius: 10px; 
        }






    </style>


</head>
<body>
    
<nav class="p-3 bg-dark">
    <a class="btn btn-secondary" href="../index.php">Inicio</a> 
</nav>


    <div class="container mt-5">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6" id="datos_card" >
                 <h1>Datos</h1>
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

                    <form class="my-4 text-center" action="editar_datos.php" method="post">
                        <input value="<?php echo $_SESSION['idUser'] ?>" name="user" hidden>
                        <input class="btn btn-primary fw-bolder w-50" id="datosForm" type="submit" value="Editar">
                    </form>

            </div>



            <div class="col-lg-3 text-center mt-4">
                 <h2>Direccion</h2>
                <?php foreach ($usuario_dir as $us_dir) { 
                    if($us_dir['direccion'] != null){?>
                    
                    <section class="mt-4 text-start " >
                        <h5 class="fw-bolder mb-2 ">Departamento: <span class="fw-light"><?php echo $us_dir['departamento']; ?></span> </h5>
                        <h5 class="fw-bolder mb-2 ">Provincia: <span class="fw-light"><?php echo $us_dir['provincia']; ?></span> </h5>
                        <h5 class="fw-bolder mb-2 ">Distrito: <span class="fw-light"><?php echo $us_dir['distrito']; ?></span> </h5>
                        <h5 class="fw-bolder mb-2 ">Dirección: <span class="fw-light"><?php echo $us_dir['direccion']; ?></span> </h5>
                        
                        <h5 class="fw-bolder mb-2"> Referencia: <span class="fw-light"><?php echo $us_dir['referencia']; ?></span> </h5>
                

                        <div class="mt-3 text-center" >
                            <a class="btn btn-warning" href="editar_direccion.php?id=<?php echo $us_dir['id']; ?>">Editar</a>
                            <a class="btn btn-danger" href="elim_dir_proc.php?id=<?php echo $us_dir['id']; ?>">Eliminar</a>
                        </div>

                    </section>                    

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