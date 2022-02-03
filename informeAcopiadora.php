<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/arrays.php");
require("includes/funciones.php");

require_once 'datosInformeAcopiadora.php';

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
    <script src="js/chartjs-plugin-labels.min.js"></script>
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
        <?php if (!$comparacionValido) { ?>
        <h3>Periodo: <?php echo formatearFecha($desde)." / ".formatearFecha($hasta);?></h3>
        <?php 
        }
        ?>
        <div class="bs-docs-example">
              <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="#ingresos" data-toggle="tab"><b>Ingresos</b></a></li>
                <li><a href="#egresos" data-toggle="tab"><b>Egresos</b></a></li>
                <li><a href="#muertes" data-toggle="tab"><b>Muertes</b></a></li>
              </ul>
          <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="ingresos">
              <?php include('informes/ingresos.php');?>
            </div>
            <div class="tab-pane fade" id="egresos">
              <?php include('informes/egresos.php');?>
            </div>
            <div class="tab-pane fade" id="muertes">
              <?php include('informes/muertes.php');?>
            </div>
          </div>
        </div>
        <button class="btn btn-primary" onclick="imprimir()">Imprimir</button>
          <span class="ir-arriba icon-arrow-up2"></span>
        </div>
        <hr>
      <footer>
        <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
      </footer>
    </div>

    <script type="text/javascript">

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

        function calculaCPS(){
          var desde = $('#pesoDesde').val();
          var hasta = $('#pesoHasta').val();
          var fechaDesde = <?php echo "'".$desde."'";?>;
          var fechaHasta = <?php echo "'".$hasta."'";?>;
          var datos = 'desde=' + desde + '&hasta=' + hasta + '&fDesde=' + fechaDesde + '&fHasta=' + fechaHasta;
          var url = 'cantidadSegunPesoInforme.php';
          console.log(desde);
          console.log(hasta);
          console.log(fechaDesde);
          console.log(fechaHasta);
          console.log(url);

          $.ajax({
            type:'POST',
            url:url,
            data:datos,
            success: function(datos){
              console.log(datos);
              datos = datos.split(",");
              myDoughnut.data.datasets[0].data[0] = datos[0];
              myDoughnut.data.datasets[0].data[1] = datos[1];
              myDoughnut.update();
            }
          });
        } 


      window.onload = function() {
        <?php if (!$comparacionValido) {?>
              var color = Chart.helpers.color;
              

          var lineChartDataIngEgr = {
            labels: [
            <?php
            if ($labelsIngEgrMeses) {
              echo implode(",",$meses);
            }else{
                    $fechasLabels = array();
                    for ($i=0; $i < sizeof($fechas) ; $i++) { 
                      $fechasLabels[$i] = formatearFecha($fechas[$i]);
                    }
                    echo "'".implode("','",$fechasLabels)."'";
                  }
            ?>
            ],
            datasets: [{
              label: 'Ingresos',
              borderColor: window.chartColors.red,
              backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
              fill: false,
              data: [
                <?php
                  if ($labelsIngEgrMeses) {
                    echo implode(",",$ingresosPorMes);
                  }else{
                    $cantIngresos = array();
                    for ($i=0; $i < sizeof($fechas) ; $i++) { 
                      $fechaDeArray = $fechas[$i];
                      $sql1 = "SELECT COUNT(fecha) as cantidad FROM ingresos WHERE fecha = '$fechaDeArray'";
                      $query1 = mysqli_query($conexion,$sql1);
                      $fila1 = mysqli_fetch_array($query1);
                      $cantIngresos[] = $fila1['cantidad'];
                    }
                    echo implode(",",$cantIngresos);
                  }
                ?>
              ],
              yAxisID: 'y-axis-1',
            }, {
              label: 'Egresos',
              backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
              borderColor: window.chartColors.blue,
              fill: false,
              data: [
                <?php
                if ($labelsIngEgrMeses) {
                  echo implode(",",$egresosPorMes);
                }else{
                  $cantEgresos = array();
                    for ($i=0; $i < sizeof($fechas) ; $i++) { 
                      $fechaDeArray = $fechas[$i];
                      $sql = "SELECT COUNT(fecha) as cantidad FROM egresos WHERE fecha = '$fechaDeArray'";
                      $query = mysqli_query($conexion,$sql);
                      $fila = mysqli_fetch_array($query);
                      $cantEgresos[] = $fila['cantidad'];
                    }
                    echo implode(",",$cantEgresos);
                }
                ?>
              ],
              yAxisID: 'y-axis-2'
            }]
          };

          var ctxIngEgr = document.getElementById('canvasIngEgr').getContext('2d');
           window.myLine = Chart.Line(ctxIngEgr, {
              data: lineChartDataIngEgr,
              options: {
                responsive: true,
                hoverMode: 'index',
                stacked: false,
                title: {
                  display: true,
                  text: 'Relación Ingresos/Egresos'
                },
                scales: {
                  yAxes: [{
                    type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: 'left',
                    id: 'y-axis-1',
                  }, {
                    type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: 'right',
                    id: 'y-axis-2',

                    // grid line settings
                    gridLines: {
                      drawOnChartArea: false, // only want the grid lines for one axis to show up
                    },
                  }],
                }
              }
            });


          //Ingresos

          var cantidadPesos = document.getElementById('chart-areaPesos').getContext('2d');
          window.myDoughnut = new Chart(cantidadPesos, cantPesos);


          var sexo = document.getElementById('chart-area').getContext('2d');
          window.myPie = new Chart(sexo, config);

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
              },
              plugins: {
                labels: {
                  render: 'value'
                }
              }
            }
          });
          
          var cantidadIngreso = document.getElementById('canvasCantidades').getContext('2d');
          window.myLine = new Chart(cantidadIngreso, ingresos);



          //Egresos
          var sexoEgr = document.getElementById('chart-areaEgr').getContext('2d');
          window.myPie = new Chart(sexoEgr, configEgr);

          var razaEgr = document.getElementById('canvasRazaEgr').getContext('2d');
          window.myBar = new Chart(razaEgr, {
            type: 'bar',
            data: barChartDataEgr,
            options: {
              responsive: true,
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Cant. Segun Raza'
              },
              plugins: {
                labels: {
                  render: 'value'
                }
              }
            }
          });
          
          var cantidadEgreso = document.getElementById('canvasCantidadesEgr').getContext('2d');
          window.myLine = new Chart(cantidadEgreso, egresos);

          //Muertes
          var tipoMuerte = document.getElementById('chart-areaTipo').getContext('2d');
          window.myPie = new Chart(tipoMuerte, configTipo);

          var cantidadMuertes = document.getElementById('canvasMuertes').getContext('2d');
          window.myLine = new Chart(cantidadMuertes, muertes);
        <?php
        }else{
        ?>

          var cantIng = parseFloat($('#cantIng').html().replace(".",""));
          var cantIngComp = parseFloat($('#cantIngComp').html().replace(".",""));
          var cantEgr = parseFloat($('#cantEgr').html().replace(".",""));
          var cantEgrComp = parseFloat($('#cantEgrComp').html().replace(".",""));
          var cantMuertes = parseFloat($('#cantMuertes').html().replace(".",""));
          var cantMuertesComp = parseFloat($('#cantMuertesComp').html().replace(".",""));

          var maximoIng = Math.max(cantIng,cantIngComp);
          var minimoIng = Math.min(cantIng,cantIngComp);

          var maximoEgr = Math.max(cantEgr,cantEgrComp);
          var minimoEgr = Math.min(cantEgr,cantEgrComp);

          var maximoMuertes = Math.max(cantMuertes,cantMuertesComp);
          var minimoMuertes = Math.min(cantMuertes,cantMuertesComp);

          var difAnimalesIng = maximoIng - minimoIng;
          var difAnimalesEgr = maximoEgr - minimoEgr;
          var difAnimMuertos = maximoMuertes - minimoMuertes;

          if (difAnimalesIng == 0) {
            $('#difAnimIng').html('0 Animales');
          }else{
            $('#difAnimIng').html(difAnimalesIng + ' Animales');
          }

          if (difAnimalesEgr == 0) {
            $('#difAnimEgr').html('0 Animales');
          }else{
            $('#difAnimEgr').html(difAnimalesEgr + ' Animales');
          }

          if (difAnimMuertos == 0) {
            $('#difAnimMuertos').html('0 Animales');
          }else{
            $('#difAnimMuertos').html(difAnimMuertos + ' Animales');
          }

          var porcentajeIng = ((difAnimalesIng * 100) / cantIng).toFixed(2);
          var porcentajeEgr = ((difAnimalesEgr * 100) / cantEgr).toFixed(2);
          var porcentajeMuertes = ((difAnimMuertos * 100) / cantMuertes).toFixed(2);

          var dataIng = porcentajeIng;
          var dataEgr = porcentajeEgr;
          var dataMuertes = porcentajeMuertes;

          if (cantIng < cantIngComp) {
            dataIng += ' % <span class="icon-arrow-up2" style="color:green;"></span>';
          }else{
            dataIng += ' % <span class="icon-arrow-down" style="color:red;"></span>';
          }

          if (cantEgr < cantEgrComp) {
            dataEgr += ' % <span class="icon-arrow-up2" style="color:green;"></span>';
          }else{
            dataEgr += ' % <span class="icon-arrow-down" style="color:red;"></span>';
          }

          if (cantMuertes < cantMuertesComp) {
            dataMuertes += ' % <span class="icon-arrow-up2" style="color:red;"></span>';
          }else{
            dataMuertes += ' % <span class="icon-arrow-down" style="color:green;"></span>';
          }

          $('#difIng').html(dataIng);
          $('#difEgr').html(dataEgr);
          $('#difMuertes').html(dataMuertes);

          
          //Ingresos Comp
          var sexo = document.getElementById('chart-area').getContext('2d');
          window.myPie = new Chart(sexo, config);


          var sexoC = document.getElementById('chart-areaComp').getContext('2d');
          window.myPie = new Chart(sexoC, configComp);

          var razaComp = document.getElementById('canvasRazaComparacion').getContext('2d');
          window.myBar = new Chart(razaComp, {
            type: 'bar',
            data: barChartDataRazaC,
            options: {
              responsive: true,
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Ingresos segun Raza'
              },
              plugins: {
                labels: {
                  render: 'value'
                }
              }
            }
          });

          var cantidadIngreso = document.getElementById('canvasCantidades').getContext('2d');
          window.myLine = new Chart(cantidadIngreso, ingresos);

          var cantidadIngresoComp = document.getElementById('canvasCantidadesComp').getContext('2d');
          window.myLine = new Chart(cantidadIngresoComp, ingresosComp);


          //Egresos Comp
          var sexoEgr = document.getElementById('chart-areaEgr').getContext('2d');
          window.myPie = new Chart(sexoEgr, configEgr);


          var sexoCEgr = document.getElementById('chart-areaCompEgr').getContext('2d');
          window.myPie = new Chart(sexoCEgr, configEgrComp);

          var razaCompEgr = document.getElementById('canvasRazaComparacionEgr').getContext('2d');
          window.myBar = new Chart(razaCompEgr, {
            type: 'bar',
            data: barChartDataRazaEgrC,
            options: {
              responsive: true,
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Ingresos segun Raza'
              },
              plugins: {
                labels: {
                  render: 'value'
                }
              }
            }
          });

          var cantidadEgresos = document.getElementById('canvasCantidadesEgr').getContext('2d');
          window.myLine = new Chart(cantidadEgresos, egresos);

          var cantidadEgresosComp = document.getElementById('canvasCantidadesCompEgr').getContext('2d');
          window.myLine = new Chart(cantidadEgresosComp, egresosComp);


          // Muertes Comp

          var tipoMuerte = document.getElementById('chart-areaTipo').getContext('2d');
          window.myPie = new Chart(tipoMuerte, configTipo);

          var cantidadMuertes = document.getElementById('canvasMuertes').getContext('2d');
          window.myLine = new Chart(cantidadMuertes, muertes);

          var tipoMuerteComp = document.getElementById('chart-areaCompTipo').getContext('2d');
          window.myPie = new Chart(tipoMuerteComp, configTipoComp);

          var cantidadMuertesComp = document.getElementById('canvasMuertesComp').getContext('2d');
          window.myLine = new Chart(cantidadMuertesComp, muertesComp);
        <?php
        }
        ?>
      };

      function imprimir(){
        var comparacionValido = <?php echo ($comparacionValido == TRUE) ? 1 : 0;?>;
       if (!comparacionValido) {
        var v1 = $('#pesoDesde').val();
        var v2 = $('#pesoHasta').val();
        window.open('imprimir/informeAcopiadora.php?desde=<?php echo $desde;?>&hasta=<?php echo $hasta;?>&seccion=<?php echo $seccion;?>&v1=' + v1 + '&v2=' + v2);
       }else{
        window.open('imprimir/informeComparacionAcopiadora.php?desde=<?php echo $desde;?>&hasta=<?php echo $hasta;?>&desdeComp=<?php echo $desdeComp;?>&hastaComp=<?php echo $hastaComp;?>&seccion=<?php echo $seccion;?>');
       }
      }

    </script>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>
