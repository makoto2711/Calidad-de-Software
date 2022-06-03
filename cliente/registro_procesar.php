<?php

require_once "../config/conectar.php";

  $message = '';
if (!empty($_POST)){
    if (!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['conf_pass']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['numero']) && !empty($_POST['email'])) {
        $usuario = $_POST['user'];
        $contra = $_POST['pass'];
        $contra_conf = $_POST['conf_pass'];
        $nombres = $_POST['nombre'];
        $apellidos = $_POST['apellido'];
        $numero = $_POST['numero'];
        $email = $_POST['email'];

        $val_usuario = "SELECT usuario from usuario where usuario = '$usuario'";
        $val_email = "SELECT correo from usuario where correo = '$email'";

        $q_val_usuar = mysqli_query($conexion,$val_usuario);
        $q_val_email = mysqli_query($conexion,$val_email);

        $insertar = true;

        if(mysqli_num_rows($q_val_usuar) > 0){
            echo "usuario repetido";
            $insertar = false;
        }
        if(mysqli_num_rows($q_val_email) > 0){
            echo "email repetido";
            $insertar = false;
        }
        
        if($insertar){
            $contrasena = md5($contra);
            $query_ins = "INSERT into usuario (usuario,contraseña,nombre,apellidos,numero,correo,idRol) 
                            values ('$usuario','$contrasena','$nombres','$apellidos','$numero','$email','3')";
            $insertar = mysqli_query($conexion,$query_ins);
            if ($insertar) {
                $message = 'Registro exitoso';
            }   
        }
    }
}
?>
