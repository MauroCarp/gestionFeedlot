<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");
require_once('lib/excel/php-excel-reader/excel_reader2.php');
require_once('lib/excel/SpreadsheetReader.php');

if( isset($_POST["submit"]) ){

    $mixer = $_POST['mixer'];
	$error = false;

	$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

	if(in_array($_FILES["file"]["type"],$allowedFileType)){
		$ruta = "carga/" . $_FILES['file']['name'];
		move_uploaded_file($_FILES['file']['tmp_name'], $ruta);

        $archivo = $_FILES['file']['name'];

        $Reader = new SpreadsheetReader($ruta);	
		$sheetCount = count($Reader->sheets());

        if($sheetCount > 1){

            echo "<script>
            
            alert('El archivo cargado no es del Mixer Autoconsumo');
            
            window.location = 'raciones.php';
            
            </script>";
            
            die();

        }

        for($i=0;$i<$sheetCount;$i++){
            
                $Reader->ChangeSheet($i);

                $primera = true;
                
                $accionTemp = "";

                $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                foreach ($Reader as $Row){
                    
                    // Evitamos la primer linea
                    if($primera){
                        $primera = false;
                        continue;
                    }

                    $buscar = 'Lote';                    
                    $esDescarga = strpos($Row[4], $buscar);

                    if($esDescarga === 0){
                        $accion = 'Descarga';
                        $tabla = 'mixer_descargas';
                        $columna = 'lote';
                    }else{
                        $accion = 'Carga';
                        $tabla = 'mixer_cargas';
                        $columna = 'ingrediente';
                    }


                     // Obtenemos informacion
                     $fecha= "";
                     if(isset($Row[0])) {
                         $fecha = mysqli_real_escape_string($conexion,$Row[0]);
                         $fecha = explode('-',$fecha);
                         $fecha = '20'.$fecha[2].'-'.$fecha[0].'-'.$fecha[1];
                     }
                     $hora= "";
                     if(isset($Row[1])) {
                         $hora = mysqli_real_escape_string($conexion,$Row[1]);
                         $hora = substr($hora,0,-3);

                     }
                    

                     $num= "";
                     if(isset($Row[2])) {
                         $num= mysqli_real_escape_string($conexion,$Row[2]);
                     }
 
                     $descripcion = "";
                     if(isset($Row[3])) {
                         $descripcion = mysqli_real_escape_string($conexion,$Row[3]);
                     }
                     
 
                     
                     if(isset($Row[4]) AND trim($Row[4]) != '') {

                         $loteIngrediente = mysqli_real_escape_string($conexion,$Row[4]);

                         $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                         $cantidad = mysqli_real_escape_string($conexion,$Row[5]);
                         
                         if($accionTemp == $accion){

                            $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                            
                        }
    
                        //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                        //fecha = '.$fecha.' Hora = '.$hora.' Tabla = '.$tabla.' Columna = '.$columna.'<br>
                        //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
                        
                        $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";
                        mysqli_query($conexion,$sql);
                        echo mysqli_error($conexion);
                        
                     }

                     if(isset($Row[6]) AND trim($Row[6]) != '') {

                        $loteIngrediente = mysqli_real_escape_string($conexion,$Row[6]);

                        $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                        $cantidad = mysqli_real_escape_string($conexion,$Row[7]);
 
                        if($accionTemp == $accion){

                           $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                           
                       }
   
                       //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                       //fecha = '.$fecha.' hora = '.$hora.' Tabla = '.$tabla.'<br>
                       //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
   
                       $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";  
                       mysqli_query($conexion,$sql);
                       echo mysqli_error($conexion);
                       
                    }

                    if(isset($Row[8]) AND trim($Row[8]) != '') {

                        $loteIngrediente = mysqli_real_escape_string($conexion,$Row[8]);
                        
                        $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                        // var_dump($loteIngrediente);

                        $cantidad = mysqli_real_escape_string($conexion,$Row[9]);
 
                        if($accionTemp == $accion){

                           $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                           
                       }
   
                       //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                       //fecha = '.$fecha.' hora = '.$hora.' Tabla = '.$tabla.'<br>
                       //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
   
                       $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";  
                       mysqli_query($conexion,$sql);
                       echo mysqli_error($conexion);
                       
                    }

                    if(isset($Row[10]) AND trim($Row[10]) != '') {
                        $loteIngrediente = mysqli_real_escape_string($conexion,$Row[10]);
                        
                        $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                        // var_dump($loteIngrediente);

                        $cantidad = mysqli_real_escape_string($conexion,$Row[11]);
 
                        if($accionTemp == $accion){

                           $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                           
                       }
   
                       //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                       //fecha = '.$fecha.' hora = '.$hora.' Tabla = '.$tabla.'<br>
                       //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
   
                       $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";  
                       mysqli_query($conexion,$sql);
                       echo mysqli_error($conexion);
                       
                    }

                    if(isset($Row[12]) AND trim($Row[12]) != '') {

                        $loteIngrediente = mysqli_real_escape_string($conexion,$Row[12]);
                        
                        $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                        // var_dump($loteIngrediente);

                        $cantidad = mysqli_real_escape_string($conexion,$Row[13]);
 
                        if($accionTemp == $accion){

                           $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                           
                       }
   
                       //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                       //fecha = '.$fecha.' hora = '.$hora.' Tabla = '.$tabla.'<br>
                       //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
   
                       $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";  
                       mysqli_query($conexion,$sql);
                       echo mysqli_error($conexion);
                       
                    }

                    if(isset($Row[14]) AND trim($Row[14]) != '') {

                        $loteIngrediente = mysqli_real_escape_string($conexion,$Row[14]);
                        
                        $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                        // var_dump($loteIngrediente);

                        $cantidad = mysqli_real_escape_string($conexion,$Row[15]);
 
                        if($accionTemp == $accion){

                           $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                           
                       }
   
                       //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                       //fecha = '.$fecha.' hora = '.$hora.' Tabla = '.$tabla.'<br>
                       //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
   
                       $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";  
                       mysqli_query($conexion,$sql);
                       echo mysqli_error($conexion);
                       
                    }

                    if(isset($Row[16]) AND trim($Row[16]) != ''){

                        $loteIngrediente = mysqli_real_escape_string($conexion,$Row[16]);
                        
                        $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                        // var_dump($loteIngrediente);

                        $cantidad = mysqli_real_escape_string($conexion,$Row[17]);
 
                        if($accionTemp == $accion){

                           $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                           
                       }
   
                       //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                       //fecha = '.$fecha.' hora = '.$hora.' Tabla = '.$tabla.'<br>
                       //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
   
                       $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";  
                       mysqli_query($conexion,$sql);
                       echo mysqli_error($conexion);
                       
                    }

                    if(isset($Row[18]) AND trim($Row[18]) != ''){

                        $loteIngrediente = mysqli_real_escape_string($conexion,$Row[18]);

                        $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                        // var_dump($loteIngrediente);

                        $cantidad = mysqli_real_escape_string($conexion,$Row[19]);
 
                        if($accionTemp == $accion){

                           $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                           
                       }
   
                       //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                       //fecha = '.$fecha.' hora = '.$hora.' Tabla = '.$tabla.'<br>
                       //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
   
                       $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";  
                       mysqli_query($conexion,$sql);
                       echo mysqli_error($conexion);
                       
                    }

                    if(isset($Row[20]) AND trim($Row[20]) != ''){

                        $loteIngrediente = mysqli_real_escape_string($conexion,$Row[20]);
                                
                        $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                        // var_dump($loteIngrediente);

                        $cantidad = mysqli_real_escape_string($conexion,$Row[21]);
 
                        if($accionTemp == $accion){

                           $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                           
                       }
   
                       //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                       //fecha = '.$fecha.' hora = '.$hora.' Tabla = '.$tabla.'<br>
                       //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
   
                       $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";  
                       mysqli_query($conexion,$sql);
                       echo mysqli_error($conexion);
                       
                    }

                    if(isset($Row[22]) AND trim($Row[22]) != ''){

                        $loteIngrediente = mysqli_real_escape_string($conexion,$Row[22]);
                        
                        $loteIngrediente = ($accion == 'Descarga') ? trim(substr($loteIngrediente,5)) : $loteIngrediente; 

                        // var_dump($loteIngrediente);

                        $cantidad = mysqli_real_escape_string($conexion,$Row[23]);

                        
                        if($accionTemp == $accion){

                           $id_carga = obtenerMax('id_carga','mixer_cargas',$conexion);
                           
                       }
   
                       //echo 'Esto es una '.$accion.' con un id = '.$id_carga.'<br>
                       //fecha = '.$fecha.' hora = '.$hora.' Tabla = '.$tabla.'<br>
                       //Lote/Ingrediente = '.$loteIngrediente.' - Cantidad = '.$cantidad."<hr>";
   
                       $sql = "INSERT INTO $tabla(archivo,mixer,id_carga,fecha,hora,$columna,cantidad) VALUES('$archivo','$mixer','$id_carga','$fecha','$hora','$loteIngrediente','$cantidad')";  
                       mysqli_query($conexion,$sql);
                       echo mysqli_error($conexion);
                       
                    }  
                        
                    
                    if($accion == 'Descarga'){
                        
                        $id_carga = (obtenerMax('id_carga','mixer_cargas',$conexion)) + 1;
                        
                    }
                    
            

                    $accionTemp = $accion;

                }
                
            
            
        }
        
    }

    unlink($ruta);

    
    echo '<script>
				window.location = "raciones.php";

        </script>';

}


?>
<!-- <form name="f1" class="form-horizontal" method="POST" action="ingresoMixer2.php" enctype="multipart/form-data"> 
<input type="submit" class="btn btn-primary btn-lg" name="submit" value="Subir" accept=".xls,.xlsx" />
<input type="file" name="file" required />
</form> -->
