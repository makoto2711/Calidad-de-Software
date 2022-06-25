<?php
session_start();
require_once "../config/conectar.php";

    $id = $_SESSION['idUser'];

    $sql_detalle = "SELECT c.idProducto 'id',
c.cantidad 'cont',
pr.precio 'price',
CONCAT('http://software.test/imgs/',i.foto) 'image',
CONCAT(pr.nombre,' | ',p.nombre) 'name'
FROM carrito as c
INNER JOIN producto as pr on pr.idProducto = c.idProducto
INNER JOIN imagen as i on i.idProducto = pr.idProducto
INNER JOIN presentacion as p on p.idPresentacion = pr.idPresentacion
WHERE idUsuario = $id";
    $query_detalle = mysqli_query($conexion, $sql_detalle);

    $arr_cabecera = mysqli_fetch_all($query_detalle, MYSQLI_ASSOC);

    echo json_encode($arr_cabecera);
