<?php
include('includes/conexion.php');
include('includes/funciones.php');
include("includes/init_session.php");

$desde = $_POST['desde'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$sqlQuery = "SELECT * FROM registroegresos WHERE feedlot = '$feedlot' ORDER BY fecha DESC, tropa DESC LIMIT 12 OFFSET $desde";
$query = mysqli_query($conexion,$sqlQuery);

while($resultadosEgr = mysqli_fetch_array($query)){
    $tropa = $resultadosEgr['tropa'];

?>
<tr>
  <td><?php echo formatearFecha($resultadosEgr['fecha']);?></td>
  <td><?php echo $resultadosEgr['cantidad'];?></td>
  <td><?php echo number_format($resultadosEgr['pesoPromedio'],2,",",".")." Kg";?></td>
  <td><?php echo number_format($resultadosEgr['gmdPromedio'],2,",",".")." Kg";?></td>
  <td><?php echo number_format($resultadosEgr['gpvPromedio'],2,",",".")." Kg";?></td>  
  <td><a href="verTropa.php?tropa=<?php echo $resultadosEgr['tropa'];?>&seccion=egresos"><span class="icon-eye iconos"></span></a></td>
  <td><a href="stock.php?accion=eliminarEgreso&id=<?php echo $resultadosEgr['id'];?>&tropa=<?php echo $resultadosEgr['tropa'];?>" onclick="return confirm('¿Eliminar Registro?');"><span class="icon-bin2 iconos"></span></a></td>
</tr>
<?php

}

?>