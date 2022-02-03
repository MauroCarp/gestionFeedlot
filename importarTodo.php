<?php
require("includes/init_session.php");
include("includes/conexion.php");

$feedlot = $_SESSION['feedlot'];

if ($_FILES['exportado']["error"] > 0){
          echo "Error: " . $_FILES['exportado']['error'] . "<br>";
          }
        else{
          $nombre = $_FILES['exportado']['name'];
          }
          move_uploaded_file($_FILES['exportado']['tmp_name'],"carga/" . $_FILES['exportado']['name']);

        $registros = file_get_contents("carga/$nombre", true);
        $registros = explode(";",$registros);


        $delete = "DELETE FROM stock WHERE feedlot = '$feedlot'";
        $eliminar = mysqli_query($conexion, $delete);

        $delete = "DELETE FROM status WHERE feedlot = '$feedlot'";
        $eliminar = mysqli_query($conexion, $delete);

        /*
        $delete = "DELETE FROM raciones WHERE feedlot = '$feedlot'";
        $eliminar = mysqli_query($conexion, $delete);*/

        $registroStock = "";
        $registroStatus = "";
        $registroRacion = "";

        for ($i=0; $i < sizeof($registros); $i++) { 
          if ($registros[0] == $registros[$i]) {
            $registroStock = $registros[$i];
          }
          if ($registros[1] == $registros[$i]) {
            $registroStatus = $registros[$i];
          }
          if ($registros[2] == $registros[$i]) {
            $registroRacion = $registros[$i];
          }
        }

        $valuesStock = "feedlot,tropaNum,fecha,cantidad,pesoIngreso,origen,egreso,pesoEgreso,destino,muertes,causaMuerte,precioCV,flete,comision";

        $valuesStatus = "feedlot,tropaNum,procedimiento,fechaRealizado,fechaMetafilaxis,metafilaxis,fechaVacuna,vacuna,fechaRefuerzo,refuerzo";

        $valuesRacion = "feedlot,fecha,turno,operario,maizKg,maizPrecio,conceKg,concePrecio,siloKg,siloPrecio,corral";

        echo $registroStock;
        $insert = "INSERT INTO stock($valuesStock) VALUES $registroStock";
        $carga = mysqli_query($conexion, $insert);

        $insert = "INSERT INTO status($valuesStatus) VALUES $registroStatus";
        $carga = mysqli_query($conexion, $insert);
        echo mysqli_error($conexion);
        die();

        $insert = "INSERT INTO stock($valuesRacion) VALUES $registroRacion";
        $carga = mysqli_query($conexion, $insert);
        echo mysqli_error($conexion);

        header("Location:datos.php?seccion=$seccion");
?>

  