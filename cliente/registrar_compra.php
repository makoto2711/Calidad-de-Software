<?php
session_start();

require_once "../config/conectar.php";

$msg = "ERROR";

if(isset($_SESSION['id']) || isset($_SESSION['rol']) && $_SESSION['rol'] != 3 ){//verifica si hay logeado
  
    $input = json_decode(file_get_contents('php://input'), true);
    $idUser = $_SESSION['idUser'];

    $query = "INSERT into compra_cabecera (idUsuario) values ('$idUser')";
    $sql = mysqli_query($conexion,$query);

    $id_compra = $conexion->insert_id;

    foreach($input as $i){
        
        $idProd = $i['id'];
        $cantProd = $i['cont'];

        $query = "INSERT into compra_detalle (idCompra, idProducto, cantidad) values ('$id_compra','$idProd','$cantProd')";
        $sql = mysqli_query($conexion,$query);

    }

    $msg = "Compra registrada";
}
else{
    $msg = "No estas logueado";
}

echo json_encode($msg);
