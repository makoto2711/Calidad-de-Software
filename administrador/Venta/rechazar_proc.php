<?php
require_once "../../config/conectar.php";

if(!isset($_GET['id'])){
    header("location: index.php");
}
else
{
    $id = $_GET['id'];
    $sql1 = "DELETE FROM compra_cabecera WHERE id = $id";
    $query1 = mysqli_query($conexion, $sql1);

    $sql2 = "DELETE FROM compra_detalle WHERE idCompra = $id";
    $query2 = mysqli_query($conexion, $sql2);
    if ($query1) {
        $msg = "Venta rechazada";
        echo json_encode($msg);
    }
}