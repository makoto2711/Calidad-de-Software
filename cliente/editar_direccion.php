<?php
session_start();
if(!isset($_SESSION['id']) || !isset($_SESSION['rol'])){//verifica si hay logeado
    header("location: ../index.php"); exit;
}

require_once "../config/conectar.php";

$id = $_GET['id'];
$query = "SELECT dis.idDepartamento as departamento,
dis.idProvincia as provincia,
dis.id as distrito,
dir.direccion,
dir.referencia
FROM direccion as dir
inner join distrito as dis on dis.id = dir.idDistrito
where dir.id = $id";

$direccion = mysqli_query($conexion,$query);
foreach ($direccion as $d){
	$departamento = $d['departamento'];
	$provincia = $d['provincia'];
	$distrito = $d['distrito'];
	$direccion = $d['direccion'];
	$referencia = $d['referencia'];
}

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

			<form action="edit_dir_proc.php?id=<?php echo $id ?>" method="post">
		<label>Departamento </label> 
		<select id="selDepartamento" class="form-select" name="departamento" required>
			<option value="0"> - Seleccione - </option>
			<?php
			$departamentos = mysqli_query($conexion, "SELECT * FROM departamento");
			foreach ($departamentos as $dep) { ?>
				<option value="<?php echo $dep['id']; ?>"><?php echo $dep['nombre']; ?></option>
			<?php } ?>
		</select>
			<br>
		<label>Provincias</label>
		<select id="selProvincias" class="form-select" name="provincia" required>
			<option value="0"> - Seleccione - </option>
			<?php
			$provincias = mysqli_query($conexion, "SELECT id,nombre FROM provincia where idDepartamento=$departamento");
			foreach ($provincias as $prov) { ?>
				<option value="<?php echo $prov['id']; ?>"><?php echo $prov['nombre']; ?></option>
			<?php } ?>
		</select>
		<br>
		<label>Distritos</label>
		<select id="selDistritos" class="form-select" name="distrito" required>
			<option value="0"> - Seleccione - </option>
			<?php
			$distritos = mysqli_query($conexion, "SELECT id,nombre FROM distrito where idProvincia=$provincia");
			foreach ($distritos as $dist) { ?>
				<option value="<?php echo $dist['id']; ?>"><?php echo $dist['nombre']; ?></option>
			<?php } ?>
		</select>
		<br>
		<label>Direccion: </label>
		<input type="text" class="form-control" value="<?php echo $direccion ?>" name="direccion" required> 
		<br>
		<label>Referencia: </label>
		<input type="text" class="form-control" value="<?php echo $referencia ?>" name="referencia" required>
		<br>
		
		<div class="mt-3">
			<input class="w-100 btn btn-success"  type="submit" value="Guardar">
		</div>

	</form>

		</div>
	</div>
</div>		

	 



	<script type="text/javascript">
	$(document).ready(function(){
		$('#selDepartamento').val(<?php echo $departamento ?>);
		$('#selProvincias').val(<?php echo $provincia ?>);
		$('#selDistritos').val(<?php echo $distrito ?>);

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
 

</body>
</html>
