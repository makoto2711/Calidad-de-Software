<?php 
require_once "../config/conectar.php";
if(isset($_POST['idDepartamento'])){
    $idDepartamento=$_POST['idDepartamento'];

        $sql="SELECT id, nombre from provincia 
            where idDepartamento='$idDepartamento'";
        //$cadena="";
        $provincias =mysqli_query($conexion,$sql);

        $cadena="<option value='0'> - Seleccione - </option>";
        
        foreach ($provincias as $prov) {
        $cadena=$cadena.'<option value='.$prov['id'].'>'.$prov['nombre'].'</option>';
        }

        echo $cadena;
        
        
}

if(isset($_POST['idProvincia'])){
    $idProvincia=$_POST['idProvincia'];

        $sql="SELECT id, nombre from distrito 
            where idProvincia='$idProvincia'";

        $distritos =mysqli_query($conexion,$sql);

        $cadena="<option value='0'> - Seleccione - </option>";

        foreach ($distritos as $dist) {
        $cadena=$cadena.'<option value='.$dist['id'].'>'.$dist['nombre'].'</option>';
        } 

        echo $cadena;
}


	

?>