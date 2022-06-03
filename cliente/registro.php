<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>


<?php
 include 'registro_procesar.php' 
 ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

  <div class="container">

  <div class="row justify-content-center">
      <div class="col-6">
                  <h1>Registro</h1>
    <span><a class="btn btn-primary" href="../login.php">Login</a></span>

      </div>
  </div>


    <div class="row justify-content-center">
    

        <div class="col-lg-6">
  
    <form class="mt-4" action="" method="POST">
        
        <input class="form-control" name="user" type="text" placeholder="Usuario" minlength="6" required><br>
        <input class="form-control" name="pass" type="password" placeholder="Contraseña" minlength="6" required><br>
        <input class="form-control" name="conf_pass" type="password" placeholder="Confirmar contraseña" minlength="6" required><br><br>
        <input class="form-control" name="nombre" type="text" placeholder="Nombres" required><br>
        <input class="form-control" name="apellido" type="text" placeholder="Apellidos" required><br>
        <input class="form-control" name="numero" type="number" placeholder="Numero Cel/Telf" required><br>
        <input class="form-control" name="email" type="email" placeholder="Correo" required><br>
        <input class="form-control btn btn-success"  type="submit" value="Registrar">
    </form>

        </div>
    </div>
  </div>


</body>
</html> 


