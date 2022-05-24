<?php

session_start();

if(!isset($_SESSION['id']) || !isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)){//verifica si hay logeado
    header("location: ../../index.php"); exit;
}




require_once "../../config/conectar.php";
include "../asset/header.php";
?>


<nav class="p-3 bg-dark">
<a class="btn btn-secondary" href="index.php">Lista productos</a>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-12 my-3 text-center">
            <h2 class="modal-title" id="title">Nuevo Producto</h2>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-5">
        <form action="crear_procesar.php" id="form" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-group"> 
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" required>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-group"> 
                        <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripción" rows="3" required></textarea>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <select id="presentacion" class="form-control" name="presentacion" required>
                            <option value="0">Categoria</option>
                            <?php
                            $presentacion = mysqli_query($conexion, "SELECT * FROM presentacion");
                            foreach ($presentacion as $pres) { ?>
                                <option value="<?php echo $pres['idPresentacion']; ?>"><?php echo $pres['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group"> 
                        <input id="cantidad" class="form-control" type="number"   name="cantidad" placeholder="Cantidad" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group"> 
                        <input id="precio" class="form-control" type="number"   name="precio" placeholder="Precio" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group"> 
                        <input type="button" class="btn btn-primary w-100" id="boton_foto" value="Foto del Producto">
                        <input type="file" id="file"  placeholder="foto del producto" class="form-control d-none" name="foto" >
                    </div>
                </div>
            </div>
      
            <div class="text-center mt-3">
                <button class="py-2 btn btn-success w-100" type="submit">Registrar</button>
            </div>
                                
        </form>
    </div>
    </div>

</div>

<script>

    !function() 
    {
        const form = document.getElementById("form")
        const boton_foto = document.getElementById("boton_foto")
        const file = document.getElementById("file")

        boton_foto.addEventListener("click", e => 
        {
            file.click()
        })
        
        form.addEventListener("submit", e => 
        { 
            e.preventDefault()

            const inputs = document.querySelectorAll("input");   
            let enviar = false

            inputs.forEach(item => 
            {
                if (item.value.trim() == "") 
                { 
                  enviar = false
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Rellene todos los campos!'
                    })
                }
                else
                {
                    enviar = true
                }
            });
            
            if (enviar)  
            {
                const datos = new FormData(form)
                enviar_form(datos)
            }

        })

        async function enviar_form(datos) 
        {
            const data = await fetch("crear_procesar.php", {
                                    method: "POST",
                                    body: datos
                                });

            const rpta = await data.json();
            
            if (rpta == "nuevo") 
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Correcto',
                    text: 'Se agrego el nuevo producto!',
                    })    
                
                    form.reset()
            }
            else if(rpta == "existente")
            {
 
                Swal.fire({
                    icon: 'warning',
                    title: 'Incorrecto',
                    text: 'Ya existe un producto con esas caracteristicas!',
                    })    
            }
            
        }


    }();

</script>



                            </body>
                            </html>