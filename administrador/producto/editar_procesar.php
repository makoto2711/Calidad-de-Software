<?php
require_once "../../config/conectar.php";

$mensaje = null;
 
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $presentacion = $_POST['presentacion'];

    $img = $_FILES['foto'];
    $name = $img['name'];
    $tmpname = $img['tmp_name'];

    $sql = "UPDATE producto SET nombre = '$nombre', descripcion = '$descripcion', idPresentacion = $presentacion, stock= $cantidad, precio=$precio WHERE idProducto=$id";
    $query = mysqli_query($conexion, $sql);

    if($tmpname != "")
    {//si no hay imagen que modificar
        if($query)
        {// si se actualizo los datos del producto

            $fecha = date("YmdHis");
            $foto = $fecha . ".jpg";
            $destino = "../../imgs/" . $foto;

            $sql_f = mysqli_query($conexion, "SELECT foto from imagen where idProducto = $id");//extraes el nombre de la imagen en la bd
            $fotoURL = mysqli_fetch_assoc($sql_f);
            
            $sql = "UPDATE imagen set foto = '$foto' where idProducto = $id";
            $query = mysqli_query($conexion, $sql);
                if(isset($fotoURL['foto']) && file_exists("../../imgs/".$fotoURL['foto'])){
                    unlink("../../imgs/".$fotoURL['foto']);
                }
                if (move_uploaded_file($tmpname, $destino)) {
                    $mensaje = "actualizado";
                    $msg = "Producto actualizado exitosamente";
                    /* header("location: index.php?msg=$msg"); exit; */
                }
        }
        else
        {
            $mensaje = "existente";
            $msg = "Producto ya existente";
            /* header("location: index.php?msg=$msg"); exit; */
        }
    }
    else
    { 
        $mensaje = "actualizado";
        $msg = "Producto actualizado exitosamente";
        /* header("location: index.php?msg=$msg"); exit; */ 
    } 


    echo json_encode($mensaje);

?>