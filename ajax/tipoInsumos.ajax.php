<?php
include('../includes/conexion.php');

$sql = "SELECT DISTINCT(tipo) FROM insumos ORDER BY tipo ASC";

$query = mysqli_query($conexion,$sql);


while($resultado = mysqli_fetch_array($query)){

    echo "<option value=".$resultado['tipo'].">".$resultado['tipo']."</option>";

}

    echo "<option value='otroTipo'>Otro</option>";

?>