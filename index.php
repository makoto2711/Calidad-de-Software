<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/main.css">
    <script defer src="assets/js/main.js"></script>
</head>
<body>

   <nav class="navbar navbar-light bg-dark mb-5 py-3 fixed">
        <div class="container-fluid">
          <a class="navbar-brand text-white" href="#">
              <img src="./imgs/logo.jpeg" width="50" alt="">
          </a>

          
      <?php
if(!isset($_SESSION['id'])){
    //verifica si hay logeado
  ?>  
    <a class="btn btn-primary" href='login.php'>Login</a>
<?php
}
if(isset($_SESSION['id'])){//verifica si hay logeado
?>
   <a class="btn btn-primary" href='logout.php'>Cerrar sesion</a>
<?php
}
 ?>
          <section>
                <span class="fa fa-shopping-bag text-white fs me-5 open"></span>
                <span class="cont open" id="contador">0</span> 
          </section>

        </div>
    </nav>   
 

    <main class="container mt-5 pt-5">
        <div class="row" id="contenedor"> 
            <!--    <div class="card col-lg-4 border-0 ">
                    <section class="m-3 cuerpo">
                        <img src="assets/img/lana.png" class="card-img-top border-top" alt="...">
                        <div class="card-body background">
                            <h5 class="card-title text-white text-center mb-3"><span class="producto">Lana Azul</span> - S/. <span class="precio">15.00</span></h5>
                            <div class="text-center">
                                <a href="#" class="btn boton">Agregar al Carrito</a>
                            </div>
                        </div>
                    </section>
                </div>
            --> 
        </div>
    </main>



    <aside class="aside vh-100" id="aside">
        <section class="h-100 position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center my-3">
                        <h3 class="mb-0">Tus Productos</h3>
                    </div>
                </div>
    
                <div class="row" id="itemsComprados">
                    
                </div>
                
                <div class="text-white">
                    <p class="fw mb-1">Cantidad: <span id="productos_totales"></span></p>
                    <p class="fw  mb-0 ">Total: <span id="total"></span></p>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button class="btn btn-primary">Comprar</button>
                    </div>
                </div>

            </div>
    
            <span class="close"></span>

            

        </section>
    </aside>
 



    <footer class="text-center mt-5 py-3 design">
      <p class="mb-0 ">Hecho con ❤️ | <span id="year"></span> </p>
    </footer>
 

    <template id="template">
        <div class="card col-lg-4 border-0 ">
            <section class="m-3 cuerpo">
                <img src="assets/img/lana.png" class="card-img-top border-top imagen" alt="...">
                <div class="card-body background">
                    <h5 class="card-title text-white text-center mb-3"><span class="producto">Lana Azul</span> - S/. <span class="precio">15.00</span></h5>
                    <div class="text-center">
                        <a  class="btn boton add" >Agregar al Carrito</a>
                        <a  class="btn btn-warning py-1 mt-3 mt-xl-0 view" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Detalles</a>
                    </div>
                </div>
            </section>
        </div>
    </template>


    <template id="filaProducto">
        <div class="col-12 my-2">
            <div class="row no-gutters py-2 bg-row">
                <div class="col-3">
                     <img src="assets/img/lana.png" class="w-100" alt="">
                </div>
                <div class="col-9 text-white d-flex justify-content-between align-items-center">
                     <div>
                         <p class="mb-0 p_name">hola mundo</p>
                         <p class="mb-0 p_price">precio</p>
                     </div>
                     <div class="d-flex">
                         <input type="button" class="plus" value="+">
                         <p class="mb-0 mx-2 cantidad">1</p>
                         <input type="button" class="minus" value="-">
                     </div>
                </div>
            </div>
         </div>
    </template>


  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
         <!--  <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          --> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-center">
                <div class="col-6">
                    <img id="img_modal" class="w-100" src="" alt="">
                </div>
                <div class="col-12 mt-2">
                    <h4 class="text-center" title="titulo" id="title_modal"></h4>
                    <p id="description_modal"></p>
                    <p id="presentacion_modal"></p>
                    <p id="price_modal"></p>
                    <p id="stock_modal"></p>
                </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> 
        </div>
      </div>
    </div>
  </div>



</body>
</html> 