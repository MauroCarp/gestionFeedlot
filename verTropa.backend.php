<?php

$accionValido = array_key_exists("accion", $_REQUEST);

if ($accionValido) {
  $accion = $_GET['accion'];

  if ($accion == "modificar") {
    $tropaOriginal = $_GET['tropa'];
    $tropa = $_POST['tropa'];
    $fechaIngreso = $_POST['fechaIngreso'];
    $renspa = $_POST['renspa'];
    $adpv = ($_POST['adpv'] == "") ? 0 : $_POST['adpv'];
    $origen = $_POST['origen'];
    $proveedor = $_POST['proveedor'];
    $estado = $_POST['estado'];
    $corral = $_POST['corral'];
    $notas = $_POST['notas'];

    $sqlIngreso = "UPDATE ingresos SET
    tropa = '$tropa',
    fecha = '$fechaIngreso',
    renspa = '$renspa',
    adpv = '$adpv',
    origen = '$origen',
    proveedor = '$proveedor',
    estado = '$estado',
    corral = '$corral',
    notas = '$notas' WHERE tropa = '$tropaOriginal'";
    mysqli_query($conexion,$sqlIngreso);
    header("Location:verTropa.php?tropa=$tropa&seccion=ingresos");
  }

}

$tropaValido = array_key_exists("tropa", $_REQUEST);

if ($tropaValido) {
$tropa = $_GET['tropa'];
$seccion = $_GET['seccion'];
$cantIng = 0;
$cantEgr = 0;
$cantMuertes = 0;
$totalPesoIng = 0;
$totalPesoEgr = 0;
$kgIngProm = 0;
$kgEgrProm = 0;
$diferenciaIngEgr = 0;
if ($seccion == 'ingresos') {

  $sqlIng = "SELECT renspa,adpv,peso,estado,fecha,proveedor,estado,origen,corral,notas, MAX(peso) as maximo, MIN(peso) as minimo, COUNT(id) as total, SUM(peso) as pesoTotal FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
  $queryIng = mysqli_query($conexion,$sqlIng);
  $resultados = mysqli_fetch_array($queryIng);
    $cantIng = $resultados['total'];
    $renspa = $resultados['renspa'];
    $adpv = $resultados['adpv'];
    $totalPesoIng = $resultados['pesoTotal'];
    $fechaIngreso = $resultados['fecha'];
    $estado = $resultados['estado'];
    $proveedor = $resultados['proveedor'];
    $origen = $resultados['origen'];
    $corral = $resultados['corral'];
    $notas = $resultados['notas'];
    $pesoMax = $resultados['maximo'];
    $pesoMin = $resultados['minimo'];


  if ($cantIng > 0) {
  $kgIngProm = ($totalPesoIng/$cantIng);
  }
  $kgIngProm = round($kgIngProm, 2);
}

if ($seccion == 'egresos') {
  $sqlEgr = "SELECT peso,fecha,destino, MAX(peso) as maximo, MIN(peso) as minimo, COUNT(id) as total, SUM(peso) as pesoTotal FROM egresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
  $queryEgr = mysqli_query($conexion,$sqlEgr);
  $resultados = mysqli_fetch_array($queryEgr);
    $cantEgr = $resultados['total'];
    $totalPesoEgr = $resultados['pesoTotal'];
    $fechaEgreso = $resultados['fecha'];
    $destino = $resultados['destino'];
    $pesoMaxEgr = $resultados['maximo'];
    $pesoMinEgr = $resultados['minimo'];


  if ($cantEgr > 0) {
  $kgEgrProm = ($totalPesoEgr/$cantEgr);
  }
  $kgEgrProm = round($kgEgrProm, 2);

}
  
}
