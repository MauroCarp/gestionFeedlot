<?php
include('includes/conexion.php');
include('includes/funciones.php');
include('includes/init_session.php');

$desde = (array_key_exists('desde', $_POST)) ? $_POST['desde'] : "";
$hasta = (array_key_exists('hasta', $_POST)) ? $_POST['hasta'] : "";
$destino = (array_key_exists('destino', $_POST)) ? trim($_POST['destino']) : "";
$orden = $_POST['orden'];

$sql = array();
$filtros = array();


if ($destino != "") {
	$sql[] = "destino = '$destino'";
	$filtros[] = "Destino: $destino";
}

if ($desde != "" AND $hasta != "") {
	$sql[] = "fecha BETWEEN '$desde' AND '$hasta'";
	$filtros[] = "Periodo: ".formatearFecha($desde)." / ".formatearFecha($hasta);
}

$sql = implode(' AND ', $sql);
$filtros = implode(' - ',$filtros);

if ($sql != "") {
	$sql = "WHERE ".$sql." AND ";
}else{
	$sql = "WHERE ";
}


//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$sqlQuery = "SELECT DISTINCT(tropa) FROM egresos $sql feedlot = '$feedlot' ORDER BY fecha $orden";

if ($feedlot == "Acopiadora Pampeana") {

	$sqlQuery = "SELECT * FROM registroegresos $sql feedlot = '$feedlot' ORDER BY fecha $orden";
	
}

$query = mysqli_query($conexion,$sqlQuery);
echo $sqlQuery;
//die();
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped" style="box-shadow: 1px -2px 15px 1px;">
        	<tr>
                <th>Fecha Egreso</th>
                <th>Cantidad</th>
                <th>Peso Prom.</th>
                <th>Destino</th>
                <th></th>
                <th></th>
            </tr>';
if(mysqli_num_rows($query)>0){

	$totalCantidad = 0;
	$totalPNeto = 0;

	while($registro2 = mysqli_fetch_array($query)){
		
		if ($feedlot == "Acopiadora Pampeana") {

		
			$tropa = $registro2['tropa'];
			
			$sql2 = "SELECT SUM(peso) AS pesoTotal FROM egresos WHERE tropa = '$tropa'";
	
			$query2 = mysqli_query($conexion,$sql2);
	
			$resultadosEgr = mysqli_fetch_array($query2);
	
				  
			echo '<tr>
					<td>'.formatearFecha($registro2['fecha']).'</td>
					<td>'.$registro2['cantidad'].'</td>
					<td>'.$registro2['pesoPromedio'].' Kg</td>
					<td>'.$registro2['destino'].'</td>
					<td><a href="verTropa.php?tropa='.$registro2['tropa'].'&seccion=egresos"><span class="icon-eye iconos"></span></a></td>
					<td><a href="stock.php?accion=eliminarEgreso&id='.$registro2['id'].'&tropa='.$registro2['tropa'].'" onclick="return confirm(\'¿Eliminar Registro?\');"><span class="icon-bin2 iconos"></span></a></td>
					</tr>';
					
					$totalCantidad += $registro2['cantidad'];
						
					$totalPNeto += ($registro2['pesoPromedio'] * $registro2['cantidad']);
	
	
		}else{

			$tropa = $registro2['tropa'];
			
			$sql2 = "SELECT SUM(peso) AS pesoTotal, COUNT(tropa) as cantidadTotal, fecha, destino, id FROM egresos WHERE tropa = '$tropa'";
	
			$query2 = mysqli_query($conexion,$sql2);
	
			$resultadosEgr = mysqli_fetch_array($query2);
			
			$pesoPromedio = $resultadosEgr['pesoTotal'] / $resultadosEgr['cantidadTotal'];

				  
			echo '<tr>
					<td>'.formatearFecha($resultadosEgr['fecha']).'</td>
					<td>'.$resultadosEgr['cantidadTotal'].'</td>
					<td>'.$pesoPromedio.' Kg</td>
					<td>'.$resultadosEgr['destino'].'</td>
					<td><a href="verTropa.php?tropa='.$registro2['tropa'].'&seccion=egresos"><span class="icon-eye iconos"></span></a></td>
					<td><a href="stock.php?accion=eliminarEgreso&id='.$resultadosEgr['id'].'&tropa='.$tropa.'" onclick="return confirm(\'¿Eliminar Registro?\');"><span class="icon-bin2 iconos"></span></a></td>
					</tr>';
					
					$totalCantidad += $resultadosEgr['cantidadTotal'];
					
					$totalPNeto += $resultadosEgr['pesoTotal'];
						
					}

					
	
	}


	echo 	'<tr>
		<td><b>SubTotales:</b></td>
		<td><b>'.number_format($totalCantidad,0,",",".").' Animales</b></td>
		<td><b>'.number_format(($totalPNeto / $totalCantidad),2,",",".").' Kg</b></td>
		<td><b>Peso Neto: '.number_format($totalPNeto,2,",",".").' Kg</b></td>
		<td><b><a href="exportar/stockEgr.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-primary btn-block">Exportar</a></b></td>
		<td><b><a href="imprimir/stockEgr.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-primary btn-block" target="_blank">Imprimir</a></b></td>
		</tr>';
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>