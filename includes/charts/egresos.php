<?php
if(!$comparacionValido){
?>
<div class="row-fluid">
	<div class="span5">
		<div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
			<canvas id="chart-areaEgr"></canvas>
		</div>
	</div>
	<div class="span7">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasRazaEgr"></canvas>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasCantidadesEgr"></canvas>
		</div>
	</div>
</div>
<?php
}else{
?>
<div class="row-fluid">
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
			<canvas id="chart-areaEgr"></canvas>
		</div>
	</div>
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
			<canvas id="chart-areaCompEgr"></canvas>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasRazaComparacionEgr"></canvas>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasCantidadesEgr"></canvas>
		</div>
	</div>
	<div class="span6">
		<div id="canvas-holder" style="width:100%;display: inline-block;">
			<canvas id="canvasCantidadesCompEgr"></canvas>
		</div>
	</div>
</div>
<?php
}
?>

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
	// EGRESOS 
	   	var egresos = {
	      type: 'line',
	      data: {
	        labels: [

	        <?php
	      	if ($labelsMeses) {
				echo implode(",",$meses);
	      	}else{
		        $labelsEgr = "";
		        $fechaTempEgr = "";
		        $contadorEgr = 0;
		        $cantidadEgr = 0;
		        $sqlEgresos = "SELECT * FROM egresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha ASC";
		        $queryEgresos = mysqli_query($conexion,$sqlEgresos);
		        while ($filaEgresos = mysqli_fetch_array($queryEgresos)) {

		          if($fechaTempEgr != $filaEgresos['fecha']){
		            $fechaTempEgr = $filaEgresos['fecha'];
		            $labelsEgr = $labelsEgr."','".formatearFecha($fechaTempEgr);
		            $cantidadEgr = $cantidadEgr.",".$contadorEgr;
		            $contadorEgr = 0;
		          }
		          $contadorEgr++;
		        }
		        $cantidadEgr = $cantidadEgr.",".$contadorEgr;

				$labelsEgr = substr($labelsEgr,2);
				if ($labelsEgr == "") {
				echo $labelsEgr;
				}else{
				echo $labelsEgr."'";
				}
			}
	        ?>

	        ],
	        datasets: [{
	          label: 'Cantidad de Animales por Fecha de Egresos',
	          backgroundColor: window.chartColors.red,
	          borderColor: window.chartColors.red,
	          data: [
	            <?php
	            if ($labelsMeses) {
					echo implode(",",$egresosPorMes);
	            }else{
	            	echo substr($cantidadEgr,4);
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
		var configEgrComp = {
		type: 'pie',
		data: {
			datasets: [{
				data: [
				<?php
				$sqlMachoEgresoC = "SELECT COUNT(sexo) AS macho FROM egresos WHERE sexo = 'Macho' AND feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp'";
				$queryMachoEgresoC = mysqli_query($conexion,$sqlMachoEgresoC);
				$resultadoEgresoC = mysqli_fetch_array($queryMachoEgresoC);
				$machoEgresoC = $resultadoEgresoC['macho'];

				$sqHembEgresoC = "SELECT COUNT(sexo) AS hembra FROM egresos WHERE sexo = 'Hembra' AND feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp'";
				$querHembEgresoC = mysqli_query($conexion,$sqHembEgresoC);
				$resultadoEgresoC = mysqli_fetch_array($querHembEgresoC);
				$hembraEgresoC = $resultadoEgresoC['hembra'];

				$resultadoEgrC = $machoEgresoC.",".$hembraEgresoC.",";
				echo $resultadoEgrC;

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
	  	var barChartDataRazaEgrC = {
		    labels: [
		    <?php
		    echo $labelsRazaEgr;
		    ?>
		    ],
	  		datasets: [{
	  			label: 'Periodo 1',
	  			backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
	  			borderColor: window.chartColors.red,
	  			borderWidth: 1,
	  			data: [
	  			<?php
	  			echo $cantXrazaEgr;	  
		      ?>
	  			]
	  		}, {
	  			label: 'Periodo 2',
	  			backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
	  			borderColor: window.chartColors.blue,
	  			borderWidth: 1,
	  			data: [
	  			<?php
			  	echo substr($cantXrazaCompEgr, 1);
				?>
	  			]
	  		}]

	  	};
	// EGRESOS COMPARACION 
	var egresosComp = {
	      type: 'line',
	      data: {
	        labels: [

	        <?php
	      	if ($labelsMeses) {
				echo implode(",",$mesesComp);
	      	}else{
		        $labelsEgrComp = "";
		        $fechaTempEgrComp = "";
		        $contadorEgrComp = 0;
		        $cantidadEgrComp = 0;
		        $sqlEgresosComp = "SELECT * FROM egresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '$desdeComp' AND '$hastaComp' ORDER BY fecha ASC";
		        $queryEgresosComp = mysqli_query($conexion,$sqlEgresosComp);
		        while ($filaEgresosComp = mysqli_fetch_array($queryEgresosComp)) {

		          if($fechaTempEgrComp != $filaEgresosComp['fecha']){
		            $fechaTempEgrComp = $filaEgresosComp['fecha'];
		            $labelsEgrComp = $labelsEgrComp."','".formatearFecha($fechaTempEgrComp);
		            $cantidadEgrComp = $cantidadEgrComp.",".$contadorEgrComp;
		            $contadorEgrComp = 0;
		          }
		          $contadorEgrComp++;
		        }
		        $cantidadEgrComp = $cantidadEgrComp.",".$contadorEgrComp;

				$labelsEgrComp = substr($labelsEgrComp,2);
				if ($labelsEgrComp == "") {
				echo $labelsEgrComp;
				}else{
				echo $labelsEgrComp."'";
				}
			}
	        ?>

	        ],
	        datasets: [{
	          label: 'Cantidad de Animales por Fecha de Egresos',
	          backgroundColor: window.chartColors.red,
	          borderColor: window.chartColors.red,
	          data: [
	            <?php
	            if ($labelsMeses) {
					echo implode(",",$egresosPorMesComp);
	            }else{
	            	echo substr($cantidadEgrComp,4);
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
