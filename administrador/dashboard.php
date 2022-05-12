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
            <div class="col-4 mt-3">
                
                <aside>
                        
                    <a class="bg-dark p-2 btn text-white" href="producto/index.php">Productos</a>

                </aside>

            </div>
        </div>
    </div>
</main>



</body>
</html>