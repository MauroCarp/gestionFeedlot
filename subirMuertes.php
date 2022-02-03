<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");

error_reporting(0);

$fechaHoy = date("Y-m-d");
$feedlot = $_SESSION['feedlot'];

//Aquí es donde seleccionamos nuestro csv
$fname = $_FILES['fileMuertes']['name'];

$chk_ext = explode(".",$fname);



if(strtolower(end($chk_ext)) == "csv"){
	//si es correcto, entonces damos permisos de lectura para subir
	$filename = $_FILES['fileMuertes']['tmp_name'];

	$handle = fopen($filename, "r");

	$tropaTemp = $_FILES['fileMuertes']['name'];

	$tropa = substr($tropaTemp,0,-4);

	$totalAnimales = 0;

	$causaMuerte = $_POST['causaMuerte'];

	$contador = 0;

	
	$sqlTropa = "SELECT COUNT(tropa) as valido FROM muertes WHERE tropa = '$tropa' AND feedlot = '$feedlot'";

	$queryTropa = mysqli_query($conexion,$sqlTropa);

	$tropaValido = mysqli_fetch_array($queryTropa);

	// echo mysqli_error($conexion);

	if ($tropaValido['valido'] != 0 ) { ?>

				<script type="text/javascript">
					alert("El nombre de el Archivo ya esta siendo utilizado. Cambia el nombre del Archivo de Carga.");
					window.location = 'stock.php?seccion=muertes.php';
				</script>
				
			<?php 
				die();
			}
			
			$fecha = "";
			$raza = "";
			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE){	
				
				if ($contador > 4) {
					$IDE = registroVacioString($data[0]);	
					$peso = registroVacioNumero($data[1]);
					$notas = registroVacioString($data[2]);
					$sexo = registroVacioString($data[3]);
					$proveedor = registroVacioString($data[4]);
					$corral = registroVacioString($data[5]);
					$origen = registroVacioString($data[6]);
					$diasTotal = registroVacioNumero($data[7]);
					$fecha = $data[9];
					$fecha = explode('/',$fecha);
					$fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];
					$hora = $data[10];
					
					//Insertamos los datos con los valores...
					
					$sql = "INSERT INTO muertes(feedlot,tropa,IDE,peso,sexo,proveedor,corral,origen,totalDias,causaMuerte,fecha,hora) 
						VALUES('$feedlot','$tropa','$IDE','$peso','$sexo','$proveedor','$corral','$origen','$diasTotal','$causaMuerte','$fecha','$hora')";

					mysqli_query($conexion,$sql);

					// or die('<b>Error: Compuebe que el archivo este correcto.</b><br>Intente descargandolo nuevamente, y volviendolo a cargar en el sistema.<br>Para volver a la pagina anterior, click en la flecha ATRAS del navegador.');
					// echo mysqli_error($conexion);
					$totalAnimales++;
					
				}
				$contador++;
			}
			
			//cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
			
			$sql = "INSERT INTO registromuertes(feedlot,tropa,fecha,cantidad,causaMuerte) VALUES('$feedlot','$tropa','$fecha','$totalAnimales','$causaMuerte')";
			$query = mysqli_query($conexion,$sql);
			echo mysqli_error($conexion);
			
			fclose($handle);
			echo '<script>
			window.location = "stock.php?seccion=muerte";

			</script>';
}

?>
