<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");

$accionValido = array_key_exists("accion", $_REQUEST);

if ($accionValido) {
  $accion = $_GET['accion'];

  if ($accion == 'modificar') {
    $tropa = $_GET['tropa'];
    $procedimiento = $_POST['procedimiento'];
    $fechaRealizado = $_POST['fechaRealizado'];
    $operario = $_POST['operario'];
    $otroOperario = $_POST['operarioOtro'];

    if ($operario == 'otro') {
      $operario = $otroOperario;
      $sqlNueva = "INSERT INTO operarios(feedlot,nombre) VALUES ('$feedlot','$operario')";
      $queryNueva = mysqli_query($conexion,$sqlNueva);

    }

    $consulta = "";

    switch ($procedimiento) {
      case 'Metafilaxis':
        $consulta = "operario1 = '".$operario."', metafilaxis = '1', fechaMetafilaxis = '".$fechaRealizado."'";
        break;
      
      case '1er Dosis':
        $consulta = "operario2 = '".$operario."', vacuna = '1', fechaVacuna = '".$fechaRealizado."'";
        break;

      case 'Refuerzo':
        $consulta = "operario3 = '".$operario."', refuerzo = '1', fechaRefuerzo = '".$fechaRealizado."'";
      break; 

      default:
        # code...
        break;
    }
    $sql = "UPDATE status SET
    operario = '$operario',
    procedimiento = '$procedimiento',
    fechaRealizado = '$fechaRealizado',
    $consulta,
    notificado = 0
    WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    $query = mysqli_query($conexion,$sql);

    echo "<script>
	    window.location = 'status.php';
    </script>";
  }

  if ($accion == 'notificar') {
    $tropa = $_GET['tropa'];

    $sql = "UPDATE status SET
    notificado = 1
    WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    $query = mysqli_query($conexion,$sql);
    
    echo "<script>
    window.location = 'status.php';
  </script>";
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
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
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
      <h1 style="display: inline-block;">STATUS SANITARIO</h1>
      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>
      <hr>
      <div class="hero-unit" style="padding-top:10px;">
        <?php
        include("alertas.php");
        ?>
        <hr>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Tropa</th>
              <th scope="col">Fecha Ingreso</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Operario</th>
              <th scope="col" style="text-align: center;">Metafilaxis</th>
              <th scope="col" style="text-align: center;">1er Dosis</th>
              <th scope="col" style="text-align: center;">Refuerzo</th>
              <td></td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT * FROM status WHERE feedlot = '$feedlot' ORDER BY fechaIngreso DESC, tropa ASC"; 
              $query = mysqli_query($conexion,$sql);
              echo mysqli_error($conexion);
              $tropa = "";
              while ($resultado = mysqli_fetch_array($query)) {
                if ($tipoSesion != "balanza") {
              ?>
              <tr>
                <td><?php echo $resultado['tropa'];?></td>  
                <td><?php echo formatearFecha($resultado['fechaIngreso']);?></td>
                <td><?php echo $resultado['animales'];?></td>
                <td><?php echo $resultado['operario'];?></td> 
                <td style="text-align: center;">
                  <?php 
                  if($resultado['metafilaxis']){ ?>
                    <span class="icon-checkmark"></span>
                  <?php
                  }else{ ?>
                    <span class="icon-cross"></span>
                  <?php
                  }
                  ?>
                </td>
                <td style="text-align: center;">
                  <?php 
                  if($resultado['vacuna']){ ?>
                    <span class="icon-checkmark"></span>
                  <?php
                  }else{ ?>
                    <span class="icon-cross"></span>
                  <?php
                  }
                  ?>
                </td>
                <td style="text-align: center;">
                  <?php 
                  if($resultado['refuerzo']){ ?>
                    <span class="icon-checkmark"></span>
                  <?php
                  }else{ ?>
                    <span class="icon-cross"></span>
                  <?php
                  }
                  ?>
                </td>
                <td style="cursor: pointer;"><span class="icon-pencil" data-toggle="modal" data-target="#modificarStatus<?php echo $resultado['id'];?>"></span></td>
                <td style="cursor: pointer;"><span class="icon-eye" data-toggle="modal" data-target="#verStatus<?php echo $resultado['id'];?>"></span><td>
              </tr>
              <?php
            }else{ 
              if ($tropa != $resultado['tropa']) {
                $tropaTemp = $resultado['tropa'];
                $fechaHoy = date("Y-m-d");
                $fechaHoy = new DateTime($fechaHoy);
                $fechaRefuerzo = new DateTime($resultado['fechaRefuerzo']);
                $diff = $fechaHoy->diff($fechaRefuerzo);
                $diferenciaDias = $diff->days;

                if ($resultado['refuerzo'] == 1 AND $diferenciaDias > 5) {
                }else{
          ?>
            <tr>
                <td><?php echo $resultado['tropa'];?></td>  
                <td><?php echo formatearFecha($resultado['fechaIngreso']);?></td>
                <td><?php echo $resultado['animales'];?></td>
                <td><?php echo $resultado['operario'];?></td> 
                <td style="text-align: center;">
                  <?php 
                  if($resultado['metafilaxis']){ ?>
                    <span class="icon-checkmark"></span>
                  <?php
                  }else{ ?>
                    <span class="icon-cross"></span>
                  <?php
                  }
                  ?>
                </td>
                <td style="text-align: center;">
                  <?php 
                  if($resultado['vacuna']){ ?>
                    <span class="icon-checkmark"></span>
                  <?php
                  }else{ ?>
                    <span class="icon-cross"></span>
                  <?php
                  }
                  ?>
                </td>
                <td style="text-align: center;">
                  <?php 
                  if($resultado['refuerzo']){ ?>
                    <span class="icon-checkmark"></span>
                  <?php
                  }else{ ?>
                    <span class="icon-cross"></span>
                  <?php
                  }
                  ?>
                </td>
                <td style="cursor: pointer;"><span class="icon-pencil" data-toggle="modal" data-target="#modificarStatus<?php echo $resultado['id'];?>"></span></td>
                <td style="cursor: pointer;"><span class="icon-eye" data-toggle="modal" data-target="#verStatus<?php echo $resultado['id'];?>"></span></td>
              </tr>
          <?php
              }
            }
            $tropa = $resultado['tropa'];
          }
?>
              <div class="modal fade" style="z-index: 1;" id="modificarStatus<?php echo $resultado['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"    aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Modificar Status</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                      </div>
                      <form method="POST" action="status.php?accion=modificar&tropa=<?php echo $resultado['tropa']?>">
                        <div class="modal-body">
                          <div class="row-fluid">
                            <div class="span4">
                              <b>Procedimiento:</b>
                            </div>
                            <div class="span6">
                              <select name="procedimiento">
                              <option value="<?php echo $resultado['procedimiento'];?>"><?php echo $resultado['procedimiento'];?></option>
                              <option value="Metafilaxis">Metafilaxis</option>
                              <option value="1er Dosis">1er Dosis</option>
                              <option value="Refuerzo">Refuerzo</option>
                              </select>                              
                            </div>
                          </div>
                          <div class="row-fluid">
                            <div class="span4">
                              <b>Fecha Realizado:</b>
                            </div>
                            <div class="span6">
                              <input type="date" name="fechaRealizado" value="<?php echo $resultado['fechaRealizado'];?>"/>
                            </div>
                          </div>
                          <div class="row-fluid">
                            <div class="span4">
                              <b>Operario:</b>
                            </div>
                            <div class="span6">
                              <select class="form-control" id="inputOperario" name="operario">
                                <option value="">Seleccionar Operario</option> 
                              <?php
                                $sqlOp = "SELECT * FROM operarios ORDER BY nombre ASC";
                                $queryOp = mysqli_query($conexion,$sqlOp);
                                while ($filaOp = mysqli_fetch_array($queryOp)){ ?> 
                                  <option value="<?php echo $filaOp['nombre']?>"><?php echo $filaOp['nombre']?></option>  
                               <?php }
                              ?>
                                <option value="otro">Otro</option> 
                              </select>
                              <input type="text" class="form-control input-medium otroOperario" id="mostrarOperario" name="operarioOtro" value="">
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Modificar</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </form>
                    </div>
                  </div>
              </div>

              <div class="modal fade" style="z-index: 1;width:850px;margin-left: -400px;" id="verStatus<?php echo $resultado['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelStatus"    aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Status</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                      </div>
                      <div class="row-fluid">
                        <div class="span5">
                          <ul>
                            <li><b>Tropa N°: </b><?php echo $resultado['tropa'];?></li>
                            <li><b>Fecha Ingreso: </b><?php echo formatearFecha($resultado['fechaIngreso']);?></li>
                            <li><b>Status: </b><?php echo $resultado['procedimiento'];?></li>
                            <li><b>Operario: </b><?php echo $resultado['operario'];?></li>
                            <li><b>Fecha Realizado: </b><?php echo formatearFecha($resultado['fechaRealizado']);?></li>
                          </ul>
                        </div>
                        <div class="span7" style="text-align: center;">
                          <div class="row-fluid">
                            <div class="span4" style="border-bottom: solid 2px #ADADAD;"><b>Procedimiento</b></div>
                            <div class="span4" style="border-bottom: solid 2px #ADADAD;"><b>Fecha Realizado</b></div>
                            <div class="span4" style="border-bottom: solid 2px #ADADAD;"><b>Operario</b></div>
                          </div>
                            <?php
                            if ($resultado['metafilaxis'] == 1) { ?>
                            <div class="row-fluid">
                              <div class="span4" style="border-right:1px solid #A8A8A8;">
                                Metafilaxis
                              </div>
                              <div class="span4" style="border-right:1px solid #A8A8A8;">
                                <?php  echo formatearFecha($resultado['fechaMetafilaxis']); ?>
                              </div>
                              <div class="span4">
                                <?php echo $resultado['operario1'];?>
                              </div>
                            </div>
                            <?php
                            }
                            if ($resultado['vacuna'] == 1) { ?>
                            <div class="row-fluid">
                              <div class="span4" style="border-right:1px solid #A8A8A8;">
                                1er Dosis
                              </div>
                              <div class="span4" style="border-right:1px solid #A8A8A8;">
                                <?php  echo formatearFecha($resultado['fechaVacuna']); ?>
                              </div>
                              <div class="span4">
                                <?php echo $resultado['operario2'];?>
                              </div>
                            </div>
                            <?php 
                            }
                            if ($resultado['refuerzo'] == 1) { ?>
                            <div class="row-fluid">
                              <div class="span4" style="border-right:1px solid #A8A8A8;">
                                Refuerzo
                              </div>
                              <div class="span4" style="border-right:1px solid #A8A8A8;">
                                <?php  echo formatearFecha($resultado['fechaRefuerzo']); ?>
                              </div>
                              <div class="span4">
                                <?php echo $resultado['operario3'];?>
                              </div>
                            </div>
                            <?php
                            }
                          ?>
                          </div>
                        </div>
                    </div>
                  </div>
              </div>
              <?php
              }
            ?>
          </tbody>
        </table>
      </div>
      <hr>

      <footer>
        <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
      </footer>
    </div> <!-- /container -->

    <script type="text/javascript">
      $(document).ready(function(){
                $(".otroOperario").hide();
                $("#inputOperario").change(function(){
                $(".otroOperario").hide();
                var causa = $(this).val();
                if (causa == "otro") {
                    $("#mostrarOperario").show();
                }
                });
            });
    </script>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>

    
  </body>
</html>
