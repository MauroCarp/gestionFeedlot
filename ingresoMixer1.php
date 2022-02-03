<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");
require_once('lib/excel/php-excel-reader/excel_reader2.php');
require_once('lib/excel/SpreadsheetReader.php');

function validateTypeDate($fecha){

	$fecha = explode('/',$fecha);

	$fechaValida = (sizeof($fecha) == 3) ? TRUE : FALSE;
                        
	return $fechaValida;

}

function validarColumna($valor,$campo){

	if($valor != '' ){
		
		$campoValido = TRUE;
		
	}else{
		
		$campoValido[] = FALSE;

		$arrayErrores[] = 'Hay un error en la '.$campo.'. Verifique que los datos no esten en blanco, o tengan el formato correcto.';
		
	} 
		


	return $campoValido;

}

$arrayHojas = array(0=>'Recetas',4=>'Cargas',5=>'Descargas');

$arrayErrores = array();

if( isset($_POST["submit"]) ){
	$error = false;

	$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

	if(in_array($_FILES["file"]["type"],$allowedFileType)){

		$ruta = "carga/" . $_FILES['file']['name'];
		move_uploaded_file($_FILES['file']['tmp_name'], $ruta);
		
        $archivo = $_FILES['file']['name']; 

		$Reader = new SpreadsheetReader($ruta);	
		
		$sheetCount = count($Reader->sheets());

		if($sheetCount == 1){

            echo "<script>
            
            alert('El archivo cargado no es del Mixer 456ST');
            
            window.location = 'raciones.php';
            
            </script>";

			die();

        }

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
					
					$sql = "INSERT INTO mixer_recetas(id_receta,archivo,nombre,tipo,tiempoMezcla,$columns) VALUES ('$id_receta','$archivo','$nombre','$tipo','$tipoMezcla',$values)";
					mysqli_query($conexion,$sql);		

				}

			}
            


			/******* 
			 * 			CARGAS
			 * 					*******/
			
			 
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

						$tipoFechaValida = validateTypeDate($fecha);

						$fechaValida = FALSE;

						if($tipoFechaValida){

							$fechaError = $fecha;

							$fecha = explode('/',$fecha);

							if($fecha[1] > 12){

								$arrayErrores[] = 'Hay un error en la Columna Fecha de la Hoja Cargas. Posiblemente el formato de fecha no sea el correcto. Modifiquelo. El formato debe ser el siguiente dd/mm/yyyy ej(01/01/2020)';

								$fechaValida = FALSE;

							}else{

								$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];

								$fechaTemp = $fecha;

								$fechaValida = TRUE;
							}

							

						}else{
							
							$fecha = $fechaTemp;
							
							$fechaValida = TRUE;
							
						}	
						
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
					
					$ingredienteValido = FALSE;

					if(isset($Row[5])) {
						
						$ingrediente = mysqli_real_escape_string($conexion,$Row[5]);

						if($ingrediente == ''){

							$ingredienteValido = FALSE;

							$arrayErrores[] = 'Hay un error en la Columna Ingrediente en la Hoja Cargas. Verifique que los datos no esten en blanco, o tengan el formato correcto.';

						}else{

							$ingredienteValido = TRUE;

						}
						
					}
					
					$cantidad = "";

					$validarCantidad = FALSE;
					
					if(isset($Row[6])) {
						
						$cantidad = mysqli_real_escape_string($conexion,$Row[6]);
						
						if($cantidad == ''){

							$cantidadValido = FALSE;

							$arrayErrores[] = 'Hay un error en la Columna Cantidad en la Hoja Cargas. Verifique que los datos no esten en blanco, o tengan el formato correcto.';

						}else{

							$cantidadValido = TRUE;
							
						}

					}
					
					$ideal = "";
					
					$idealValido = FALSE;

					if(isset($Row[7])) {
						
						$ideal = mysqli_real_escape_string($conexion,$Row[7]);

						if($ideal == ''){

							$idealValido = FALSE;

							$arrayErrores[] = 'Hay un error en la Columna Ideal en la Hoja Cargas. Verifique que los datos no esten en blanco, o tengan el formato correcto.';

						}else{

							$idealValido = TRUE;
							
						}
						
					}
					


					if($fechaValida AND $ingredienteValido AND $cantidadValido AND $idealValido){
						
						$sql = "INSERT INTO mixer_cargas(archivo,mixer,id_carga,fecha,hora,ingrediente,cantidad,ideal,id_receta) VALUES ('$archivo','mixer1','$id_carga','$fecha','$hora','$ingrediente','$cantidad','$ideal','$id_receta')";
						
						mysqli_query($conexion,$sql);	
						
						echo mysqli_error($conexion);
						
					}else{

						var_dump('HUBO ERRORES EN CARGAS');

						echo "<script>
								alert('";
						for ($a=0; $a < sizeof($arrayErrores) ; $a++) { 

							echo $arrayErrores[$a]."\\n";

						}

						echo "')</script>";

						die();

						$sql = "DELETE FROM mixer_cargas WHERE archivo = '$archivo'";
	
						mysqli_query($conexion,$sql);

						echo mysqli_error($conexion);
						
						$sql = "DELETE FROM mixer_descargas WHERE archivo = '$archivo'";
						
						mysqli_query($conexion,$sql);
						
						echo mysqli_error($conexion);
					
						$sql = "DELETE FROM mixer_recetas WHERE archivo = '$archivo'";
						
						mysqli_query($conexion,$sql);
						
						echo mysqli_error($conexion);
						echo "<script>
							window.location = 'raciones.php';
						</script>";


					}

				}

			}

			
			/******* 
			 * 			DESCARGAS
			 * 					*******/

			if ($i == 5) {
				
				$primera = true;
				$cont = 0;		
				foreach ($Reader as $Row){

					$cont++;

					if($primera){
						
						$primera = false;
						
						continue;

					}

					// ID DESCARGA 

					$id_descarga = "";
					
					if(isset($Row[0])) {
						
						$id_descarga = mysqli_real_escape_string($conexion,$Row[0]);

						if ($id_descarga == '') {

							if($Row == 0){
							
								$id_descarga = 1;
							
							}else{

								$id_descarga = $idTemp;

							}


						}

						$idTemp = $id_descarga;
						
					}

					// FECHA

					$fecha = "";

					if(isset($Row[1])) {
						
                        $fecha = mysqli_real_escape_string($conexion,$Row[1]);
                        
						$tipoFechaValida = validateTypeDate($fecha);

						$fechaValida = FALSE;
						
						if($tipoFechaValida){

							$fechaError = $fecha;

							$fecha = explode('/',$fecha);

							if($fecha[1] > 12){

								$arrayErrores[] = 'Hay un error en la Columna Fecha de la Hoja Descargas. Posiblemente el formato de fecha no sea el correcto. Modifiquelo. El formato debe ser el siguiente dd/mm/yyyy ej(01/01/2020) Fila:'.$cont;

								$fechaValida = FALSE;

							}else{

								$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];

								$fechaTemp = $fecha;

								$fechaValida = TRUE;
							}
						
                    	}else{

							$fecha = $fechaTemp;

							$fechaValida = TRUE;

						}
					}
				
					// HORA

					$hora = "";
					
					if(isset($Row[2])) {
						
						$hora = mysqli_real_escape_string($conexion,$Row[2]);

						$horaValida = preg_match('/([0-9][0-9])(:)([0-9][0-9])/',$hora);

						if($horaValida){

							$hora = $hora.':00';

							$horaTemp = $hora;

						}else{
							
							$hora = $horaTemp;
								
						}
						
					}
				
					$lote = "";
					
					if(isset($Row[5])) {
						$cont ++;
						$lote = $Row[5];

						$loteValido = ($lote != '') ? TRUE : FALSE; 

						if(!$loteValido){

							echo "<script>
								
								alert('Hay un formato erroneo o vacío en la la columna LOTE de la hoja de $arrayHojas[$i] en la fila: $cont');
								
								window.location = 'raciones.php?accion=eliminar&archivo=".$archivo."';
								
								</script>";

						}
						
					}
					
					$cantidad = "";
					
					if(isset($Row[6])) {
						
						$cantidad = mysqli_real_escape_string($conexion,$Row[6]);

						$cantidad = ($cantidad == '' OR $cantidad == '-') ? 0 : $cantidad;

					}
					
					$animales = "";
					
					if(isset($Row[7])) {
						
						$animales = $Row[7];

						if($animales == '')
						$animales = 0;
						
					}
                
                    $operario = "";
					
					if(isset($Row[8])) {
						
						$operario = mysqli_real_escape_string($conexion,$Row[8]);
						
						if($operario == ''){

							$operario = $operarioTemp;

						}

						$operarioTemp = $operario;

					}


					if($fechaValida){

						$sql = "INSERT INTO mixer_descargas(archivo,mixer,id_descarga,id_carga,fecha,hora,lote,cantidad,animales,operario) VALUES ('$archivo','mixer1','$id_descarga','$id_carga','$fecha','$hora','$lote','$cantidad','$animales','$operario')";
	
						mysqli_query($conexion,$sql);	
						
						echo mysqli_error($conexion);

					}else{

						var_dump('HUBO ERRORES EN CARGAS');

						echo "<script>
							alert('";
							for ($i=0; $i < sizeof($arrayErrores) ; $i++) { 

								echo $arrayErrores[$i];

							}

						echo "')</script>";

						$sql = "DELETE FROM mixer_cargas WHERE archivo = '$archivo'";
	
						mysqli_query($conexion,$sql);

						$sql = "DELETE FROM mixer_descargas WHERE archivo = '$archivo'";
	
						mysqli_query($conexion,$sql);

						$sql = "DELETE FROM mixer_recetas WHERE archivo = '$archivo'";
	
						mysqli_query($conexion,$sql);

						echo mysqli_error($conexion);
						echo "<script>
							window.location = 'raciones.php';
						</script>";

						die();

					}

				}
			}
			
		}
	}
}

// unlink($ruta);

echo "<script>
	window.location = 'raciones.php';
</script>";


echo "<script>
	window.location = 'raciones.php';
</script>";

?>