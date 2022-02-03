<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
include("includes/arrays.php");

$seccion = $_GET['seccion'];


$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

$desdeComp = validarCampo('desdeComp');
$hastaComp = validarCampo('hastaComp');

$comparacionValido = ($desdeComp != '' AND $desdeComp != '') ? TRUE : FALSE;

$cantIng = 0;
$cantEgr = 0;
$cantMuertes = 0;
$totalPesoIng = 0;
$totalPesoEgr = 0;
$kgIngProm = 0;
$kgEgrProm = 0;
$diferenciaIngEgr = 0;

if ($tipoSesion != 'balanza') {
  $sql = "SELECT * FROM stock WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
  $query = mysqli_query($conexion,$sql);
  while($resultados = mysqli_fetch_array($query)){
    $cantIng = $cantIng + $resultados['cantidad'];
    $cantEgr = $cantEgr + $resultados['egreso'];
    $cantMuertes = $cantMuertes + $resultados['muertes'];
    $totalPesoIng = $totalPesoIng + ($resultados['cantidad'] * $resultados['pesoIngreso']);
    $totalPesoEgr = $totalPesoEgr + ($resultados['egreso'] * $resultados['pesoEgreso']);
    if ($cantIng > 0) {
      $kgIngProm = ($totalPesoIng/$cantIng);
    }
    $kgIngProm = round($kgIngProm, 2);

    if ($cantEgr > 0) {
      $kgEgrProm = ($totalPesoEgr/$cantEgr);
    }
    $kgEgrProm = round($kgEgrProm, 2);

    if ($kgEgrProm > $kgIngProm) {
      $diferenciaIngEgr = $kgEgrProm - $kgIngProm;  
    }
  }
}else{
  $sql = "SELECT * FROM ingresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
  $query = mysqli_query($conexion,$sql);
  while($resultados = mysqli_fetch_array($query)){
    $cantIng++;
    $totalPesoIng += $resultados['peso'];
  }
    if ($cantIng > 0) {
      $kgIngProm = ($totalPesoIng/$cantIng);
    }
    $kgIngProm = round($kgIngProm, 2);
  $sql = "SELECT * FROM egresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
  $query = mysqli_query($conexion,$sql);
  while($resultados = mysqli_fetch_array($query)){
    $cantEgr++;
    $totalPesoEgr += $resultados['peso'];
  }  
    if ($cantEgr > 0) {
      $kgEgrProm = ($totalPesoEgr/$cantEgr);
    }
    $kgEgrProm = round($kgEgrProm, 2);

    if ($kgEgrProm > $kgIngProm) {
      $diferenciaIngEgr = $kgEgrProm - $kgIngProm;  
    }
  } 
/*
  if ($comparacionValido) {
    $sqlComp = "SELECT * FROM stock WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp'";
    $queryComp = mysqli_query($conexion,$sqlComp);
    while($resultadosComp = mysqli_fetch_array($queryComp)){
      $cantIngComp = $cantIngComp + $resultadosComp['cantidad'];
      $cantEgrComp = $cantEgrComp + $resultadosComp['egreso'];
      $cantMuertesComp = $cantMuertesComp + $resultadosComp['muertes'];
      $totalPesoIngComp = $totalPesoIngComp + ($resultadosComp['cantidad'] * $resultadosComp['pesoIngreso']);
      $totalPesoEgrComp = $totalPesoEgrComp + ($resultadosComp['egreso'] * $resultadosComp['pesoEgreso']);
      if ($cantIngComp > 0) {
        $kgIngPromComp = ($totalPesoIngComp/$cantIngComp);
      }
      $kgIngPromComp = round($kgIngPromComp, 2);

      if ($cantEgrComp > 0) {
        $kgEgrPromComp = ($totalPesoEgrComp/$cantEgrComp);
      }
      $kgEgrPromComp = round($kgEgrPromComp, 2);

      if ($kgEgrPromComp > $kgIngPromComp) {
        $diferenciaIngEgrComp = $kgEgrPromComp - $kgIngPromComp;  
      }
    }
  }
}else{
  $sql = "SELECT * FROM ingresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
  $query = mysqli_query($conexion,$sql);
  while($resultados = mysqli_fetch_array($query)){
    $cantIng = $cantIng + $resultados['cantidad'];
    $cantEgr = $cantEgr + $resultados['egreso'];
    $cantMuertes = $cantMuertes + $resultados['muertes'];
    $totalPesoIng = $totalPesoIng + ($resultados['cantidad'] * $resultados['pesoIngreso']);
    $totalPesoEgr = $totalPesoEgr + ($resultados['egreso'] * $resultados['pesoEgreso']);
    if ($cantIng > 0) {
      $kgIngProm = ($totalPesoIng/$cantIng);
    }
    $kgIngProm = round($kgIngProm, 2);

    if ($cantEgr > 0) {
      $kgEgrProm = ($totalPesoEgr/$cantEgr);
    }
    $kgEgrProm = round($kgEgrProm, 2);

    if ($kgEgrProm > $kgIngProm) {
      $diferenciaIngEgr = $kgEgrProm - $kgIngProm;  
    }
  }
}
*/



