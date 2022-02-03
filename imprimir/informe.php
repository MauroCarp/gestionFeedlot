<?php
include("../includes/init_session.php");
require("../includes/conexion.php");
require("../includes/arrays.php");
require("../includes/funciones.php");
require("datosInforme.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>JORGE CORNALE - GESTION DE FEEDLOTS</title>
    <link rel="icon" href="../img/ico.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="../img/ico.ico" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/jquery-2.2.4.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <script src="../js/chart/dist/Chart.bundle.js"></script>
    <script src="../js/chart/samples/utils.js"></script>
    <script src="../js/chartjs-plugin-labels.min.js"></script>
    <script src="../js/printThis.js"></script>    
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <style type="text/css">
        .conteiner{
            width: 900px;
            padding: 20px 30px;
            width: 0 auto;
        }
        table{
            font-size: 1.2em;
        }
        canvas{
            margin: 0;
            padding: 0;
        }
        hr{
          border-color: #8F8F8F;
        }
        ul,li{
          margin: 0;
          padding: 0;
          line-height: 1.2em;
          list-style: none;
        }
    </style>
</head>
<body>
    <div class="conteiner">
      <table width="900px">
        <tr>
          <td><h1>Informe Stock</h1></td><td style="text-align: right;"><img src="../img/logo.png"></td>
        </tr>
      </table>
    <hr>
    <h3>Periodo desde <?php echo formatearFecha($desde).' hasta '.formatearFecha($hasta);?></h3>
<?php 
include "ingresos.php";
?>
<?php
include "egresos.php";
?>
<?php
include "muertes.php";
?>
</div>

<script type="text/javascript" async="async">
    $(document).ready(function() {
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
                }
              }
            });
            
      var tipoMuerte = document.getElementById('chart-areaTipo').getContext('2d');
      window.myPie = new Chart(tipoMuerte, configTipo);

      var cantidadMuertes = document.getElementById('canvasMuertes').getContext('2d');
      window.myLine = new Chart(cantidadMuertes, muertes);
      
      var cantidadPesos = document.getElementById('chart-areaPesos').getContext('2d');
      window.myDoughnut = new Chart(cantidadPesos, cantPesos);

      calculaCPS();
    });

    function calculaCPS(){
          var desde = <?php echo $_GET['v1'];?>;
          var hasta = <?php echo $_GET['v2'];?>;
          var fechaDesde = <?php echo "'".$desde."'";?>;
          var fechaHasta = <?php echo "'".$hasta."'";?>;
          var datos = 'desde=' + desde + '&hasta=' + hasta + '&fDesde=' + fechaDesde + '&fHasta=' + fechaHasta;
          var url = '../cantidadSegunPesoInforme.php';


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


    setTimeout(function () { window.print(); }, 1300);
    window.onfocus = function () { setTimeout('window.close();', 1); }

</script>
</body>
</html>