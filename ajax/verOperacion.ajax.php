<?php
include('../includes/conexion.php');

$idOperacion = $_POST['idOperacion'];

$fecha = $_POST['fecha'];

$operacion = $_POST['operacion'];

$tabla = 'mixer_'.$operacion.'s';

$item = 'id_'.$operacion;

$sql = "SELECT * FROM $tabla WHERE $item = '$idOperacion' AND fecha = '$fecha' ORDER BY hora ASC";

$query = mysqli_query($conexion,$sql);
echo mysqli_error($conexion);
echo $sql;

while($respuesta = mysqli_fetch_array($query)){
    
    echo "<tr>
            <td>".$respuesta['mixer']."</td>
            <td>".$respuesta['fecha']."</td>
            <td>".$respuesta['hora']."</td>";

    if($operacion == 'carga'){

        echo "<td>".$respuesta['ingrediente']."</td>
              <td>".$respuesta['cantidad']."</td>
              <td>".$respuesta['ideal']."</td>";
    }else{
    
        echo "<td>".$respuesta['lote']."</td>
              <td>".$respuesta['cantidad']."</td>
              <td>".$respuesta['animales']."</td>
              <td>".$respuesta['operario']."</td>";
                

    }

};


// print_r(json_encode($respuesta));

?>