?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>JORGE CORNALE - GESTION DE FEEDLOTS</title>
    <link rel="icon" href="img/ico.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/ico.ico" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/chart/dist/Chart.bundle.js"></script>
    <script src="js/chart/samples/utils.js"></script>
    <script type="text/javascript" src="js/tablesorter/jquery.tablesorter.js"></script> 
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <script type="text/javascript">
    function mostrar(id) {
      $("#" + id).show(200);
    }
          
    </script>
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php
          include("includes/nav.php");
          ?>
        </div>
      </div>
    </div>
    <div class="container" style="padding-top: 50px;">
      <h1 style="display: inline-block;">Informe <?php echo ucwords($seccion). "Periodo: ".formatearFecha($desde)." -> ".formatearFecha($hasta);?></h1>
      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>
      <hr>
      <div class="hero-unit" style="padding-top: 10px;">
        <?php
        if ($seccion == 'stock') {
        ?>
          <h2 style="text-decoration: underline;"><b>Ingresos</b></h2>
            <div class="row-fluid">
              <div class="span12">
                <ul class="totales comparacion">
                  <?php 
                  echo ($comparacionValido) ? "<li><h4>Periodo: ".formatearFecha($desde)." al ".formatearFecha($hasta)."</h4></li>" : "";
                  ?>
                  <li><b>- Total Ingresos: </b><?php echo $cantIng." Animales";?></li>
                  <li><b>- Kg Neto Ingreso: </b><?php echo $totalPesoIng." Kg";?></li>
                  <li><b>- Kg Ingreso Promedio: </b><?php echo $kgIngProm." Kg";?></li>
                  <li><b>- Diferencia Kg Ing/Egr: </b><?php echo $diferenciaIngEgr." Kg";?></li>
                </ul>
                <?php
                if ($comparacionValido) {
                ?>
                <ul class="totales comparacion">
                  <li><h4>Periodo: <?php echo formatearFecha($desdeComp)." al ".formatearFecha($hastaComp);?></h4></li>
                  <li><b>- Total Ingresos: </b><?php echo $cantIngComp." Animales";?></li>
                  <li><b>- Kg Neto Ingreso: </b><?php echo $totalPesoIngComp." Kg";?></li>
                  <li><b>- Kg Ingreso Promedio: </b><?php echo $kgIngPromComp." Kg";?></li>
                  <li><b>- Diferencia Kg Ing/Egr: </b><?php echo $diferenciaIngEgrComp." Kg";?></li>
                </ul>
                <?php
                }
                include('includes/charts/ingreso.php');
                ?>
              </div>
            </div>
          <hr>
          <div class="row-fluid">
              <div class="span12">
                <h2 style="text-decoration: underline;"><b>Egresos</b></h2>
                <ul class="totales comparacion">
                 <?php 
                  echo ($comparacionValido) ? "<li><h4>Periodo: ".formatearFecha($desde)." al ".formatearFecha($hasta)."</h4></li>" : "";
                  ?>
                  <li><b>- Total Egresos: </b><?php echo $cantEgr." Animales";?></li>
                  <li><b>- Kg Neto Egreso: </b><?php echo $totalPesoEgr." Kg";?></li>
                  <li><b>- Kg Egreso Promedio: </b><?php echo $kgEgrProm." Kg";?></li>
                  <li><b>- Diferencia Kg Ing/Egr: </b><?php echo $diferenciaIngEgr." Kg";?></li>
                </ul>
                <?php
                if ($comparacionValido) {
                ?>
                <ul class="totales comparacion">
                  <li><h4>Periodo: <?php echo formatearFecha($desdeComp)." al ".formatearFecha($hastaComp);?></h4></li>
                  <li><b>- Total Egresos: </b><?php echo $cantEgrComp." Animales";?></li>
                  <li><b>- Kg Neto Egreso: </b><?php echo $totalPesoEgrComp." Kg";?></li>
                  <li><b>- Kg Egreso Promedio: </b><?php echo $kgEgrPromComp." Kg";?></li>
                  <li><b>- Diferencia Kg Ing/Egr: </b><?php echo $diferenciaIngEgrComp." Kg";?></li>
                </ul>
                <?php
                }
                include('includes/charts/egreso.php');
                ?>
              </div>
            </div>
          <hr>
          <hr>
            <div class="row-fluid">
                <div class="span12">
                <h2 style="text-decoration: underline;"><b>Muertes</b></h2>
                  <ul class="totales comparacion">
                    <li><b>- Total Muertes: </b><?php echo $cantMuertes;?></li>
                  </ul>
                  <?php
                  if ($comparacionValido) {
                  ?>
                  <ul class="totales comparacion">
                    <li><b>- Total Muertes: </b><?php echo $cantMuertesComp;?></li>
                  </ul>
                  <?php
                  }
                  ?>
                <br>
                <br>
                <table id="tablesorter-demo3" class="table table-striped tablesorter" style="box-shadow: 1px -2px 15px 1px;">
                  <thead>
                    <tr>
                      <th scope="col">Fecha Muerte</th>
                      <th scope="col">Cantidad</th>
                      <th scope="col">Causa Muerte</th>
                      <td scope="col">Total</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sqlQuery = "SELECT * FROM stock WHERE (fecha BETWEEN '$desde' AND '$hasta') AND (muertes != 0) AND (feedlot = '$feedlot')";
                    $query = mysqli_query($conexion,$sqlQuery);
                    while($fila3 = mysqli_fetch_array($query)){
                      ?>
                    <tr>
                      <td scope="row"><?php echo formatearFecha($fila3['fecha']);?></td>
                      <td><?php echo $fila3['muertes'];?></td>
                      <td><?php echo $fila3['causaMuerte'];?></td>
                      <td>TOTAL</td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
                  <div id="canvas-holder" style="width:60%;margin:0 auto;">
                    <canvas id="muertes"></canvas>
                  </div>
                  <script>
                    var config = {
                      type: 'pie',
                      data: {
                        datasets: [{
                          data: [
                            <?php
                              $virus = 0;
                              $neumo = 0;
                              $sequia = 0;
                              $desconocida = 0;

                              $sql = "SELECT causaMuerte,muertes FROM stock WHERE (fecha BETWEEN '$desde' AND '$hasta') AND (muertes != 0) AND (feedlot = '$feedlot')";
                              $query = mysqli_query($conexion,$sql);
                              while($resultado = mysqli_fetch_array($query)){
                                switch ($resultado['causaMuerte']) {
                                  case 'VIRUS':
                                    $virus = $virus + $resultado['muertes'];
                                    break;
                                  
                                  case 'NEUMO':
                                    $neumo = $neumo + $resultado['muertes'];
                                    break;

                                  case 'SEQUIA':
                                    $sequia = $sequia + $resultado['muertes'];
                                    break;

                                  case 'DESCONOCIDA':
                                    $desconocida = $desconocida + $resultado['muertes'];
                                    break;

                                  default:
                                    # code...
                                    break;
                                }
                              }
                             echo $virus.",".$neumo.",".$sequia.",".$desconocida.",";
                            ?>
                            ],
                            backgroundColor: [
                              window.chartColors.red,
                              window.chartColors.orange,
                              window.chartColors.blue,
                              window.chartColors.green,
                            ],
                            label: 'Dataset 1'
                          }],
                          labels: [
                            'Virus',
                            'Neumo',
                            'Sequia',
                            'Desconocida'
                          ]
                        },
                        options: {
                          responsive: true
                        }
                      };

                      
                    </script>
                    <br>
                    <?php
                    if ($comparacionValido) {
                    ?>
                    <table id="tablesorter-demo3" class="table table-striped tablesorter" style="box-shadow: 1px -2px 15px 1px;">
                      <thead>
                        <tr>
                          <th scope="col">Fecha Muerte</th>
                          <th scope="col">Cantidad</th>
                          <th scope="col">Causa Muerte</th>
                          <td scope="col">Total</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sqlQuery = "SELECT * FROM stock WHERE (fecha BETWEEN '$desdeComp' AND '$hastaComp') AND (muertes != 0) AND (feedlot = '$feedlot')";
                        $query = mysqli_query($conexion,$sqlQuery);
                        while($fila4 = mysqli_fetch_array($query)){
                          ?>
                        <tr>
                          <td scope="row"><?php echo formatearFecha($fila4['fecha']);?></td>
                          <td><?php echo $fila4['muertes'];?></td>
                          <td><?php echo $fila4['causaMuerte'];?></td>
                          <td>TOTAL</td>
                        </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                    <div id="canvas-holder" style="width:60%;margin:0 auto;">
                      <canvas id="muertesComp"></canvas>
                    </div>
                    <script>
                      var config2 = {
                        type: 'pie',
                        data: {
                          datasets: [{
                            data: [
                            <?php
                            $virusComp = 0;
                            $neumoComp = 0;
                            $sequiaComp = 0;
                            $desconocidaComp = 0;

                            $sql2 = "SELECT causaMuerte,muertes FROM stock WHERE (fecha BETWEEN '$desdeComp' AND '$hastaComp') AND (muertes != 0) AND (feedlot = '$feedlot')";
                            $query2 = mysqli_query($conexion,$sql2);
                            while($resultado2 = mysqli_fetch_array($query2)){
                              switch ($resultado2['causaMuerte']) {
                                case 'VIRUS':
                                $virusComp = $virusComp + $resultado2['muertes'];
                                break;

                                case 'NEUMO':
                                $neumoComp = $neumoComp + $resultado2['muertes'];
                                break;

                                case 'SEQUIA':
                                $sequiaComp = $sequiaComp + $resultado2['muertes'];
                                break;

                                case 'DESCONOCIDA':
                                $desconocidaComp = $desconocidaComp + $resultado2['muertes'];
                                break;

                                default:
                                break;
                              }
                            }
                            echo $virusComp.",".$neumoComp.",".$sequiaComp.",".$desconocidaComp.",";
                            ?>
                            ],
                            backgroundColor: [
                            window.chartColors.red,
                            window.chartColors.orange,
                            window.chartColors.blue,
                            window.chartColors.green,
                            ],
                            label: 'Dataset 1'
                          }],
                          labels: [
                          'Virus',
                          'Neumo',
                          'Sequia',
                          'Desconocida'
                          ]
                        },
                        options: {
                          responsive: true
                        }
                      };


                    </script>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                  <script type="text/javascript">
                    window.onload = function() {
                      var stock = document.getElementById('stock').getContext('2d');
                      window.myLine = new Chart(stock, configStock);

                        var muertes = document.getElementById('muertes').getContext('2d');
                        window.myPie = new Chart(muertes, config);
                        <?php
                        if ($comparacionValido) {
                          ?>
                          var muertesComp = document.getElementById('muertesComp').getContext('2d');
                        window.myPie2 = new Chart(muertesComp, config2);
                        <?php
                      }
                        ?>
                      };
                  </script>
      <?php
        }

        if ($seccion == 'status') {
        ?>
        <?php
        }
        if ($seccion == 'racion') {
        ?>
        <?php
        }
        ?>
      </div>
      <hr>
      <footer>
        <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
      </footer>
    </div>

    <script type="text/javascript">
      
    </script>
    






    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/alert.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/dropdown.js"></script>
    <script src="js/scrollspy.js"></script>
    <script src="js/tab.js"></script>
    <script src="js/tooltip.js"></script>
    <script src="js/popover.js"></script>
    <script src="js/button.js"></script>
    <script src="js/collapse.js"></script>
    <script src="js/carousel.js"></script>
    
  </body>
</html>
