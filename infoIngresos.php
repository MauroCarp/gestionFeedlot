<div class="row-fluid">
    
    <div class="span12">
    
        <h3>Ingresos por Balanza</h3>
   
     </div>
    
     <div class="span12">

        <ul class="totales" style="background-color:transparent!important;">

            <li><b>- Total Ingresos: </b><?php echo number_format($cantIng,0,",",".")." Animales";?></li>

            <li><b>- Kg Neto Ingreso: </b><?php echo number_format($pesoTotalIng,2,",",".")." Kg";?></li>

            <li><b>- Kg Ingreso Promedio: </b><?php echo number_format($kgIngProm,2,",",".")." Kg";?></li>
            
            <li><b>- Diferencia Kg Ing/Egr: </b><?php echo number_format($diferenciaIngEgr,2,",",".")." Kg";?>

                <span style="float:right;"><a href="imprimir/stockGeneral.php" style="font-size:18px;" class="btn btn-default" target="_blank"><span class="icon-printer iconos"></span></a></span>

            </li>

        </ul>
                
    </div>

</div>

