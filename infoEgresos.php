<div class="row-fluid">
  
  <div class="span12">
      
      <h3>Egresos por Balanza</h3>

  </div>

  <div class="span12">

    <ul class="totales">
     
        <li><b>- Total Egresos: </b><?php echo number_format($cantEgr,0,",",".")." Animales";?></li>
     
        <li><b>- Kg Neto Engreso: </b><?php echo number_format($pesoTotalEgr,0,",",".")." Kg";?></li>

        <li><b>- Kg Egreso Promedio: </b><?php echo number_format($kgEgrProm,0,",",".")." Kg";?></li>

        <li><b>- Peso Min.: </b><?php echo number_format($kgMinEgr,0,",",".")." Kg";?></li>

        <li><b>- Peso Max.: </b><?php echo number_format($kgMaxEgr,0,",",".")." Kg";?></li>

            <span style="float:right;"><a href="imprimir/stockGeneral.php" style="font-size:18px;" class="btn btn-default" target="_blank"><span class="icon-printer iconos"></span></a></span>

     
        </li>
     
    </ul>
  
  </div>

</div>