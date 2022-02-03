<div class="row-fluid">
  <div class="span4">
    <div class="totales">
        <?php 
        if($comparacionValido){
        echo 
        "<div class=\"row-fluid\">
            <div class=\"span12\">
              <b>Periodo: ".formatearFecha($desde)." al ".formatearFecha($hasta)."
            </b></div>
          </div>";
          }
         ?>
      <div class="row-fluid">
          <div class="span6"><b>- Total Ing:</b></div>
          <div class="span6"><span id="cantIng"><?php echo number_format($cantIng,0,",",".");?></span> Animales</div>
      </div>
      <div class="row-fluid" style="background-color:#eeeeee">
          <div class="span6"><b>- Kg Neto Ing:</b></div>
          <div class="span6"><?php echo formatearNum($totalPesoIng)." Kg";?></div>
      </div>
      <div class="row-fluid">
          <div class="span6"><b>- Kg Ing. Prom:</b></div>
          <div class="span6"><?php echo formatearNum($kgIngProm)." Kg";?></div>
      </div>
      <div class="row-fluid" style="background-color:#eeeeee">
          <div class="span6"><b>- Dif. Kg Ing/Egr:</b></div>
          <div class="span6"><?php echo formatearNum($diferenciaIngEgr)." Kg";?></div>
      </div>
    </div>
  </div>
    <?php
    if (!$comparacionValido) { ?>
    <div class="span2">
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
    <?php
    }
    if ($comparacionValido) {
      ?>
    <div class="span4">
      <div class="totales">
        <div class="row-fluid">
            <div class="span6"><b>- Dif. Animales:</b></div>
            <div class="span6" id="difAnimIng"></div>
        </div>
        <div class="row-fluid" style="background-color:#eeeeee">
            <div class="span6"><b>- Ingresos:</b></div>
            <div class="span6" id="difIng"></div>
        </div>
      </div>
    </div> 
    <div class="span4">
      <div class="totales comparacion">
        <div class="row-fluid">
            <div class="span12"><b>Periodo: <?php echo formatearFecha($desdeComp)." al ".formatearFecha($hastaComp);?></b></div>
        </div>
        <div class="row-fluid">
            <div class="span6"><b>- Total Ing:</b></div>
            <div class="span6"><span id="cantIngComp"><?php echo number_format($cantIngComp,0,",",".");?></span> Animales</div>
        </div>
        <div class="row-fluid" style="background-color:#eeeeee">
            <div class="span6"><b>- Kg Neto Ing:</b></div>
            <div class="span6"><?php echo formatearNum($totalPesoIngComp)." Kg";?></div>
        </div>
        <div class="row-fluid">
            <div class="span6"><b>- Kg Ing. Prom:</b></div>
            <div class="span6"><?php echo formatearNum($kgIngPromComp)." Kg";?></div>
        </div>
        <div class="row-fluid" style="background-color:#eeeeee">
            <div class="span6"><b>- Dif. Kg Ing/Egr:</b></div>
            <div class="span6"><?php echo formatearNum($diferenciaIngEgrComp)." Kg";?></div>
        </div>
      </div>
    </div>
 <?php
    }
    ?>
  </div>
<?php
include('includes/charts/ingreso.php');
?>