<?php
require_once "../config/conectar.php";

$id = $_GET['id'];

$query = "DELETE FROM direccion where id=$id ";
$sql = mysqli_query($conexion,$query);

header("location: perfil.php"); exit;

?>