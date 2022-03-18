
<?php
$accionValido = array_key_exists("accion", $_REQUEST);

if ($accionValido) {
  $accion = $_GET['accion'];

  if ($accion == 'modificar') {
    $tropa = $_GET['tropa'];
    $procedimiento = $_POST['procedimiento'];
    $fechaRealizado = $_POST['fechaRealizado'];
    $operario = $_POST['operario'];
    $otroOperario = $_POST['operarioOtro'];

    if ($operario == 'otro') {
      $operario = $otroOperario;
      $sqlNueva = "INSERT INTO operarios(feedlot,nombre) VALUES ('$feedlot','$operario')";
      $queryNueva = mysqli_query($conexion,$sqlNueva);

    }

    $consulta = "";

    switch ($procedimiento) {
      case 'Metafilaxis':
        $consulta = "operario1 = '".$operario."', metafilaxis = '1', fechaMetafilaxis = '".$fechaRealizado."'";
        break;
      
      case '1er Dosis':
        $consulta = "operario2 = '".$operario."', vacuna = '1', fechaVacuna = '".$fechaRealizado."'";
        break;

      case 'Refuerzo':
        $consulta = "operario3 = '".$operario."', refuerzo = '1', fechaRefuerzo = '".$fechaRealizado."'";
      break; 

      default:
        # code...
        break;
    }
    $sql = "UPDATE status SET
    operario = '$operario',
    procedimiento = '$procedimiento',
    fechaRealizado = '$fechaRealizado',
    $consulta,
    notificado = 0
    WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    $query = mysqli_query($conexion,$sql);

    echo "<script>
	    window.location = 'status.php';
    </script>";
  }

  if ($accion == 'notificar') {
    $tropa = $_GET['tropa'];

    $sql = "UPDATE status SET
    notificado = 1
    WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    $query = mysqli_query($conexion,$sql);
    
    echo "<script>
    window.location = 'status.php';
  </script>";
  }
}

?>