<?php
session_start();

$msg = "ERROR";

if(isset($_SESSION['id']) || isset($_SESSION['rol']) || $_SESSION['rol'] != 3 ){//verifica si hay logeado
  
    $input = json_decode(file_get_contents('php://input'), true);
    $idUser = $_SESSION['idUser'];
    $idProd = $input['id'];
    $cantProd = $input['cont'];

    //delete
    $query = "DELETE FROM carrito where idUsuario=$idUser and idProducto=$idProd";
    $sql = mysqli_query($conexion,$query);

    //insert
    $query = "INSERT into carrito (idUsuario,idProducto,cantidad) values ('$idUser','$idProd','$cantProd')";
    $sql = mysqli_query($conexion,$query);

    $msg = "REGISTRADO $idUser, $idProd, $cantProd";
}

echo json_encode($input["id"]);

