<?php
session_start();

require_once "../config/conectar.php";

$msg = "ERROR";

if(isset($_SESSION['id']) || isset($_SESSION['rol']) && $_SESSION['rol'] == 3 ){//verifica si hay logeado
  
    $input = json_decode(file_get_contents('php://input'), true);
    $idUser = $_SESSION['idUser'];

    $productos = $input['items'];
    $direccion = $input['dire'];
    $total = $input['total'];


    $query = "INSERT into compra_cabecera (idUsuario,idDireccion,valTotal) values ('$idUser','$direccion','$total')";
    $sql = mysqli_query($conexion,$query);
    
    $query = "DELETE FROM carrito where idUsuario=$idUser";
    $sql = mysqli_query($conexion,$query);
    if(!$sql){
        $msg = "Error al insertar cabecera";
        
    }
    else{
        $msg = "Compra registrada";
    }

    $id_compra = $conexion->insert_id;

    foreach($productos as $i){
        
        $idProd = $i['id'];
        $cantProd = $i['cont'];

        $query = "INSERT into compra_detalle (idCompra, idProducto, cantidad) values ('$id_compra','$idProd','$cantProd')";
        $sql = mysqli_query($conexion,$query);

    }

    
}
else{
    $msg = "No estas logueado";
}

echo json_encode($msg);
