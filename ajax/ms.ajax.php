<?php
include('../includes/conexion.php');

    $id = $_POST['idProducto'];

    echo $id;

    $sql2 = "SELECT porceMS FROM insumos WHERE id = '$id'";

    $query2 = mysqli_query($conexion,$sql2);

    $resultado2 = mysqli_fetch_array($query2);

    // echo mysqli_error($conexion);

    $porMS = $resultado2['porceMS'];



?>