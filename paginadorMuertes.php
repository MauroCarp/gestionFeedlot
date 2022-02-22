<?php
include('includes/conexion.php');
include('includes/funciones.php');
include("includes/init_session.php");

$desde = $_POST['desde'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$sqlQuery = "SELECT * FROM registromuertes WHERE feedlot = '$feedlot' ORDER BY fecha DESC LIMIT 8 OFFSET $desde";
$query = mysqli_query($conexion,$sqlQuery);
echo mysqli_error($conexion);
while($fila = mysqli_fetch_array($query)){
?>
<tr>

  <td><?php echo formatearFecha($fila['fecha']);?></td>
  <td style="text-align:center;"><?php echo $fila['cantidad'];?></td>
  <td><?php echo $fila['causaMuerte'];?></td>
  <td><a style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modalEditarCausa" onclick="editarCausa('<?php  echo $fila['id'];?>')"><span class="icon-pencil iconos"></span></a></td>
  <td><a href="stock.php?accion=eliminarMuerte&id=<?php echo $fila['id'];?>&tropa=<?php echo $fila['tropa'];?>" onclick="return confirm('¿Eliminar Registro?');"><span class="icon-bin2 iconos"></span></a></td>

</tr>
<?php

}

?>

