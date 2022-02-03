<?php
include('includes/conexion.php');
include('includes/funciones.php');
include('includes/init_session.php');

$desde = (array_key_exists('desde', $_POST)) ? $_POST['desde'] : "";
$hasta = (array_key_exists('hasta', $_POST)) ? $_POST['hasta'] : "";
$renspa = (array_key_exists('renspa', $_POST)) ? trim($_POST['renspa']) : "";
$proveedor = (array_key_exists('proveedor', $_POST)) ? trim($_POST['proveedor']) : "";
$orden = $_POST['orden'];

$sql = array();
$filtros = array();

$sql[] = "feedlot = '$feedlot'";

if ($renspa != "") {
	$sql[] = "renspa = '$renspa'";
	$filtros[] = "Renspa: $renspa";
}

if ($proveedor != "") {
	$sql[] = "proveedor = '$proveedor'";
	$filtros[] = "Proveedor: $proveedor";
}

if ($desde != "" AND $hasta != "") {
	$sql[] = "fecha BETWEEN '$desde' AND '$hasta'";
	$filtros[] = "Periodo ".formatearFecha($desde)." / ".formatearFecha($hasta);
}

$sql = implode(' AND ', $sql);
$filtros = implode(' - ',$filtros);
if ($sql != "") {
	$sql = "WHERE ".$sql;
}

//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$sqlQuery = "SELECT * FROM registroingresos $sql ORDER BY fecha $orden";
$query = mysqli_query($conexion,$sqlQuery);
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped" style="box-shadow: 1px -2px 15px 1px;">
        	<tr>
            	<th>Tropa</th>
                <th style="width:100px;">Fecha</th>
                <th>Cantidad</th>
                <th>Peso Prom.</th>
                <th>Renspa</th>
                <th>ADPV</th>
                <th>Estado</th>
                <th>Proveedor</th>
                <th></th>
                <th></th>
            </tr>';
if(mysqli_num_rows($query)>0){

	$totalCantidad = 0;
	$totalPNeto = 0;
	$pesoPromedio = 0;

	while($registro2 = mysqli_fetch_array($query)){
		
		$tropa = $registro2['tropa'];
		
		$sql2 = "SELECT SUM(peso) AS pesoTotal FROM ingresos WHERE tropa = '$tropa'";

		$query2 = mysqli_query($conexion,$sql2);
			  
		$resultadosIng = mysqli_fetch_array($query2);
			  			  
		echo '<tr>
				<td>'.$registro2['tropa'].'</td>
				<td>'.formatearFecha($registro2['fecha']).'</td>
				<td>'.$registro2['cantidad'].'</td>
				<td>'.$registro2['pesoPromedio'].' Kg</td>
				<td>'.$registro2['renspa'].'</td>
				<td>'.$registro2['adpv'].' Kg</td>
				<td>'.$registro2['estado'].'</td>
				<td>'.$registro2['proveedor'].'</td>
				<td><a href="verTropa.php?tropa='.$registro2['tropa'].'&seccion=ingresos"><span class="icon-eye iconos"></span></a></td>
            	<td><a href="stock.php?accion=eliminarIngreso&id='.$registro2['id'].'&tropa='.$registro2['tropa'].'" onclick="return confirm(\'¿Eliminar Registro?\');"><span class="icon-bin2 iconos"></span></a></td>
				</tr>';
				
				$totalCantidad += $registro2['cantidad'];
				
				if ($feedlot == 'Acopiadora Pampeana') {
					
					$totalPNeto += ($registro2['pesoPromedio'] * $registro2['cantidad']);

				}else{
					
					$totalPNeto += $resultadosIng['pesoTotal'];
					
				}
				
		}
	
echo 	'<tr>
		<td colspan=2><b>SubTotales:</b></td>
		<td><b>'.number_format($totalCantidad,0,",",".").' Animales</b></td>
		<td><b>'.number_format(($totalPNeto / $totalCantidad),2,",",".").' Kg</b></td>
		<td><b>Peso Neto: '.number_format($totalPNeto,2,",",".").' Kg</b></td>
		<td colspan=2><b><a href="exportar/stockIng.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-primary btn-block">Exportar</a></b></td>
		<td colspan=2><b><a href="imprimir/stockIng.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-primary btn-block" target="_blank">Imprimir</a></b></td>
		</tr>';
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>