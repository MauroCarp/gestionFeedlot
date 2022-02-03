<?php
require("includes/conexion.php");
require("includes/funciones.php");
$prove = mysqli_real_escape_string($conexion, $_POST["insumo"]);
$query = "SELECT precio FROM insumos WHERE id = '$prove'";
$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_array($result);
{
    echo '<input type="text" style="font-weight: bold;" name="precioTC" class="input-small" readonly value="'.$row['precio'].'"/>';
}
mysqli_close($conexion);
?>
