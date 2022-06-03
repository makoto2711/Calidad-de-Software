<?php
session_start();//abre/inicias session
if(isset($_SESSION['id'])){//verifica si hay logeado
    if(isset($_SESSION['rol'])){
      /*   echo $_SESSION['rol']; */
        switch($_SESSION['rol']){
            case 1:
                header("location: administrador/dashboard.php");
                exit;
                break;
            case 2:
                header("location: administrador/dashboard.php");
                exit;
                break;
            case 3:
                header("location: index.php");
                exit;
                break;
            default: 
                header("location: index.php");
                exit;
        }
    }
}
require_once "config/conectar.php";

if(isset($_POST['login'])){
    $user = $_POST['id'];
    $pass = $_POST['pass'];
       /*  echo $user; */
    $sql = "SELECT idUsuario,usuario,contraseña,nombre,idRol from usuario where usuario = '$user'";
    $resultado = mysqli_query($conexion,$sql);
    $num = mysqli_num_rows($resultado);
    
    if($num > 0){
        $row = mysqli_fetch_array($resultado);
        $pass_bd= $row['contraseña'];
        
        $pass_c = md5($pass);
        
        if($pass_bd == $pass_c){
            $_SESSION['idUser'] = $row['idUsuario'];//guardas variable en la sessiion
            $_SESSION['id'] = $row['usuario'];//guardas variable en la sessiion
            $_SESSION['nombre'] = $row['nombre'];//guardas variable en la sessiion
            $_SESSION['rol'] = $row['idRol'];//guardas variable en la sessiion
            
            if(isset($_SESSION['rol'])){
            /*     echo $_SESSION['rol']; */
                switch($_SESSION['rol']){
                    case 1:
                        header("location: administrador/dashboard.php");
                        exit;
                        break;
                    case 2:
                        header("location: administrador/dashboard.php");
                        exit;
                        break;
                    case 3:
                        header("location: index.php");
                        exit;
                        break;
                    default: 
                        header("location: index.php");
                        exit;
                }
            }
        }else{
            $_SESSION['msg_log'] = "Contraseña incorrecta";
        }
        
    }else{
        $_SESSION['msg_log'] = "Usuario incorrecto";
        //echo "No existe usuario";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .bg-login
    {
        background-color: #010000;
        border-radius: 12px;
    }

    main
    {
        background-color: #c3c3c3;
    }

</style>

</head>
<body>

<main class="vh-100 d-flex align-items-center justify-content-center">

<div class="col-lg-3">
    <form class="text-center w-100 bg-login p-4" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <div> 
            <input class="mb-3 p-2 form-control" type="text" name="id" placeholder="usuario" autocomplete="off"></td>
        </div>     
        <div> 
            <input class="mb-3 p-2 form-control" type="password" name="pass" placeholder="contraseña" autocomplete="off"></td>
        </div>     
        <div class="text-center">
            <input type="hidden" name="login" value="login">
            <button type="submit" class="btn btn-success">Iniciar sesión</button>
            <a href="cliente/registro.php" class="btn btn-primary"> Registro </a>
        </div> 
</form>
</div>

<?php 
 if(isset($_SESSION['msg_log']) && $_SESSION['msg_log']!="" ){
    $msg = $_SESSION['msg_log'];
    echo "<script type='text/javascript'>
                Swal.fire({
                    icon: 'error',
                    title: '<span style="."color:black".">$msg</span>',
                    background: 'white',
                    iconColor: 'black',
                    confirmButtonColor: 'RED',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    stopKeydownPropagation: true,
                    customClass:{
                        popup: 'alerta_contenedor'
                    }
                })
            </script> ";
            unset($_SESSION['msg_log']);
 }
 ?>

</main>


</body>
</html>

