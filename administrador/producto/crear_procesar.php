<?php 
require_once "../../config/conectar.php";

if(!isset($_GET['accion']) || $_GET['accion'] != "c"){
    header("location: ../../index.php");
}else{
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $presentacion = $_POST['presentacion'];
    $img = $_FILES['foto'];
    $name = $img['name'];
    $tmpname = $img['tmp_name'];
    $fecha = date("YmdHis");
    $foto = $fecha . ".jpg";
    $destino = "../../imgs/" . $foto;

    $sql = "INSERT INTO producto (nombre, descripcion, idPresentacion, stock, precio) VALUES ('$nombre', '$descripcion', $presentacion, $cantidad, $precio)";
    $query = mysqli_query($conexion,$sql);

    $idProd = $conexion->insert_id;

    if ($query) {

        $sql = "INSERT INTO imagen (idProducto, foto) VALUES ('$idProd', '$foto')";
        $query = mysqli_query($conexion, $sql);

        if($query){
            if (move_uploaded_file($tmpname, $destino)) {
                $msg = "Producto -$nombre- registrado exitosamente";
                header("location: index.php?msg=$msg"); exit; 
            }
        }
    }else{
        $msg = "Producto ya existente";
        header("location: index.php?msg=$msg"); exit;
    }
}
   


// if(isset($_GET['accion'])){
//     if($_GET['accion'] == "c"){

//         $nombre = $_POST['nombre'];
//         $descripcion = $_POST['descripcion'];
//         $cantidad = $_POST['cantidad'];
//         $precio = $_POST['precio'];
//         $presentacion = $_POST['presentacion'];
//         $img = $_FILES['foto'];
//         $name = $img['name'];
//         $tmpname = $img['tmp_name'];
//         $fecha = date("YmdHis");
//         $foto = $fecha . ".jpg";
//         $destino = "../../imgs/" . $foto;

//         $sql = "INSERT INTO producto (nombre, descripcion, idPresentacion, stock, precio) VALUES ('$nombre', '$descripcion', $presentacion, $cantidad, $precio)";
//         $query = mysqli_query($conexion,$sql);

//         $idProd = $conexion->insert_id;

//         if ($query) {

//             $sql = "INSERT INTO imagen (idProducto, foto) VALUES ('$idProd', '$foto')";
//             $query = mysqli_query($conexion, $sql);

//             if($query){
//                 if (move_uploaded_file($tmpname, $destino)) {
//                     echo "registro exitoso REDIRECCIONAR";
//                 }
//             }
//         }else{
//             echo  "falla  (en caso de que se registre 1 repetido nombre-presentacion) ALERTA/REDIRECCIONAR";
//         }
//     }
// }

?>