<?php 
require_once "../../config/conectar.php";

$mensaje = null;

/* if(!isset($_GET['accion']) || $_GET['accion'] != "c"){
    header("location: ../../index.php");
}
else
{
 */ 
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


    $sql = "INSERT INTO producto (nombre, descripcion, idPresentacion, stock, precio) 
            VALUES ('$nombre', '$descripcion', $presentacion, $cantidad, $precio)";
    $query = mysqli_query($conexion,$sql);

    $idProd = $conexion->insert_id;

    if ($query) 
    {

        $sql = "INSERT INTO imagen (idProducto, foto) VALUES ('$idProd', '$foto')";
        $query = mysqli_query($conexion, $sql);

        if($query){
            if (move_uploaded_file($tmpname, $destino)) {
                $mensaje = "nuevo";
            }
        }
    }
    else
    {
        $mensaje = "existente";
        $msg = "Producto ya existente";         
    }  

    echo json_encode($mensaje);

/*  

}


 */


 ?>