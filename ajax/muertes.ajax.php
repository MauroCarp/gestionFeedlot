<?php

include('../includes/conexion.php');

$idMuerte = $_POST['id'];

$causa = $_POST['causa'];

$sql  = "UPDATE registromuertes SET causaMuerte = '$causa' WHERE id = '$idMuerte'";

if(mysqli_query($conexion,$sql)){
    echo "ok";
}else{
    echo 'error';
}

?>