	<?php
	include('includes/conexion.php');
	$feedlot = 'Acopiadora Pampeana';
	$sql = "SELECT DISTINCT tropa FROM egresos WHERE feedlot = '$feedlot' ORDER BY id ASC";

	$query1 = mysqli_query($conexion,$sql);
	while($fila1 = mysqli_fetch_array($query1)){
		$tropa = $fila1['tropa'];
		$sql = "SELECT COUNT(*) as cantidad, SUM(peso) as peso,destino,fecha FROM egresos WHERE feedlot = '$feedlot' AND tropa = '$tropa'";
		$query = mysqli_query($conexion,$sql);
		$fila = mysqli_fetch_array($query);
		$pesoProm = $fila['peso'] / $fila['cantidad'];
;

		$cantidad = $fila['cantidad'];
		$fecha = $fila['fecha'];
		//$renspa = $fila['renspa'];
		//$adpv = $fila['estado'];
		$destino = $fila['destino'];
		//$estado = $fila['estado'];
		$sqlQuery = "INSERT INTO registroegresos(feedlot,tropa,fecha,cantidad,pesoPromedio,destino) VALUES('$feedlot','$tropa','$fecha','$cantidad','$pesoProm','$destino')";
		mysqli_query($conexion,$sqlQuery);
		echo mysqli_error($conexion);
	};



	?>