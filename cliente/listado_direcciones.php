<?php
// session_start();

require_once "../config/conectar.php";


// if(isset($_SESSION['id']) || isset($_SESSION['rol']) || $_SESSION['rol'] == 3 ){//verifica si hay logeado
  
//     $idUser = $_SESSION['idUser'];

    $query = "SELECT d.id, dep.nombre 'departamento', pr.nombre 'provincia', dis.nombre 'distrito', d.direccion, d.referencia FROM direccion as d
    INNER JOIN distrito as dis on dis.id = d.idDistrito
    INNER JOIN provincia as pr on pr.id = dis.idProvincia
    INNER JOIN departamento as dep on dep.id = pr.idDepartamento
    where d.idUsuario = 2";

    $dir = mysqli_query($conexion,$query);
/*     $direcciones = Array();
    while($d = $dir->fetch_assoc()){
        array_push($direcciones,$d);
    }
 */
    $arr = mysqli_fetch_all($dir, MYSQLI_ASSOC);

    echo json_encode($arr);

//    print_r($direcciones);



    // }

// echo json_encode();
