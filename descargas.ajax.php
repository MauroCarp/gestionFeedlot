<?php
include('includes/conexion.php');
include('includes/funciones.php');
include("includes/init_session.php");

$id_descarga = $_POST['idDescarga'];

$archivo = $_POST['archivo'];

$accionValido = array_key_exists('accion',$_POST);

if ($accionValido) {

    $mixer = ($_POST['mixer'] == '456ST') ? 'mixer1' : 'mixer2';
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $lote = $_POST['lote'];
    $cantidad = $_POST['cantidad'];
    $animales = $_POST['animales'];
    $operario = $_POST['operario'];
    
    $sql = "UPDATE mixer_descargas SET 
    mixer = '$mixer',
    fecha = '$fecha',
    hora = '$hora',
    lote = '$lote',
    cantidad = '$cantidad',
    animales = '$animales',
    operario = '$operario'

    WHERE id = '$id_descarga'";

    mysqli_query($conexion,$sql);
    echo mysqli_error($conexion);

}else{
    //EJECUTAMOS LA CONSULTA DE BUSQUEDA
    $sql = "SELECT * FROM mixer_descargas WHERE id = '$id_descarga' AND archivo = '$archivo'";

    $query = mysqli_query($conexion,$sql);

    $resultado = mysqli_fetch_array($query);

    // CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

    $resultadoJson = json_encode($resultado);

    print_r($resultadoJson);

}
?>