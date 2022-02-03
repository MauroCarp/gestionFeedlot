<div class="row-fluid">
  <div class="span12">
    <h3 style="text-decoration: underline;"><b>Egresos</b></h3>
    <form name="f1" class="form-horizontal" method="POST" action="subirEgreso.php" enctype="multipart/form-data"> 
      <div class="row-fluid">
        <div class="span2">
          <label for="file-uploadEgr" class="btn btn-primary btn-block">
              <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo
          </label>
          <input id="file-uploadEgr" onchange="cambiar('file-uploadEgr','infoEgr')" type="file" name="fileEgr" style='display: none;' required/>
        </div>
        <div class="span3" id="infoEgr" style="text-align: left;font-weight: bold;">No se eligi&oacute; archivo.</div>
        <div class="span3">
          <input type="submit" class="btn btn-primary btn-block" name="submitEgr" value="Cargar"/>
        </div>
      </div>
    </form>
    <ul class="totales">
      <li><b>- Total Egresos: </b><?php echo number_format($cantEgr,0,",",".")." Animales";?></li>
      <li><b>- Kg Neto Ingreso: </b><?php echo number_format($pesoTotalEgr,2,",",".")." Kg";?></li>
      <li><b>- Kg Egreso Promedio: </b><?php echo number_format($kgEgrProm,2,",",".")." Kg";?></li>
      <li><b>- Diferencia Kg Ing/Egr: </b><?php echo number_format($diferenciaIngEgr,2,",",".")." Kg";?>
      <span style="float:right;"><a href="imprimir/stockGeneral.php" style="font-size:18px;" class="btn btn-primary btn-large" target="_blank">Imprimir</a></span>
      </li>
      <li>&nbsp</li>
    </ul>
    <button class="btn btn-secondary" id="filtrosEgr" style="margin: 10px 0;"><b>Filtros</b> <span class="icon-filter"></span></button>
      <div id="contFiltrosEgr">
        <div class="row-fluid" style="margin-bottom: 10px;">
          <div class="span2">
            <b style="font-size: .8em;">Desde:</b>
            <input type="date" id="desdeEgr">
          </div> 
          <div class="span2">
            <b style="font-size: .8em;">Hasta:</b>
            <input type="date" id="hastaEgr">
          </div>
          <div class="span1">
            <b style="font-size: .8em;"><span class="icon-arrow-up"></span>&nbsp;&nbsp;<span class="icon-arrow-down"></span></b><br>
            <input type="radio" name="ordenEgr" id="ordenAsc" value="ASC" checked>&nbsp;&nbsp;<input type="radio" name="ordenEgr" id="ordenDesc" value="DESC">
          </div>
          <div class="span2">
            <b style="font-size: .8em;">Destino:</b>
            <select id="destino" class="input-medium">
              <option value="">Seleccione Destino</option>
              <?php
              
              $sqlDestino = "SELECT DISTINCT destino FROM egresos ORDER BY destino ASC";

              if($feedlot == 'Acopiadora Pampeana'){
  
                $sqlDestino = "SELECT DISTINCT destino FROM registroegresos ORDER BY destino ASC";
              
              }

              $queryDestino = mysqli_query($conexion,$sqlDestino);
              $destinos = array();
              $destinoTemp = "";
              while ($destino = mysqli_fetch_array($queryDestino)) {
                if ($destinoTemp != $destino['destino']) {
                  $destinos[] = $destino['destino'];
                }
                $destinoTemp = $destino['destino'];
              }
              for ($i=0; $i < sizeof($destinos) ; $i++) { ?>
                <option value="<?php echo $destinos[$i];?>"><?php echo strtoupper($destinos[$i]);?></option>  
              <?php
              }
              ?>
            </select>
          </div>
          <div class="span1">
            <br>
            <button id="filtrarEgr" class="btn btn-secondary" onclick="filtrarEgr()"><b>Filtrar</b></button>
          </div>
          <div class="span1">
            <br>
            <button id="reset" class="btn btn-secondary" onclick="reset('Egresos')"><b>Reset</b></button>
          </div>
        </div>
      </div>   
      <div id="contenedorEgresos"></div>
    <table class="table table-striped" id="myTableEgresos" style="box-shadow: 1px -2px 15px 1px;">
      <thead>
        <tr>
          <th>Fecha Egreso</th>
          <th>Cantidad</th>
          <th>Peso Prom.</th>
          <th>GMD Prom</th>
          <th>GPV Prom</th>
          <td></td>
          <td></td>
        </tr>
      </thead>
      <tbody id="paginadoEgr">
        <script>
          cargaEgresos();
        </script>
      </tbody>
    </table>
    <div class="pagination pagination-mini pagination-centered">
        <ul>
          <?php
          echo paginador('registroegresos',$feedlot,$conexion);
          ?>
        </ul>
      </div>
  </div>
</div>