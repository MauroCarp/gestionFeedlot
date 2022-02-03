<?php
function comprobarExisteCampo($nombreCampo) {
    $resultado = false;
    if( array_key_exists($nombreCampo, $_REQUEST) ){     
        $resultado = true;
    }
    return $resultado;
  }


function diferenciaDias($fechaProc){
	$fechaProc = new DateTime($fechaProc);
	$fechaDeHoy = date('Y-m-d');
	$fechaDeHoy = new DateTime($fechaDeHoy);
	$diasDiferencia = $fechaProc->diff($fechaDeHoy);
    $diasDiferencia = $diasDiferencia->days;
    return $diasDiferencia;
}

function esVencido($diferenciaDias,$procedimiento){
	$esVencido = FALSE;
	if ($procedimiento == 'Metafilaxis' AND $diferenciaDias > 7) {
		$esVencido = TRUE;
	}
	if ($procedimiento == '1er Dosis' AND $diferenciaDias > 15) {
		$esVencido = TRUE;
	}
	return $esVencido;
}

function esProximo($diferenciaDias,$procedimiento){
	$esProximo = FALSE;
	if ($procedimiento == 'Metafilaxis' AND $diferenciaDias <= 7 AND $diferenciaDias >= 2 ) {
		$esProximo = TRUE;
	}
	if ($procedimiento == '1er Dosis' AND $diferenciaDias <= 15 AND $diferenciaDias >= 7) {
		$esProximo = TRUE;
	}
		return $esProximo;
}

function formatearFecha($fecha){
	if ($fecha == NULL) {
		$fechaFormateada = '';
	}else{	
  		$fechaFormateada = date("d-m-Y",strtotime($fecha));
	}
  return $fechaFormateada;
}

function validarCampo($campo){
	$campoValido = array_key_exists($campo, $_POST);
	$valorCampo = "";
	if ($campoValido) {
		$valorCampo = $_POST[$campo];
	}
	return $valorCampo;
	}

function porcentaje($valor,$total){
	$resultadoPorcentaje = ($valor*100)/$total;
	$resultadoPorcentaje = round($resultadoPorcentaje,2);
	return $resultadoPorcentaje;
}

function porcentajeMS($porcentaje,$porcentajeMSinsumo){
	
	$porcentajeMS = $porcentaje * ($porcentajeMSinsumo/100);
	
	$porcentajeMS = round($porcentajeMS,2);
	
	return $porcentajeMS;
	
}

function ultimaFecha($insumo,$conexion){
	$sql = "SELECT MAX(fecha) AS ultimaFecha FROM insumos WHERE insumo = '$insumo'";
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);

	return $fila['ultimaFecha'];
}

function traeDatos($ultimaFecha,$insumo,$conexion){
	$sql = "SELECT * FROM insumos WHERE insumo = '$insumo' AND fecha = '$ultimaFecha'";
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);

	return $fila;	
}

function nombreInsumo($productoN,$productoResultado,$conexion){
	$sql = "SELECT * FROM formulas INNER JOIN insumos ON formulas.$productoN = insumos.id WHERE insumos.id = '$productoResultado'";
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);
	$resultado = $fila['insumo'];
	return $resultado;
}

function precioInsumo($productoN,$productoResultado,$conexion){
	$sql = "SELECT * FROM formulas INNER JOIN insumos ON formulas.$productoN = insumos.id WHERE insumos.id = '$productoResultado'";
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);
	$resultado = $fila['precio'];
	return $resultado;
}

function tomaPorcentajeMS($productoN,$productoResultado,$conexion){
	
	$sql = "SELECT * FROM formulas INNER JOIN insumos ON formulas.$productoN = insumos.id WHERE insumos.id = '$productoResultado'";
	
	$query = mysqli_query($conexion,$sql);
	
	$fila = mysqli_fetch_array($query);
	
	$resultado = $fila['porceMS'];
	
	return $resultado;
}

