<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
require("includes/arrays.php");

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
die();
if ($seccion == 'ingresos') {

  $sqlIng = "SELECT * FROM ingresos WHERE tropa = '$tropa'";
  $queryIng = mysqli_query($conexion,$sqlIng);
  while($resultados = mysqli_fetch_array($queryIng)){
    $cantIng++;
    $renspa = $resultados['renspa'];
    $adpv = $resultados['adpv'];
    $totalPesoIng += $resultados['peso'];
    $fechaIngreso = $resultados['fecha'];
    $estado = $resultados['estado'];
    $proveedor = $resultados['proveedor'];
  }

  if ($cantIng > 0) {
  $kgIngProm = ($totalPesoIng/$cantIng);
  }
  $kgIngProm = round($kgIngProm, 2);
}

if ($seccion == 'egresos') {

  $sqlIng = "SELECT * FROM egresos WHERE tropa = '$tropa'";
  $queryIng = mysqli_query($conexion,$sqlIng);
  while($resultados = mysqli_fetch_array($queryIng)){
    $cantEgr++;
    $totalPesoEgr += $resultados['peso'];
    $fechaEgreso = $resultados['fecha'];
    $destino = $resultados['destino'];
  }

  if ($cantEgr > 0) {
  $kgEgrProm = ($totalPesoEgr/$cantEgr);
  }
  $kgEgrProm = round($kgEgrProm, 2);
}

}

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>JORGE CORNALE - GESTION DE FEEDLOTS</title>
    <link rel="icon" href="img/ico.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/ico.ico" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-2.2.4.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/chart/dist/Chart.bundle.js"></script>
    <script src="js/chart/samples/utils.js"></script>
    <script type="text/javascript" src="js/tableSorter/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="js/tableSorter/jquery.tablesorter.widgets.js"></script>
    <script src="js/tab.js"></script>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 10px;
      }
    </style>
    <script type="text/javascript">
    
    function mostrar(id) {
      $("#" + id).show(200);
    }
    
    $(function() {
      $("#myTable").tablesorter();
    });          
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
      <h1 style="display: inline-block;">STOCK</h1>
      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>
      <div class="hero-unit" style="padding-top: 10px;margin-bottom: 5px;">
        <h2>Tropa <?php echo $tropa;?></h2>

        <div class="bs-docs-example">
          <?php
          if ($seccion == 'ingresos') { ?>
          <ul class="totales">
            <li><b>- R.E.N.S.P.A: </b><?php echo $renspa;?></li>
            <li><b>- ADPV: </b><?php echo $adpv." Kg";?></li>
            <li><b>- Fecha de Ingreso: </b><?php echo formatearFecha($fechaIngreso);?></li>
            <li><b>- Estado: </b><?php echo $estado;?></li>
            <li><b>- Proveedor: </b><?php echo $proveedor;?></li>
            <li><b>- Total Ingreso: </b><?php echo $cantIng." Animales";?></li>
            <li><b>- Kg Neto Ingreso: </b><?php echo $totalPesoIng." Kg";?></li>
            <li><b>- Kg Ingreso Promedio: </b><?php echo $kgIngProm." Kg";?></li>
          </ul>
          <?php }
          if ($seccion == 'egresos') { ?>
            <ul class="totales">
              <li><b>- Fecha de Egreso: </b><?php echo formatearFecha($fechaEgreso);?></li>
              <li><b>- Destino: </b><?php echo $destino;?></li>
              <li><b>- Total Egreso: </b><?php echo $cantEgr." Animales";?></li>
              <li><b>- Kg Neto Egreso: </b><?php echo $totalPesoEgr." Kg";?></li>
              <li><b>- Kg Egreso Promedio: </b><?php echo $kgEgrProm." Kg";?></li>
            </ul>
          <?php }
          ?>
          <hr>
          <div class="row-fluid">
            <div class="span7">
              <div id="canvas-holder" style="width:100%;display: inline-block;">
                <canvas id="canvasRaza"></canvas>
              </div>
            </div>
            <div class="span5">
              <div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
                <canvas id="chart-area"></canvas>
              </div>
            </div>
          </div>
          <hr>
          <div class="row-fluid">
            <div class="span7">
              <div id="canvas-holder" style="width:100%;display: inline-block;">
                <canvas id="canvasIncremento"></canvas>
              </div>
            </div>
            <div class="span5">
            </div>
          </div>
          <span class="ir-arriba icon-arrow-up2"></span>
        </div>
        <br>
        <br>
        <?php
        if ($seccion == 'ingresos') { ?>
          <a href="stock.php?seccion=ingreso" class="btn btn-primary btn-large">Volver</a>
        <?php }
        if ($seccion == 'egresos') { ?>
          <a href="stock.php?seccion=egreso" class="btn btn-primary btn-large">Volver</a>
        <?php }
        ?>
        <hr>
      <footer>
        <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
      </footer>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
                $(".causaMuerteOtro").hide();
                $("#selectCausaMuerte").change(function(){
                $(".causaMuerteOtro").hide();
                var causa = $(this).val();
                if (causa == "otro") {
                    $("#mostrarOtra").show();
                }
                });
            });



        $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        })

        $(document).ready(function(){
 
          $('.ir-arriba').click(function(){
            $('body, html').animate({
              scrollTop: '0px'
            }, 300);
          });
         
          $(window).scroll(function(){
            if( $(this).scrollTop() > 0 ){
              $('.ir-arriba').slideDown(300);
            } else {
              $('.ir-arriba').slideUp(300);
            }
          });
         
        });

        $(function() {
          $("#myTable").tablesorter({ sortList: [[0,0], [1,0]] });
        });


        // SEXO

        var config = {
      type: 'pie',
      data: {
        datasets: [{
          data: [
          <?php
            if ($seccion == 'ingresos') {
            $sqlMacho = "SELECT COUNT(sexo) AS macho FROM ingresos WHERE sexo = 'Macho' AND tropa = '$tropa'";
            $queryMacho = mysqli_query($conexion,$sqlMacho);
            $resultado = mysqli_fetch_array($queryMacho);
            $macho = $resultado['macho'];

            $sqHemb = "SELECT COUNT(sexo) AS hembra FROM ingresos WHERE sexo = 'Hembra' AND tropa = '$tropa'";
            $querHemb = mysqli_query($conexion,$sqHemb);
            $resultado = mysqli_fetch_array($querHemb);
            $hembra = $resultado['hembra'];
            }

            if ($seccion == 'egresos') {
            $sqlMacho = "SELECT COUNT(sexo) AS macho FROM egresos WHERE sexo = 'Macho' AND tropa = '$tropa'";
            $queryMacho = mysqli_query($conexion,$sqlMacho);
            $resultado = mysqli_fetch_array($queryMacho);
            $macho = $resultado['macho'];

            $sqHemb = "SELECT COUNT(sexo) AS hembra FROM egresos WHERE sexo = 'Hembra' AND tropa = '$tropa'";
            $querHemb = mysqli_query($conexion,$sqHemb);
            $resultado = mysqli_fetch_array($querHemb);
            $hembra = $resultado['hembra'];
            }

          $resultado = $macho.",".$hembra.",";
          echo $resultado;

          ?>
          ],
          backgroundColor: [
            window.chartColors.red,
            window.chartColors.orange,
          ],
          label: 'Sexo'
        }],
        labels: [
          'Macho',
          'Hembra'
        ]
      },
      options: {
        responsive: true,
        title: {
              display: true,
              text: 'Cant. Segun Sexo'
            }
        
      }
    };



    // RAZAS
    <?php
    $sqlRazas = "SELECT raza FROM razas ORDER BY raza ASC";
    $queryRazas = mysqli_query($conexion,$sqlRazas);
    $labelsRaza = "";
    $cantXraza = "";
    while ($razas = mysqli_fetch_array($queryRazas)) {
      $labelsRaza = $labelsRaza.",'".$razas['raza']."'";  
      ${$razas['raza']} = cantRaza($razas['raza'],'ingresos',$tropa,$conexion);
      $cantXraza = $cantXraza.",".${$razas['raza']};
    }
    $labelsRaza = substr($labelsRaza, 1);
    $cantXraza = substr($cantXraza, 1);
    ?>
    var RAZAS = [
    <?php
    echo $labelsRaza;
    ?>
    ];
      var color = Chart.helpers.color;
      var barChartData = {
      labels: [
      <?php
      echo $labelsRaza;
      ?>
      ],
      datasets: [{
        label: 'Razas',
        backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
        borderColor: window.chartColors.red,
        borderWidth: 1,
        data: [
          <?php
          if ($seccion == 'ingresos') { 
            echo $cantXraza;
          }

         /* if ($seccion == 'egresos') { 
            $aberdeen = cantRaza('Aberdeen Angus','egresos',$tropa,$conexion);
            $bradford = cantRaza('Bradford','egresos',$tropa,$conexion);
            $shorthorn = cantRaza('Shorthorn','egresos',$tropa,$conexion);
            $hereford = cantRaza('Hereford','egresos',$tropa,$conexion);
            $brangus = cantRaza('Brangus','egresos',$tropa,$conexion);
            $cruza = cantRaza('Cruza','egresos',$tropa,$conexion);
          }

            echo $aberdeen.",".$bradford.",".$shorthorn.",".$hereford.",".$brangus.",".$cruza.",";*/
          ?>
        ]
      }]

    };

