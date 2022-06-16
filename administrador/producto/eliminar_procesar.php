<?php
require_once "../../config/conectar.php";

if(!isset($_GET['accion']) || $_GET['accion'] != "d"){
    header("location: ../../index.php");
}
else
{
    $id = $_GET['id'];
    $sql = "UPDATE producto SET estado = 0 WHERE idProducto = $id";
    $query = mysqli_query($conexion, $sql);
    if ($query) {
        $msg = "Producto eliminado exitosamente";
        echo json_encode($msg);
    }
}
