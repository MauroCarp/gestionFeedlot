<table class="table" align="center">
	<tr colspan="3">
		<td style="font-size: 1.2em;" colspan="2"><b>Ingresos</b></td>
	</tr>
	<tr>
		<td>
			<ul>
				<li>Periodo: <?php echo formatearFecha($desde)." al ".formatearFecha($hasta);?></li>
				<li>
					<b>- Total Ing: </b><span id="cantIng"><?php echo number_format($cantIng,0,",",".");?></span> Animales
				</li>
				<li>
					<b>- Kg Neto Ing: </b><?php echo formatearNum($totalPesoIng)." Kg";?>
				</li>
				<li>
					<b>- Kg Ing. Prom: </b><?php echo formatearNum($kgIngProm)." Kg";?>
				</li>
				<li>
					<b>- Dif. Kg Ing/Egr: </b><?php echo formatearNum($diferenciaIngEgr)." Kg";?>
				</li>
			</ul>
		</td>
		<td>
			<ul>
				<li>
					<b>- Dif. Animales: </b><span id="difAnimIng"></span>
				</li>
				<li>
					<b>- Ingresos: </b><span id="difIng"></span>
				</li>
			</ul>
		<td>
		<td>
			<ul>
				<li>Periodo: <?php echo formatearFecha($desdeComp)." al ".formatearFecha($hastaComp);?></li>
				<li>
					<b>- Total Ing: </b><span id="cantIngComp"><?php echo number_format($cantIngComp,0,",",".");?></span> Animales
				</li>
				<li>
					<b>- Kg Neto Ing: </b><span><?php echo formatearNum($totalPesoIngComp)." Kg";?>
				</li>
				<li>
					<b>- Kg Ing. Prom: </b><span><?php echo formatearNum($kgIngPromComp)." Kg";?>
				</li>
				<li>
					<b>- Dif. Kg Ing/Egr: </b><span><?php echo formatearNum($diferenciaIngEgrComp	)." Kg";?>
				</li>
			</ul>
		<td>
	</tr>
</table>
<table class="table table-stripped" style="width: 900px" align="left">
	<tr>
		<td><canvas width="400px" id="chart-area"></canvas></td>
		<td><canvas width="400px" id="chart-areaComp"></canvas></td>
	</tr>
	<tr>
		<td colspan="2"><canvas id="canvasRazaComparacion"></canvas></td>
	</tr>
	<tr>
		<td><canvas id="canvasCantidades"></canvas></td>
		<td><canvas id="canvasCantidadesComp"></canvas></td>
	</tr>
</table>

<table class="table table-stripped" style="width: 900px" align="left">
	<tr>
		<td><canvas width="400px" id="canvasIngEgr"></canvas></td>
		<td><canvas width="400px" id="canvasIngEgrComp"></canvas></td>
	</tr>
</table>

<!-- <table cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp</td>
	</tr>
