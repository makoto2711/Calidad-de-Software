<?php 
    require "../../config/conectar.php";
    
    $id = $_GET["id"];

    $sql = "SELECT  p.idProducto,
                    p.nombre as nombre,
                    p.descripcion,pr.nombre as 
                    PRnombre, p.stock, p.precio, i.foto 
                    FROM producto p inner JOIN presentacion pr 
                    on p.idPresentacion = pr.idPresentacion inner JOIN imagen i on 
                    p.idProducto = i.idProducto where p.estado = 1 and p.idProducto = $id";
               
    $query = mysqli_query($conexion,$sql); 
    $arr = mysqli_fetch_all($query, MYSQLI_ASSOC);
    
    echo json_encode($arr);