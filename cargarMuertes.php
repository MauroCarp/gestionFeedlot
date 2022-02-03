<?php
include('includes/conexion.php');

$sql = "SELECT * FROM muertes ORDER BY id DESC";
$query = mysqli_query($conexion,$sql);
$contador = 1;
while($resultado = mysqli_fetch_array($query)){



    $feedlot = $resultado['feedlot'];
    $tropa = "Sin nombre (".$contador.")";
    $cantidad = $resultado['muertes'];
    $causa = $resultado['causaMuerte'];
    $fecha = $resultado['fecha'];

    $sql = "INSERT INTO registromuertes(feedlot,tropa,fecha,cantidad,causaMuerte) VALUES('$feedlot','$tropa','$fecha','$cantidad','$causa')";
    mysqli_query($conexion,$sql);


    $contador++;
}
echo $contador;
?>