</table> -->
<script type="text/javascript">

	//SEXO
		let config = {
				type: 'pie',
				data: {
					datasets: [{
						data: [
						<?php
						$sqlMachoIngreso = "SELECT COUNT(*) AS macho FROM ingresos WHERE sexo = 'Macho' AND feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
						$queryMachoIngreso = mysqli_query($conexion,$sqlMachoIngreso);
						$resultadoIngreso = mysqli_fetch_array($queryMachoIngreso);
						$machoIngreso = $resultadoIngreso['macho'];

						$sqHembIngreso = "SELECT COUNT(*) AS hembra FROM ingresos WHERE sexo = 'Hembra' AND feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
						$querHembIngreso = mysqli_query($conexion,$sqHembIngreso);
						$resultadoIngreso = mysqli_fetch_array($querHembIngreso);
						$hembraIngreso = $resultadoIngreso['hembra'];

						$resultado = $machoIngreso.",".$hembraIngreso.",";
						echo $resultado;

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
					plugins:{
					labels:{
						render:'percentage',
						fontColor:'white'
					}
				}

				}
			};
	// SEXO COMPARACION
		let configComp = {
		type: 'pie',
		data: {
			datasets: [{
				data: [
				<?php
				$sqlMachoIngresoC = "SELECT COUNT(sexo) AS macho FROM ingresos WHERE sexo = 'Macho' AND feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp'";
				$queryMachoIngresoC = mysqli_query($conexion,$sqlMachoIngresoC);
				$resultadoIngresoC = mysqli_fetch_array($queryMachoIngresoC);
				$machoIngresoC = $resultadoIngresoC['macho'];

				$sqHembIngresoC = "SELECT COUNT(sexo) AS hembra FROM ingresos WHERE sexo = 'Hembra' AND feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp'";
				$querHembIngresoC = mysqli_query($conexion,$sqHembIngresoC);
				$resultadoIngresoC = mysqli_fetch_array($querHembIngresoC);
				$hembraIngresoC = $resultadoIngresoC['hembra'];

				$resultadoC = $machoIngresoC.",".$hembraIngresoC.",";
				echo $resultadoC;

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
				plugins:{
					labels:{
						render:'percentage',
						fontColor:'white'
					}
				}

			}
		};

  	// RAZAS COMPARACION
  	<?php 
	  	  $sqlRazas = "SELECT raza FROM razas ORDER BY raza ASC";
		  $queryRazas = mysqli_query($conexion,$sqlRazas);
		  $labelsRaza = "";
		  $cantXraza = "";
		  $cantXrazaComp = "";
		  while ($razas = mysqli_fetch_array($queryRazas)) {
		    $labelsRaza = $labelsRaza.",'".$razas['raza']."'";  
		    ${$razas['raza']} = cantRazaInforme($razas['raza'],'ingresos',$feedlot,$desde,$hasta,$conexion);
		    $cantXraza = $cantXraza.",".${$razas['raza']};
		    if ($comparacionValido) {
		    	${$razas['raza']."Comp"} = cantRazaInforme($razas['raza'],'ingresos',$feedlot,$desdeComp,$hastaComp,$conexion);
		    	$cantXrazaComp = $cantXrazaComp.",".${$razas['raza']."Comp"};
		    }
		  }
		  $labelsRaza = substr($labelsRaza, 1);
		  $cantXraza = substr($cantXraza, 1);
		?>
	  	let color = Chart.helpers.color;
	  	let barChartDataRazaC = {
		    labels: [
		    <?php
		    echo $labelsRaza;
		    ?>
		    ],
	  		datasets: [{
	  			label: 'Periodo 1',
	  			backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
	  			borderColor: window.chartColors.red,
	  			borderWidth: 1,
	  			data: [
	  			<?php
	  			echo $cantXraza;	  
		      ?>
	  			]
	  		}, {
	  			label: 'Periodo 2',
	  			backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
	  			borderColor: window.chartColors.blue,
	  			borderWidth: 1,
	  			data: [
	  			<?php
			  	echo substr($cantXrazaComp, 1);
				?>
	  			]
	  		}]

	  	};

// INGRESOS 
	   	let ingresos = {
	      type: 'line',
	      data: {
	        labels: [

	        <?php
	      	if ($labelsMeses) {
				echo implode(",",$meses);
	      	}else{
		        $labels = "";
		        $fechaTemp = "";
		        $contador = 0;
		        $cantidad = 0;
		        $sqlIngresos = "SELECT * FROM ingresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha ASC";
		        $queryIngresos = mysqli_query($conexion,$sqlIngresos);
		        while ($filaIngresos = mysqli_fetch_array($queryIngresos)) {

		          if($fechaTemp != $filaIngresos['fecha']){
		            $fechaTemp = $filaIngresos['fecha'];
		            $labels = $labels."','".formatearFecha($fechaTemp);
		            $cantidad = $cantidad.",".$contador;
		            $contador = 0;
		          }
		          $contador++;
		        }
		        $cantidad = $cantidad.",".$contador;

		         $labels = substr($labels,2);
				if ($labels == "") {
					echo $labels;
				}else{
					echo $labels."'";
				}
	      	}

	        ?>

	        ],
	        datasets: [{
	          label: 'Cantidad de Animales por Fecha de Ingresos',
	          backgroundColor: window.chartColors.red,
	          borderColor: window.chartColors.red,
	          data: [
	            <?php
	            if ($labelsMeses) {
					echo implode(",",$ingresosPorMes);
	            }else{
	            	echo substr($cantidad,4);
	            }

	            ?>
	          ],
	          fill: false,
	        }]
	      },
	      options: {
	        responsive: true,
	        title: {
	          display: true,
	          text: 'Cantidad de Animales'
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

// INGRESOS COMPARACION 
	   	let ingresosComp = {
	      type: 'line',
	      data: {
	        labels: [

	        <?php
	      	if ($labelsMeses) {
				echo implode(",",$mesesComp);
		      	}else{
		        $labelsComp = "";
		        $fechaTempComp = "";
		        $contadorComp = 0;
		        $cantidadComp = 0;
		        $sqlIngresosComp = "SELECT * FROM ingresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp' ORDER BY fecha ASC";
		        $queryIngresosComp = mysqli_query($conexion,$sqlIngresosComp);
		        while ($filaIngresosComp = mysqli_fetch_array($queryIngresosComp)) {

		          if($fechaTempComp != $filaIngresosComp['fecha']){
		            $fechaTempComp = $filaIngresosComp['fecha'];
		            $labelsComp = $labelsComp."','".formatearFecha($fechaTempComp);
		            $cantidadComp = $cantidadComp.",".$contadorComp;
		            $contadorComp = 0;
		          }
		          $contadorComp++;
		        }
		        $cantidadComp = $cantidadComp.",".$contadorComp;

		        echo substr($labelsComp,2)."'";
		    	}
		        ?>

	        ],
	        datasets: [{
	          label: 'Cantidad de Animales por Fecha de Ingresos',
	          backgroundColor: window.chartColors.red,
	          borderColor: window.chartColors.red,
	          data: [
	            <?php
				if ($labelsMeses) {
					echo implode(",",$ingresosPorMesComp);
	            }else{
	            	echo substr($cantidadComp,4);
				}
	            ?>
	          ],
	          fill: false,
	        }]
	      },
	      options: {
	        responsive: true,
	        title: {
	          display: true,
	          text: 'Cantidad de Animales'
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
// INGRESO/EGRESO

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

	// COMP
	
	let lineChartDataIngEgrComp = {
		labels: [
		<?php
		if ($labelsIngEgrMesesComp) {
			echo implode(",",$mesesComp);
		}else{
				$fechasLabels = array();
				for ($i=0; $i < sizeof($fechasComp) ; $i++) { 
					$fechasLabels[$i] = formatearFecha($fechasComp[$i]);
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
				if ($labelsIngEgrMesesComp) {
				echo implode(",",$ingresosPorMesComp);
				}else{
				$cantIngresos = array();
				for ($i=0; $i < sizeof($fechasComp) ; $i++) { 
					$fechaDeArray = $fechasComp[$i];
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
			if ($labelsIngEgrMesesComp) {
				echo implode(",",$egresosPorMesComp);
			}else{
				$cantEgresos = array();
				for ($i=0; $i < sizeof($fechasComp) ; $i++) { 
					$fechaDeArray = $fechasComp[$i];
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

	let ctxIngEgrComp = document.getElementById('canvasIngEgrComp').getContext('2d');

	let chartIngEgrComp = Chart.Line(ctxIngEgrComp, {
		data: lineChartDataIngEgrComp,
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


	

</script>