<?php
include("../../../../includes/conexion.php");
?>
<!doctype html>
<html>

<head>
	<title>Pie Chart</title>
	<script src="../../dist/Chart.bundle.js"></script>
	<script src="../utils.js"></script>
</head>

<body>
	<div id="canvas-holder" style="width:40%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>


		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						<?php
                        $virus = 0;
                        $neumo = 0;
                        $sequia = 0;
                        $desconocida = 0;

                        $sql = "SELECT causaMuerte,muertes FROM stock WHERE muertes != 0";
                        $query = mysqli_query($conexion,$sql);
                        while($resultado = mysqli_fetch_array($query)){
                          switch ($resultado['causaMuerte']) {
                            case 'VIRUS':
                              $virus = $virus + $resultado['muertes'];
                              break;
                            
                            case 'NEUMO':
                              $neumo = $neumo + $resultado['muertes'];
                              break;

                            case 'SEQUIA':
                              $sequia = $sequia + $resultado['muertes'];
                              break;

                            case 'DESCONOCIDA':
                              $desconocida = $desconocida + $resultado['muertes'];
                              break;

                            default:
                              # code...
                              break;
                          }
                        }
                       echo $virus.",".$neumo.",".$sequia.",".$desconocida.",";
                      ?>
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.yellow,
						window.chartColors.green,
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Virus',
					'Neumo',
					'Sequia',
					'Desconocida'
				]
			},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};



	</script>
</body>

</html>
