<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
require("includes/arrays.php");

$accionValido = array_key_exists("accion", $_REQUEST);

if ($accionValido) {
  $accion = $_GET['accion'];

  if ($accion == "modificar") {
    $tropaOriginal = $_GET['tropa'];
    $tropa = $_POST['tropa'];
    $fechaIngreso = $_POST['fechaIngreso'];
    $renspa = $_POST['renspa'];
    $adpv = ($_POST['adpv'] == "") ? 0 : $_POST['adpv'];
    $origen = $_POST['origen'];
    $proveedor = $_POST['proveedor'];
    $estado = $_POST['estado'];
    $corral = $_POST['corral'];
    $notas = $_POST['notas'];

    $sqlIngreso = "UPDATE ingresos SET
    tropa = '$tropa',
    fecha = '$fechaIngreso',
    renspa = '$renspa',
    adpv = '$adpv',
    origen = '$origen',
    proveedor = '$proveedor',
    estado = '$estado',
    corral = '$corral',
    notas = '$notas' WHERE tropa = '$tropaOriginal'";
    mysqli_query($conexion,$sqlIngreso);
    header("Location:verTropa.php?tropa=$tropa&seccion=ingresos");
  }

}

$tropaValido = array_key_exists("tropa", $_REQUEST);

if ($tropaValido) {
$tropa = $_GET['tropa'];
$seccion = $_GET['seccion'];
$cantIng = 0;
$cantEgr = 0;
$cantMuertes = 0;
$totalPesoIng = 0;
$totalPesoEgr = 0;
$kgIngProm = 0;
$kgEgrProm = 0;
$diferenciaIngEgr = 0;
if ($seccion == 'ingresos') {

  $sqlIng = "SELECT renspa,adpv,peso,estado,fecha,proveedor,estado,origen,corral,notas, MAX(peso) as maximo, MIN(peso) as minimo, COUNT(id) as total, SUM(peso) as pesoTotal FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
  $queryIng = mysqli_query($conexion,$sqlIng);
  $resultados = mysqli_fetch_array($queryIng);
    $cantIng = $resultados['total'];
    $renspa = $resultados['renspa'];
    $adpv = $resultados['adpv'];
    $totalPesoIng = $resultados['pesoTotal'];
    $fechaIngreso = $resultados['fecha'];
    $estado = $resultados['estado'];
    $proveedor = $resultados['proveedor'];
    $origen = $resultados['origen'];
    $corral = $resultados['corral'];
    $notas = $resultados['notas'];
    $pesoMax = $resultados['maximo'];
    $pesoMin = $resultados['minimo'];


  if ($cantIng > 0) {
  $kgIngProm = ($totalPesoIng/$cantIng);
  }
  $kgIngProm = round($kgIngProm, 2);
}

if ($seccion == 'egresos') {
  $sqlEgr = "SELECT peso,fecha,destino, MAX(peso) as maximo, MIN(peso) as minimo, COUNT(id) as total, SUM(peso) as pesoTotal FROM egresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
  $queryEgr = mysqli_query($conexion,$sqlEgr);
  $resultados = mysqli_fetch_array($queryEgr);
    $cantEgr = $resultados['total'];
    $totalPesoEgr = $resultados['pesoTotal'];
    $fechaEgreso = $resultados['fecha'];
    $destino = $resultados['destino'];
    $pesoMaxEgr = $resultados['maximo'];
    $pesoMinEgr = $resultados['minimo'];


  if ($cantEgr > 0) {
  $kgEgrProm = ($totalPesoEgr/$cantEgr);
  }
  $kgEgrProm = round($kgEgrProm, 2);

}
  
}

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>JORGE CORNALE - GESTION DE FEEDLOTS</title>
    <link rel="icon" href="img/ico.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/ico.ico" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-2.2.4.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/chart/dist/Chart.bundle.js"></script>
    <script src="js/chart/samples/utils.js"></script>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 10px;
      }
    </style>
    <script type="text/javascript">
    
    function mostrar(id) {
      $("#" + id).show(200);
    }
       

    </script>
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php
          include("includes/nav.php");
          ?>
        </div>
      </div>
    </div>
    <div class="container" style="padding-top: 50px;">
      <h1 style="display: inline-block;">STOCK</h1>
      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>
      <div class="hero-unit" style="padding-top: 10px;margin-bottom: 5px;">
        <h2>Tropa <?php echo $tropa;?></h2>

        <div class="bs-docs-example">
          <?php
          if ($seccion == 'ingresos') { ?>
          <div class="totales">
            <div class="row-fluid">
              <div class="span6"><b>- R.E.N.S.P.A: </b><?php echo $renspa;?></div>
              <div class="span6"><b>- ADPV: </b><?php echo number_format($adpv,2,",",".")." Kg";?></div>
            </div>
            <div class="row-fluid" style="background-color:#eeeeee">
              <div class="span6"><b>- Fecha de Ingreso: </b><?php echo formatearFecha($fechaIngreso);?></div>
              <div class="span6"><b>- Total Ingreso: </b><?php echo number_format($cantIng,0,",",".")." Animales";?></div>
            </div>
            <div class="row-fluid">
              <div class="span6"><b>- Proveedor: </b><?php echo $proveedor;?></div>
              <div class="span6"><b>- Origen: </b><?php echo $origen;?></div>
            </div>
            <div class="row-fluid" style="background-color:#eeeeee">
              <div class="span6"><b>- Estado: </b><?php echo $estado;?></div>
              <div class="span6"><b>- Corral: </b><?php echo $corral;?></div> 
            </div>
            <div class="row-fluid">
              <div class="span6"><b>- Kg Neto Ingreso: </b><?php echo number_format($totalPesoIng,2,",",".")." Kg";?></div>
              <div class="span6"><b>- Kg Ingreso Promedio: </b><?php echo number_format($kgIngProm,2,",",".")." Kg";?></div>
            </div>
            <div class="row-fluid">
              <div class="span6"><b>- Peso Min: </b><?php echo formatearNum($pesoMin)." Kg";?></div>
              <div class="span6"><b>- Peso Max.: </b><?php echo formatearNum($pesoMax)." Kg";?></div>
            </div>
            <div class="row-fluid" style="background-color:#eeeeee">
              <div class="span12"><b>- Notas: </b><?php echo $notas;?></div>
            </div>
            <div class="row-fluid" style="margin-top: 5px;">
              <div class="span6">
                <a href="#" data-toggle="modal" data-target="#modificarTropa" class="btn btn-primary" onclick="zindexModal()">Modificar</a>
              </div>
            </div>
            
            <div class="modal fade" id="modificarTropa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width: 450px;">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Modificar Tropa</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                  </div>
                  <form style="margin-bottom: 10px;" method="POST" action="verTropa.php?accion=modificar&tropa=<?php echo $tropa?>">
                    <div class="modal-body">    
                      <div class="row-fluid">
                        <div class="span6">
                          <div class="control-group">
                            <label class="control-label formulario" for="inputTropa">Tropa:</label>
                            <div class="controls">
                              <input type="text" id="inputTropa" name="tropa"  value="<?php echo $tropa;?>" required autofocus>
                            </div>
                          </div>
                        </div>
                        <div class="span6">
                          <div class="control-group">
                            <label class="control-label formulario" for="inputFechaIng">Fecha Ingreso:</label>
                            <div class="controls">
                              <input type="date" id="inputFechaIng" name="fechaIngreso" value="<?php echo $fechaIngreso?>" required>
                            </div>
                          </div>           
                        </div>   
                      </div>
                      <div class="row-fluid">
                        <div class="span6">
                          <div class="control-group">
                            <label class="control-label formulario" for="inputRenspa">R.E.N.S.P.A:</label>
                            <div class="controls">
                              <input type="text" id="inputRenspa" name="renspa" value="<?php echo $renspa;?>">
                            </div>
                          </div>           
                        </div>
                        <div class="span6">
                          <div class="control-group">
                            <label class="control-label formulario" for="inputAdpv">ADPV:</label>
                            <div class="controls">
                              <input type="number" step="0.01" id="inputAdpv" name="adpv" value="<?php echo $adpv;?>">
                            </div>
                          </div>           
                        </div>  
                      </div>
                      <div class="row-fluid">
                        <div class="span6">
                          <div class="control-group">
                            <label class="control-label formulario" for="inputOrigen">Origen:</label>
                            <div class="controls">
                              <input type="text" id="inputOrigen" name="origen" value="<?php echo $origen;?>" >
                            </div>
                          </div>           
                        </div>
                        <div class="span6">
                          <div class="control-group">
                            <label class="control-label formulario" for="inputProveedor">Proveedor:</label>
                            <div class="controls">
                              <input type="text" id="inputProveedor" name="proveedor" value="<?php echo $proveedor;?>" >
                            </div>
                          </div>           
                        </div>
                      </div>
                      <div class="row-fluid">
                        <div class="span6">
                          <div class="control-group">
                            <label class="control-label formulario" for="inputEstado">Estado:</label>
                            <div class="controls">
                              <input type="text" id="inputEstado" name="estado" value="<?php echo $estado;?>">
                            </div>
                          </div>           
                        </div>
                        <div class="span6">
                          <div class="control-group">
                            <label class="control-label formulario" for="inputCorral">Corral:</label>
                            <div class="controls">
                              <input type="number" id="inputCorral" name="corral" value="<?php echo $corral;?>">
                            </div>
                          </div>           
                        </div>
                      </div>
                      <div class="row-fluid">
                        <div class="span6">
                          <div class="control-group">
                            <label class="control-label formulario" for="inputNotas">Notas:</label>
                            <div class="controls">
                              <input type="text" id="inputNotas"  class="input-large" name="notas"  value="<?php echo $notas; ?>">
                            </div>
                          </div>           
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" style="padding: 10px 15px 10px 0;">
                      <button type="submit" class="btn btn-primary">Modificar</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <a href="#" class="btn btn-primary btn-small" style="margin-top: 10px;margin-bottom: -5px;" id="verDetalles">Detalle de Tropa</a>
          <div id="detalleTropa" style="display:none;" class="row-fluid">
            <div class="span12" style="height: 250px;overflow-y: scroll;margin-top:10px;">
              <table class="table table-striped table-hover">
                <thead>
                  <th>IDE</th>
                  <th>Num. DTE</th>
                  <th>Peso</th>
                  <th>Raza</th>
                  <th>Sexo</th>
                  <th>Estado</th>
                  <th>Hora</th>
                </thead>
                <tbody>
                  <?php
                  $detalleIng = "SELECT IDE,numDTE,peso,raza,sexo,estadoAnimal,hora FROM ingresos WHERE tropa = '$tropa' ORDER BY hora ASC,peso ASC";
                  $queryDetalleIng = mysqli_query($conexion,$detalleIng);
                  while ($filaDetalle = mysqli_fetch_array($queryDetalleIng)) { ?>
                  <tr>
                    <td><?php echo $filaDetalle['IDE'];?></td>
                    <td><?php echo $filaDetalle['numDTE'];?></td>
                    <td><?php echo $filaDetalle['peso'];?></td>
                    <td><?php echo $filaDetalle['raza'];?></td>
                    <td><?php echo $filaDetalle['sexo'];?></td>
                    <td><?php echo $filaDetalle['estadoAnimal'];?></td>
                    <td><?php echo $filaDetalle['hora'];?></td>
                  </tr>  
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php }
          if ($seccion == 'egresos') { ?>
            <div class="totales">
              <div class="row-fluid">
                <div class="span6"><b>- Fecha de Egreso: </b><?php echo formatearFecha($fechaEgreso);?></div>
                <div class="span6"><b>- Total Egreso: </b><?php echo number_format($cantEgr,0,",",".")." Animales";?></div>
              </div>
              <div class="row-fluid" style="background-color:#eeeeee">
                <div class="span6"><b>- Kg Neto Egreso: </b><?php echo formatearNum($totalPesoEgr)." Kg";?></div>
                <div class="span6"><b>- Kg Egreso Promedio: </b><?php echo formatearNum($kgEgrProm)." Kg";?></div>
              </div>
              <div class="row-fluid">
                <div class="span6"><b>- Peso Min.: </b><?php echo formatearNum($pesoMinEgr)." Kg";?></div> 
                <div class="span6"><b>- Peso Max.: </b><?php echo formatearNum($pesoMaxEgr)." Kg";?></div>
              </div>
            </div>
            <a href="#" class="btn btn-primary btn-small" style="margin-top: 10px;margin-bottom: -5px;" id="verDetalles">Detalle de Tropa</a>
            <div id="detalleTropa" style="display:none;" class="row-fluid">
              <div class="span12" style="height: 250px;overflow-y: scroll;margin-top:10px;">
                <table class="table table-striped table-hover">
                  <thead>
                    <th>IDE</th>
                    <th>Peso</th>
                    <th>Raza</th>
                    <th>Sexo</th>
                    <th>GMD Total</th>
                    <th>GPV Total</th>
                    <th>Destino</th>
                    <th>Hora</th>
                  </thead>
                  <tbody>
                    <?php
                    $detalleIng = "SELECT IDE,peso,raza,sexo,hora,gdmTotal,gpvTotal,destino FROM egresos WHERE tropa = '$tropa' ORDER BY hora ASC,peso ASC";
                    $queryDetalleIng = mysqli_query($conexion,$detalleIng);
                    while ($filaDetalle = mysqli_fetch_array($queryDetalleIng)) { ?>
                    <tr>
                      <td><?php echo $filaDetalle['IDE'];?></td>
                      <td><?php echo $filaDetalle['peso'];?></td>
                      <td><?php echo $filaDetalle['raza'];?></td>
                      <td><?php echo $filaDetalle['sexo'];?></td>
                      <td><?php echo $filaDetalle['gdmTotal'];?></td>
                      <td><?php echo $filaDetalle['gpvTotal'];?></td>
                      <td><?php echo $filaDetalle['destino'];?></td>
                      <td><?php echo $filaDetalle['hora'];?></td>
                    </tr>  
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
           
          <?php }
          ?>
          <hr>
          <?php
          if ($seccion == 'ingresos') { ?>
          <div class="row-fluid">
            <div class="span7">
              <div id="canvas-holder" style="width:100%;display: inline-block;">
                <canvas id="canvasRaza"></canvas>
              </div>
            </div>
            <div class="span5">
              <div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
                <canvas id="chart-area"></canvas>
              </div>
            </div>
          </div>
          <hr>
          <div class="row-fluid">
            <div class="span7">
              <div id="canvas-holder" style="width:100%;display: inline-block;">
                <canvas id="canvasIncremento"></canvas>
              </div>
            </div>
            <div class="span5">
              <div id="canvas-holder" style="width:100%">
                <canvas id="chart-areaPesos"></canvas>
              </div>
              <div class="row-fluid">
                <div class="span4"></div>
                <div class="span2">
                  <input type="number" class="input-mini" id="pesoDesde" value="0" onblur="calculaCPS()">
                </div>
                <div class="span2">
                  <input type="number" class="input-mini" id="pesoHasta" value="0" onblur="calculaCPS()">
                </div>
                <div class="span4"></div>
              </div>
              <div class="row-fluid">
                <div class="span12" style="text-align: center;">
                  <button class="btn btn-secondary" id="calcularCant" value="">Calcular</button>
                </div>
              </div>
            </div>
          </div>
          <a href="stock.php?seccion=ingreso" class="btn btn-primary btn-large">Volver</a>
          <?php }
          if ($seccion == 'egresos') { ?>
            <div class="row-fluid">
            <div class="span7">
              <div id="canvas-holder" style="width:100%;display: inline-block;">
                <canvas id="canvasRazaEgr"></canvas>
              </div>
            </div>
            <div class="span5">
              <div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
                <canvas id="chart-areaEgr"></canvas>
              </div>
            </div>
          </div>
          <hr>
          <a href="stock.php?seccion=egreso" class="btn btn-primary btn-large">Volver</a>
        <?php }
        ?>
          <span class="ir-arriba icon-arrow-up2"></span>
        </div>
        <br>
        <hr>
      <footer>
        <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
      </footer>
    </div>

    <script type="text/javascript">
      var btnDetalles = document.getElementById('verDetalles');
      btnDetalles.addEventListener('click',function(){
        $('#detalleTropa').toggle(500);
      });

        $(document).ready(function(){
 
          $('.ir-arriba').click(function(){
            $('body, html').animate({
              scrollTop: '0px'
            }, 300);
          });
         
          $(window).scroll(function(){
            if( $(this).scrollTop() > 0 ){
              $('.ir-arriba').slideDown(300);
            } else {
              $('.ir-arriba').slideUp(300);
            }
          });
         
        });

        function zindexModal(){
              $("#modificarTropa").css('z-index','1');
          }
          
          $(document).ready(function(){
              $(".modal").each(function(){
                $(this).css('z-index',0);
              })  
            });

//INGRESOS
  <?php
  if ($seccion == 'ingresos') { 
    ?>
  // SEXO

    var config = {
      type: 'pie',
      data: {
        datasets: [{
          data: [
          <?php
          if ($seccion == 'ingresos') {
            $sqlMacho = "SELECT COUNT(sexo) AS macho FROM ingresos WHERE sexo = 'Macho' AND tropa = '$tropa'";
            $queryMacho = mysqli_query($conexion,$sqlMacho);
            $resultado = mysqli_fetch_array($queryMacho);
            $macho = $resultado['macho'];

            $sqHemb = "SELECT COUNT(sexo) AS hembra FROM ingresos WHERE sexo = 'Hembra' AND tropa = '$tropa'";
            $querHemb = mysqli_query($conexion,$sqHemb);
            $resultado = mysqli_fetch_array($querHemb);
            $hembra = $resultado['hembra'];
          }

          $resultado = $macho.",".$hembra.",";
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
  // CANTIDAD SEGUN PESO
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
        }

      }
    };  
  // RAZAS
    <?php
    $sqlRazas = "SELECT raza FROM razas ORDER BY raza ASC";
    $queryRazas = mysqli_query($conexion,$sqlRazas);
    $labelsRaza = "";
    $cantXraza = "";
    while ($razas = mysqli_fetch_array($queryRazas)) {
      $labelsRaza = $labelsRaza.",'".$razas['raza']."'";  
      ${$razas['raza']} = cantRaza($razas['raza'],'ingresos',$tropa,$conexion);
      $cantXraza = $cantXraza.",".${$razas['raza']};
    }
    $labelsRaza = substr($labelsRaza, 1);
    $cantXraza = substr($cantXraza, 1);
    ?>
    var RAZAS = [
    <?php
    echo $labelsRaza;
    ?>
    ];
    var color = Chart.helpers.color;
    var barChartData = {
      labels: [
      <?php
      echo $labelsRaza;
      ?>
      ],
      datasets: [{
        label: 'Cantidad',
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
  // INCREMENTO

      var configInc = {
        type: 'line',
        data: {
          labels: [

          <?php
          $fechaHoy = date("Y-m-d");
          $ingreso = new DateTime("$fechaIngreso");
          $hoy = new DateTime("$fechaHoy");
          $diferencia = $ingreso->diff($hoy);
          $diferencia = $diferencia->days;
          $fechaSumada = $fechaIngreso;
          $contador = 1;
          $pesos = "";
          $labels = "";
          $pesoInicial = $kgIngProm;

          $pesoTemp = $kgIngProm;
          $array = array();

          if ($diferencia > 5) {
            while ($fechaSumada < $fechaHoy) {
              $contador++;
              $pesoTemp += ($adpv*5);
              $array[$fechaSumada] = $pesoTemp;
              $fechaSumada = date("Y-m-d",strtotime($fechaSumada."+ 5 days"));
              $ultimaFecha = $fechaSumada;

            }

            function endKey($array){
                end($array);
                return key( $array );
            }
            $ultimaFecha = endKey($array);

            $ultima = new DateTime("$ultimaFecha");
            $hoy = new DateTime("$fechaHoy");
            $diferencia = $ultima->diff($hoy);
            $diferencia = $diferencia->days;

            $pesoTemp = $pesoTemp + ($adpv*$diferencia);

            $array[$fechaHoy] = $pesoTemp;

            foreach ($array as $fechas => $kilos) {
              $labels = $labels.",'".formatearFecha($fechas)."'";
              $pesos = $pesos.",".$kilos;
            }

            $labels = substr($labels,1);
            $pesos = substr($pesos,1);

          }else{
          $labels = "'".formatearFecha($fechaIngreso)."','".formatearFecha($fechaHoy)."'";
          $ultimaFecha = $fechaHoy;
          $pesos = $pesoTemp.",";
          $pesoTemp = $pesoTemp + ($adpv*$diferencia);
          $pesos = $pesos.$pesoTemp;
          }



          echo $labels;
          ?>

          ],
          datasets: [{
            label: 'Incremento de peso, basado en ADPV <?php echo $adpv." Kg";?>',
            backgroundColor: window.chartColors.red,
            borderColor: window.chartColors.red,
            data: [
              <?php

              echo $pesos;

              ?>
            ],
            fill: false,
          }]
        },
        options: {
          responsive: true,
          title: {
            display: true,
            text: 'Incremento de Peso'
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
                labelString: 'Peso'
              }
            }]
          }
        }
      };
    <?php
    }
    ?>
//EGRESOS
  <?php
  if ($seccion == 'egresos') {
  include('includes/charts/tropaEgr.php');
  }
?>

      function calculaCPS(){
        var desde = $('#pesoDesde').val();
        var hasta = $('#pesoHasta').val();
        var tropa = <?php echo "'".$tropa."'";?>;

        var datos = 'tropa=' + tropa + '&desde=' + desde + '&hasta=' + hasta;
        var url = 'cantidadSegunPeso.php';

        $.ajax({
          type:'POST',
          url:url,
          data:datos,
          success: function(datos){
            datos = datos.split(",");
            myDoughnut.data.datasets[0].data[0] = datos[0];
            myDoughnut.data.datasets[0].data[1] = datos[1];
            myDoughnut.update();
          }
        });
      } 
      window.onload = function() {
        <?php if ($seccion == 'ingresos') { ?>
          var cantidadPesos = document.getElementById('chart-areaPesos').getContext('2d');
          window.myDoughnut = new Chart(cantidadPesos, cantPesos);

          var sexo = document.getElementById('chart-area').getContext('2d');
          window.myPie = new Chart(sexo, config);
          
          var adpv = document.getElementById('canvasIncremento').getContext('2d');
          window.myLine = new Chart(adpv, configInc);

          var raza = document.getElementById('canvasRaza').getContext('2d');
          window.myBar = new Chart(raza, {
            type: 'bar',
            data: barChartData,
            options: {
              responsive: true,
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Cant. Segun Raza'
              },
              scaleShowValues: true,
              scales: {
                xAxes: [{
                  ticks: {
                    autoSkip: false
                  }
                }]
              }
            }
          });


          document.getElementById('calcularCant').addEventListener('click', function() {
            var desde = $('#pesoDesde').val();
            var hasta = $('#pesoHasta').val();
            var tropa = <?php echo "'".$tropa."'";?>;

            var datos = 'tropa=' + tropa + '&desde=' + desde + '&hasta=' + hasta;
            var url = 'cantidadSegunPeso.php';

            $.ajax({
              type:'POST',
              url:url,
              data:datos,
              success: function(datos){
                datos = datos.split(",");
                myDoughnut.data.datasets[0].data[0] = datos[0];
                myDoughnut.data.datasets[0].data[1] = datos[1];
                myDoughnut.update();
              }
            });   
          });
          
        <?php 
        }

        if ($seccion == 'egresos') { ?>
          var sexoEgr = document.getElementById('chart-areaEgr').getContext('2d');
          window.myPie = new Chart(sexoEgr, configEgr);

          var razaEgr = document.getElementById('canvasRazaEgr').getContext('2d');
          window.myBar = new Chart(razaEgr, {
            type: 'bar',
            data: barChartDataEgr,
            options: {
              responsive: true,
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Cant. Segun Raza'
              },
              scaleShowValues: true,
              scales: {
                xAxes: [{
                  ticks: {
                    autoSkip: false
                  }
                }]
              }
            }
          });
        <?php
        }
        ?>

        
      };

   </script>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
  </body>
</html>
