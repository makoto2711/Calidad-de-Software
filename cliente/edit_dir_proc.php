<?php
require_once "../config/conectar.php";

$id = $_POST['id'];
$distrito = $_POST['distrito'];
$direccion = $_POST['direccion'];
$referencia = $_POST['referencia'];

$mensaje = null;


$query = "UPDATE direccion set idDistrito = '$distrito', direccion = '$direccion', referencia = '$referencia' where id=$id ";
$sql = mysqli_query($conexion,$query);


if ($sql) 
{
    $mensaje = "exito";
}


echo json_encode($mensaje);