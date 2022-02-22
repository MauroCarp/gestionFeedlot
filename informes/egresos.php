<div class="row-fluid">

  <div class="span4">

    <div class="totales">
        <?php 
        if($comparacionValido){
        echo 
        "<div class=\"row-fluid\">
            <div class=\"span12\">
              <b>Periodo: ".formatearFecha($desde)." al ".formatearFecha($hasta)."</b>
            </div>
          </div>";
          }
         ?>
      <div class="row-fluid">
          <div class="span6"><b>- Total Egr:</b></div>
          <div class="span6"><span id="cantEgr"><?php echo number_format($cantEgr,0,",",".");?></span> Animales</div>
      </div>
      <div class="row-fluid" style="background-color:#eeeeee">
          <div class="span6"><b>- Kg Neto Egr:</b></div>
          <div class="span6"><?php echo formatearNum($totalPesoEgr)." Kg";?></div>
      </div>
      <div class="row-fluid">
          <div class="span6"><b>- Kg Egr. Prom:</b></div>
          <div class="span6"><?php echo formatearNum($kgEgrProm)." Kg";?></div>
      </div>
      
      <div class="row-fluid"  style="background-color:#eeeeee">
          <div class="span6"><b>- Kg Min. Prom:</b></div>
          <div class="span6"><?php echo formatearNum($kgMinEgr)." Kg";?></div>
      </div>

      <div class="row-fluid">
          <div class="span6"><b>- Kg Max. Prom:</b></div>
          <div class="span6"><?php echo formatearNum($kgMaxEgr)." Kg";?></div>
      </div>

      <!-- <div class="row-fluid" style="background-color:#eeeeee">
          <div class="span6"><b>- Dif. Kg Ing/Egr:</b></div>
          <div class="span6"><?php echo formatearNum($diferenciaIngEgr)." Kg";?></div>
      </div> -->

    </div>

  </div>
    <?php
    if (!$comparacionValido) { ?>

      <div class="span2">
      </div>  

      <div class="span5">

        <div id="canvas-holder" style="width:100%">
          <canvas id="chart-areaPesosEgr"></canvas>
        </div>

        <div class="row-fluid">
          
          <div class="span4"></div>
          
          <div class="span2">
            <input type="number" class="input-mini" id="pesoDesdeEgr" value="0" onblur="calculaCPS('Egr')">
          </div>

          <div class="span2">
            <input type="number" class="input-mini" id="pesoHastaEgr" value="0" onblur="calculaCPS('Egr')">
          </div>

          <div class="span4"></div>

        </div>

        <div class="row-fluid">

          <div class="span12" style="text-align: center;">
            <button class="btn btn-secondary" id="calcularCantEgr" value="">Calcular</button>
          </div>

        </div>

      </div>

    <?php
    }
    ?>
    <?php
    if ($comparacionValido) {
      ?>
  <div class="span4">
      <div class="totales">
        <div class="row-fluid">
            <div class="span6"><b>- Dif. Animales:</b></div>
            <div class="span6" id="difAnimEgr"></div>
        </div>
        <div class="row-fluid" style="background-color:#eeeeee">
            <div class="span6"><b>- Egresos:</b></div>
            <div class="span6" id="difEgr"></div>
        </div>
      </div>
    </div> 
  <div class="span4">
    <div class="totales comparacion">
      <div class="row-fluid">
          <div class="span12"><b>Periodo: <?php echo formatearFecha($desdeComp)." al ".formatearFecha($hastaComp);?></b></div>
      </div>

      <div class="row-fluid">
          <div class="span6"><b>- Total Egr:</b></div>
          <div class="span6"><span id="cantEgrComp"><?php echo number_format($cantEgrComp,0,",",".");?></span> Animales</div>
      </div>

      <div class="row-fluid" style="background-color:#eeeeee">
          <div class="span6"><b>- Kg Neto Egr:</b></div>
          <div class="span6"><?php echo formatearNum($totalPesoEgrComp)." Kg";?></div>
      </div>

      <div class="row-fluid">
          <div class="span6"><b>- Kg Egr. Prom:</b></div>
          <div class="span6"><?php echo formatearNum($kgEgrPromComp)." Kg";?></div>
      </div>

      <div class="row-fluid">
          <div class="span6"><b>- Kg Min. Prom:</b></div>
          <div class="span6"><?php echo formatearNum($kgMinEgr)." Kg";?></div>
      </div>

      <div class="row-fluid">
          <div class="span6"><b>- Kg Max. Prom:</b></div>
          <div class="span6"><?php echo formatearNum($kgMinEgr)." Kg";?></div>
      </div>
<!-- 
      <div class="row-fluid" style="background-color:#eeeeee">
          <div class="span6"><b>- Dif. Kg Ing/Egr:</b></div>
          <div class="span6"><?php //echo formatearNum($diferenciaIngEgrComp)." Kg";?></div>
      </div> -->

    </div>
  </div>

      <?php
    }
    ?>
</div>
<?php
include('includes/charts/egresos.php');
?>