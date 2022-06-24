<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>


<?php
 include 'registro_procesar.php' 
 ?>
 

  <div class="container">

  <div class="row justify-content-center">
      <div class="col-6">
                  <h1>Registro</h1>
    <span><a class="btn btn-primary" href="../login.php">Login</a></span>

      </div>
  </div>


    <div class="row justify-content-center">
    

        <div class="col-lg-6">
  
    <form class="mt-4" action="" id="form" method="POST">
        
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



  <script>

      const FORM = document.getElementById("form")

      FORM.addEventListener("submit", e => 
      {
          e.preventDefault()

          const DATA_F = new FormData(FORM)

          fetch("registro_procesar.php", 
          {
            method: "POST",
            body: DATA_F
          })
          .then(data => data.json() )
          .then((result) => {
            
            switch (result) 
            {
              case "usuario repetido":
                Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Usuario repetido!',
                      })
              break;
              case "email repetido":
                   Swal.fire({
                        icon: 'error',
                        title:'Oops...',
                        text: 'Email repetido!',
                      })
              break;
              default:
                Swal.fire(
                      'Exito!',
                      'Te registraste correctamente!',
                      'success'
                    )
                break;
            }


          }).catch((err) => {
            console.log(err);
          });
        


      })
      

  </script>


</body>
</html> 


