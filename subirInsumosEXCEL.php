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

                if($primera){
                    
                    if(isset($Row[0])) {

                        $tipo= mysqli_real_escape_string($conexion,$Row[0]);

                    }
                    
					$primera = false;

					continue;

				}

				// Obtenemos informacion

				$nombre = "";
				if(isset($Row[0])) {

					$nombre= mysqli_real_escape_string($conexion,$Row[0]);

				}
                
                $ms = "";

                if(isset($Row[1])) {

                    $ms= mysqli_real_escape_string($conexion,$Row[1]);

                }
                
                $dms = "";

                if(isset($Row[2])) {

                    $dms= mysqli_real_escape_string($conexion,$Row[2]);

                }

                $ee = "";

                if(isset($Row[3])) {

                    $ee= mysqli_real_escape_string($conexion,$Row[3]);

                }

                $pr = "";

                if(isset($Row[4])) {

                    $pr= mysqli_real_escape_string($conexion,$Row[4]);

                }

                $pba = "";

                if(isset($Row[5])) {

                    $pba= mysqli_real_escape_string($conexion,$Row[5]);

                }

                $pbb = "";

                if(isset($Row[6])) {

                    $pbb= mysqli_real_escape_string($conexion,$Row[6]);

                }

                $h = "";

                if(isset($Row[7])) {

                    $h= mysqli_real_escape_string($conexion,$Row[7]);

                }

                $nida = "";

                if(isset($Row[8])) {

                    $nida = mysqli_real_escape_string($conexion,$Row[8]);

                }

                $em= "";

                if(isset($Row[9])) {

                    $em= mysqli_real_escape_string($conexion,$Row[9]);

                }
    
                $fecha = date('Y-m-d');
			  	
				$precio = 0;

				// Guardamos en base de datos
          
				$sqlInsert = "INSERT INTO insumos(feedlot,insumo,tipo,precio,porceMS,DMS,EE,Pr,PBa,PBb,H,NIDA,EM,fecha) 
                VALUES ('Acopiadora Pampeana','$nombre','$tipo','$precio','$ms','$dms','$ee','$pr','$pba','$pbb','$h','$nida','$em','$fecha')";

				mysqli_query($conexion,$sqlInsert);

				echo mysqli_error($conexion);
				
			    $contador++;

			}
		}
	}
}


?>
<form name="f1" class="form-horizontal" method="POST" action="subirInsumosEXCEL.php" enctype="multipart/form-data"> 
<input type="submit" class="btn btn-primary btn-lg" name="submit" value="Subir" accept=".xls,.xlsx" />
<input type="file" name="file" required />
</form>
