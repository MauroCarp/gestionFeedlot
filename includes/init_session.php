<?php
	session_start();
  	if(!array_key_exists('logged', $_SESSION)){
    	header('Location:login.php');
  	}else{
    	$feedlot = $_SESSION['feedlot'];
    	$tipoSesion = $_SESSION['tipo'];
  	}
    $fechaDeHoy = date("d-m-Y");

    $feedlot = $_SESSION['feedlot'];
?>