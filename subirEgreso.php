<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");

error_reporting(0);

$fechaHoy = date("Y-m-d");
$feedlot = $_SESSION['feedlot'];

//Aquí es donde seleccionamos nuestro csv
$fname = $_FILES['fileEgr']['name'];

$chk_ext = explode(".",$fname);


if(strtolower(end($chk_ext)) == "csv"){
	//si es correcto, entonces damos permisos de lectura para subir
	$filename = $_FILES['fileEgr']['tmp_name'];

	$handle = fopen($filename, "r");

	$archivoTemp = $_FILES['fileEgr']['name'];

	$archivo = substr($archivoTemp,0,-4);

	$totalAnimales = 0;

	$pesoTotal = 0;	

	$totalGdm = 0;	

	$totalGpv = 0;	

	$contador = 0;
	
	$sqlArchivo = "SELECT COUNT(tropa) as valido FROM egresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";

	$queryArchivo = mysqli_query($conexion,$sqlArchivo);

	$archivoValido = mysqli_fetch_array($queryArchivo);

	echo mysqli_error($conexion);

	if ($archivoValido['valido'] != 0 ) { ?>

		<script type="text/javascript">

			alert("El nombre del Archivo ya esta siendo utilizado. Cambia el nombre del Archivo de Carga.");

			window.location = 'stock.php?seccion=egreso.php';

		</script>
		
	<?php 
		die();
	}


	$fecha = "";

	$raza = "";

	$fechaIngreso = "";


	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE){	

		if ($contador > 4) {
			$IDE = registroVacioString($data[0]);
			$peso = registroVacioNumero($data[1]);
			$pesoTotal += $peso;
			$notas = registroVacioString($data[2]);
			$raza = registroVacioString($data[3]);

			// GENERO ARRAY CON LAS RAZAS DE LA BASE DE DATOS
			$arrayRazas = array();
			$sqlRazas = "SELECT raza FROM razas ORDER BY raza ASC";
			$queryRazas = mysqli_query($conexion,$sqlRazas);
			while ($razas = mysqli_fetch_array($queryRazas)) {
				$arrayRazas[] = $razas['raza'];
			}
			
			if (!in_array($raza, $arrayRazas)) {
				$nuevaRaza = $raza;
				$sqlInsert = "INSERT INTO razas(raza) VALUES('$nuevaRaza')";
				mysqli_query($conexion,$sqlInsert);
			}



			$sexo = registroVacioString($data[4]);
			$proveedor = registroVacioString($data[5]);
			$numeroDTE = registroVacioNumero($data[6]);
			$origen = registroVacioString($data[7]);
			$destino = registroVacioString($data[8]);
			$gdmTotal = registroVacioNumero($data[9]);
			$totalGdm += $gdmTotal;	
			$gpvTotal = registroVacioNumero($data[10]);
			$totalGpv += $gpvTotal;
			$diasTotal = registroVacioNumero($data[11]);
			$fecha = $data[12];
			$fecha = explode('/',$fecha);
			$fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];

			$hora = $data[13];
			
			//Insertamos los datos con los valores...

			$sql = "INSERT INTO egresos(feedlot,tropa,IDE,peso,raza,sexo,proveedor,numeroDTE,origen,destino,notas,gdmTotal,gpvTotal,diasTotal,fecha,hora) 
			VALUES('$feedlot','$archivo','$IDE','$peso','$raza','$sexo','$proveedor','$numeroDTE','$origen','$destino','$notas','$gdmTotal','$gpvTotal','$diasTotal','$fecha','$hora')";
			mysqli_query($conexion,$sql);// or die('<b>Error: Compuebe que el archivo este correcto.</b><br>Intente descargandolo nuevamente, y volviendolo a cargar en el sistema.<br>Para volver a la pagina anterior, click en la flecha ATRAS del navegador.');
			echo mysqli_error($conexion)."<br>";
			$totalAnimales++;

		}
		
		$contador++;
	}


	//cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"

	$pesoProm = $pesoTotal / $totalAnimales;	
	
	$pesoProm = (float)$pesoProm;
	
	$pesoProm =  number_format($pesoProm,2);

	$gdmProm = $totalGdm / $totalAnimales;	

	$gdmProm = (float)$gdmProm;
;
	$gdmProm =  number_format($gdmProm,2);


	$gpvProm = $totalGpv / $totalAnimales;	
	
	$gpvProm = (float)$gpvProm;
	
	$gpvProm =  number_format($gpvProm,2);
	

	$sql = "INSERT INTO registroegresos(feedlot,tropa,fecha,cantidad,pesoPromedio,gmdPromedio,gpvPromedio) 
								VALUES('$feedlot','$archivo','$fecha','$totalAnimales','$pesoProm','$gdmProm','$gpvProm')";
	
	$query = mysqli_query($conexion,$sql);
	echo mysqli_error($conexion);

	fclose($handle);
	
	echo '<script>
				window.location = "stock.php?seccion=egreso";

				</script>';
	}

?>

