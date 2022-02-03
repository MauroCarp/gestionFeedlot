<table class="table" align="center">
	<tr>
		<td style="font-size: 1.2em;" colspan="2"><b>Ingresos</b></td>
	</tr>
	<tr>
		<td>
			<ul>
				<li>
					<b>- Total Ing: </b><?php echo number_format($cantIng,0,",",".");?> Animales
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
		<td style="width: 350px;"><canvas id="chart-areaPesos"></canvas></td>
	</tr>
	<tr><td></td><td style="text-align: center;"><b><?php echo "Entre ".$_GET['v1']." Kilos y ".$_GET['v2']." Kilos"?></b></td></tr>
</table>
<table class="table table-stripped" align="left">
	<tr>
		<td style="width: 350px;"><canvas id="chart-area"></canvas></td>
		<td style="width: 550px;"><canvas id="canvasRaza"></canvas></td>		
	</tr>

</table>
<script type="text/javascript">

	// INGRESOS SEGUN SEXP Y PESO

		var cantPesos = {
		type: 'doughnut',
		data: {
		  datasets: [{
		    data: [
		    0,0
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
		  }

		}
		};


	//SEXO
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

	// CANT ING EGR
		var lineChartDataIngEgr = {
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
</script>