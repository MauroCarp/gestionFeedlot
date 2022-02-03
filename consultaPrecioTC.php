<?php
require("includes/conexion.php");
require("includes/funciones.php");
$id = mysqli_real_escape_string($conexion, $_POST["id"]);
$query = "SELECT precio FROM insumos WHERE id = '$id'";
$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_array($result);
{
    echo $row['precio'];
}
mysqli_close($conexion);
?>
