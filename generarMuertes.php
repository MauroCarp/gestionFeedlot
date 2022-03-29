<?php
include('includes/conexion.php');
include('includes/funciones.php');
include("includes/init_session.php");


$desde = (array_key_exists('desde', $_POST)) ? $_POST['desde'] : "";
$hasta = (array_key_exists('hasta', $_POST)) ? $_POST['hasta'] : "";
$causa = (array_key_exists('causa', $_POST)) ? trim($_POST['causa']) : "";
$orden = $_POST['orden'];
$feedlot = $_SESSION['feedlot'];

$sql = array();
$filtros = array();
if ($causa != "") {
	$sql[] = "causaMuerte = '$causa'";
	$filtros[] = "Causa Muerte = $causa";
}

$sql[] = "feedlot = '$feedlot'";


if ($desde != "" AND $hasta != "") {
	$sql[] = "fecha BETWEEN '$desde' AND '$hasta'";
	$filtros[] = "Periodo: ".formatearFecha($desde)." / ".formatearFecha($hasta);

}

$sql = implode(' AND ', $sql);
$filtros = implode(' - ',$filtros);

if ($sql != "") {
	$sql = "WHERE ".$sql;
}

//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$sqlQuery = "SELECT id, fecha, cantidad, causaMuerte, tropa FROM registromuertes $sql ORDER BY fecha $orden";
$query = mysqli_query($conexion,$sqlQuery);
echo mysqli_error($conexion);
//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped" style="box-shadow: 1px -2px 15px 1px;">
        	<tr>
                <th>Fecha Muerte</th>
                <th>Cantidad</th>
                <th>Causa Muerte</th>
                <th></th>
                <th></th>
            </tr>';
if(mysqli_num_rows($query)>0){

	$totalMuertes = 0;

	while($registro2 = mysqli_fetch_array($query)){
		echo '<tr>
				<td>'.formatearFecha($registro2['fecha']).'</td>
				<td>'.$registro2['cantidad'].'</td>
				<td>'.$registro2['causaMuerte'].'</td>
				<td><a style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modalEditarCausa" onclick="editarCausa(\''.$registro2['id'].'\')"><span class="icon-pencil iconos"></span></a></td>
            	<td><a href="stock.php?accion=eliminarMuerte&id='.$registro2['id'].'&tropa='.$registro2['tropa'].'" onclick="return confirm(\'¿Eliminar Registro?\');"><span class="icon-bin2 iconos"></span></a></td>
            	
				</tr>';
				$totalMuertes += $registro2['cantidad'];
		}
		echo 	'<tr>
			<td><b>SubTotales:</b></td>
			<td><b>'.number_format($totalMuertes,0,",",".").' Animales</b></td>
			<td></td>
			<td><b><a href="exportar/stockMuertes.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-primary btn-block"  style="font-size:1.3em;"><span class="icon-file-excel iconos"></span></a></b></td>
			<td><b><a href="imprimir/stockMuertes.php?sql='.$sqlQuery.'&filtros='.$filtros.'" class="btn btn-primary btn-block"  style="font-size:1.3em;" target="_blank"><span class="icon-printer iconos"></span></a></b></td>
		</tr>';

}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>