function obtenerMSinsumo($id_insumo,$conexion){

	$sql = "SELECT porceMS FROM insumos WHERE id = '$id_insumo'";

	$query = mysqli_query($conexion,$sql);

	$resultado = mysqli_fetch_array($query);

	$msInsumo = $resultado['porceMS'];

	return $msInsumo;

}
function nombreFormula($id,$conexion){
	$sqlFormula = "SELECT tipo,nombre FROM formulas WHERE id = '$id'";
	$queryFormula = mysqli_query($conexion,$sqlFormula);
	$filaFormula = mysqli_fetch_array($queryFormula);
	$resultado = $filaFormula['tipo']." - ".$filaFormula['nombre'];
	return $resultado;
}

function getLabels($feedlot,$conexion){
	$sqlLabel = "SELECT DISTINCT causaMuerte FROM muertes WHERE feedlot = '$feedlot' ORDER BY causaMuerte ASC";
	$queryLabel = mysqli_query($conexion,$sqlLabel);
	$labels = array();
	while ($label = mysqli_fetch_array($queryLabel)) {
	$labels[] = $label['causaMuerte'];
	}
	return $labels;
}

function cantidadCausa($feedlot,$conexion,$causa){
	$sql = "SELECT SUM(cantidad) as total FROM registromuertes WHERE feedlot = '$feedlot' AND causaMuerte = '$causa'";
	$query = mysqli_query($conexion,$sql);
	$resultado = mysqli_fetch_array($query);
	return $resultado['total'];

}

function fechaExcel($fecha){
	$fechaTemp = explode("-",$fecha);
	$nuevaFecha = $fechaTemp[1]."-".$fechaTemp[0]."-".$fechaTemp[2];
	$standarddate = "20".substr($nuevaFecha,6,2) . "-" . substr($nuevaFecha,3,2) . "-" . substr($nuevaFecha,0,2);
	return $standarddate;
}

function cantRaza($raza,$seccion,$tropa,$conexion){
	$sql = "SELECT COUNT(raza) AS cantidad FROM $seccion WHERE raza = '$raza' AND tropa = '$tropa'";
	$query = mysqli_query($conexion,$sql);
	$resultado = mysqli_fetch_array($query);
	$cantidad = $resultado['cantidad'];

	return $cantidad;
}


function cantRazaInforme($raza,$seccion,$feedlot,$desde,$hasta,$conexion){
	$sql = "SELECT COUNT(raza) AS cantidad FROM $seccion WHERE raza = '$raza' AND feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
	$query = mysqli_query($conexion,$sql);
	$resultado = mysqli_fetch_array($query);
	$cantidad = $resultado['cantidad'];

	return $cantidad;
}



function stock($fecha,$feedlot,$conexion){
	
	$sqlIng = "SELECT SUM(cantidad) AS cantidad FROM registroingresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '2010-01-01' AND '$fecha'";
    $queryIng = mysqli_query($conexion,$sqlIng);
    $resultadoIng = mysqli_fetch_array($queryIng);
    $cantIng = $resultadoIng['cantidad'];


    $sqlEgr = "SELECT SUM(cantidad) AS cantidad FROM registroegresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '2010-01-01' AND '$fecha'";
    $queryEgr = mysqli_query($conexion,$sqlEgr);
    $resultadoEgr = mysqli_fetch_array($queryEgr);
    $cantEgr = $resultadoEgr['cantidad'];


    $sqlMuertes = "SELECT SUM(cantidad) AS cantidad FROM registromuertes WHERE feedlot = '$feedlot' AND fecha BETWEEN '2010-01-01' AND '$fecha'";
    $queryMuertes = mysqli_query($conexion,$sqlMuertes);
    $resultadoMuertes = mysqli_fetch_array($queryMuertes);
    $cantMuertes = $resultadoMuertes['cantidad'];


    $stock = $cantIng;
    if ($cantEgr != 0) {
      $stock -= $cantEgr;
    }

    if ($cantMuertes != 0) {
      $stock -= $cantMuertes;
    }

	return $stock;

}

function porceMS($id_producto,$porcentaje,$conexion){

    $sql = "SELECT porceMS FROM insumos WHERE id = '$id_producto'";

    $query = mysqli_query($conexion,$sql);
    
    $resultado = mysqli_fetch_array($query);

    $porceMSinsumo = $resultado['porceMS'];

    $porceMS = $porcentaje * ($porceMSinsumo / 100);

    return $porceMS;
}


