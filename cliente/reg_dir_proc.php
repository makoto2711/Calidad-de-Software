<?php
require_once "../config/conectar.php";

$usuario = $_POST['user'];
$distrito = $_POST['distrito'];
$direccion = $_POST['direccion'];
$referencia = $_POST['referencia'];

$query = "INSERT into direccion (idUsuario,idDistrito,direccion,referencia) VALUES ('$usuario', '$distrito', '$direccion', '$referencia')";
$sql = mysqli_query($conexion,$query);

$mensaje = null;

if ($sql) 
{
    $mensaje = "exito";
}

echo json_encode($mensaje);