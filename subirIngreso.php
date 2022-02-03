<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");

error_reporting(0);

$fechaHoy = date("Y-m-d");
$feedlot = $_SESSION['feedlot'];

//Aquí es donde seleccionamos nuestro csv
$fname = $_FILES['fileIng']['name'];

$chk_ext = explode(".",$fname);



if(strtolower(end($chk_ext)) == "csv"){
	//si es correcto, entonces damos permisos de lectura para subir
	$filename = $_FILES['fileIng']['tmp_name'];
	$handle = fopen($filename, "r");

	$adpv = (($_POST['adpv']) != "") ? $_POST['adpv'] : 0;

	$renspa = $_POST['renspa'];
	$tropaTemp = $_FILES['fileIng']['name'];
	$tropa = substr($tropaTemp,0,-4);
	$totalAnimales = 0;
	$pesoTotal = 0;	
	$contador = 0;
	
	$sqlTropa = "SELECT COUNT(tropa) as valido FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
	$queryTropa = mysqli_query($conexion,$sqlTropa);
	$tropaValido = mysqli_fetch_array($queryTropa);
	// echo mysqli_error($conexion);
	if ($tropaValido['valido'] != 0 ) { ?>

				<script type="text/javascript">
					alert("El nombre de la Tropa ya esta siendo utilizado. Cambia el nombre del Archivo de Carga.");
					window.location = 'stock.php?seccion=ingreso.php';
				</script>
				
			<?php 
				die();
			}
			
			$fecha = "";
			$raza = "";
			$fechaIngreso = "";
	
	
			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE){	
				
				if ($contador > 4) {
					
					// GENERO ARRAY CON LAS RAZAS DE LA BASE DE DATOS
					$arrayRazas = array();
					$sqlRazas = "SELECT raza FROM razas ORDER BY raza ASC";
					$queryRazas = mysqli_query($conexion,$sqlRazas);
					while ($razas = mysqli_fetch_array($queryRazas)) {
						$arrayRazas[] = $razas['raza'];
					}
					
					if (!in_array($data[3], $arrayRazas)) {
						$nuevaRaza = $data[3];
						$sqlInsert = "INSERT INTO razas(raza) VALUES('$nuevaRaza')";
						mysqli_query($conexion,$sqlInsert);
					}
					
					$IDE = $data[0];

					$peso = $data[1];
					$pesoTotal += $data[1];

					$notas = $data[2];
					$raza = $data[3];
					$sexo = $data[4];
					$estadoAnimal = $data[5];
					$proveedor = $data[6];
					$corral = $data[7];
					$numeroDTE = $data[8];
					$origen = $data[9];
					$fecha = $data[10];
					$fecha = explode('/',$fecha);
					$fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];
					$hora = $data[11];
					// echo $IDE."-".$peso."-".$notas."-".$raza."-".$sexo."-".$estadoAnimal."-".$proveedor."-".$corral."-".$numeroDTE."-".$origen."-".$fecha."-".$hora."<br>";
					//Insertamos los datos con los valores...
					
					$sql = "INSERT INTO ingresos(feedlot,tropa,adpv,renspa,IDE,peso,raza,sexo,numDTE,origen,proveedor,notas,estadoAnimal,corral,fecha,hora) 
					VALUES('$feedlot','$tropa','$adpv','$renspa','$IDE','$peso','$raza','$sexo','$numeroDTE','$origen','$proveedor','$notas','$estadoAnimal','$corral','$fecha','$hora')";
					mysqli_query($conexion,$sql);// or die('<b>Error: Compuebe que el archivo este correcto.</b><br>Intente descargandolo nuevamente, y volviendolo a cargar en el sistema.<br>Para volver a la pagina anterior, click en la flecha ATRAS del navegador.');
					echo mysqli_error($conexion);
					$totalAnimales++;
				
				}
				$contador++;
			}
			

		//cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
		$sql = "INSERT INTO status(feedlot,tropa,fechaIngreso,animales) VALUES('$feedlot','$tropa','$fecha','$totalAnimales')";
		mysqli_query($conexion,$sql);
		echo mysqli_error($conexion);


		$pesoProm = $pesoTotal / $totalAnimales;	
		$pesoProm = (float)$pesoProm;
		$pesoProm =  number_format($pesoProm,2);
		$sql = "INSERT INTO registroingresos(feedlot,tropa,fecha,cantidad,pesoPromedio,renspa,proveedor,estado,adpv) VALUES('$feedlot','$tropa','$fecha','$totalAnimales','$pesoProm','$renspa','$proveedor','$estadoAnimal','$adpv')";
		mysqli_query($conexion,$sql);
		echo mysqli_error($conexion);
		
		fclose($handle);

		echo '<script>
				window.location = "stock.php?seccion=ingreso";

				</script>';
	}

?>