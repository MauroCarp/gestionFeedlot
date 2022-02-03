<?php
if(!$comparacionValido){
?>
<div class="row-fluid">
	<div class="span5">
		<div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
			<canvas id="chart-area"></canvas>
		</div>
	</div>
	<div class="span7">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasRaza"></canvas>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasCantidades"></canvas>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div style="width:100%;">
		<canvas id="canvasIngEgr"></canvas>
	</div>
	</div>
</div>
<?php
}else{
?>
<div class="row-fluid">
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
			<canvas id="chart-area"></canvas>
		</div>
	</div>
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
			<canvas id="chart-areaComp"></canvas>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasRazaComparacion"></canvas>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasCantidades"></canvas>
		</div>
	</div>
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasCantidadesComp"></canvas>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
		<canvas id="canvasIngEgr"></canvas>
		</div>
	</div>
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
		<canvas id="canvasIngEgrComp"></canvas>
		</div>
	</div>
</div>
<?php
}
?>

<script type="text/javascript">
	
	// SEXO
		var config = {
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
					labels: {
						render: 'value'
					}
				}

			}
		};

	// INGRESOS SEGUN SEXP Y PESO

		var cantPesos = {
		type: 'doughnut',
		data: {
		  datasets: [{
		    data: [
		    <?php echo $resultado;?>
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
			labels: {
				render: 'value'
			}
		  }

		}
		};


	// RAZAS 	
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
	  var RAZAS = [
	  <?php
		echo $labelsRaza;
	  ?>];
	  var color = Chart.helpers.color;
	  var barChartData = {
	    labels: [
	    <?php
	    echo $labelsRaza;
	    ?>
	    ],
	    datasets: [{
	      label: 'Razas',
	      backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
	      borderColor: window.chartColors.red,
	      borderWidth: 1,
	      data: [
	      <?php
	  		echo $cantXraza;
	      ?>
	      ]
	    }]

	  };
	// INGRESOS 
	   	var ingresos = {
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

	 <?php
	 if ($comparacionValido) {
	 ?>   
	

	// SEXO COMPARACION
		var configComp = {
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
				}

			}
		};
  	// RAZAS COMPARACION
	  	var color = Chart.helpers.color;
	  	var barChartDataRazaC = {
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
	  	
	// INGRESOS COMPARACION 
	   	var ingresosComp = {
	      type: 'line',
	      data: {
	        labels: [

	        <?php
	      	if ($labelsMeses) {

				echo implode(",",$mesesComp);

		      	}else{

					$labelsComp = "''";
					
					$fechaTempComp = "";
					
					$contadorComp = 0;
					
					$cantidadComp = 0;
					
					$sqlFechasComp = "SELECT DISTINCT(fecha) as fecha FROM ingresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp' ORDER BY fecha ASC";

					$queryFechasComp = mysqli_query($conexion,$sqlFechasComp);
					
					
					
					if (!empty($filaFechasComp)) {
					
					  
					  while($filaFechasComp = mysqli_fetch_array($queryFechasComp)){
					
						$fecha = $filaFechasComp['fecha'];
					  
						$sqlCantidadComp = "SELECT COUNT(*) as total FROM ingresos WHERE feedlot = '$feedlot' AND fecha = '$fecha' ORDER BY fecha ASC";
					  
						$queryCantidadComp = mysqli_query($conexion,$sqlCantidadComp);
					  
						$resultado = mysqli_fetch_array($queryCantidadComp);
					  
						$labelsComp = $labelsComp.','.$resultado['total'];
					  
					  };
					
					
					
					
					}

					echo $labelsComp;
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
	    <?php
	}
	    ?>
</script>
