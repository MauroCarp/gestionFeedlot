<?php
include('includes/conexion.php');
include('includes/init_session.php');

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$tropa = $_POST['tropa'];


$sql = "SELECT COUNT(id) as machos FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot' AND sexo = 'Macho' AND peso BETWEEN '$desde' AND '$hasta'";
$query = mysqli_query($conexion,$sql);
$fila = mysqli_fetch_array($query);

$sqlHembra = "SELECT COUNT(id) as hembras FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot' AND sexo = 'Hembra' AND peso BETWEEN '$desde' AND '$hasta'";
$queryHembra = mysqli_query($conexion,$sqlHembra);
$filaHembra = mysqli_fetch_array($queryHembra);

$resultado = $fila['machos'].",".$filaHembra['hembras'];

echo $resultado;
?>