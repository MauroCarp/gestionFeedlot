<?php
include('../includes/conexion.php');
include('../includes/funciones.php');

$feedlot = $_POST['feedlot'];

$cantidadCausa = array();
$cantidadCausa['accidente'] = (cantidadCausa($feedlot,$conexion,'Accidente') == null) ? 0 : cantidadCausa($feedlot,$conexion,'Accidente') ;
$cantidadCausa['digestivo'] = (cantidadCausa($feedlot,$conexion,'Digestivo') == null) ? 0 : cantidadCausa($feedlot,$conexion,'Digestivo') ;
$cantidadCausa['ingreso'] = (cantidadCausa($feedlot,$conexion,'Ingreso') == null) ? 0 : cantidadCausa($feedlot,$conexion,'Ingreso') ;
$cantidadCausa['nervioso'] = (cantidadCausa($feedlot,$conexion,'Nervioso') == null) ? 0 : cantidadCausa($feedlot,$conexion,'Nervioso') ;
$cantidadCausa['rechazo'] = (cantidadCausa($feedlot,$conexion,'Rechazo') == null) ? 0 : cantidadCausa($feedlot,$conexion,'Rechazo') ;
$cantidadCausa['respiratorio'] = (cantidadCausa($feedlot,$conexion,'Respiratorio') == null) ? 0 : cantidadCausa($feedlot,$conexion,'Respiratorio') ;
$cantidadCausa['sinDiagnostico'] = (cantidadCausa($feedlot,$conexion,'Sin Diagnostico') == null) ? 0 : cantidadCausa($feedlot,$conexion,'Sin Diagnostico') ;
$cantidadCausa['sinHallazgo'] = (cantidadCausa($feedlot,$conexion,'Sin Hallazgo') == null) ? 0 : cantidadCausa($feedlot,$conexion,'Sin Hallazgo') ;
$cantidadCausa['otro'] = (cantidadCausa($feedlot,$conexion,'Otro') == null) ? 0 : cantidadCausa($feedlot,$conexion,'Otro') ;

echo  json_encode($cantidadCausa);

?>