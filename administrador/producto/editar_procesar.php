<?php
require_once "../../config/conectar.php";

if(!isset($_GET['accion']) || $_GET['accion'] != "e"){
    header("location: ../../index.php");exit;
}else{
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

    if($tmpname != ""){//si no hay imagen que modificar
        if($query){// si se actualizo los datos del producto

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
                    $msg = "Producto actualizado exitosamente";
                    header("location: index.php?msg=$msg"); exit;
                }
        }else{
            $msg = "Producto ya existente";
            header("location: index.php?msg=$msg"); exit;
        }
    }else{ 
        $msg = "Producto actualizado exitosamente";
        header("location: index.php?msg=$msg"); exit; 
    }
}


// if(!isset($_GET['accion'])){
//     //retornar vista
// }elseif($_GET['accion'] == "e"){

//     $id = $_POST['id'];
//     $nombre = $_POST['nombre'];
//     $descripcion = $_POST['descripcion'];
//     $cantidad = $_POST['cantidad'];
//     $precio = $_POST['precio'];
//     $presentacion = $_POST['presentacion'];

//     $img = $_FILES['foto'];
//     $name = $img['name'];
//     $tmpname = $img['tmp_name'];

//     $query = mysqli_query($conexion,
//     "UPDATE producto 
//     SET nombre = '$nombre', 
//     descripcion = '$descripcion',
//     idPresentacion = $presentacion , 
//     stock= $cantidad ,
//     precio=$precio 
//     WHERE idProducto=$id");

    

//     if($tmpname != ""){
//         if($query){

            
//             $fecha = date("YmdHis");
//             $foto = $fecha . ".jpg";
//             $destino = "../../imgs/" . $foto;

//             $query_f = mysqli_query($conexion, "SELECT foto from imagen where idProducto = $id");//extraes el nombre de la imagen en la bd
//             $fotoURL = mysqli_fetch_assoc($query_f);
            
//             $query = mysqli_query($conexion, "UPDATE imagen set foto = '$foto' where idProducto = $id");
//             if($query){
//                 if(isset($fotoURL['foto'])){

//                     if(file_exists("../../imgs/".$fotoURL['foto'])){
//                         unlink("../../imgs/".$fotoURL['foto']);
//                     }else{
//                         echo "no hay coincidencia de nombre con los archivados ALERTA / REDIRECCION";
//                     }

//                     if (move_uploaded_file($tmpname, $destino)) {
//                         //header('Location: index.php');
//                         echo "registro exitoso, REDIRECCIONAR";
//                     }
//                 }
//             }else{
//                 echo "no actualizo la tabla imagen ??REDIRECCIONAR??";
//             }

//         }else{
//             echo "no paso actualizo la parte de productos REDIRECCIONAR";//por lo tanto regresar vista
//         }

//     }else{ 
//         echo "no hubo necesidad de actualizar foto EXITO y REDIRECCIONAR";  
//     }


      
// }else{
//         //retornar vista
// }


?>