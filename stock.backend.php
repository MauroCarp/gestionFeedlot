<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
require("includes/arrays.php");

$accionValido = array_key_exists("accion", $_REQUEST);
$fechaHoy = date("Y-m-d");
if ($accionValido) {
  $accion = $_GET['accion'];
  //*** INGRESOS  **//
  if ($accion == 'cargarManual') {
    $tropa = $_POST['tropa'];
    $fechaIngreso = $_POST['fechaIngreso'];
    $renspa = $_POST['renspa'];
    $adpv = ($_POST['adpv'] == "") ? 0 : $_POST['adpv'];
    $cantidad = $_POST['cantidad'];
    $raza = $_POST['raza'];
    $origen = $_POST['origen'];
    $proveedor = $_POST['proveedor'];
    $peso = $_POST['peso'];
    $estado = $_POST['estado'];
    $corral = $_POST['corral'];
    $notas = $_POST['notas'];


    if ($fechaIngreso > $fechaHoy) { ?>
      <script type="text/javascript">
        alert("La fecha de Ingreso es POSTERIOR a la fecha de HOY. Carga Fallida.");
        window.location = 'stock.php';
      </script>
    <?php 
    die();
    }
    if ($_POST['otraRaza'] != "") {
      $raza = $_POST['otraRaza'];

      $sqlRaza = "INSERT INTO razas(raza) VALUES('$raza')";
      mysqli_query($conexion,$sqlRaza);
    }

    $pesoPromedio = $peso / $cantidad;
    for ($i=0; $i < $cantidad; $i++) { 
      $sqlIngreso = "INSERT INTO ingresos(feedlot,tropa,adpv,renspa,peso,raza,estado,origen,proveedor,notas,corral,fecha) VALUES ('$feedlot','$tropa','$adpv','$renspa','$pesoPromedio','$raza','$estado','$origen','$proveedor','$notas','$corral','$fechaIngreso')";
      $queryIngreso = mysqli_query($conexion,$sqlIngreso);
    }

      $sqlStatus = "INSERT INTO status(feedlot,tropa,fechaIngreso,animales) VALUES ('$feedlot','$tropa','$fechaIngreso','$cantidad')";
      $queryStatus = mysqli_query($conexion,$sqlStatus);
     header("Location:stock.php?seccion=ingreso");
  }

  if ($accion == "modificarIngreso") {
    $id = $_GET['id'];
    $fechaIngreso = $_POST['fechaIngreso'];
    $cantidad = $_POST['cantidad'];
    $origen = $_POST['origen'];
    $proveedor = $_POST['proveedor'];
    $peso = $_POST['pesoIngreso'];
    $sqlIngreso = "UPDATE stock SET
    fecha = '$fechaIngreso',
    cantidad = '$cantidad',
    origen = '$origen',
    proveedor = '$proveedor',
    pesoIngreso = '$peso' WHERE id = '$id'";
    $queryIngreso = mysqli_query($conexion,$sqlIngreso);
    header("Location:stock.php?seccion=ingreso");
  }

  if ($accion == 'eliminarIngreso') {
    $tropa = $_GET['tropa'];

    $sqlEliminar = "DELETE FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    mysqli_query($conexion,$sqlEliminar);

    $sqlEliminarStatus = "DELETE FROM status WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    mysqli_query($conexion,$sqlEliminarStatus);

    $sqlEliminarRegistro = "DELETE FROM registroingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    mysqli_query($conexion,$sqlEliminarRegistro);

    header("Location:stock.php?seccion=ingreso");
    }

//**** EGRESOS ***/

  if ($accion == 'egreso') {
    $tropa = $_POST['tropa'];
    $fechaEgreso = $_POST['fechaEgreso'];
    $cantidad = $_POST['cantidad'];
    $raza = $_POST['raza'];
    $peso = $_POST['peso'];
    $corral = $_POST['corral'];
    $destino = $_POST['destino'];


    if ($fechaEgreso > $fechaHoy) { ?>
      <script type="text/javascript">
        alert("La fecha de Ingreso es POSTERIOR a la fecha de HOY. Carga Fallida.");
        window.location = 'stock.php';
      </script>
    <?php 
    die();
    }
    if ($_POST['otraRaza'] != "") {
      $raza = $_POST['otraRaza'];

      $sqlRaza = "INSERT INTO razas(raza) VALUES('$raza')";
      mysqli_query($conexion,$sqlRaza);
    }

    $pesoPromedio = $peso / $cantidad;
    for ($i=0; $i < $cantidad; $i++) { 
      $sqlEgreso = "INSERT INTO egresos(feedlot,tropa,fecha,corral,raza,destino,peso) VALUES ('$feedlot','$tropa','$fechaEgreso','$corral','$raza','$destino','$pesoPromedio')";
      $queryEgreso = mysqli_query($conexion,$sqlEgreso);
      echo mysqli_error($conexion);
    }
    header("Location:stock.php?seccion=egreso");

  }

  if ($accion == "modificarEgreso") {
    $id = $_GET['id'];
    $fechaEgreso = $_POST['fechaEgreso'];
    $egresos = $_POST['egreso'];
    $destino = $_POST['destino'];
    $pesoEgreso = $_POST['pesoEgreso'];
    $sqlEgreso = "UPDATE stock SET
    fecha = '$fechaEgreso',
    egreso = '$egresos',
    destino = '$destino',
    pesoEgreso = '$pesoEgreso' WHERE id = '$id'";
    $queryEgreso = mysqli_query($conexion,$sqlEgreso);
    header("Location:stock.php?seccion=egreso");
  }


  if ($accion == 'eliminarEgreso') {
    $tropa = $_GET['tropa'];

    $sqlEliminar = "DELETE FROM egresos WHERE tropa = '$tropa'";
    mysqli_query($conexion,$sqlEliminar);

    $sqlEliminar = "DELETE FROM registroegresos WHERE tropa = '$tropa'";
    mysqli_query($conexion,$sqlEliminar);





    header("Location:stock.php?seccion=egreso");
    }

//*** MUERTES ***/
  if ($accion == 'muertes') {
      $fechaMuerte = $_POST['fechaMuerte'];
      $muertes = $_POST['muertes'];
      $causaMuerte = $_POST['causaMuerte'];
      $otraCausaMuerte = $_POST['causaMuerteOtro'];

      if ($causaMuerte == 'otro') {
        $causaMuerte = $otraCausaMuerte;
        $sqlNueva = "INSERT INTO causas(causa) VALUES ('$causaMuerte')";
        $queryNueva = mysqli_query($conexion,$sqlNueva);
      }

 
      $sqlMuertes = "INSERT INTO muertes(feedlot,fecha,muertes,causaMuerte) VALUES ('$feedlot','$fechaMuerte','$muertes','$causaMuerte')";
      $queryMuertes = mysqli_query($conexion,$sqlMuertes);

      header("Location:stock.php?seccion=muerte");
    }

    if ($accion == "modificarMuerte") {
      $id = $_GET['id'];
      $fechaMuerte = $_POST['fechaMuerte'];
      $muertes = $_POST['muertes'];
      $causaMuerte = $_POST['causaMuerte'];
      $sqlMuerte = "UPDATE muertes SET
      fecha = '$fechaMuerte',
      muertes = '$muertes',
      causaMuerte = '$causaMuerte' WHERE id = '$id'";
      $queryMuerte = mysqli_query($conexion,$sqlMuerte);
      header("Location:stock.php?seccion=muerte");
    }

    if ($accion == 'eliminarMuerte') {
      
      $tropa = $_GET['tropa'];
      $sqlEliminar = "DELETE FROM muertes WHERE tropa = '$tropa'";
      mysqli_query($conexion,$sqlEliminar);

      $sqlEliminar = "DELETE FROM registromuertes WHERE tropa = '$tropa'";
      mysqli_query($conexion,$sqlEliminar);

      header("Location:stock.php?seccion=muerte");
    }
/****************////


  

}


