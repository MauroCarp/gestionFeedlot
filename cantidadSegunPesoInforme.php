<?php
include('includes/conexion.php');
include('includes/init_session.php');

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$fDesde = $_POST['fDesde'];
$fHasta = $_POST['fHasta'];

$sql = "SELECT COUNT(id) as machos FROM ingresos WHERE feedlot = '$feedlot' AND sexo = 'Macho' AND (peso BETWEEN '$desde' AND '$hasta') AND (fecha BETWEEN '$fDesde' AND '$fHasta')";
$query = mysqli_query($conexion,$sql);
$fila = mysqli_fetch_array($query);

$sqlHembra = "SELECT COUNT(id) as hembras FROM ingresos WHERE feedlot = '$feedlot' AND sexo = 'Hembra' AND (peso BETWEEN '$desde' AND '$hasta') AND (fecha BETWEEN '$fDesde' AND '$fHasta')";
$queryHembra = mysqli_query($conexion,$sqlHembra);
$filaHembra = mysqli_fetch_array($queryHembra);

$resultado = $fila['machos'].",".$filaHembra['hembras'];

echo $resultado;
?>