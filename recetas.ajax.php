<?php
include('includes/conexion.php');
include('includes/funciones.php');
include("includes/init_session.php");

$id_receta = $_POST['idReceta'];

$archivo = $_POST['archivo'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$sql = "SELECT * FROM mixer_recetas WHERE id_receta = '$id_receta' AND archivo = '$archivo'";

$query = mysqli_query($conexion,$sql);

$resultado = mysqli_fetch_array($query);

// CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

$resultadoJson = json_encode($resultado);

print_r($resultadoJson);

?>