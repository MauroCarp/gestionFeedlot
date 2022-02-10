<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/arrays.php");
require("includes/funciones.php");

require_once 'datosInforme.php';

require 'head.php';

?>

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

        <button class="btn btn-default" onclick="imprimir()">Imprimir</button>
        
        <span class="ir-arriba icon-arrow-up2"></span>
        
      </div>

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

          let desde = $('#pesoDesde').val();
          let hasta = $('#pesoHasta').val();
          let fechaDesde = <?php echo "'".$desde."'";?>;
          let fechaHasta = <?php echo "'".$hasta."'";?>;
          let datos = 'desde=' + desde + '&hasta=' + hasta + '&fDesde=' + fechaDesde + '&fHasta=' + fechaHasta;
          let url = 'cantidadSegunPesoInforme.php';
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

    const color = Chart.helpers.color

      window.onload = function() {
        
        let  comparacionValido = <?php echo ($comparacionValido == TRUE) ? 1 : 0;?>;
        
        if (!comparacionValido) {

          let lineChartDataIngEgr = {
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

          let ctxIngEgr = document.getElementById('canvasIngEgr').getContext('2d');

          let chartIngEgr = Chart.Line(ctxIngEgr, {
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

          //INGRESOS

          let cantidadPesos = document.getElementById('chart-areaPesos').getContext('2d');
          let chartCantPeso = new Chart(cantidadPesos, cantPesos);


          let sexo = document.getElementById('chart-area').getContext('2d');
          window.myPie = new Chart(sexo, config);

          let raza = document.getElementById('canvasRaza').getContext('2d');

          window.myBar = new Chart(raza, {
            type: 'horizontalBar',
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
          
          let cantidadIngreso = document.getElementById('canvasCantidades').getContext('2d');
          window.myLine = new Chart(cantidadIngreso, ingresos);

          //EGRESOS
          let sexoEgr = document.getElementById('chart-areaEgr').getContext('2d');
          window.myPie = new Chart(sexoEgr, configEgr);

          let razaEgr = document.getElementById('canvasRazaEgr').getContext('2d');

          window.myBar = new Chart(razaEgr, {
            type: 'horizontalBar',
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
          
          let cantidadEgreso = document.getElementById('canvasCantidadesEgr').getContext('2d');
          window.myLine = new Chart(cantidadEgreso, egresos);

          //MUERTES
          let tipoMuerte = document.getElementById('chart-areaTipo').getContext('2d');
          window.myPie = new Chart(tipoMuerte, configTipo);

          let cantidadMuertes = document.getElementById('canvasMuertes').getContext('2d');
          window.myLine = new Chart(cantidadMuertes, muertes);

        }else{

            let cantIng = parseFloat($('#cantIng').html().replace(".",""));

            let cantIngComp = parseFloat($('#cantIngComp').html().replace(".",""));

            let cantEgr = parseFloat($('#cantEgr').html().replace(".",""));

            let cantEgrComp = parseFloat($('#cantEgrComp').html().replace(".",""));

            // let cantMuertes = parseFloat($('#cantMuertes').html().replace(".",""));

            // let cantMuertesComp = parseFloat($('#cantMuertesComp').html().replace(".",""));

            

            let maximoIng = Math.max(cantIng,cantIngComp);
            let minimoIng = Math.min(cantIng,cantIngComp);

            let maximoEgr = Math.max(cantEgr,cantEgrComp);
            let minimoEgr = Math.min(cantEgr,cantEgrComp);

            // let maximoMuertes = Math.max(cantMuertes,cantMuertesComp);
            // let minimoMuertes = Math.min(cantMuertes,cantMuertesComp);

            let difAnimalesIng = maximoIng - minimoIng;
            let difAnimalesEgr = maximoEgr - minimoEgr;
            // let difAnimMuertos = maximoMuertes - minimoMuertes;

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

            // if (difAnimMuertos == 0) {
            // $('#difAnimMuertos').html('0 Animales');
            // }else{
            // $('#difAnimMuertos').html(difAnimMuertos + ' Animales');
            // }

            let porcentajeIng = ( cantIng != 0) ? ((difAnimalesIng * 100) / cantIng).toFixed(2) : 0;
            let porcentajeEgr = ( cantEgr != 0) ? ((difAnimalesEgr * 100) / cantEgr).toFixed(2) : 0;
            // let porcentajeMuertes = ( cantMuertes != 0) ? ((difAnimMuertos * 100) / cantMuertes).toFixed(2) : 0;

            let dataIng = porcentajeIng;
            let dataEgr = porcentajeEgr;          
            // let dataMuertes = porcentajeMuertes;

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

            // if (cantMuertes < cantMuertesComp) {
            // dataMuertes += ' % <span class="icon-arrow-up2" style="color:red;"></span>';
            // }else{
            // dataMuertes += ' % <span class="icon-arrow-down" style="color:green;"></span>';
            // }

            $('#difIng').html(dataIng);
            $('#difEgr').html(dataEgr);
            // $('#difMuertes').html(dataMuertes);

        
            //INGRESOS COMP
            let sexo = document.getElementById('chart-area').getContext('2d');
            window.myPie = new Chart(sexo, config);

            let sexoC = document.getElementById('chart-areaComp').getContext('2d');
            window.myPie = new Chart(sexoC, configComp);

            let razaComp = document.getElementById('canvasRazaComparacion').getContext('2d');

            window.myBar = new Chart(razaComp, {
                type: 'horizontalBar',
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

            let cantidadIngreso = document.getElementById('canvasCantidades').getContext('2d');
            window.myLine = new Chart(cantidadIngreso, ingresos);

            let cantidadIngresoComp = document.getElementById('canvasCantidadesComp').getContext('2d');
            window.myLine = new Chart(cantidadIngresoComp, ingresosComp);


            //EGRESOS COMP
            let sexoEgr = document.getElementById('chart-areaEgr').getContext('2d');
            window.myPie = new Chart(sexoEgr, configEgr);


            let sexoCEgr = document.getElementById('chart-areaCompEgr').getContext('2d');
            window.myPie = new Chart(sexoCEgr, configEgrComp);

            let razaCompEgr = document.getElementById('canvasRazaComparacionEgr').getContext('2d');
            window.myBar = new Chart(razaCompEgr, {
                type: 'horizontalBar',
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


                //       // MUERTES COMP

                //       var tipoMuerte = document.getElementById('chart-areaTipo').getContext('2d');
                //       window.myPie = new Chart(tipoMuerte, configTipo);

                //       var cantidadMuertes = document.getElementById('canvasMuertes').getContext('2d');
                //       window.myLine = new Chart(cantidadMuertes, muertes);

                //       var tipoMuerteComp = document.getElementById('chart-areaCompTipo').getContext('2d');
                //       window.myPie = new Chart(tipoMuerteComp, configTipoComp);

                //       var cantidadMuertesComp = document.getElementById('canvasMuertesComp').getContext('2d');
                //       window.myLine = new Chart(cantidadMuertesComp, muertesComp);
        }
                
    }

    function imprimir(){

        let comparacionValido = <?php echo ($comparacionValido == TRUE) ? 1 : 0;?>;
        if (!comparacionValido) {
        let v1 = $('#pesoDesde').val();
        let v2 = $('#pesoHasta').val();
        window.open('imprimir/informe.php?desde=<?php echo $desde;?>&hasta=<?php echo $hasta;?>&seccion=<?php echo $seccion;?>&v1=' + v1 + '&v2=' + v2);
        }else{
        window.open('imprimir/informeComparacion.php?desde=<?php echo $desde;?>&hasta=<?php echo $hasta;?>&desdeComp=<?php echo $desdeComp;?>&hastaComp=<?php echo $hastaComp;?>&seccion=<?php echo $seccion;?>');
        }

    }

    
    </script>

  </body>
</html>
