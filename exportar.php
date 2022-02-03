<?php
require("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");

$seccion = $_GET['seccion'];

if ($seccion == 'StatusSanitario') {
  $seccion = 'Status';
}

  
$sqlQuery = "SELECT * FROM $seccion WHERE feedlot = '$feedlot'";
        $query = mysqli_query($conexion,$sqlQuery);
        $hoy = date('d-m-Y');
        $registros = "";
        echo mysqli_error($conexion);

        if ($seccion == 'Stock') {  
            while($fila = mysqli_fetch_array($query)){
              $tropaNum = $fila['tropaNum'];
              $fecha = $fila['fecha'];
              $cantidad = $fila['cantidad'];
              $pesoIngreso = $fila['pesoIngreso'];
              $pesoEgreso = $fila['pesoEgreso'];
              $origen = $fila['origen'];
              $egreso = $fila['egreso'];
              $destino = $fila['destino'];
              $muertes = $fila['muertes'];
              $causaMuerte = $fila['causaMuerte'];
              $precioCV = $fila['precioCV'];
              $flete = $fila['flete'];
              $comision = $fila['comision'];

              $registros = $registros."('$feedlot','$tropaNum','$fecha','$cantidad','$pesoIngreso','$origen','$egreso','$pesoEgreso','$destino','$muertes','$causaMuerte','$precioCV','$flete','$comision'),";
            }

        }
        if ($seccion == 'Status') {  
            while($fila = mysqli_fetch_array($query)){
              $tropaNum = $fila['tropaNum'];
              $procedimiento = $fila['procedimiento'];
              $fechaRealizado = $fila['fechaRealizado'];
              $fechaMetafilaxis = ($fila['fechaMetafilaxis'] == "") ? NULL : $fila['fechaMetafilaxis'];
              echo $fechaMetafilaxis."<br>";
              $metafilaxis = $fila['metafilaxis'];
              $fechaVacuna = ($fila['fechaVacuna'] == "") ? NULL : $fila['fechaVacuna'];
              echo $fechaVacuna."<br>";
              $vacuna = $fila['vacuna'];
              $fechaRefuerzo = $fila['fechaRefuerzo'];
              $refuerzo = $fila['refuerzo'];
              echo "<br>";
              $registros = $registros."('$feedlot','$tropaNum','$procedimiento','$fechaRealizado','$fechaMetafilaxis','$metafilaxis','$fechaVacuna','$vacuna','$fechaRefuerzo','$refuerzo'),";
            }
        }
        die();
        if ($seccion == 'Raciones') {  
            while($fila = mysqli_fetch_array($query)){
              $fecha = $fila['fecha'];
              $turno = $fila['turno'];
              $operario = $fila['operario'];
              $maizKg = $fila['maizKg'];
              $maizPrecio = $fila['maizPrecio'];
              $conceKg = $fila['conceKg'];
              $concePrecio = $fila['concePrecio'];
              $siloKg = $fila['siloKg'];
              $siloPrecio = $fila['siloPrecio'];
              $corral = $fila['corral'];

              $registros = $registros."('$feedlot','$fecha','$turno','$operario','$maizKg','$maizPrecio','$conceKg','$concePrecio','$siloKg','$siloPrecio','$corral'),";
            }
        }

        $registros = trim($registros, ',');
        $nombreArchivo = strtoupper($seccion)."-".$feedlot."-".$hoy;
        echo $registros;
        header("Content-Type: text/plain");
        header("Content-Disposition: attachment; filename='$nombreArchivo.txt'");
?>