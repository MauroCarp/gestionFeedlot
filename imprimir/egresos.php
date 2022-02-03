<table class="table table-stripped" align="center">
	<tr>
		<td style="font-size: 1.2em;" colspan="2"><b>Egresos</b></td>
	</tr>
	<tr>
		<td><b>- Total Egr: </b><?php echo number_format($cantEgr,0,",",".");?> Animales</td>
		<td><b>- Kg Neto Egr: </b><?php echo formatearNum($totalPesoEgr)." Kg";?></td>
	</tr>
	<tr>
		<td><b>- Kg Egr. Prom: </b><?php echo formatearNum($kgEgrProm)." Kg";?></td>
		<td><b>- Dif. Kg Egr/Egr: </b><?php echo formatearNum($diferenciaIngEgr)." Kg";?></td>
	</tr>
</table>
<table class="table table-stripped" align="left">
	<tr>
		<td style="width: 250px;"><canvas id="chart-areaEgr"></canvas></td>
		<td style="width: 600px;"><canvas id="canvasRazaEgr"></canvas></td>		
	</tr>
	<tr>
		<td colspan="2" style="width: 800px;"><canvas id="canvasIngEgr"></canvas></td>
	</tr>
</table>
<script type="text/javascript">
	// SEXO
		var configEgr = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
					<?php
					$sqlMachoEgreso = "SELECT COUNT(sexo) AS macho FROM egresos WHERE sexo = 'Macho' AND feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
					$queryMachoEgreso = mysqli_query($conexion,$sqlMachoEgreso);
					$resultadoEgreso = mysqli_fetch_array($queryMachoEgreso);
					$machoEgreso = $resultadoEgreso['macho'];

					$sqHembEgreso = "SELECT COUNT(sexo) AS hembra FROM egresos WHERE sexo = 'Hembra' AND feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
					$querHembEgreso = mysqli_query($conexion,$sqHembEgreso);
					$resultadoEgreso = mysqli_fetch_array($querHembEgreso);
					$hembraEgreso = $resultadoEgreso['hembra'];

					$resultadoEgr = $machoEgreso.",".$hembraEgreso.",";
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
	// RAZAS 	
	  	<?php 
	  	  $sqlRazasEgr = "SELECT raza FROM razas ORDER BY raza ASC";
		  $queryRazasEgr = mysqli_query($conexion,$sqlRazasEgr);
		  $labelsRazaEgr = "";
		  $cantXrazaEgr = "";
		  $cantXrazaCompEgr = "";

		  while ($razasEgr = mysqli_fetch_array($queryRazasEgr)) {
		    $labelsRazaEgr = $labelsRazaEgr.",'".$razasEgr['raza']."'";  
		    ${$razasEgr['raza']."Egr"} = cantRazaInforme($razasEgr['raza'],'egresos',$feedlot,$desde,$hasta,$conexion);
		    $cantXrazaEgr = $cantXrazaEgr.",".${$razasEgr['raza']."Egr"};

		    if ($comparacionValido) {
		    	${$razasEgr['raza']."EgrComp"} = cantRazaInforme($razasEgr['raza'],'egresos',$feedlot,$desdeComp,$hastaComp,$conexion);
		    	$cantXrazaCompEgr = $cantXrazaCompEgr.",".${$razasEgr['raza']."EgrComp"};
		    }
		  }
		  $labelsRazaEgr = substr($labelsRazaEgr, 1);
		  $cantXrazaEgr = substr($cantXrazaEgr, 1);
		?>
	  var RAZAS = [
	  <?php
		echo $labelsRazaEgr;
	  ?>];
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

	
</script>