<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");

if( isset($_POST["submit"]) ){

	$error = false;


    $ruta = "carga/" . $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $ruta);
/*
    $xmlObject = simplexml_load_string($xml);
 
    //Encode the SimpleXMLElement object into a JSON string.
    $jsonString = json_encode($xmlObject);
     
    //Convert it back into an associative array for
    //the purposes of testing.
    $jsonArray = json_decode($jsonString, true);
     
    //var_dump out the $jsonArray, just so we can
    //see what the end result looks like
    var_dump($jsonArray);
*/
    

	
}


?>
<form name="f1" class="form-horizontal" method="POST" action="subirRacion.php" enctype="multipart/form-data"> 
<input type="submit" class="btn btn-primary btn-lg" name="submit" value="Subir"/>
<input type="file" name="file" required />
</form>
