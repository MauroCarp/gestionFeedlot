<?php
include('includes/conexion.php');
include('includes/funciones.php');
include("includes/init_session.php");

$desde = $_POST['desde'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$sqlQuery = "SELECT * FROM registromuertes WHERE feedlot = '$feedlot' ORDER BY fecha DESC LIMIT 12 OFFSET $desde";
$query = mysqli_query($conexion,$sqlQuery);
echo mysqli_error($conexion);
while($fila = mysqli_fetch_array($query)){
?>
<tr>
  <td><?php echo formatearFecha($fila['fecha']);?></td>
  <td><?php echo $fila['cantidad'];?></td>
  <td><?php echo $fila['causaMuerte'];?></td>
  <td><a href="stock.php?accion=eliminarMuerte&id=<?php echo $fila['id'];?>&tropa=<?php echo $fila['tropa'];?>" onclick="return confirm('¿Eliminar Registro?');"><span class="icon-bin2 iconos"></span></a></td>
</tr>
<?php

}

?>