// INCREMENTO

   var FECHAS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var configInc = {
      type: 'line',
      data: {
        labels: [

        <?php
        $fechaHoy = date("Y-m-d");
        $ingreso = new DateTime("$fechaIngreso");
        $hoy = new DateTime("$fechaHoy");
        $diferencia = $ingreso->diff($hoy);
        $diferencia = $diferencia->days;
        $fechaSumada = $fechaIngreso;
        $contador = 1;
        $pesos = "";
        $labels = "";
        $pesoInicial = $kgIngProm;

        $pesoTemp = $kgIngProm;
        $array = array();

        if ($diferencia > 5) {
          while ($fechaSumada < $fechaHoy) {
            $contador++;
            $pesoTemp += ($adpv*5);
            $array[$fechaSumada] = $pesoTemp;
            $fechaSumada = date("Y-m-d",strtotime($fechaSumada."+ 5 days"));
            $ultimaFecha = $fechaSumada;

          }

          function endKey($array){
              end($array);
              return key( $array );
          }
          $ultimaFecha = endKey($array);

          $ultima = new DateTime("$ultimaFecha");
          $hoy = new DateTime("$fechaHoy");
          $diferencia = $ultima->diff($hoy);
          $diferencia = $diferencia->days;

          $pesoTemp = $pesoTemp + ($adpv*$diferencia);

          $array[$fechaHoy] = $pesoTemp;

          foreach ($array as $fechas => $kilos) {
            $labels = $labels.",'".formatearFecha($fechas)."'";
            $pesos = $pesos.",".$kilos;
          }

          $labels = substr($labels,1);
          $pesos = substr($pesos,1);

        }else{
        $labels = "'".formatearFecha($fechaIngreso)."','".formatearFecha($fechaHoy)."'";
        $ultimaFecha = $fechaHoy;
        $pesos = $pesoTemp.",";
        $pesoTemp = $pesoTemp + ($adpv*$diferencia);
        $pesos = $pesos.$pesoTemp;
        }



        echo $labels;
        ?>

        ],
        datasets: [{
          label: 'Incremento de peso, basado en ADPV <?php echo $adpv." Kg";?>',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [
            <?php

            echo $pesos;

            ?>
          ],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Incremento de Peso'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Fecha'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Peso'
            }
          }]
        }
      }
    };
  
      window.onload = function() {
        var sexo = document.getElementById('chart-area').getContext('2d');
        window.myPie = new Chart(sexo, config);
        
        var adpv = document.getElementById('canvasIncremento').getContext('2d');
        window.myLine = new Chart(adpv, configInc);

        var raza = document.getElementById('canvasRaza').getContext('2d');
        window.myBar = new Chart(raza, {
          type: 'bar',
          data: barChartData,
          options: {
            responsive: true,
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Cant. Segun Raza'
            }
          }
        });

      };

    </script>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
  </body>
</html>
