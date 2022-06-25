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

            <table class="table row-border stripe"  id="tabla" style="width: 100%;">
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
                    INNER JOIN departamento as dp on dp.id = dis.idDepartamento
                    ORDER BY cc.fechaCompra DESC";
                    $query = mysqli_query($conexion, $sql);
                    $cont = 1;
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $cont; ?></td>
                            <td><?php echo $data['cliente']; ?></td>
                            <td><?php echo $data['fechaCompra']; ?></td>
                            <td><?php echo $data['direccion']; ?></td>
                            <td><?php echo $data['valTotal']; ?></td>
                            <td><?php echo $data['estadoCompra']; ?></td>
                            <td>
                                 <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" href= "visualizar_venta.php?id=<?php echo $data['id']; ?>">
                                    <img src="../../imgs/ojo.svg" class="img-g" style="width: 100%; height: 18px; filter: invert(1);"  alt="">
                                </a>
                                <?php if($data['estadoCompra'] == 'PENDIENTE'){ ?>
                                <a class="btn btn-warning" href= "aprobar_proc.php?id=<?php echo $data['id']; ?>"> Aprobar </a>
                                <a class="btn btn-danger" href= "rechazar_proc.php?id=<?php echo $data['id']; ?>"> Rechazar </a>
                               
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



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle de venta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
         <section id="primera_plana" >

         </section>    
         <hr>      
          
         <section  >
               <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad </th>
                        </tr>
                    </thead>
                    <tbody id="segunda_plana">
                        
                    </tbody>
                </table>                     
         </section>                 
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> 
      </div>
    </div>
  </div>
</div>




<script>

$(document).ready(function () {
        $('#tabla').DataTable({
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }});
});

const tabla = document.getElementById("tabla")

const primera_plana = document.getElementById("primera_plana")
const segunda_plana = document.getElementById("segunda_plana")


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
     else if( e.target.classList.contains("btn-dark") || e.target.classList.contains("img-g")  )
     {
        let peticion = e.target.href
        
        if (e.target.classList.contains("img-g"))  peticion = e.target.parentNode.href
        
  
        fetch( peticion )
        .then(data => data.json())
        .then((result) => 
        {
          console.log(result);   

          console.log( result[1][0].cliente );

          primera_plana.innerHTML = ""
          primera_plana.innerHTML = `<p class="mb-1" >Nombre Cliente: ${result[1][0].cliente}</p>
                                     <p class="mb-1" >Dirección Cliente: ${result[1][0].direccion}</p>
                                     <p class="mb-1" >Fecha pedido: ${result[1][0].fechaCompra}</p>
                                     <p class="mb-1" >Valor: ${result[1][0].valTotal}</p>
                                     <p class="mb-1" >Estado: <strong>${result[1][0].estadoCompra}</strong> </p>`
         
   
            console.log(result[0].length);

            segunda_plana.innerHTML = ""
            result[0].forEach((element,i) => 
            {
                segunda_plana.innerHTML += `
                        <tr>
                            <th scope="row">${i+1}</th>
                            <td>${element.producto}</td>
                            <td>${element.cantidad}</td> 
                        </tr> ` 
                console.log(element);    
            });
                           
/* 
            result[0][0].foreach(item => 
            {
                console.log(item);
            })
 */
                                     




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