<?php

require_once "../../config/conectar.php";

$arr2 = null;


if(!isset($_GET['id'])){
    header("location: index.php");
}
else
{
    $id = $_GET['id'];

    $sql_detalle = "SELECT CONCAT(p.nombre,' ',pr.nombre) 'producto', cd.cantidad 
                    FROM compra_detalle as cd
                    INNER JOIN compra_cabecera as cc on cc.id = cd.idCompra
                    INNER JOIN producto as p on p.idProducto = cd.idProducto
                    INNER JOIN presentacion as pr on pr.idPresentacion = p.idPresentacion
                    WHERE cd.idCompra = $id";
    $query_detalle = mysqli_query($conexion, $sql_detalle);

    $sql_cabecera = "SELECT CONCAT(us.nombre,' ',us.apellidos) 'cliente',
                        cc.fechaCompra, cc.valTotal,
                        CONCAT(dp.nombre,' ',pr.nombre,' ',dis.nombre,' ',dir.direccion,' ',dir.referencia) 'direccion',
                        cc.estadoCompra
                        FROM compra_cabecera as cc
                        INNER JOIN usuario as us on us.idUsuario = cc.idUsuario
                        INNER JOIN direccion as dir on dir.id = cc.idDireccion
                        INNER JOIN distrito as dis on dis.id = dir.idDistrito
                        INNER JOIN provincia as pr on pr.id = dis.idProvincia
                        INNER JOIN departamento as dp on dp.id = dis.idDepartamento
                        WHERE cc.id = $id";
    $query_cabecera =  mysqli_query($conexion, $sql_cabecera);         
    

    $arr_detalle = mysqli_fetch_all($query_detalle, MYSQLI_ASSOC);
    $arr_cabecera = mysqli_fetch_all($query_cabecera, MYSQLI_ASSOC);

    $arr2 = Array( $arr_detalle, $arr_cabecera );
 

}
   echo json_encode($arr2);
