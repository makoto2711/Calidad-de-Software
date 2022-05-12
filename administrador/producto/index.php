<?php

session_start();//abre/inicias session

if(!isset($_SESSION['id']) || !isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)){//verifica si hay logeado
    header("location: ../../index.php"); exit;
}

require_once "../../config/conectar.php";
include "../asset/header.php";
?>

<nav class="p-3 bg-dark">
    <a class="btn btn-secondary me-3" href="../dashboard.php">Dashboard</a>
    <a class="btn btn-primary" href="crear.php">Nuevo producto</a>
</nav>

<?php if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
        echo "<h5> $msg </h5>";
    }   ?>

<div class="container mt-4">
    <div class="row">

    <div class="col-12">

    <h1 class="h3 mb-3 text-gray-800">Productos</h1>

    </div>

    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark" style="border: 10px #000">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Presentacion</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody style="border: 10px #000">
                    <?php
                    $sql = "SELECT p.idProducto,p.nombre as Pnombre,p.descripcion,pr.nombre as PRnombre, p.stock, p.precio, i.foto FROM producto p inner JOIN presentacion pr on p.idPresentacion = pr.idPresentacion inner JOIN imagen i on p.idProducto = i.idProducto where p.estado = 1";
                    $query = mysqli_query($conexion, $sql);
                    
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><img class="img-thumbnail" src="../../imgs/<?php echo $data['foto']; ?>" width="50"></td>
                            <td><?php echo $data['Pnombre']; ?></td>
                            <td><?php echo $data['descripcion']; ?></td>
                            <td><?php echo $data['PRnombre']; ?></td>
                            <td><?php echo $data['stock']; ?></td>
                            <td><?php echo $data['precio']; ?></td>
                            <td>
                                <a class="btn btn-warning" href= "editar.php?id=<?php echo $data['idProducto']; ?>"> Editar </a>
                                <a class="btn btn-danger" href= "eliminar_procesar.php?accion=d&id=<?php echo $data['idProducto']; ?>"> Eliminar </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

                    </body>
                    </html>