<?php
require_once "../config/conectar.php";

$id = $_GET['id'];
$distrito = $_POST['distrito'];
$direccion = $_POST['direccion'];
$referencia = $_POST['referencia'];

$query = "UPDATE direccion set idDistrito = '$distrito', direccion = '$direccion', referencia = '$referencia' where id=$id ";
$sql = mysqli_query($conexion,$query);

header("location: perfil.php"); 
exit;
