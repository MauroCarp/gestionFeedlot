<?php
include('../includes/conexion.php');

$tabla = $_POST['tabla'];

$sql = "SELECT id,nombre FROM  $tabla ORDER BY nombre ASC";

$query = mysqli_query($conexion,$sql);


while($resultado = mysqli_fetch_array($query)){

    $value = ($tabla == 'formulas') ? $resultado['id'] : $resultado['nombre'];

    echo "<option value=".$value.">".$resultado['nombre']."</option>";

}

if($tabla == 'operarios'){

    echo "<option value='otroOperario'>Otro Operario</option>";

}

?>