<?php
require_once "../../config/conectar.php";

if(!isset($_GET['id'])){
    header("location: index.php");
}
else
{
    $id = $_GET['id'];
    $sql = "UPDATE compra_cabecera SET estadoCompra = 'APROBADO' WHERE id = $id";
    $query = mysqli_query($conexion, $sql);
    if ($query) {
        $msg = "Venta aprobada";
        echo json_encode($msg);
    }
}