<?php
session_start();//abre/inicias session

if(!isset($_SESSION['id']) || !isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)){//verifica si hay logeado
    header("location: ../../index.php"); exit;
}

require_once "../../config/conectar.php";
include "../asset/header.php";

if(isset($_GET['id'])){    
    $id = $_GET['id'];
    $sql = "SELECT p.nombre as Pnombre,p.descripcion,p.idPresentacion, p.stock, p.precio, i.foto FROM producto p inner JOIN imagen i on p.idProducto = i.idProducto where p.estado = 1 and p.idProducto = $id";
    $query = mysqli_query($conexion, $sql);

    if(!$query){
        echo "retornar a la vista index porque esta deshabilitado o no coincide id producto";
    }

    $data = mysqli_fetch_assoc($query);
?>


<nav class="p-3 bg-dark">
  <a class="btn btn-secondary" href="index.php">Regresar</a>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-12 text-center">
            <h2 class="modal-title" id="title">Editar Producto</h2>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
            <div class="col-lg-5">
            <form action="editar_procesar.php?accion=e" method="POST" id="formEditar"  enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-group"> 
                            <input id="nombre" value="<?php echo $data['Pnombre']?>" class="form-control" type="text" name="nombre" placeholder="Nombre" required>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group"> 
                            <textarea id="descripcion" class="form-control" name="descripcion" placeholder="Descripción" rows="3" required><?php echo $data['descripcion']?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group"> 
                            <select id="presentacion" class="form-control" name="presentacion" required>
                                <?php
                                $presentacion = mysqli_query($conexion, "SELECT * FROM presentacion");
                                foreach ($presentacion as $pres) { 
                                    if($pres['idPresentacion'] == $data['idPresentacion']){?>
                                        <option value="<?php echo $pres['idPresentacion']; ?>" selected><?php echo $pres['nombre']; ?></option>
                                    <?php }
                                    else{ ?>
                                    <option value="<?php echo $pres['idPresentacion']; ?>"><?php echo $pres['nombre']; ?></option>
                            <?php   } 
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group"> 
                            <input id="cantidad" value="<?php echo $data['stock']?>" class="form-control" type="number" name="cantidad" placeholder="Cantidad" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group"> 
                            <input id="precio" value="<?php echo $data['precio']?>" class="form-control" type="number" name="precio" placeholder="Precio" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <img src="../../imgs/<?php echo $data['foto']?>" width="80">
                            <label for="imagen">Foto</label>
                            <input type="file" class="form-control" name="foto" >
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $id?>">
                
                <div class="text-center mt-3">
                        <button class="py-2 btn btn-primary w-100" id="editar" type="submit">Editar</button>
                </div>

            </form>
        <?php
    }else
    {
        echo "retornar a la vista index prod";
    }

    ?>
            </div> 
    </div>
</div>

<script>
    !function() 
    {
        const formEditar = document.getElementById("formEditar")

        console.log("hola mundo");

    }();
</script>



</body>
</html>