$cantIng = 0;
$cantEgr = 0;
$cantMuertes = 0;
$totalPesoIng = 0;
$totalPesoEgr = 0;
$kgIngProm = 0;
$kgEgrProm = 0;
$diferenciaIngEgr = 0;
$pesoTotalIng = 0;
$pesoTotalEgr = 0;

  $sqlIng = "SELECT SUM(cantidad) AS cantidadConStockInicial FROM registroingresos WHERE feedlot = '$feedlot' ORDER BY fecha ASC";
  $queryIng = mysqli_query($conexion,$sqlIng);
  $resultados = mysqli_fetch_array($queryIng);

  $cantIngConStockInicial = $resultados['cantidadConStockInicial'];
  

  if ($feedlot == "Acopiadora Pampeana") {
  
    $sqlIng = "SELECT cantidad, pesoPromedio FROM registroingresos WHERE feedlot = '$feedlot' AND tropa != 'Stock Inicial' ORDER BY fecha ASC";

    $queryIng = mysqli_query($conexion,$sqlIng);
    
    while($resultados = mysqli_fetch_array($queryIng)){

      $cantidad = $resultados['cantidad'];
      $pesoPromedio = $resultados['pesoPromedio'];

      $cantIng += $cantidad;
      $pesoTotalIng += ($cantidad * $pesoPromedio);

    };



    $sqlEgr = "SELECT cantidad, pesoPromedio FROM registroegresos WHERE feedlot = '$feedlot' ORDER BY fecha ASC";

    $queryEgr = mysqli_query($conexion,$sqlEgr);

    
    while($resultados = mysqli_fetch_array($queryEgr)){
      
      $cantidadEgr = $resultados['cantidad'];
      $pesoPromedioEgr = $resultados['pesoPromedio'];
      

      $cantEgr += $cantidadEgr;
      $pesoTotalEgr += ($cantidadEgr * $pesoPromedioEgr);

    };


  }else{

    $sqlIng = "SELECT COUNT(feedlot) AS cantidad, SUM(peso) AS pesoTotal FROM ingresos WHERE feedlot = '$feedlot' AND tropa != 'Stock Inicial' ORDER BY fecha ASC";

    $queryIng = mysqli_query($conexion,$sqlIng);
    $resultados = mysqli_fetch_array($queryIng);
    $pesoTotalIng = $resultados['pesoTotal'];
    $cantIng = $resultados['cantidad'];

    $sqlEgr = "SELECT COUNT(feedlot) AS cantidad, SUM(peso) AS pesoTotal FROM egresos WHERE feedlot = '$feedlot' ORDER BY fecha ASC";
    $queryEgr = mysqli_query($conexion,$sqlEgr);
    $resultados = mysqli_fetch_array($queryEgr);
    $cantEgr = $resultados['cantidad'];
    $pesoTotalEgr = $resultados['pesoTotal'];


  }

  


  $sqlMuertes = "SELECT SUM(cantidad) as cantidad FROM registromuertes WHERE feedlot = '$feedlot' ORDER BY fecha ASC";
  $queryMuertes = mysqli_query($conexion,$sqlMuertes);
  $resultados = mysqli_fetch_array($queryMuertes);
  $cantMuertes = $resultados['cantidad'];
  

  $stock = 0;

  if ($cantIng > 0) {
  $kgIngProm = ($pesoTotalIng/$cantIng);
  }
  $kgIngProm = round($kgIngProm, 2);

  if ($cantEgr > 0) {
  $kgEgrProm = ($pesoTotalEgr/$cantEgr);
  }

  $kgEgrProm = round($kgEgrProm, 2);

  if ($kgEgrProm > $kgIngProm) {
    $diferenciaIngEgr = $kgEgrProm - $kgIngProm;  
  }

  if ($cantIngConStockInicial != 0) {
    $stock += $cantIngConStockInicial;
  }
  
  if ($cantEgr != 0 AND $stock != 0) {
    $stock = ($stock - $cantEgr);   
  }
  if ($cantMuertes != 0 AND $stock != 0) {
    $stock = ($stock - $cantMuertes); 
  }


$seccionValido = array_key_exists('seccion',$_REQUEST);
if ($seccionValido) {
  $seccion = $_GET['seccion'];
}else{
  $seccion = '';
}

?>


