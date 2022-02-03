<?php
include('../includes/conexion.php');
$accion = $_POST['accion'];

if($accion == 'select'){
    $sql = "SELECT DISTINCT(tipo) FROM insumos ORDER BY tipo ASC";

    $query = mysqli_query($conexion,$sql);

    $arrayTipo = array();

    while($resultado = mysqli_fetch_array($query)){

        $arrayTipo[] = $resultado['tipo'];

    }

    for ($i=0; $i < sizeof($arrayTipo) ; $i++) { 

        $tipo = $arrayTipo[$i];

        echo "<optgroup label='".$tipo."'>";

        $sql = "SELECT * FROM insumos WHERE tipo = '$tipo' ORDER BY insumo ASC";
        $query = mysqli_query($conexion,$sql);
    
        while ($resultado = mysqli_fetch_array($query)) {

            echo "<option style='font-size:.5em!important;' value=".$resultado['id'].">".utf8_encode($resultado['insumo'])."</option>";

        }   

        echo "</optgroup>";

    }

    echo "<optgroup label='Agua'>
            <option value='80'>Agua</option>
        </optgroup>";

}

if($accion == 'obtenerMS'){

    $id = $_POST['idProducto'];

    $sql = "SELECT porceMS FROM insumos WHERE id = '$id'";

    $query = mysqli_query($conexion,$sql);

    $resultado = mysqli_fetch_array($query);

    $porMS = $resultado['porceMS'];

    echo $porMS;

}

?>