<table class="table table-stripped" align="center">
	<tr>
		<td style="font-size: 1.2em;" colspan="2"><b>Muertes</b></td>
	</tr>
	<tr>
		<td><b>- Total Muertes: </b><?php echo number_format($totalMuertes,0,",",".");?> Animales</td>
	</tr>
</table>
<table class="table table-stripped" align="left" style="width: 650px;">
	<tr>
		<td align="center"><canvas id="chart-areaTipo"></canvas></td>
	</tr>
</table>
<table class="table table-stripped" align="left">
	<tr>
		<td><canvas id="canvasMuertes"></canvas></td>
	</tr>
</table>
<script type="text/javascript">
	// TIPO
		var configTipo = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
					<?php
					$cantMuertes = 0;
					$labelsMuertes = "";
					$colores = "";
					$sqlTipo = "SELECT DISTINCT causaMuerte FROM muertes WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta' ORDER BY causaMuerte ASC";
					$queryTipo = mysqli_query($conexion,$sqlTipo);
					if (mysqli_num_rows($queryTipo)) {
						$cantMuertes = array();
						$labelsMuertes = array();
						$colores = array();
						while($resultadoTipo = mysqli_fetch_array($queryTipo)){
							$causa = $resultadoTipo['causaMuerte'];
							$sql = "SELECT SUM(muertes) as muertes FROM muertes WHERE feedlot = '$feedlot' AND causaMuerte = '$causa' AND fecha BETWEEN '$desde' AND '$hasta'";
							$query = mysqli_query($conexion,$sql);
							$cantidad = mysqli_fetch_array($query);
							$colores[] = "'".color_rand()."'";
							$labelsMuertes[] = "'".$causa."'";
							$cantMuertes[] = $cantidad['muertes'];
						}

						$labelsMuertes = implode(',',$labelsMuertes);
						$cantMuertes = implode(',',$cantMuertes);
						$colores = implode(',',$colores);
					}
					echo $cantMuertes;
					?>
					],
					backgroundColor: [
					<?php echo $colores.",";?>
					],
					label: 'Tipo de Muerte'
				}],
				labels: [
				<?php
					echo $labelsMuertes;
				?>
				]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Muertes Segun Causa'
				},
				legend:{
					display: true,
					labels:{
						boxWidth: 5
					}
				}

			}
		};

	// MUERTES
	   	var muertes = {
	      type: 'line',
	      data: {
	        labels: [

	        <?php
	      	
	        $labelsMuertes = "";
			$cantidadMuertes = 0;
			$sqlMuertes = "SELECT fecha,muertes,causaMuerte FROM muertes WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha ASC";
			$queryMuertes = mysqli_query($conexion,$sqlMuertes);
			while ($filaMuertes = mysqli_fetch_array($queryMuertes)) {
				$cantidadMuertes = $cantidadMuertes.",".$filaMuertes['muertes'];
				$labelsMuertes = $labelsMuertes.",'".formatearFecha($filaMuertes['fecha'])."'";
			}
			$labelsMuertes = substr($labelsMuertes,1);
			$cantidadMuertes = substr($cantidadMuertes, 2);
			echo $labelsMuertes;
	        ?>

	        ],
	        datasets: [{
	          label: 'Cantidad de Muertes por Fecha',
	          backgroundColor: window.chartColors.red,
	          borderColor: window.chartColors.red,
	          data: [
	            <?php
				echo $cantidadMuertes;
	            ?>
	          ],
	          fill: false,
	        }]
	      },
	      options: {
	        responsive: true,
	        title: {
	          display: true,
	          text: 'Cantidad de Muertes'
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
	              labelString: 'Cantidad'
	            }
	          }]
	        }
	      }
	    };  
</script>