<?php
include('../includes/conexion.php');

    $sql = "SELECT id,nombre FROM insumospremix ORDER BY nombre ASC";

    $query = mysqli_query($conexion,$sql);

    
    while($resultado = mysqli_fetch_array($query)){
        
        $id = $resultado['id']; 

        $nombre = $resultado['nombre'];

        echo "<option value='$id'>$nombre</option>";

    }

?>