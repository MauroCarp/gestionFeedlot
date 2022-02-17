<?php
include('includes/conexion.php');
include('includes/funciones.php');
include('includes/init_session.php');

$desde = (array_key_exists('desde', $_POST)) ? $_POST['desde'] : "";
$hasta = (array_key_exists('hasta', $_POST)) ? $_POST['hasta'] : "";
$renspa = (array_key_exists('renspa', $_POST)) ? trim($_POST['renspa']) : "";
$proveedor = (array_key_exists('proveedor', $_POST)) ? trim($_POST['proveedor']) : "";
$estado = (array_key_exists('estado', $_POST)) ? trim($_POST['estado']) : "";
$pesoMin = (array_key_exists('pesoMin', $_POST)) ? trim($_POST['pesoMin']) : "";

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

if ($estado != "") {
	$sql[] = "estado = '$estado'";
	$filtros[] = "Estado: $estado";
}

if ($pesoMin != "") {
	
	$pesoMax = $_POST['pesoMax'];

	$sql[] = "(pesoPromedio BETWEEN '$pesoMin' AND '$pesoMax')";
	$filtros[] = "Rango Peso: $pesoMin Kg - $pesoMax Kg";

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

echo '<table class="table table-striped" style="box-shadow:0px 7px 6px 0px #cbcbcb">
			
			<thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>
            	<th>Tropa</th>
                <th style="width:100px;">Ingreso</th>
                <th>Cantidad</th>
                <th>Peso Prom.</th>
                <th>Renspa</th>
                <th>ADPV</th>
                <th>Estado</th>
                <th>Proveedor</th>
                <th></th>
                <th></th>
            </thead>';
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
									
				$totalPNeto += ($registro2['pesoPromedio'] * $registro2['cantidad']);


				
		}
	
echo 	'<tr>
			<td colspan=2><b>SubTotales:</b></td>
			<td><b>'.number_format($totalCantidad,0,",",".").'</b></td>
			<td><b>'.number_format(($totalPNeto / $totalCantidad),2,",",".").' Kg</b></td>
			<td><b>Neto: '.number_format($totalPNeto,2,",",".").' Kg</b></td>
			<td colspan="5"></td>
			</tr>
			<tr>
			<td colspan="7"></td>
			<td><b><a href="exportar/stockIng.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-default btn-block" style="font-size:1.3em;"><span class="icon-file-excel iconos"></span></a></b></td>
			<td colspan="2"><b><a href="imprimir/stockIng.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-default btn-block" target="_blank" style="font-size:1.3em;"><span class="icon-printer iconos"></span></a></b></td>
		</tr>';
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>