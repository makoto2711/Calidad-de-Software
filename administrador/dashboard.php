<?php
session_start();//abre/inicias session
if(isset($_SESSION['id'])){//verifica si hay logeado
    if(isset($_SESSION['rol'])){
        if($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2){
            header("location: ../index.php");
            exit;
        }
    }else{
        header("location: ../index.php");
        exit;
    }
}else{
    header("location: ../index.php");
    exit;
}

require_once "../config/conectar.php";
include "asset/header.php";

$cant_usuarios_sql = "SELECT count(idUsuario) as cantidad FROM usuario
                        where idRol = 3";
$query = mysqli_query($conexion, $cant_usuarios_sql);
$cant_usu = 0;
while ($q = mysqli_fetch_assoc($query)) {
    $cant_usu = $q['cantidad'];
}


$prod_comp_sql = "SELECT CONCAT(p.nombre,' | ',pr.nombre) 'producto', sum(cd.cantidad) 'cantidad'
                    FROM compra_detalle as cd
                    INNER JOIN compra_cabecera as cb on cd.idCompra = cb.id
                    INNER JOIN producto as p on p.idProducto = cd.idProducto
                    INNER JOIN presentacion as pr on pr.idPresentacion = p.idPresentacion
                    WHERE cb.fechaCompra BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
                    GROUP BY cd.idProducto
                    ORDER BY sum(cd.cantidad) DESC";
$query_prods = mysqli_query($conexion, $prod_comp_sql);



$vent_sql = "SELECT count(cb.id) 'total' FROM compra_cabecera as cb
                    WHERE cb.estadoCompra = 'ENVIADO' and
                    cb.fechaCompra BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
$query_cerrados = mysqli_query($conexion, $vent_sql);
$cant_cerrados = 0;
while ($q = mysqli_fetch_assoc($query_cerrados)) {
    $cant_cerrados = $q['total'];
}


$vent_pend = "SELECT count(cb.id) 'total' FROM compra_cabecera as cb
                WHERE cb.estadoCompra = 'PENDIENTE'";
$query_pendientes = mysqli_query($conexion, $vent_pend);
$cant_pendientes = 0;
while ($q = mysqli_fetch_assoc($query_pendientes)) {
    $cant_pendientes = $q['total'];
}
    
$vent_aprob = "SELECT count(cb.id) 'total' FROM compra_cabecera as cb
                WHERE cb.estadoCompra = 'APROBADO'";
$query_aprobados = mysqli_query($conexion, $vent_aprob);
$cant_aprobados = 0;
while ($q = mysqli_fetch_assoc($query_aprobados)) {
    $cant_aprobados = $q['total'];
}

?>


<nav class="navbar navbar-light bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-white" >
      Dashboard
    </a>

    <?php
    if(isset($_SESSION['id']))
    {
        //verifica si hay logeado
    ?>
        <a class="btn text-white" href='../../logout.php'>Cerrar sesion</a>
    <?php
    }
    ?>


  </div>
</nav>


<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 mt-3 p-0">
                <aside>
                    <a class="bg-warning w-100 p-2 mt-2 btn text-dark" href="producto/index.php">Productos</a>
                    <a class="bg-warning w-100 p-2 mt-2 btn text-dark" href="Venta/index.php">Ventas</a>
                </aside>
            </div>

            <div class="col-8  mt-3">
                   <div class="row justify-content-end">

                        <div class="col-5">
                            <div class="card text-white bg-primary mb-3  w-100 ">
                                <div class="card-header"><h6>USUARIOS:</h6></div>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $cant_usu ?></h5>
                                </div>
                            </div>
                        </div>


                        <div class="col-5">
                            <div class="card text-white bg-secondary mb-3  w-100 ">
                                <div class="card-header"><h6>VENTAS CERRADAS ULTIMOS 30 DÍAS:</h6></div>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $cant_cerrados ?></h5>
                                </div>
                            </div>
                        </div>



                        <div class="col-5">
                            <div class="card text-white bg-dark mb-3  w-100 ">
                                <div class="card-header"><h6>VENTAS APROBADAS EN ESPERA DE ENVÍO: </h6></div>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $cant_aprobados ?></h5>
                                </div>
                            </div>
                        </div>


                        <div class="col-5">
                            <div class="card text-white bg-success mb-3  w-100 ">
                                <div class="card-header"><h6>VENTAS PENDIENTES DE APROBACIÓN: </h6></div>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php  echo $cant_pendientes ?></h5>
                                </div>
                            </div>
                        </div>


                 


                        

                   </div>


                   <div class="row mt-5 ">
                        <div class="col-12 ms-5" style="overflow:auto; height: 30vh">
                            <?php while ($q = mysqli_fetch_assoc($query_prods)) { ?>
                                <h5 class="card-title">Producto: <?php echo $q['producto'] ?></h5>
                                <p>Cantidad: <?php echo $q['cantidad'] ?></p>
                                <input type="range"  min="1"  value="<?php echo $q['cantidad'] ?>"  step="1"  max="100"  name="" id="" disabled >
                            
                            <?php } ?>    
                        </div>
                   </div>




            </div>
             
            



        </div>
    </div>
</main>

<!--  CANTIDAD USUARIOS  -->


<!--  VENTAS CERRADAS ULTIMOS 30 DIAS  -->


<!--  VENTAS APROBADAS  -->

 

<!--  VENTAS PENDIENTES  -->

 


<!--  PRODUCTOS VENDIDOS ULTIMO MES  -->



</body>
</html>