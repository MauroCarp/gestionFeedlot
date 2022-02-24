<?php
include('../includes/conexion.php');

$tabla = $_POST['select'];

$campo = $_POST['campo'];

$sql = "SELECT ($campo) FROM $tabla ORDER BY $campo ASC";

$query = mysqli_query($conexion,$sql);


while($resultado = mysqli_fetch_array($query)){

    echo "<option value=".$resultado[$campo].">".$resultado[$campo]."</option>";

}

?>