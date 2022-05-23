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
        <h1 class="h3 mb-0 text-gray-800">Productos</h1>
    </div>

    <div class="col-12 col-lg-4 my-4">
        <input class="form-control" type="search" placeholder="Buscar Productos" name="buscar" id="buscar">
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
                <tbody style="border: 10px #000" id="filas_tabla" >
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


<template id="template">
    <tr>
        <td>
            <img class="img-thumbnail" src="../../imgs/<?php echo $data['foto']; ?>" width="50">
        </td>
        <td class="nombre"></td>
        <td class="descripcion"></td>
        <td class="presentacion"></td>
        <td class="stock"></td>
        <td class="precio"></td>
        <td>
            <a class="btn btn-warning" href= "editar.php?id=<?php echo $data['idProducto']; ?>"> Editar </a>
            <a class="btn btn-danger" href= "eliminar_procesar.php?accion=d&id=<?php echo $data['idProducto']; ?>"> Eliminar </a>
        </td>
    </tr>       
</template>


<script>

    !function() 
    {
        document.addEventListener("DOMContentLoaded", main)

        async function main() 
        {
            const buscar = document.getElementById("buscar")
            const filas_tabla = document.getElementById("filas_tabla")
            const $template = document.getElementById("template").content
            const fragmento = document.createDocumentFragment()
            let clonar = null

            function refrescar() 
            {
                const filas = document.getElementById("filas_tabla")
                while (filas.firstChild) filas.removeChild(filas.firstChild)
            }


            async function items_list() 
            {
                const rpta = await fetch("listar_items.php")
                const JASON = await rpta.json()
                console.log(JASON);
                return JASON
            }

            const arr_data = await items_list();
            show_table(arr_data) 

            async function show_table(arr_data) 
            {
                 
                refrescar();
                
                arr_data.forEach(item => 
                {
                    clonar =  $template.cloneNode(true)
                    clonar.querySelector(".img-thumbnail").src = `../../imgs/${item.foto}`
                    clonar.querySelector(".nombre").textContent = item.Pnombre
                    clonar.querySelector(".descripcion").textContent = item.descripcion
                    clonar.querySelector(".presentacion").textContent = item.PRnombre
                    clonar.querySelector(".stock").textContent = item.stock
                    clonar.querySelector(".precio").textContent = item.precio
                    clonar.querySelector(".btn-warning").href = `editar.php?id=${item.idProducto}`
                    clonar.querySelector(".btn-danger").href  = `eliminar_procesar.php?accion=d&id=${item.idProducto}`

                    fragmento.appendChild(clonar)
                });

                filas_tabla.appendChild(fragmento)                
            }

           



            
            buscar.addEventListener("input", async (e)=>{
                 const search = buscar.value
                 const arr_filtrado = arr_data.filter(item => item.Pnombre.toLowerCase().search(search) != -1)  
                show_table(arr_filtrado)
            });
















            // INICIO DE LA DETECCION DE CLICKS     

            window.addEventListener("click", (e)=> 
            {

                if (e.target.hasAttribute("href") && e.target.classList.contains("btn-danger") )  
                {
                    e.preventDefault();    
                    console.log("no href");
                
                    Swal.fire({
                            title: 'Estas seguro de que quieres borrar este item?',
                            text: "No podras revertir está acción!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Aceptar',
                            cancelButtonText: "Cancelar"
                            })
                            .then((result) => 
                            {
                                if (result.isConfirmed) 
                                { 
                                    fetch(e.target.href)
                                    .then(data => data.json())
                                    .then(rpta => {
                                        console.log(rpta);
                                    }).catch((err) => 
                                    {
                                        console.log(err);
                                    });  

                                    Swal.fire(
                                        'Eliminado!',
                                        'El item fue eliminado.',
                                        'success'
                                        ) 
  
                                    show_table() 
                                }
                            });

                }

            });

            // FIN DE LA DETECCION DE CLICKS  

 
        }

    }();

</script>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    </body>
                    </html>