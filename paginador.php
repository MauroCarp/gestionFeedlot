<?php
include('includes/conexion.php');
include('includes/funciones.php');
include("includes/init_session.php");

$desde = $_POST['desde'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$sqlQuery = "SELECT * FROM registroingresos WHERE feedlot = '$feedlot' ORDER BY fecha DESC, tropa DESC LIMIT 12 OFFSET $desde";
$query = mysqli_query($conexion,$sqlQuery);

while($resultadosIng = mysqli_fetch_array($query)){
    $tropa = $resultadosIng['tropa'];
?>
<tr>
  <td style="text-align: center;"><?php echo $tropa;?></td>
  <td><?php echo formatearFecha($resultadosIng['fecha']);?></td>
  <td><?php echo $resultadosIng['cantidad'];?></td>
  <td><?php echo number_format($resultadosIng['pesoPromedio'],2,",",".")." Kg";?></td>
  <td><?php echo $resultadosIng['renspa'];?></td>
  <td><?php echo $resultadosIng['adpv']." Kg";?></td>
  <td><?php echo $resultadosIng['estado'];?></td>
  <td><?php echo strtoupper($resultadosIng['proveedor']);?></td>
  <td><?php echo stock($resultadosIng['fecha'],$feedlot,$conexion); ?></td>
  <td><a href="verTropa.php?tropa=<?php echo $resultadosIng['tropa'];?>&seccion=ingresos"><span class="icon-eye iconos"></span></a></td>
  <td><a href="stock.php?accion=eliminarIngreso&id=<?php echo $resultadosIng['id'];?>&tropa=<?php echo $resultadosIng['tropa'];?>" onclick="return confirm('¿Eliminar Registro?');"><span class="icon-bin2 iconos"></span></a></td>
</tr>
<?php

}
?>