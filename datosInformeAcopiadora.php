<?php
$seccion = $_GET['seccion'];

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

$fechaDesde = new DateTime($desde);
$fechaHasta = new DateTime($hasta);
$diferencia = $fechaDesde->diff($fechaHasta);
$mesesDiferencia = $diferencia->m;
$meses =array();
$semanas = array();
$labelsIngEgrMeses = FALSE;
$labelsMeses = FALSE;

if ($mesesDiferencia >= 2) {
  $labelsIngEgrMeses = TRUE;
}

if ($mesesDiferencia > 3) {
  $labelsMeses = TRUE;
}

if ($labelsIngEgrMeses) {
  $meses = labelsCantAnimales($desde,$hasta);
}else{

  $sql = "SELECT DISTINCT(fecha) FROM registroingresos WHERE fecha BETWEEN '$desde' AND '$hasta'";
  $query = mysqli_query($conexion,$sql);
  $fechas = array();
  while ($fila = mysqli_fetch_array($query)) {
    $fechas[] = $fila['fecha'];
  }

  $sql = "SELECT DISTINCT(fecha) FROM registroegresos WHERE fecha BETWEEN '$desde' AND '$hasta'";
  $query = mysqli_query($conexion,$sql);
  while ($fila = mysqli_fetch_array($query)) {
    $fechas[] = $fila['fecha'];
  }
  asort($fechas);
  $fechas = array_unique($fechas); 
  $fechas = array_values($fechas);
}


$desdeComp = (array_key_exists('desdeComp', $_GET)) ? $_GET['desdeComp'] : "";
$hastaComp = (array_key_exists('hastaComp', $_GET)) ? $_GET['hastaComp'] : "";


$comparacionValido = ($desdeComp != '' AND $desdeComp != '') ? TRUE : FALSE;

// COMPARACION VALIDO

if ($comparacionValido) {
  $fechaDesdeComp = new DateTime($desdeComp);
  $fechaHastaComp = new DateTime($hastaComp);
  $diferenciaComp = $fechaDesdeComp->diff($fechaHastaComp);
  $mesesDiferenciaComp = $diferenciaComp->m;
  $mesesComp =array();
  $semanasComp = array();
  $labelsIngEgrMesesComp = FALSE;
  $labelsMesesComp = FALSE;

  if ($mesesDiferenciaComp >= 2) {
    $labelsIngEgrMesesComp = TRUE;
  }

  if ($mesesDiferenciaComp > 3) {
    $labelsMesesComp = TRUE;
  }

  if ($labelsIngEgrMesesComp) {
    $mesesComp = labelsCantAnimales($desdeComp,$hastaComp);
  }else{
    $diasDiferenciaComp = $diferenciaComp->days;
    $cantSemanasComp = floor($diasDiferenciaComp/7); 
    $labelsSemanasComp = array();
    for ($i=1; $i <= $cantSemanasComp ; $i++) { 
      $labelsSemanasComp[] = "Semana ".$i;
    }
  }
}

$cantIng = 0;
$cantEgr = 0;
$cantMuertes = 0;
$totalPesoIng = 0;
$totalPesoEgr = 0;
$kgIngProm = 0;
$kgEgrProm = 0;
$diferenciaIngEgr = 0;
$cantidadIngresos = 0;
$cantidadEgresos = 0;


  /// INGRESOS 

    $sqlIng = "SELECT * FROM registroingresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha";

    $queryIng = mysqli_query($conexion,$sqlIng);


    $mesFecha = "";

    $mesFechaTemp = "";

    $ingresosPorMes = $meses;

    $fechaTemp = "";

    while($resultados = mysqli_fetch_array($queryIng)){

      $cantIng += $resultados['cantidad'];

      $cantidadIngresos += $resultados['cantidad'];

      $totalPesoIng += ($resultados['cantidad'] * $resultados['pesoPromedio']);

      $fecha = $resultados['fecha'];


      /// INGRESO POR MESES
      $mesFecha = date('n',strtotime($fecha));

      if ($mesFecha != $mesFechaTemp) {

        $cantidadIngresos = 1;

      }

      foreach ($meses as $numero => $nombreMes) {

        if ($mesFecha == $numero) {

          $ingresosPorMes[$numero] = $cantidadIngresos;

        }

      }

      $mesFechaTemp = $mesFecha;
    
    }
    
    foreach ($ingresosPorMes as $numero => $cantidad) {

        if (is_string($cantidad)) {

          $ingresosPorMes[$numero] = 0;

        }

      }

    if ($cantIng > 0) {

        $kgIngProm = ($totalPesoIng/$cantIng);

    }

    $kgIngProm = round($kgIngProm, 2);

  /// EGRESOS

    $sqlIng = "SELECT * FROM registroegresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha";

    $queryIng = mysqli_query($conexion,$sqlIng);

    $mesFecha = "";

    $mesFechaTemp = "";

    $egresosPorMes = $meses;

    while($resultados = mysqli_fetch_array($queryIng)){

        $cantEgr += $resultados['cantidad'];

        $cantidadEgresos += $resultados['cantidad'];

        $totalPesoEgr += ($resultados['cantidad'] * $resultados['pesoPromedio']);
        
        $fecha = $resultados['fecha'];

        $mesFecha = date('n',strtotime($fecha));
        
        if ($mesFecha != $mesFechaTemp) {

            $cantidadEgresos = 1;
            
        }

        foreach ($meses as $numero => $nombreMes) {
        
            if ($mesFecha == $numero) {
            
                $egresosPorMes[$numero] = $cantidadEgresos;
                
            }
                
        }
            
        $mesFechaTemp = $mesFecha;
        
    }

    foreach ($egresosPorMes as $numero => $cantidad) {

      if (is_string($cantidad)) {

        $egresosPorMes[$numero] = 0;

      }

    }

    if ($cantEgr > 0) {

        $kgEgrProm = ($totalPesoEgr/$cantEgr);

    }

    $kgEgrProm = round($kgEgrProm, 2);


    /// DIFERENCIA 
    if ($kgEgrProm > $kgIngProm) {
        $diferenciaIngEgr = $kgEgrProm - $kgIngProm;  
      }

  /// MUERTES 

    $sqlMuertes = "SELECT SUM(cantidad) as totalMuertes FROM registromuertes WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha";
    $queryMuertes = mysqli_query($conexion,$sqlMuertes);
    $resultadoMuertes = mysqli_fetch_array($queryMuertes);
    $totalMuertes = $resultadoMuertes['totalMuertes'];


