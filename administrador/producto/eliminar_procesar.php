<?php
require_once "../../config/conectar.php";

if(!isset($_GET['accion']) || $_GET['accion'] != "d"){
    header("location: ../../index.php");
}else{
    $id = $_GET['id'];
    $sql = "UPDATE producto SET estado = 0 WHERE idProducto = $id";
    $query = mysqli_query($conexion, $sql);
    if ($query) {
        $msg = "Producto eliminado exitosamente";//cambiar por alerta JS
        header("location: index.php?msg=$msg"); exit;
    }
}



// if(isset($_GET['accion'])){
//     if($_GET['accion'] == "d"){
//         if (!empty($_GET['id'])) {
//             $id = $_GET['id'];
//                 $sql = "UPDATE producto SET estado = 0 WHERE idProducto = $id";
//                 $query = mysqli_query($conexion, $sql);
//                 if ($query) {
//                     echo "eliminado(deshabilitado) REDIRECCIONAR";
//                 }
//         }else{
//             echo "no hay id enviado ALERTA/REDIRECCIONAR";
//         }
//     }
// }

?>