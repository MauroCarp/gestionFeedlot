<?php
include('includes/conexion.php');

$sql = "SELECT tropa , cantidad , fecha FROM registroingresos ORDER BY fecha ASC ,  tropa ASC, cantidad ASC";
$query = mysqli_query($conexion,$sql);
echo mysqli_error($conexion);
$tropaTemp = "";
$fechaTemp = "";
$cantidadTemp = "";
$arrayTropas = array();
while($resultado = mysqli_fetch_array($query)){

    $tropa = explode('(',$resultado['tropa']);
    $tropa = $tropa[0];
    echo $tropaTemp." / ".$fechaTemp." / ".$cantidadTemp;
    echo "<br>".$tropa." / ".$resultado['fecha']." / ".$resultado['cantidad'];
    echo "<br>".$resultado['tropa'];
    if($tropaTemp == $tropa AND $cantidadTemp == $resultado['cantidad'] AND $fechaTemp == $resultado['fecha']){
        echo "hola";
        $arrayTropas[] = $resultado['tropa'];
    }
    echo "<hr>";

    $tropaTemp = $tropa;
    $cantidadTemp = $resultado['cantidad'];
    $fechaTemp = $resultado['fecha'];
    

}

asort($arrayTropas);
var_dump($arrayTropas);

for ($i=0; $i < sizeof($arrayTropas) ; $i++) { 

    $tropa = $arrayTropas[$i];

    $sql = "DELETE FROM registroingresos WHERE tropa = '$tropa'";
    
    mysqli_query($conexion,$sql);

    echo mysqli_error($conexion);


    $sql = "DELETE FROM ingresos WHERE tropa = '$tropa'";

    mysqli_query($conexion,$sql);

    echo mysqli_error($conexion);


}   

?>