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

$sqlQuery = "SELECT * FROM registroegresos $sql feedlot = '$feedlot' ORDER BY fecha $orden";


$query = mysqli_query($conexion,$sqlQuery);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX


echo '<table class="table table-striped" style="box-shadow:0px 7px 6px 0px #cbcbcb">
			
			<thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>
                <th>Fecha Egreso</th>
                <th>Cantidad</th>
                <th>Peso Prom.</th>
                <th>Destino</th>
                <th></th>
                <th></th>
            </thead>';

if(mysqli_num_rows($query)>0){

	$totalCantidad = 0;
	$totalPNeto = 0;

	while($registro2 = mysqli_fetch_array($query)){
		
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
				
	
	}


	echo 	'<tr>
			<td><b>SubTotales:</b></td>
			<td><b>'.number_format($totalCantidad,0,",",".").'</b></td>
			<td><b>'.number_format(($totalPNeto / $totalCantidad),2,",",".").' Kg</b></td>
			<td colspan="2"><b>Neto: '.number_format($totalPNeto,0,",",".").' Kg</b></td>
			<td colspan="4"></td>
		</tr>
		<tr>
			<td colspan="4"></td>
			<td><b><a href="exportar/stockEgr.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-primary btn-block"  style="font-size:1.3em;"><span class="icon-file-excel iconos"></span></a></b></td>
			<td  colspan="2"><b><a href="imprimir/stockEgr.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-primary btn-block"  style="font-size:1.3em;" target="_blank"><span class="icon-printer iconos"></span></a></b></td>
		</tr>';

}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>