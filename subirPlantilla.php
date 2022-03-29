<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");
require_once('lib/excel/php-excel-reader/excel_reader2.php');
require_once('lib/excel/SpreadsheetReader.php');
$fechaHoy = date("Y-m-d");

if( isset($_POST["submit"]) ){
	$contadorIng = $_POST['contadorIng'];
	$contadorEgr = $_POST['contadorEgr'];
	$error = false;
	$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
	if(in_array($_FILES["file"]["type"],$allowedFileType)){
		$ruta = "carga/" . $_FILES['file']['name'];
		move_uploaded_file($_FILES['file']['tmp_name'], $ruta);

		$Reader = new SpreadsheetReader($ruta);	
		$sheetCount = count($Reader->sheets());

		$fecha = "";
		$raza = "";
		$fechaIngreso = "";
		$filaValida = true;
		for($a=0;$a<$sheetCount;$a++){
			$Reader->ChangeSheet($a);
			foreach ($Reader as $data){
				if($filaValida){
					$filaValida = false;
					continue;
				}
				if ($data[1] != "") {
					$tropa = $data[2]."(".$contadorIng.")";

					$cantIngresos = $data[1];
					$peso = $data[10];
					$origen = $data[2];
					$proveedor = $data[2];
					$fecha = fechaExcel($data[0]);
					for ($i=0; $i < $cantIngresos ; $i++) { 
						$sql = "INSERT INTO ingresos(feedlot,tropa,origen,proveedor,peso,fecha) values('$feedlot','$tropa','$origen','$proveedor','$peso','$fecha')";
						mysqli_query($conexion,$sql);
					}

					$contadorIng++;
					
				}
				if ($data[3] != "") {
					$tropa = $data[5]."(".$contadorEgr.")";

					$cantEgresos = $data[3];
					$peso = $data[12];
					$fecha = fechaExcel($data[0]);
					$destino = $data[5];
					for ($i=0; $i < $cantEgresos ; $i++) { 
						$sql = "INSERT INTO egresos(feedlot,tropa,fecha,destino,peso) values('$feedlot','$tropa','$fecha','$destino','$peso')";
						mysqli_query($conexion,$sql);
					}
					$contadorEgr++;
					
				}
				if ($data[4] != "") {
					$cantMuertes = $data[4];
					$fecha = fechaExcel($data[0]);
					$causaMuerte = $data[6];

					$causaMuerte = strtoupper($causaMuerte);
					$sqlCausaMuerte = "SELECT COUNT(causa) AS valido FROM causas WHERE causa = '$causaMuerte'";
					$queryCausa = mysqli_query($conexion,$sqlCausaMuerte);
					$causa = mysqli_fetch_array($queryCausa);

					if ($causa['valido'] == 0) {
						$sql = "INSERT INTO causas(causa) VALUES ('$causaMuerte')";
						mysqli_query($conexion,$sql);
					}

					$sql = "INSERT INTO muertes(feedlot,fecha,muertes,causaMuerte) values('$feedlot','$fecha','$cantMuertes','$causaMuerte')";
					mysqli_query($conexion,$sql);


				}
			}
		}
	}
	unlink($ruta);
	header("Location:subirPlantilla.php");
}
?>
<form name="f1" class="form-horizontal" method="POST" action="subirPlantilla.php" enctype="multipart/form-data"> 
<input type="number" name="contadorIng" placeholder="Contador Ingresos"/>	
<input type="number" name="contadorEgr" placeholder="Contador Egresos"/>	
<input type="submit" class="btn btn-primary btn-lg" name="submit" value="Subir" accept=".xls,.xlsx" />
<input type="file" name="file" required />
</form>

