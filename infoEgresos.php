<div class="row-fluid">
  
  <div class="span12">
      
      <h3>Ingresos por Balanza</h3>

  </div>

  <div class="span12">

    <ul class="totales">
     
        <li><b>- Total Egresos: </b><?php echo number_format($cantEgr,0,",",".")." Animales";?></li>
     
        <li><b>- Kg Neto Ingreso: </b><?php echo number_format($pesoTotalEgr,2,",",".")." Kg";?></li>

        <li><b>- Kg Egreso Promedio: </b><?php echo number_format($kgEgrProm,2,",",".")." Kg";?></li>

        <li><b>- Diferencia Kg Ing/Egr: </b><?php echo number_format($diferenciaIngEgr,2,",",".")." Kg";?>
     
            <span style="float:right;"><a href="imprimir/stockGeneral.php" style="font-size:18px;" class="btn btn-default" target="_blank"><span class="icon-printer iconos"></span></a></span>

     
        </li>
     
    </ul>
  
  </div>

</div>