<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");
require_once('lib/excel/php-excel-reader/excel_reader2.php');
require_once('lib/excel/SpreadsheetReader.php');

if( isset($_POST["submit"]) ){

	$error = false;

	$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

	if(in_array($_FILES["file"]["type"],$allowedFileType)){
		$ruta = "carga/" . $_FILES['file']['name'];
		move_uploaded_file($_FILES['file']['tmp_name'], $ruta);

		$tropaTemp = $_FILES['file']['name'];
		$tropaTemp = explode('.',$tropaTemp);
		$tropa = $tropaTemp[0];

		$Reader = new SpreadsheetReader($ruta);	
		$sheetCount = count($Reader->sheets());

		for($i=0;$i<$sheetCount;$i++){

			$Reader->ChangeSheet($i);
				
			$primera = true;
			foreach ($Reader as $Row){
		                
		        // Evitamos la primer linea
				if($primera){
					$primera = false;
					continue;
				}

				// Obtenemos informacion
			  	
				$fecha= "";
				if(isset($Row[0])) {
					$fecha= mysqli_real_escape_string($conexion,$Row[0]);
				}

				$sexo= "";
				if(isset($Row[1])) {
					$sexo= mysqli_real_escape_string($conexion,$Row[1]);
				}
					
				$raza= "";
				if(isset($Row[2])) {
					$raza= mysqli_real_escape_string($conexion,$Row[2]);
				}
					
				$peso= "";
				if(isset($Row[3])) {
					$peso= mysqli_real_escape_string($conexion,$Row[3]);
				}

				$destino= "";
				if(isset($Row[4])) {
					$destino= mysqli_real_escape_string($conexion,$Row[4]);
				}

				$fecha = fechaExcel($fecha);
			
				// Guardamos en base de datos
				if (!empty($feedlot) || !empty($sexo) || !empty($fecha) || !empty($raza) || !empty($peso) || !empty($destino)) {
					$query = "INSERT INTO egresos(feedlot,tropa,fecha,sexo,raza,peso,destino) VALUES('$feedlot','$tropa','$fecha','$sexo','$raza','$peso','$destino')";

					$result = mysqli_query($conexion, $query);
					echo mysqli_error($conexion);		
					
					}

			}
		}
		header("Location:stock.php?seccion=egreso");
	}
}
?>
