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


		$Reader = new SpreadsheetReader($ruta);	
		$sheetCount = count($Reader->sheets());
		$contador = 2;
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
			  	
				$cantidad= "";
				if(isset($Row[1])) {
					$cantidad= mysqli_real_escape_string($conexion,$Row[1]);
				}
				
				$causaMuerte= "";
				if(isset($Row[2])) {
					$causaMuerte= mysqli_real_escape_string($conexion,$Row[2]);
				}

				$fecha = fechaExcel($fecha);
				$causaMuerte = strtoupper($causaMuerte);
				$sqlCausaMuerte = "SELECT COUNT(causa) AS valido FROM causas WHERE causa = '$causaMuerte'";
				$queryCausa = mysqli_query($conexion,$sqlCausaMuerte);
				$causa = mysqli_fetch_array($queryCausa);

				if ($causa['valido'] == 0) {
					$sql = "INSERT INTO causas(causa) VALUES ('$causaMuerte')";
					mysqli_query($conexion,$sql);
				}



				// Guardamos en base de datos
				$sqlInsert = "INSERT INTO muertes(feedlot,fecha,muertes,causaMuerte) VALUES ('Acopiadora Pampeana','$fecha','$cantidad','$causaMuerte')";
				mysqli_query($conexion,$sqlInsert);
				echo mysqli_error($conexion);
				

			$contador++;
			}
		}
	}
}


?>
<form name="f1" class="form-horizontal" method="POST" action="subirMuertesExcel.php" enctype="multipart/form-data"> 
<input type="submit" class="btn btn-primary btn-lg" name="submit" value="Subir" accept=".xls,.xlsx" />
<input type="file" name="file" required />
</form>
