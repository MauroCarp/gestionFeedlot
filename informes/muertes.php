<div class="row-fluid">

  <?php 
    if($comparacionValido){ 
  ?>
      <div class='span4'>

        <div class='totales'>

          <div class='row-fluid'>

                  <div class='span12'>

                    <b>Periodo: <?php echo formatearFecha($desde)." al ".formatearFecha($hasta); ?></b>

                  </div>

          </div>

          <div class="row-fluid">

            <div class="span6">
    
              <div class="row-fluid" style="background-color:#eeeeee">
    
                  <div class="span6"><b>- Total Muertes: </b></div>
                  <div class="span6"><span id="cantMuertes"><?php echo number_format($totalMuertes,0,",",".");?></span> Animales</div>
    
              </div>
          
            </div>
          
            <div class="span6">
    
              <div id="canvas-holder">
    
                <canvas id="chart-areaTipo"></canvas>
    
              </div>
    
            </div>
  
          </div>
  
        </div>

  </div>
  <?php
  }else{
  ?>
      <div class='span12'>    
        <div class='totales'>
  
  <?php
  }        
  ?>

  </div>

  <?php
    if ($comparacionValido) {
  ?>

  <!-- CUADRO CENTRAL -->
  <div class="span4">

      <div class="totales">

        <div class="row-fluid">
            <div class="span6"><b>- Dif. Muertes:</b></div>
            <div class="span6" id="difAnimMuertos"></div>
        </div>

        <div class="row-fluid" style="background-color:#eeeeee">
            <div class="span6"><b>- Muertes:</b></div>
            <div class="span6" id="difMuertes"></div>
        </div>

      </div>

  </div> 

  <!-- CUADRO COMPARATIVO -->
  <div class="span4">
  
    <div class="totales comparacion">
      <div class="row-fluid">
          <div class="span12"><b>Periodo: <?php echo formatearFecha($desdeComp)." al ".formatearFecha($hastaComp);?></b></div>
      </div>
      <div class="row-fluid" style="background-color:#eeeeee">
          <div class="span6"><b>- Total Muertes: </b></div>
          <div class="span6"><span id="cantMuertesComp"><?php echo number_format($totalMuertesComp,0,",",".");?></span> Animales</div>
      </div>
    </div>

  </div>
  <?php
  }
    ?>

</div>

<?php

include('includes/charts/muertes.php');

?>