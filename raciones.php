<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
include("includes/arrays.php");

include('raciones.backend.php');

include('head.php');
?>

<div class="container" style="padding-top: 50px;">

      <h1 style="display: inline-block;">Raciones</h1>

      <h4 style="display: inline-block;: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>

      <hr style="padding:0;margin-top:0;">

      <div class="hero-unit" style="padding-top: 10px;">

        <div class="bs-docs-example">

          <ul id="myTab" class="nav nav-tabs">

            <li <?php if($seccion == 'ingreso' OR $seccion == ''){ echo "class=\"active\"";}?>><a href="#ingresos" data-toggle="tab" class="labels">Ingreso</a></li>

            <li <?php if($seccion == 'insumos'){ echo "class=\"active\"";}?>><a href="#insumos" data-toggle="tab" class="labels">Insumos</a></li>

            <li <?php if($seccion == 'formulas'){ echo "class=\"active\"";}?>><a href="#formulas" data-toggle="tab" class="labels">Formulas</a></li>

            <li <?php if($seccion == 'premix'){ echo "class=\"active\"";}?>><a href="#premix" data-toggle="tab" class="labels">Premix</a></li>

            <li <?php if($seccion == 'mixer'){ echo "class=\"active\"";}?>><a href="#mixer" data-toggle="tab" class="labels">Mixer</a></li>

          </ul>

          <div id="myTabContent" class="tab-content">

            
            <div class="tab-pane fade <?php if($seccion == 'insumos'){ echo 'active in';}?>" id="insumos">

              <?php include("insumos.php");?>

            </div>


            <div class="tab-pane fade <?php if($seccion == 'formulas'){ echo 'active in';}?>" id="formulas">

              <?php 
              if ($accionValido) {

                if ($accion == "modificar") {

                  $id = $_GET['id'];

                  include("modificarFormula.php");

                }

              }else{

                include("formulas.php");

              }

              ?>

            </div>

            <div class="tab-pane fade <?php if($seccion == 'mixer'){ echo 'active in';}?>" id="mixer">

            <?php include("mixer.php");?>

            </div>
            
            <div class="tab-pane fade <?php if($seccion == 'premix'){ echo 'active in';}?>" id="premix">

            <?php 
            
            if ($accionValido) {
              
              if ($accion == "modificarPremix") {
                
                $id = $_GET['id'];
                
                include("modificarPremix.php");
                
              }
              
            }else{
              
              include("premix.php");

            }
            
            ?>

            </div>
           
            <div class="tab-pane fade <?php if($seccion == 'ingreso' OR $seccion == ''){ echo 'active in';}?>" id="ingresos">

              <?php include("ingresoRacion.php");?>

            </div>

          </div>
        </div>
      </div>
    <hr>
    <footer>
      <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
    </footer>
    </div> <!-- /container -->

  <script type="text/javascript">

        var mixer = (document).getElementById('selectMixer');
        
        mixer.addEventListener('change',()=>{

          var tipoMixer = $('#selectMixer').val();

          if(tipoMixer == 'mixer2'){

            $('#mixer2cantidad').css('display','block');

            $('form').attr('action','ingresoMixer2.php');

          }else{

            $('form').attr('action','ingresoMixer1.php');

            $('#mixer2cantidad').css('display','none');


          }

        });

        $('.collapse').css('display','block');
        

        $(document).ready(function() {
            $('.mi-selector').select2();
        });
        
    </script>    

  </body>
</html>
