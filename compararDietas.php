<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
require("includes/arrays.php");

$id = $_GET['id'];

$sqlComparar = "SELECT * FROM formulas WHERE id = '$id'";

$queryComparar = mysqli_query($conexion,$sqlComparar);

$fila = mysqli_fetch_array($queryComparar);

$id = $fila['id'];

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

    <link href="css/miselect.css" rel="stylesheet">

    <style type="text/css">

      body {
        padding-top: 60px;
        padding-bottom: 10px;
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

      <h1 style="display: inline-block;">RACIONES</h1>

      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>

      <div class="hero-unit" style="padding-top: 10px;margin-bottom: 5px;">
      
        <h2 class="modal-title" id="modalFormula">Formula <?php echo $fila['tipo']." - ".$fila['nombre'];?></h2>

        <div id="dieta">

          <div class="row-fluid">

            <div class="span12">

              <b>
              Composici&oacute;n de la dieta | Precio por Kilo: $
              
              <span id="precioKiloComp<?php echo $fila['id'];?>">

              </span> 
              
              | Precio por Kilo MS: $ 
              
              <span id="precioMSComp<?php echo $fila['id'];?>"> 
                
              
              </span> 
              
              | Total % de MS: 
              
              <span id="totalPorMSComp<?php echo $fila['id'];?>"></span>
              
              %</b>
              
              <br>

              <b>Fecha Realizada: <?php echo formatearFecha($fila['fecha']);?></b>  

            </div>

          </div>

          <div class="row-fluid" style="border-bottom: 2px solid #7D7D7D">
            <div class="span2"><b>Producto</b></div>

            <div class="span2"><b>% en la Dieta</b></div>

            <div class="span2"><b>% MS</b></div>

            <div class="span1" style="line-height:1em;"><b>Precio Insumo</b></div>

            <div class="span1" style="line-height:1em;"><b>$/Kg MS</b></div>

            <div class="span2"><b>% MS Insumo</b></div>
            
            <div class="span2"><b>% MS en la Dieta</b></div>
          
          </div>
          
          <div class="row-fluid" style="border-bottom: 1px solid #7D7D7D">

          <div class="span2">
                          
                          <?php 
                          
                              $nombreInsumo = nombreInsumo('p1',$fila['p1'],$conexion);

                              $tipo = obtenerTipoInsumo($nombreInsumo,$conexion);

                              if ($tipo == 'Premix') {
                                
                                echo 'Premix '.utf8_encode($nombreInsumo);

                              }else{

                                echo utf8_encode(nombreInsumo('p1',$fila['p1'],$conexion));

                              }

                            ?>
                        
                        </div>

                        <div class="span2">
                        
                          <span class="porceComp<?php echo $id;?>" id="porceComp<?php echo $id."_1"; ?>"><?php echo number_format($fila['por1'],2,",",".");?></span> %
                        
                        </div>

                        <div class="span2 porcentajesMSComp<?php echo $id;?>" id="porceMS<?php echo $id;?>">
                        
                          <?php 
                          
                          $porcentajeMS = porceMS($fila['p1'],$fila['por1'],$conexion);

                          echo number_format($porcentajeMS,2,",",".")." %";

                          ?>
                          
                        </div>

                        <div class="span1 preciosInsumosComp<?php echo $id;?>">
                        
                          <?php
                          
                          $precioInsumo = precioInsumo('p1',$fila['p1'],$conexion);

                          echo "$ ".number_format($precioInsumo,2,",",".");
                          
                          ?>
                          
                        </div>

                        <div class="span1 precioKgMSComp<?php echo $id;?>">
                        <?php
                          $porMS = obtenerMSinsumo($fila['p1'],$conexion);
                          
                          $precioKgMS = (100 * $precioInsumo) / $porMS;

                          echo "$ ".number_format($precioKgMS,2,',','.');        
                          
                        ?>
                        </div>

                        <div class="span2 porcMS<?php echo $id;?>_0" style="text-align:center;">
                        
                          <?php 

                            echo $porMS." %";
                          
                          ?>
                        
                        </div>

                        <div class="span2 totalMS<?php echo $id;?>" id="totalMS<?php echo $id;?>_1" style="text-align:center;">

                        </div>

                      </div>

                      <?php 
                      for ($i=1; $i < 11 ; $i++) { 

                        $producto = "p".($i+1);

                        $porcentaje = "por".($i+1);

                        if($fila[$producto] != ''){ 

                          $precioInsumo = precioInsumo($producto,$fila[$producto],$conexion);

                          $porcentajeMS = tomaPorcentajeMS($producto,$fila[$producto],$conexion);

                          ?>

                          <div class="row-fluid" style="border-bottom: 1px solid #7D7D7D">

                            <div class="span2">
                            <?php 
                            
                              $nombreInsumo = nombreInsumo($producto,$fila[$producto],$conexion);

                              $tipo = obtenerTipoInsumo($nombreInsumo,$conexion);

                              if ($tipo == 'Premix') {
                                
                                echo 'Premix '.utf8_encode($nombreInsumo);

                              }else{

                                echo utf8_encode(nombreInsumo($producto,$fila[$producto],$conexion));

                              }
                            
                            ?>
                            
                            </div>

                            <div class="span2"><span class="porceComp<?php echo $id;?>" id="porceComp<?php echo $id."_".($i+1); ?>"><?php echo formatearNum($fila[$porcentaje]);?></span> %</div>

                            <div class="span2 porcentajesMSComp<?php echo $id;?>" id="porceMS<?php echo $id;?>"><?php echo formatearNum(porceMS($fila[$producto],$fila[$porcentaje],$conexion));?> %</div>

                            <div class="span1 preciosInsumosComp<?php echo $id;?>"><?php echo "$ ".number_format($precioInsumo,2,",",".");?></div>

                            <div class="span1 precioKgMSComp<?php echo $id;?>">
                            <?php 
                              
                              ${"porMS".($i+1)} = obtenerMSinsumo($fila[$producto],$conexion);

                              $precioKgMS = (100 * $precioInsumo) / ${"porMS".($i+1)};

                              echo "$ ".number_format($precioKgMS,2,',','.');        

                            ?>
                            </div>

                            <div class="span2 porcMS<?php echo $id."_".$i;?>" style="text-align:center;"><?php
                            ${"porMS".($i+1)} = obtenerMSinsumo($fila[$producto],$conexion);

                            echo ${"porMS".($i+1)}." %";?></div>

                            <div class="span2 totalMS<?php echo $id;?>" id="totalMS<?php echo $id;?>_<?php echo ($i + 1);?>" style="text-align:center;">

                            </div>
                          </div>
                      <?php  }
                      }
                      ?>

          <div class="row-fluid">

            <div class="span5" style="font-size: .6em;">

              <p>*Valores en base a 1 Kilo de Formula.</p>

            </div>

          </div>

         <hr>


         <!-- LISTADO COMPARATIVO -->
        <?php

        // CARGAR NUEVO

        include('modificarFormula.php');   

        ?>
      </div>

      <hr>
      <footer>
        <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
      </footer>
    </div>


    <!-- Le javascript
    ================================================== -->
    <script type="text/javascript" async="async">
  
      $(document).ready(function(){

        // SE LE ASIGNA LAFUNCION SELECT2 a todos LOS SELECTS

        $('.productos').each(function(){

          $(this).select2();
          
        });

        // SE CARGA LA INFO DE MS A LA DIETA

        let id = getQueryVariable('id');
              
        let totalPrecioMF = calcularPrecioKgMF(id,'Comp');
        
        $('#precioKiloComp' + id).html(totalPrecioMF.toFixed(2));
        
        let precioKgMS = calcularPrecioKgMS(id,'Comp');

        $('#precioMSComp' + id).html(precioKgMS.toFixed(2)); 

        let porcentajeTotalMSDieta = calcularPorcentajeTotalMS(id,'Comp');
        
        $("#totalPorMSComp" + id).text(porcentajeTotalMSDieta.toFixed(2).replace(".",","));
       
        calcularPorcentajeMSDieta(calcularTotalPorcentajeMS(id,'Comp'),id,'Comp');

        // SE PASA DE MODIFICAR FORMULA A CARGAR FORMULA

        $('.botonCarga').html('Cargar Formula');

        $('#cabeceraFormula').html('<b>Comparar Formulas</b>');

        $('#cargaFormula').attr('action','raciones.php?accion=nuevaFormula');

        // SE MODIFICAN PARAMETROS PARA Q NO INTERFIERAN LOS ID O CLASES

        // $('#precioKilo' + idFormula).attr('id','precioKilo');

        // $('#totalPorMS' + idFormula).attr('id','totalPorMS');

        // var totalPMS = 0;

        // $(".totalPorMS").each(function(){

        //   var pMS = $(this).text();
          
        //   pMS = $.trim(pMS);
          
        //   pMS = parseFloat(pMS.substring(0,5).replace(",","."));
          
        //   totalPMS = pMS + totalPMS;

        // });

        // $('#totalPorMS').html(totalPMS.toFixed(2));

        // $('.totalPorMS').removeClass().addClass('totalPorMS').addClass('span2');


        // SE CARGA EL PRECIO POR KILO
        // var precioTotalMF = 0;

        // var arrayPorcentajesMF = [];

        // var arrayPreciosInsumos = [];

        // $('.porcentajesMF').each(function(){

        //   var porceMF = $(this).text();

        //   porceMF = $.trim(porceMF);
                      
        //   porceMF = porceMF.replace(',','.');
                
        //   porceMF = parseFloat(porceMF);

        //   arrayPorcentajesMF.push(porceMF);

        //   $(this).removeClass().addClass('porcentajesMF');


        // });

        // $('.precioMF').each(function(){

        //   var precioMF = $(this).text();
            
        //   precioMF = $.trim(precioMF);

        //   precioMF = precioMF.substring(2,6).replace(',','.');
          
        //   precioMF = parseFloat(precioMF);
          
        //   arrayPreciosInsumos.push(precioMF);

        // });

        // for (let index = 0; index < arrayPorcentajesMF.length; index++) {

        //   precioTotalMF += (arrayPorcentajesMF[index] * arrayPreciosInsumos[index]) / 100;

        // }



        // $('#precioKilo').html(precioTotalMF.toFixed(2));


        // SE RESETEA EL NOMBRE DE LA NUEVA FORMULA

        $("input[name='nombre']").val('');

      });


    </script>           
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/formulas.js"></script>
    <script src="js/miselect.js"></script>

  </body>
</html>
