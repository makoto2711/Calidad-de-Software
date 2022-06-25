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
</nav>


<div class="container mt-4">
    <div class="row">

    <div class="col-12">

    <h1 class="h3 mb-3 text-gray-800">Ventas</h1>

    </div>

    <div class="col-lg-12">
        <div class="table-responsive">

            <table class="table table-hover table-bordered"  id="tabla" style="width: 100%;">
                <thead class="thead-dark" style="border: 10px #000">
                    <tr>
                        <th></th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Direccion</th>
                        <th>Valor</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody style="border: 10px #000">
                    <?php
                    $sql = "SELECT cc.id, CONCAT(us.nombre,' ',us.apellidos) 'cliente',
                    cc.fechaCompra, cc.valTotal,
                    CONCAT(dp.nombre,' ',pr.nombre,' ',dis.nombre,' ',dir.direccion,' ',dir.referencia) 'direccion',
                    cc.estadoCompra
                    FROM compra_cabecera as cc
                    INNER JOIN usuario as us on us.idUsuario = cc.idUsuario
                    INNER JOIN direccion as dir on dir.id = cc.idDireccion
                    INNER JOIN distrito as dis on dis.id = dir.idDistrito
                    INNER JOIN provincia as pr on pr.id = dis.idProvincia
                    INNER JOIN departamento as dp on dp.id = dis.idDepartamento";
                    $query = mysqli_query($conexion, $sql);
                    $cont = 0;
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $cont; ?></td>
                            <td><?php echo $data['cliente']; ?></td>
                            <td><?php echo $data['fechaCompra']; ?></td>
                            <td><?php echo $data['direccion']; ?></td>
                            <td><?php echo $data['valTotal']; ?></td>
                            <td><?php echo $data['estadoCompra']; ?></td>
                            <td>
                                <?php if($data['estadoCompra'] == 'PENDIENTE'){ ?>
                                <a class="btn btn-warning" href= "aprobar_proc.php?id=<?php echo $data['id']; ?>"> Aprobar </a>
                                <a class="btn btn-danger" href= "rechazar_proc.php?id=<?php echo $data['id']; ?>"> Rechazar </a>
                                <a class="btn btn-dark" href= "visualizar_venta.php?id=<?php echo $data['id']; ?>"> Ojo </a>
                                <?php }elseif($data['estadoCompra'] == 'APROBADO'){ ?>
                                    <a class="btn btn-primary" href= "enviar_proc.php?id=<?php echo $data['id']; ?>"> Enviar </a>
                                <?php }else{ ?>
                                     Cerrado 
                                <?php } ?>
                            </td>
                        </tr>
                    <?php $cont++; } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>



<script>

const tabla = document.getElementById("tabla")




tabla.addEventListener("click", (e)=> 
{
    e.preventDefault();

    if ( e.target.classList.contains("btn-warning")  ) 
    {

        Swal.fire({
                        title: 'Seguro que quieres aprobar?',
                        text: "No seras capaz de revertir esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aprobar!' 
                    })
                    .then((result) => 
                    {
                        if (result.isConfirmed) 
                        {
                                fetch(e.target.href)
                                .then(data => data.json())
                                .then((result) => 
                                {
                                    
                                    if (result == "Venta aprobada") {
                                        Swal.fire(
                                                    'Aprobado!',
                                                    'Se aprobo correctamente.',
                                                    'success'
                                                    )
                                        .then( (result) => 
                                        {
                                              if (result.isConfirmed) 
                                                {
                                                  location.reload();
                                                }
                                        })            
          

                                    }
                                    
                                })
                                .catch((err) => 
                                {
                                    console.log(err);
                                });
                        }
                    })


        
    }
    else if( e.target.classList.contains("btn-danger") )
    {
        
          Swal.fire({
                        title: 'Seguro que quieres rechazar?',
                        text: "No seras capaz de revertir esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aprobar!',
                        cancelButtonText: 'Cancelar'
                    })
                     .then((result) => 
                    {

                           fetch(e.target.href)
                            .then(data => data.json())
                            .then((result) => 
                            {
                                
                                if (result == "Venta rechazada") 
                                {
                                         Swal.fire(
                                                    'Rechazado!',
                                                    'Se rechazo la venta.',
                                                    'error'
                                                    )

                                        e.target.parentNode.parentNode.remove()            
                                }
                                
                            })
                            .catch((err) => 
                            {
                                console.log("errro");   
                            });

                    })
 
    }
    else if( e.target.classList.contains("btn-primary") )
    {

         Swal.fire({
                        title: 'Seguro que quieres aprobar?',
                        text: "No seras capaz de revertir esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aprobar!' 
                    })
                    .then((result) => 
                    {
                        if (result.isConfirmed) 
                        {
                                fetch(e.target.href)
                                .then(data => data.json())
                                .then((result) => 
                                {
                                    
                                    if (result == "Venta enviada") {
                                          Swal.fire(
                                                    'Venta enviada!',
                                                    'Se empezaran a preparas los productos para el envio.',
                                                    'success'
                                                    )  
                                    }
                                    
                                })
                                .catch((err) => 
                                {
                                    console.log(err);
                                });
                        }
                    })


         /*    Swal.fire({
                        title: 'Seguro que quieres Enviar?',
                        text: "No seras capaz de revertir esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aprobar!',
                        cancelButtonText: 'Cancelar'
                    })
                    .then((result) => 
                    {

                        fetch(e.target.href)
                            .then(data => data.json())
                            .then((result) => 
                            {
                                
                                if (result == "Venta enviada") 
                                {
                                         Swal.fire(
                                                    'Venta enviada!',
                                                    'Se empezaran a preparas los productos para el envio.',
                                                    'success'
                                                    )  
                                }
                                
                            })
                            .catch((err) => 
                            {
                                console.log("errro");   
                            });


                    }) */
    }
     else if( e.target.classList.contains("btn-dark") )
     {
        fetch(e.target.href)
        .then(data => data.json())
        .then((result) => 
        {
          console.log(result);   
        })
        .catch((err) => 
        {
            console.log(err);
        });
     }

})

</script>



</body>
</html>