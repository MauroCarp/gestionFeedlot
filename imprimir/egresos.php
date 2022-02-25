
<table class="table" align="center">
	<tr>
		<td style="font-size: 1.2em;" colspan="2"><b>Egresos</b></td>
	</tr>
	
	<tr>
		<td>
			<ul>
				<li>
					<b>- Total Egr: </b><?php echo number_format($cantEgr,0,",",".");?> Animales
				</li>
				<li>
					<b>- Kg Neto Egr: </b><?php echo formatearNum($totalPesoEgr)." Kg";?>
				</li>
				<li>
					<b>- Kg Egr. Prom: </b><?php echo formatearNum($kgEgrProm)." Kg";?>
				</li>
				<!-- <li>
					<b>- Dif. Kg Ing/Egr: </b><?php echo formatearNum($diferenciaIngEgr)." Kg";?>
				</li> -->
				<li>
					<b>-  Kg Min. Prom:: </b><?php echo formatearNum($kgMinEgr)." Kg";?>
				</li>
				<li>
					<b>-  Kg Max. Prom:: </b><?php echo formatearNum($kgMaxEgr)." Kg";?>
				</li>
			</ul>
		</td>
	
		<td style="width: 350px;"><canvas id="chart-areaPesosEgr"></canvas></td>
	
	</tr>
	
	<tr>
		<td></td>
		<td style="text-align: center;font-size:.7em;line-height:.7em;"><b><?php echo "Entre ".$_GET['v1Egr']." Kilos y ".$_GET['v2Egr']." Kilos"?></b></td>
	</tr>

</table>

<table class="table table-stripped" align="left">

	<tr>

		<td style="width: 350px;"><canvas id="chart-areaEgr"></canvas></td>

		<td style="width: 600px;"><canvas id="canvasRazaEgr"></canvas></td>		

	</tr>

</table>

<script type="text/javascript">
		// INGRESOS SEGUN SEXP Y PESO
		let cantPesosEgr = {
			type: 'doughnut',
			data: {
			datasets: [{
				data: [
				//TODO:CARGAR DATA DEL GRAFICO DINAMICO
				],
				backgroundColor: [
				'#FF6D88',
				'#F8A233',
				],
				label: 'Dataset 1'
			}],
			labels: [
				'Macho',
				'Hembra'
			]
			},
			options: {
			circumference: Math.PI,
			rotation: -Math.PI,
			responsive: true,
			legend: {
				position: 'top',
			},
			title: {
				display: true,
				text: 'Cantidad según Sexo, y Peso'
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			plugins:{
				labels:{
					render:'percentage',
					fontColor:'white'
				}
			}

			}
		};

	// SEXO
		let configEgr = {
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
				},
				plugins: {
                labels: {
                  render: 'percentage',
				  fontColor:'white'
                }
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
	  let RAZAS = [
	  <?php
		echo $labelsRazaEgr;
	  ?>];

	  let barChartDataEgr = {
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