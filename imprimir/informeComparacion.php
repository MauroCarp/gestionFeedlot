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
          <td><h1>Informe Stock</h1></td><td style="text-align: right;"><img src="../img/logo1.png"></td>
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
          let cantIng = parseFloat($('#cantIng').html().replace(".",""));
          let cantIngComp = parseFloat($('#cantIngComp').html().replace(".",""));

          let cantEgr = parseFloat($('#cantEgr').html().replace(".",""));
          let cantEgrComp = parseFloat($('#cantEgrComp').html().replace(".",""));
          let cantMuertes = parseFloat($('#cantMuertes').html());
          let cantMuertesComp = parseFloat($('#cantMuertesComp').html());

          let maximoIng = Math.max(cantIng,cantIngComp);
          let minimoIng = Math.min(cantIng,cantIngComp);

          let maximoEgr = Math.max(cantEgr,cantEgrComp);
          let minimoEgr = Math.min(cantEgr,cantEgrComp);

          let maximoMuertes = Math.max(cantMuertes,cantMuertesComp);
          let minimoMuertes = Math.min(cantMuertes,cantMuertesComp);

          let difAnimalesIng = maximoIng - minimoIng;
          let difAnimalesEgr = maximoEgr - minimoEgr;
          let difAnimMuertos = maximoMuertes - minimoMuertes;

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

          let porcentajeIng = (cantIng != 0 || cantIngComp != 0) ? ((difAnimalesIng * 100) / (cantIng + cantIngComp)).toFixed(2) : 0;
          let porcentajeEgr = (cantEgr != 0 || cantEgrComp != 0) ? ((difAnimalesEgr * 100) / (cantEgr + cantEgrComp)).toFixed(2) : 0;
          let porcentajeMuertes = (cantMuertes != 0 || cantMuertesComp != 0) ? ((difAnimMuertos * 100) / (cantMuertes + cantMuertesComp)).toFixed(2) : 0;


          let dataIng = porcentajeIng;
          let dataEgr = porcentajeEgr;
          let dataMuertes = porcentajeMuertes;

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
      
      // EGRESOS 
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

        let cantidadEgresos = document.getElementById('canvasCantidadesEgr').getContext('2d');
        window.myLine = new Chart(cantidadEgresos, egresos);

        let cantidadEgresosComp = document.getElementById('canvasCantidadesCompEgr').getContext('2d');
        window.myLine = new Chart(cantidadEgresosComp, egresosComp);

        //MUERTES

          let tipoMuerte = document.getElementById('chart-areaTipo').getContext('2d');
          window.myPie = new Chart(tipoMuerte, configTipo);

          let cantidadMuertes = document.getElementById('canvasMuertes').getContext('2d');
          window.myLine = new Chart(cantidadMuertes, muertes);

          let tipoMuerteComp = document.getElementById('chart-areaCompTipo').getContext('2d');
          window.myPie = new Chart(tipoMuerteComp, configTipoComp);

          let cantidadMuertesComp = document.getElementById('canvasMuertesComp').getContext('2d');
          window.myLine = new Chart(cantidadMuertesComp, muertesComp);

    });


    setTimeout(function () { window.print(); }, 1000);
    window.onfocus = function () { setTimeout('window.close();', 1); }

</script>
</body>
</html>