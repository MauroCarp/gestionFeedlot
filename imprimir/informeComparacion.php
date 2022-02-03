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
<?php 
include "ingresosComp.php";
include "egresosComp.php";
include "muertesComp.php";
?>
</div>

<script type="text/javascript" async="async">
    $(document).ready(function() {
          var cantIng = parseFloat($('#cantIng').html().replace(".",""));
          var cantIngComp = parseFloat($('#cantIngComp').html().replace(".",""));

          var cantEgr = parseFloat($('#cantEgr').html().replace(".",""));
          var cantEgrComp = parseFloat($('#cantEgrComp').html().replace(".",""));
          var cantMuertes = parseFloat($('#cantMuertes').html());
          var cantMuertesComp = parseFloat($('#cantMuertesComp').html());

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

      //INGRESOS
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
      
      // EGRESOS 
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

        //MUERTES

          var tipoMuerte = document.getElementById('chart-areaTipo').getContext('2d');
          window.myPie = new Chart(tipoMuerte, configTipo);

          var cantidadMuertes = document.getElementById('canvasMuertes').getContext('2d');
          window.myLine = new Chart(cantidadMuertes, muertes);

          var tipoMuerteComp = document.getElementById('chart-areaCompTipo').getContext('2d');
          window.myPie = new Chart(tipoMuerteComp, configTipoComp);

          var cantidadMuertesComp = document.getElementById('canvasMuertesComp').getContext('2d');
          window.myLine = new Chart(cantidadMuertesComp, muertesComp);

    });


    setTimeout(function () { window.print(); }, 1000);
    window.onfocus = function () { setTimeout('window.close();', 1); }

</script>
</body>
</html>