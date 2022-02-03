<?php
include("includes/conexion.php");
include("includes/init_session.php");
header('Content-Type: application/json');

$sqlQuery = "SELECT muertes, causaMuerte FROM stock WHERE feedlot = '$feedlot'";

$result = mysqli_query($conexion,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conexion);

echo json_encode($data);
?>