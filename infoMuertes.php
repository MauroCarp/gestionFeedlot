<div class="row-fluid">
    
    <div class="span12">

      <h3>Totales</h3>
   
    </div>
    
    <div class="span12">
      
      <ul class="totales"  style="padding-top:10px;margin-bottom:10px;">
        
        <li><b>- Total Muertes: </b><?php echo number_format($cantMuertes,0,",",".");?>
        
          <!-- <span style="float:right;"><a href="imprimir/stockGeneral.php" style="font-size:18px;" class="btn btn-default btn-large" target="_blank"><span class="icon-printer iconos"></span></a></span> -->
        
        </li>

        <li>
        
          <div id="canvas-holder">
        
            <canvas id="chart-area"></canvas>
        
          </div>
        
        </li>
        
      </ul>

    </div>

</div>
