<?php
include('includes/conexion.php');

$razas = array('Brangus','Britanico');
$sexos = array('Macho','Hembra');
$estados = array('Malo','Bueno');
$IDE = rand(900000,1000000);

for ($i=0; $i < 2042; $i++) { 

	$a = rand(0 ,1);
	$b = rand(0 ,1);
	$c = rand(0 ,1);
 
 	$sexo = $sexos[$a];
 	$raza = $razas[$b];
 	$estado = $estados[$c];
 	$peso = rand(300,450);
 	$IDE++;

	//$sql = "INSERT INTO ingresos(feedlot,tropa,fecha,corral,raza,sexo,origen,proveedor,peso,IDE,estado) VALUES ('SuperRural','Ingreso Cinco','2019-07-18','3','$raza','$sexo','Mercedes','Salvucci','$peso','$IDE','$estado')";

	$sql = "INSERT INTO ingresos(feedlot,tropa,fecha) VALUES ('Acopiadora Pampeana','Stock Inicial','2016-01-01')";
	mysqli_query($conexion,$sql);
	echo mysqli_error($conexion);
}
	die();
?>