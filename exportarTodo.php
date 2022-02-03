<?php
require("includes/init_session.php");
include("includes/conexion.php");


$hoy = date('d-m-Y');
$registrosStock = "";
$registrosStatus = "";
$registrosRacion = "";

$sqlQuery = "SELECT * FROM stock WHERE feedlot = '$feedlot'";
$query = mysqli_query($conexion,$sqlQuery);  
while($fila = mysqli_fetch_array($query)){
  $tropaNum = ($fila['tropaNum'] == "") ? 0 : $fila['tropaNum'];
  $fecha = $fila['fecha'];
  $cantidad = $fila['cantidad'];
  $pesoIngreso = $fila['pesoIngreso'];
  $pesoEgreso = $fila['pesoEgreso'];
  $origen = $fila['origen'];
  $egreso = $fila['egreso'];
  $destino = $fila['destino'];
  $muertes = $fila['muertes'];
  $causaMuerte = $fila['causaMuerte'];
  $precioCV = $fila['precioCV'];
  $flete = $fila['flete'];
  $comision = $fila['comision'];

  $registrosStock = $registrosStock."('$feedlot','$tropaNum','$fecha','$cantidad','$pesoIngreso','$origen','$egreso','$pesoEgreso','$destino','$muertes','$causaMuerte','$precioCV','$flete','$comision'),";
}

$registrosStock = trim($registrosStock, ',');
$registrosStock = $registrosStock.";";


$sqlQuery2 = "SELECT * FROM status WHERE feedlot = '$feedlot'";
$query2 = mysqli_query($conexion,$sqlQuery2);                 
while($fila2 = mysqli_fetch_array($query2)){
  $tropaNum = $fila2['tropaNum'];
  $procedimiento = $fila2['procedimiento'];
  $fechaRealizado = ($fila2['fechaRealizado'] == "") ? NULL : $fila2['fechaRealizado'];
  $fechaMetafilaxis = ($fila2['fechaMetafilaxis'] == "") ? NULL : $fila2['fechaMetafilaxis'];
  $metafilaxis = $fila2['metafilaxis'];
  $fechaVacuna = ($fila2['fechaVacuna'] == "") ? NULL : $fila2['fechaVacuna'];
  $vacuna = $fila2['vacuna'];
  $fechaRefuerzo = ($fila2['fechaRefuerzo'] == "") ? NULL : $fila2['fechaRefuerzo'];
  $refuerzo = $fila2['refuerzo'];
  var_dump($fechaVacuna);

  $registrosStatus = $registrosStatus."('$feedlot','$tropaNum','$procedimiento','$fechaRealizado','$fechaMetafilaxis','$metafilaxis','$fechaVacuna','$vacuna','$fechaRefuerzo','$refuerzo'),";
}
die();
$registrosStatus = trim($registrosStatus, ',');
$registrosStatus = $registrosStatus.";";

$sqlQuery = "SELECT * FROM raciones WHERE feedlot = '$feedlot'";
$query = mysqli_query($conexion,$sqlQuery); 
while($fila = mysqli_fetch_array($query)){
  $fecha = $fila['fecha'];
  $turno = $fila['turno'];
  $operario = $fila['operario'];
  $maizKg = $fila['maizKg'];
  $maizPrecio = $fila['maizPrecio'];
  $conceKg = $fila['conceKg'];
  $concePrecio = $fila['concePrecio'];
  $siloKg = $fila['siloKg'];
  $siloPrecio = $fila['siloPrecio'];
  $corral = $fila['corral'];

  $registrosRacion = $registrosRacion."('$feedlot','$fecha','$turno','$operario','$maizKg','$maizPrecio','$conceKg','$concePrecio','$siloKg','$siloPrecio','$corral'),";
}
        

$registrosRacion = trim($registrosRacion, ',');
$nombreArchivo = "BD-".$feedlot."-".$hoy;

echo $registrosStock;
print_r($registrosStatus);
echo $registrosRacion;


header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename='$nombreArchivo.txt'");
?>