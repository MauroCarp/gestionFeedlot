<table class="table" align="center">
	<tr colspan="3">
		<td style="font-size: 1.2em;" colspan="2"><b>Muertes</b></td>
	</tr>
	<tr>
		<td>
			<ul>
				<li>Periodo: <?php echo formatearFecha($desde)." al ".formatearFecha($hasta);?></li>
				<li>
					<b>- Total Muertes: </b><span id="cantMuertes"><?php echo number_format($totalMuertes,0,",",".");?></span> Animales
				</li>
			</ul>
		</td>
		<td>
			<ul>
				<li>
					<b>- Dif. Muertes:</b><span id="difAnimMuertos"></span>
				</li>
				<li>
					<b>- Muertes: </b><span id="difMuertes"></span>
				</li>
			</ul>
		<td>
		<td>
			<ul>
				<li>Periodo: <?php echo formatearFecha($desdeComp)." al ".formatearFecha($hastaComp);?></li>
				<li>
					<b>- Total Muertes: </b><span id="cantMuertesComp"><?php echo number_format($totalMuertesComp,0,",",".");?></span> Animales
				</li>
			</ul>
		<td>
	</tr>
</table>
<table class="table table-stripped" style="width: 900px" align="left">
	<tr>
		<td><canvas width="400px" id="chart-areaTipo"></canvas></td>
		<td><canvas width="400px" id="chart-areaCompTipo"></canvas></td>
	</tr>
	<tr>
		<td><canvas id="canvasMuertes"></canvas></td>
		<td><canvas id="canvasMuertesComp"></canvas></td>
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

	// TIPO COMPARACION
		var configTipoComp = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
					<?php
					$cantMuertes = 0;
		            $labelsMuertes = "";
		            $colores = "";
					$sqlTipoComp = "SELECT DISTINCT causaMuerte FROM muertes WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp' ORDER BY causaMuerte ASC";
					$queryTipoComp = mysqli_query($conexion,$sqlTipoComp);
					if (mysqli_num_rows($queryTipoComp)) {
						$cantMuertesComp = array();
						$labelsMuertesComp = array();
						while($resultadoTipoComp = mysqli_fetch_array($queryTipoComp)){
							$causaComp = $resultadoTipoComp['causaMuerte'];
							$sqlComp = "SELECT SUM(muertes) as muertes FROM muertes WHERE feedlot = '$feedlot' AND causaMuerte = '$causaComp' AND fecha BETWEEN '$desdeComp' AND '$hastaComp'";
							$queryComp = mysqli_query($conexion,$sqlComp);
							$cantidadComp = mysqli_fetch_array($queryComp);
							$coloresComp[] = "'".color_rand()."'";
							$labelsMuertesComp[] = "'".$causaComp."'";
							$cantMuertesComp[] = $cantidadComp['muertes'];
						}

						$labelsMuertesComp = implode(',',$labelsMuertesComp);
						$cantMuertesComp = implode(',',$cantMuertesComp);
						$coloresComp = implode(',',$coloresComp);
					}

					echo $cantMuertesComp;
					?>
					],
					backgroundColor: [
					<?php echo $coloresComp.",";?>
					],
					label: 'Tipo de Muerte'
				}],
				labels: [
				<?php
					echo $labelsMuertesComp;
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
  
	// MUERTES COMPARACION 
			var muertesComp = {
	      type: 'line',
	      data: {
	        labels: [

	        <?php
	      	
	        $labelsMuertesComp = "";
			$cantidadMuertesComp = 0;
			$sqlMuertesComp = "SELECT fecha,muertes,causaMuerte FROM muertes WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp' ORDER BY fecha ASC";
			$queryMuertesComp = mysqli_query($conexion,$sqlMuertesComp);
			while ($filaMuertesComp = mysqli_fetch_array($queryMuertesComp)) {
				$cantidadMuertesComp = $cantidadMuertesComp.",".$filaMuertesComp['muertes'];
				$labelsMuertesComp = $labelsMuertesComp.",'".formatearFecha($filaMuertesComp['fecha'])."'";
			}
			$labelsMuertesComp = substr($labelsMuertesComp,1);
			$cantidadMuertesComp = substr($cantidadMuertesComp, 2);
			echo $labelsMuertesComp;
	        ?>

	        ],
	        datasets: [{
	          label: 'Cantidad de Muertes por Fecha',
	          backgroundColor: window.chartColors.red,
	          borderColor: window.chartColors.red,
	          data: [
	            <?php
				echo $cantidadMuertesComp;
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