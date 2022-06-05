<?php
session_start();
if(!isset($_SESSION['id']) || !isset($_SESSION['rol'])){//verifica si hay logeado
    header("location: ../index.php"); exit;
}

if(isset($_POST['user']) && $_POST['user']==$_SESSION['idUser']){
require_once "../config/conectar.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Llenar select a partir de otro con php y 	mysql</title>
	<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
	   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
</head>
<body>

<nav class="p-3 bg-dark">
	<a class="btn btn-secondary" href="perfil.php">Regresar</a>
</nav>

<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-6">
			
				<form action="reg_dir_proc.php?user=<?php echo $_POST['user'] ?>" method="post" >
					<label>Departamento: </label> 
					<select id="selDepartamento" class="form-select" name="departamento" required>
						<option value="0"> - Seleccione - </option>
						<?php
						$presentacion = mysqli_query($conexion, "SELECT * FROM departamento");
						foreach ($presentacion as $pres) { ?>
							<option value="<?php echo $pres['id']; ?>"><?php echo $pres['nombre']; ?></option>
						<?php } ?>
					</select>
						<br>
					<label>Provincia: </label>
					<select class="form-select" name="provincia" id="selProvincias" required>
						<option value="0"> - Seleccione - </option>
					</select>
					<br>
					<label>Distrito: </label>
					<select class="form-select" name="distrito" id="selDistritos" required>
						<option value="0"> - Seleccione - </option>
					</select>
					<br>
					<label>Direccion: </label>
					<input type="text" class="form-control" name="direccion" placeholder="Av., Nro, Mz, Lote" required>
					<br>
					<label>Referencia: </label>
					<input type="text" class="form-control" name="referencia" placeholder="Cerca de.., Enfrente de.." >
					
					<div class="text-center mt-3">
						<input type="submit" class="btn btn-success w-100 fw-bold" value="Registrar">
					</div>

				</form>
		</div>
	</div>
</div>

			


</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		 $('#selDepartamento').val(0);
		  recargarProvincia();
		  recargarDistrito();
		

		$('#selDepartamento').change(function(){
			recargarProvincia();
            recargarDistrito();
		});

		$('#selProvincias').change(function(){
			recargarDistrito();
		});


	})
</script>
<script type="text/javascript">
	function recargarProvincia(){
		$.ajax({
			type:"POST",
			url:"direccion_procesar.php",
			data:"idDepartamento=" + $('#selDepartamento').val(),
			success:function(r){
				$('#selProvincias').html(r);
			}
		});
	}
	function recargarDistrito(){
		$.ajax({
			type:"POST",
			url:"direccion_procesar.php",
			data:"idProvincia=" + $('#selProvincias').val(),
			success:function(r){
				$('#selDistritos').html(r);
			}
		});
	}
</script>

<?php }else{
    header("location: perfil.php"); exit;
} ?>