///////////////////////// COMPARAR /////////////////////////////////

  if ($comparacionValido) {
    $cantIngComp = 0;
    $cantEgrComp = 0;
    $cantMuertesComp = 0;
    $totalPesoIngComp = 0;
    $totalPesoEgrComp = 0;
    $kgIngPromComp = 0;
    $kgEgrPromComp = 0;
    $diferenciaIngEgrComp = 0;
    $cantidadIngresosComp = 0;
    $cantidadEgresosComp = 0;


    /// INGRESOS 

      $sqlIngComp = "SELECT * FROM registroingresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp' ORDER BY fecha";

      $queryIngComp = mysqli_query($conexion,$sqlIngComp);

      $mesFechaComp = "";

      $mesFechaTempComp = "";

      $ingresosPorMesComp = $mesesComp; 

      $fechaTempComp = "";

      while($resultadosComp = mysqli_fetch_array($queryIngComp)){

        $cantIngComp += $resultadosComp['cantidad'];

        $cantidadIngresosComp += $resultadosComp['cantidad'];

        $totalPesoIngComp += ($resultadosComp['cantidad'] * $resultadosComp['pesoPromedio']);

        $fechaComp = $resultadosComp['fecha'];


        /// INGRESO POR MESES
        $mesFechaComp = date('n',strtotime($fechaComp));

        if ($mesFechaComp != $mesFechaTempComp) {

          $cantidadIngresosComp = 1;

        }

        foreach ($mesesComp as $numeroComp => $nombreMesComp) {

          if ($mesFechaComp == $numeroComp) {

            $ingresosPorMesComp[$numeroComp] = $cantidadIngresosComp;

          }

        }

        $mesFechaTempComp = $mesFechaComp;
    
      }

        foreach ($ingresosPorMesComp as $numeroComp => $cantidadComp) {
          if (is_string($cantidadComp)) {
            $ingresosPorMesComp[$numeroComp] = 0;
          }
        }

        if ($cantIngComp > 0) {
          $kgIngPromComp = ($totalPesoIngComp/$cantIngComp);
          }
          $kgIngPromComp = round($kgIngPromComp, 2);

    /// EGRESOS

      $sqlEgrComp = "SELECT * FROM registroegresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp' ORDER BY fecha";

      $queryEgrComp = mysqli_query($conexion,$sqlEgrComp);

      $mesFechaComp = "";

      $mesFechaTempComp = "";

      $egresosPorMesComp = $mesesComp;

      while($resultadosComp = mysqli_fetch_array($queryEgrComp)){

        $cantEgrComp += $resultadosComp['cantidad'];

        $cantidadEgresosComp += $resultadosComp['cantidad'];

        $totalPesoEgrComp += ($resultadosComp['cantidad'] * $resultadosComp['pesoPromedio']);
        
        
        ////

        $fechaComp = $resultadosComp['fecha'];

        $mesFechaComp = date('n',strtotime($fechaComp));

        if ($mesFechaComp != $mesFechaTempComp) {

          $cantidadEgresosComp = 1;

        }

        foreach ($mesesComp as $numero => $nombreMes) {

          if ($mesFechaComp == $numero) {

            $egresosPorMesComp[$numero] = $cantidadEgresosComp;

          }

        }

        $mesFechaTempComp = $mesFechaComp;

      }


      foreach ($egresosPorMesComp as $numero => $cantidad) {

        if (is_string($cantidad)) {

          $egresosPorMesComp[$numero] = 0;

        }

      }

      /// DIFERENCIA 

      if ($cantEgrComp > 0) {

      $kgEgrPromComp = ($totalPesoEgrComp/$cantEgrComp);

      }

      $kgEgrPromComp = round($kgEgrPromComp, 2);


      
          /// DIFERENCIA 
        if ($kgEgrPromComp > $kgIngPromComp) {

            $diferenciaIngEgrComp = $kgEgrPromComp - $kgIngPromComp;  

          }
    /// MUERTES 

      $sqlMuertesComp = "SELECT SUM(cantidad) as totalMuertes FROM registromuertes WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp'";
      $queryMuertesComp = mysqli_query($conexion,$sqlMuertesComp);
      $resultadoMuertesComp = mysqli_fetch_array($queryMuertesComp);
      $totalMuertesComp = $resultadoMuertesComp['totalMuertes'];
  }


function color_rand() {
 return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}