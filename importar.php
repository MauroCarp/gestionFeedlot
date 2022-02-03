<?php
require("includes/init_session.php");
include("includes/conexion.php");

$feedlot = $_SESSION['feedlot'];
$seccion = $_GET['seccion'];
if ($seccion == 'StatusSanitario') {
  $seccion = 'Status';
}


if ($_FILES['exportado']["error"] > 0){
          echo "Error: " . $_FILES['exportado']['error'] . "<br>";
          }
        else{
          $nombre = $_FILES['exportado']['name'];
          }
          move_uploaded_file($_FILES['exportado']['tmp_name'],"carga/" . $_FILES['exportado']['name']);

        $registros = file_get_contents("carga/$nombre", true);

        $delete = "DELETE FROM $seccion WHERE feedlot = '$feedlot'";
        $eliminar = mysqli_query($conexion, $delete);

        switch ($seccion) {
          case 'Stock':
            $values = "feedlot,tropaNum,fecha,cantidad,pesoIngreso,origen,egreso,pesoEgreso,destino,muertes,causaMuerte,precioCV,flete,comision";
            break;

          case 'Status':
            $values = "feedlot,tropaNum,procedimiento,fechaRealizado,fechaMetafilaxis,metafilaxis,fechaVacuna,vacuna,fechaRefuerzo,refuerzo";
            break;

          case 'Raciones':
            $values = "feedlot,fecha,turno,operario,maizKg,maizPrecio,conceKg,concePrecio,siloKg,siloPrecio,corral";
            break;
          
          default:
            # code...
            break;
        }

        $insert = "INSERT INTO $seccion ($values) VALUES $registros";
        $carga = mysqli_query($conexion, $insert);
        echo mysqli_error($conexion);

        die();

        
        
        echo "<script>
        window.location = 'datos.php?seccion=$seccion';
    </script>";
?>

  