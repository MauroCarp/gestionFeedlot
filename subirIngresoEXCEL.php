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

		var_dump('hola');

		$Reader = new SpreadsheetReader($ruta);	
		$sheetCount = count($Reader->sheets());
		for($i=0;$i<$sheetCount;$i++){
			$Reader->ChangeSheet($i);

			
			if ($i == 0) {

				$primera = true;
								
				foreach ($Reader as $Row){

					if($primera){
						
						$primera = false;
						
						continue;

					}
					$id_receta = "";
					
					if(isset($Row[0])) {
						
						$id_receta = mysqli_real_escape_string($conexion,$Row[0]);
						
					}
					
					$nombre = "";

					if(isset($Row[1])) {
						
						$nombre = mysqli_real_escape_string($conexion,$Row[1]);
						
					}
					
					$tipo = "";
					
					if(isset($Row[2])) {
						
						$tipo = mysqli_real_escape_string($conexion,$Row[2]);
						
					}
					
					$tipoMezcla = "";
					
					if(isset($Row[3])) {
						
						$tipoMezcla = mysqli_real_escape_string($conexion,$Row[3]);
						
					}
					
					$columns = array();
					$values  = array();

					$contador = 1;
					$contadorTemp = 1;
					
					for ($a=4; $a < 30; $a++) { 
						
						$ingrediente = "";
						
						if(isset($Row[$a])){

							if($Row[$a] != '') {
							
								if ($a%2==0){
									
									$ingrediente = mysqli_real_escape_string($conexion,$Row[$a]);
									
									$columns[] = 'ingrediente'.$contadorTemp;
									
									$values[]  = "'".$ingrediente."'";
									
								}else{
									
									$cantidad = mysqli_real_escape_string($conexion,$Row[$a]);
									
									$columns[] = 'cantidad'.$contadorTemp;
									
									$values[]  = "'".$cantidad."'";
									
									$contadorTemp++;
									
								}
							}
							
						}
						
					}
					
					$columns = implode(',',$columns);
					$values = implode(',',$values);
					
					$sql = "INSERT INTO mixer_recetas(id_receta,nombre,tipo,tiempoMezcla,$columns) VALUES ('$id_receta','$nombre','$tipo','$tipoMezcla',$values)";

					mysqli_query($conexion,$sql);					

				}

			}
			
			if ($i == 4) {

				$primera = true;
								
				foreach ($Reader as $Row){

					if($primera){
						
						$primera = false;
						
						continue;

					}

					$id_carga = "";
					
					if(isset($Row[0])) {
						
						$id_carga = mysqli_real_escape_string($conexion,$Row[0]);
						
					}
					
					$fecha = "";

					if(isset($Row[1])) {
						
						$fecha = mysqli_real_escape_string($conexion,$Row[1]);
						
					}
					
					$hora = "";
					
					if(isset($Row[2])) {
						
						$hora = mysqli_real_escape_string($conexion,$Row[2]);
						
					}
					
					$id_receta = "";
					
					if(isset($Row[3])) {
						
						$id_receta = mysqli_real_escape_string($conexion,$Row[3]);
						
					}
					
					$ingrediente = "";
					
					if(isset($Row[5])) {
						
						$ingrediente = mysqli_real_escape_string($conexion,$Row[5]);
						
					}
					
					$cantidad = "";
					
					if(isset($Row[6])) {
						
						$cantidad = mysqli_real_escape_string($conexion,$Row[6]);
						
					}
					
					$ideal = "";
					
					if(isset($Row[7])) {
						
						$ideal = mysqli_real_escape_string($conexion,$Row[7]);
						
					}
					
					
					
					$sql = "INSERT INTO mixer_recetas(id_receta,nombre,tipo,tiempoMezcla,$columns) VALUES ('$id_receta','$nombre','$tipo','$tipoMezcla',$values)";

					mysqli_query($conexion,$sql);					

				}

			}

			
			if ($i == 5) {
				
				$primera = true;
				
				echo 'DESCARGAS<br>';
				
				foreach ($Reader as $Row){

					if($primera){
						
						$primera = false;
						
						continue;

					}

					// echo $Row[0].'<br>';

				}

			}
			
				// // Obtenemos informacion
				// $fecha= "";
				// if(isset($Row[0])) {
				// 	$fecha= mysqli_real_escape_string($conexion,$Row[0]);
				// }
			  	
// 				$cantidad= "";
// 				if(isset($Row[1])) {
// 					$cantidad= mysqli_real_escape_string($conexion,$Row[1]);
// 				}
				
// 				$destino= "";
// 				if(isset($Row[2])) {
// 					$destino= mysqli_real_escape_string($conexion,$Row[2]);
// 				}else{
// 					$destino = "";
// 				}

// 				$peso= "";
// 				if(isset($Row[6])) {
// 					$peso= mysqli_real_escape_string($conexion,$Row[6]);
// 				}

// 				if ($peso == '' OR $peso == '-') {
// 					$peso = 0;
// 				}
// 				if ($peso != 0) {
// 					$peso = number_format($peso,2);
// 				}

// 				$fecha = fechaExcel($fecha);
// 				//echo $origen." / ".$cantidad." / ".$peso;
// 				//echo "<br>";
// 				if ($destino == "") {
// 					$tropa = "Sin Nombre(".$contador.")";
// 				}else{
// 					$tropa = $destino."(".$contador.")";
// 				}


// 				// Guardamos en base de datos
// 				for ($i=0; $i < $cantidad ; $i++) { 
// 					$sqlInsert = "INSERT INTO egresos(feedlot,tropa,fecha,destino,peso) VALUES ('Acopiadora Pampeana','$tropa','$fecha','$destino','$peso')";
// ;
// 					mysqli_query($conexion,$sqlInsert);
// 					echo mysqli_error($conexion);
// 				}

// 			$contador++;
			}
		}
	}



?>

<form name="f1" class="form-horizontal" method="POST" action="subirIngresoExcel.php" enctype="multipart/form-data"> 
<input type="submit" class="btn btn-primary btn-lg" name="submit" value="Subir" accept=".xls,.xlsx" />
<input type="file" name="file" required />
</form>