function traerNombreInsumo($id,$conexion){
	$sqlIns = "SELECT insumo FROM insumos WHERE id = '$id'";
    $queryIns = mysqli_query($conexion,$sqlIns);
    $resultadoIns = mysqli_fetch_array($queryIns);
    $nombre = $resultadoIns['insumo'];
    return $nombre;	
}

function paginador($seccion,$feedlot,$conexion){

	$sql = "SELECT COUNT(*) as cantidad FROM $seccion WHERE feedlot = '$feedlot'";

	if ($seccion == 'muertes') {
		$sql = "SELECT COUNT(*) as cantidad FROM $seccion WHERE feedlot = '$feedlot'";
	}
	
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);
	$totalRegistros = $fila['cantidad'];
	$totalPaginas = 1;
	if ($totalRegistros > 12) {
		$totalPaginas = $totalRegistros / 12;
		$totalPaginas += 1;
	}

	$totalPaginas = round($totalPaginas,0,PHP_ROUND_HALF_UP);

	$paginador = "";

	for ($i=0; $i <= $totalPaginas ; $i++) { 
		if ($i != 0) {
			$paginador = $paginador.'<li style="cursor:pointer;"><a onclick="paginar(\''.($i-1).'\',\''.$seccion.'\')">'.$i.'</a></li>'."\n";
		}else{
			$paginador = $paginador.'<li style="cursor:pointer;"><a onclick="paginar(\''.($i).'\',\''.$seccion.'\')">&laquo;</a></li>'."\n";
		}
	}

	return $paginador;
}

function nombreMes($numero){
	include('arrays.php');
	$mes = "";
	foreach ($nombreMes as $num => $nombre) {
		if ($numero == $num) {
			$mes = "'".$nombre."'";
		}
	}
	return $mes;
}

function formatearNum($numero){
	$numeroFormateado = number_format($numero,2,",",".");
	return $numeroFormateado;
}

function labelsCantAnimales($fechaDesde,$fechaHasta){
	  $numeroDesde = date("n", strtotime($fechaDesde));
	  $numeroHasta = date("n", strtotime($fechaHasta));

	  $cantMeses = $numeroHasta - $numeroDesde;
	  $meses[$numeroDesde] = nombreMes($numeroDesde);
	  $contador = $numeroDesde;
	  for ($i=1; $i < $cantMeses; $i++) { 
	    $numero = $contador + $i; 
	    $meses[$numero] = nombreMes($numero);
	  }
	  $meses[$numeroHasta] = nombreMes($numeroHasta);

	  return $meses;
	
}

function registroVacioString($registro){
	$dato = ($registro != "") ? $registro : 'Sin Registro';

	return $dato;
}

function registroVacioNumero($registro){
	$dato = ($registro != "") ? $registro : 0;

	return $dato;
}

function registroVacioFecha($registro){
	$dato = ($registro != "") ? $registro : '0000-00-00';

	return $dato;
}

function obtenerMax($campo,$tabla,$conexion){
	$sql = "SELECT MAX($campo) as maximo FROM $tabla";
	$query = mysqli_query($conexion,$sql);
	echo mysqli_error($conexion);
	$resultado = mysqli_fetch_array($query);
	$maximo = ($resultado['maximo'] != '') ? $resultado['maximo'] : 0;
	return $maximo;
}


function dataInsumoPremix($id,$campo,$conexion){

	$sql = "SELECT $campo FROM insumospremix WHERE id = '$id'";

	$query = mysqli_query($conexion,$sql);

	$resultado = mysqli_fetch_array($query);

	return $resultado[$campo];
}	

function obtenerTipoInsumo($nombreInsumo,$conexion){

	$sql = "SELECT tipo FROM insumos WHERE insumo = '$nombreInsumo'";

	$query = mysqli_query($conexion,$sql);

	$resultado = mysqli_fetch_array($query);

	return $resultado['tipo'];

}


?>

