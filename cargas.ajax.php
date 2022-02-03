<?php
include('includes/funciones.php');
include("includes/init_session.php");
include('includes/conexion.php');

$id_carga = $_POST['idCarga'];

$archivo = $_POST['archivo'];

$accionValido = array_key_exists('accion',$_POST);

if ($accionValido) {

    $mixer = ($_POST['mixer'] == '456ST') ? 'mixer1' : 'mixer2';
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $ingrediente = $_POST['ingrediente'];
    $cantidad = $_POST['cantidad'];
    $ideal = $_POST['ideal'];
    
    $sql = "UPDATE mixer_cargas SET 
    mixer = '$mixer',
    fecha = '$fecha',
    hora = '$hora',
    ingrediente = '$ingrediente',
    cantidad = '$cantidad',
    ideal = '$ideal'

    WHERE id = '$id_carga'";

    mysqli_query($conexion,$sql);
    echo mysqli_error($conexion);

}else{

    //EJECUTAMOS LA CONSULTA DE BUSQUEDA
    $sql = "SELECT * FROM mixer_cargas WHERE id = '$id_carga' AND archivo = '$archivo'";
    
    $query = mysqli_query($conexion,$sql);
    
    $resultado = mysqli_fetch_array($query);
    
    // CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX
    
    $resultadoJson = json_encode($resultado);
    
    print_r($resultadoJson);

}



?>