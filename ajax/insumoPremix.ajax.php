<?php
    
    include('../includes/conexion.php');

    $id = $_POST['idInsumo'];

    $sql = "SELECT precio FROM insumospremix WHERE id = '$id'";

    $query = mysqli_query($conexion,$sql);

    $resultado = mysqli_fetch_array($query);

    echo mysqli_error($conexion);

    $precioInsumo = $resultado['precio'];
    
    echo $precioInsumo;

?>