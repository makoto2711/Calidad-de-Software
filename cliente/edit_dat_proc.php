<?php
require_once "../config/conectar.php";

$id = $_GET['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$numero = $_POST['numero'];

$query = "UPDATE usuario set nombre = '$nombre', apellidos = '$apellido', numero = '$numero' where idUsuario=$id ";
$sql = mysqli_query($conexion,$query);

header("location: perfil.php"); 
exit;
