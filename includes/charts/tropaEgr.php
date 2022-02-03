  var configEgr = {
    type: 'pie',
    data: {
      datasets: [{
        data: [
        <?php
        if ($seccion == 'egresos') {
          $sqlMachoEgr = "SELECT COUNT(sexo) AS macho FROM egresos WHERE sexo = 'Macho' AND tropa = '$tropa'";
          $queryMachoEgr = mysqli_query($conexion,$sqlMachoEgr);
          $resultadoEgr = mysqli_fetch_array($queryMachoEgr);
          $machoEgr = $resultadoEgr['macho'];

          $sqHembEgr = "SELECT COUNT(sexo) AS hembra FROM egresos WHERE sexo = 'Hembra' AND tropa = '$tropa'";
          $querHembEgr = mysqli_query($conexion,$sqHembEgr);
          $resultadoEgr = mysqli_fetch_array($querHembEgr);
          $hembraEgr = $resultadoEgr['hembra'];
        }

        $resultadoEgr = $machoEgr.",".$hembraEgr.",";
        echo $resultadoEgr;

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


  <?php
  $sqlRazasEgr = "SELECT raza FROM razas ORDER BY raza ASC";
  $queryRazasEgr = mysqli_query($conexion,$sqlRazasEgr);
  $labelsRazaEgr = "";
  $cantXrazaEgr = "";
  while ($razasEgr = mysqli_fetch_array($queryRazasEgr)) {
    $labelsRazaEgr = $labelsRazaEgr.",'".$razasEgr['raza']."'";  
    ${$razasEgr['raza']."Egr"} = cantRaza($razasEgr['raza'],'egresos',$tropa,$conexion);
    $cantXrazaEgr = $cantXrazaEgr.",".${$razasEgr['raza']."Egr"};
  }
  $labelsRazaEgr = substr($labelsRazaEgr, 1);
  $cantXrazaEgr = substr($cantXrazaEgr, 1);

  ?>
  var RAZASEGR = [
  <?php
  echo $labelsRazaEgr;
  ?>
  ];
  var color = Chart.helpers.color;
  var barChartDataEgr = {
    labels: [
    <?php
    echo $labelsRazaEgr;
    ?>
    ],
    datasets: [{
      label: 'Razas',
      backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
      borderColor: window.chartColors.red,
      borderWidth: 1,
      data: [
      <?php
        echo $cantXrazaEgr;
      ?>
      ]
    }]

  };
