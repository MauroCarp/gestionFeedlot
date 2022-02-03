<h3 style="text-decoration: underline;cursor: pointer;" id="abrirBalanza"><b>Balanza</b></h3>
<div id="cargaBalanza">
  <form name="f1" class="form-horizontal" method="POST" action="subirMuertes.php" enctype="multipart/form-data"> 
            <div class="row-fluid">

              <div class="span2">
                <label for="file-uploadMuertes" class="btn btn-primary btn-block">
                    <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo
                </label>
                <input id="file-uploadMuertes" onchange="cambiar('file-uploadMuertes','infoMuertes')" type="file" name="fileMuertes" style='display: none;' required/>
              </div>
              
              <div class="span3" id="infoMuertes" style="text-align: left;font-weight: bold;">No se eligi&oacute; archivo.</div>

              <div class="span5">
                <div class="control-group"> 
                  <label class="control-label formulario" for="inputCausa">Causa de Muerte:</label>
                  <div class="controls">
                    <select name="causaMuerte" id="selectCausaMuerte" class="form-control input-large">
                        
                        <option value="">Seleccionar Causa Muerte</option>
                        <option value="Accidente">Accidente</option>
                        <option value="Digestivo">Digestivo</option>
                        <option value="Ingreso">Ingreso</option>
                        <option value="Nervioso">Nervioso</option>
                        <option value="Rechazo">Rechazo</option>
                        <option value="Respiratorio">Respiratorio</option>
                        <option value="Sin Diagnostico">Sin Diagnostico</option>
                        <option value="Sin Hallazgo">Sin Hallazgo</option>
                        <option value="Otro">Otro</option>

                    </select>
                  </div>
                </div>           
              </div>

              <div class="span1">
                <input type="submit" class="btn btn-primary btn-block" name="submitIng" value="Cargar" required="TRUE" />
              </div>
            </div>
  </form>
</div>
    <ul class="totales"  style="padding-top:10px;margin-bottom:10px;">
      <li><b>- Total Muertes: </b><?php echo number_format($cantMuertes,0,",",".");?>
      <span style="float:right;"><a href="imprimir/stockGeneral.php" style="font-size:18px;" class="btn btn-primary btn-large" target="_blank">Imprimir</a></span>
      </li>
      <li>&nbsp</li>
    </ul>
    <div id="canvas-holder" style="width:60%;margin:0 auto;">
      <canvas id="chart-area"></canvas>
    </div>
    <script>
      function getRandomColor() {
      var letters = '0123456789ABCDEF';
      var color = '#';
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }
    <?php
      $cantidadCausa = array();
      $cantidadCausa['Accidente'] = cantidadCausa($feedlot,$conexion,'Accidente');
      $cantidadCausa['Digestivo'] = cantidadCausa($feedlot,$conexion,'Digestivo');
      $cantidadCausa['Ingreso'] = cantidadCausa($feedlot,$conexion,'Ingreso');
      $cantidadCausa['Nervioso'] = cantidadCausa($feedlot,$conexion,'Nervioso');
      $cantidadCausa['Rechazo'] = cantidadCausa($feedlot,$conexion,'Rechazo');
      $cantidadCausa['Respiratorio'] = cantidadCausa($feedlot,$conexion,'Respiratorio');
      $cantidadCausa['Sin Diagnostico'] = cantidadCausa($feedlot,$conexion,'Sin Diagnostico');
      $cantidadCausa['Sin Hallazgo'] = cantidadCausa($feedlot,$conexion,'Sin Hallazgo');
      $cantidadCausa['Otro'] = cantidadCausa($feedlot,$conexion,'Otro');


    ?>
      var config = {
        type: 'pie',
        data: {
          datasets: [{
            data: [
              <?php

                echo "'".$cantidadCausa['Accidente']."','".$cantidadCausa['Digestivo']."','".$cantidadCausa['Ingreso']."','".$cantidadCausa['Nervioso']."','".$cantidadCausa['Rechazo']."','".$cantidadCausa['Respiratorio']."','".$cantidadCausa['Sin Diagnostico']."','".$cantidadCausa['Sin Hallazgo']."','".$cantidadCausa['Otro']."'";

              ?>  
            ],

            backgroundColor: [
            <?php 
            function color_rand() {
             return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }
            echo "'".color_rand()."','".color_rand()."','".color_rand()."','".color_rand()."','".color_rand()."','".color_rand()."','".color_rand()."','".color_rand()."','".color_rand()."'";
            ?>
            ],
            label: 'Dataset 1'
          }],
          labels: [
          <?php
            echo "'Accidente','Digestivo','Ingreso','Nervioso','Rechazo','Respiratorio','Sin Diagnostico','Sin Hallazgo','Otro'";
            ?>
          ]
        },
        options: {
          responsive: true,
          legend: {
            position: 'right',
          },
        }
      };

      window.onload = function() {
        var ctx = document.getElementById('chart-area').getContext('2d');
        window.myPie = new Chart(ctx, config);
      };
    </script>
    <button class="btn btn-secondary" id="filtrosM" style="margin: 10px 0;"><b>Filtros</b> <span class="icon-filter"></span></button>
    <div id="contFiltrosM">
        <div class="row-fluid" style="margin-bottom: 10px;">
          <div class="span2">
            <b style="font-size: .8em;">Desde:</b>
            <input type="date" id="desdeM">
          </div> 
          <div class="span2">
            <b style="font-size: .8em;">Hasta:</b>
            <input type="date" id="hastaM">
          </div>
          <div class="span1">
            <b style="font-size: .8em;"><span class="icon-arrow-up"></span>&nbsp;&nbsp;<span class="icon-arrow-down"></span></b><br>
            <input type="radio" name="ordenM" id="ordenAsc" value="ASC" checked>&nbsp;&nbsp;<input type="radio" name="ordenM" id="ordenDesc" value="DESC">
          </div>
          <div class="span2">
            <b style="font-size: .8em;">Causa:</b>
            <select id="causa" class="input-medium">
              <option value="">Causa de Muerte</option>
              <option value="">Otro</option>

            </select>
          </div>
          <div class="span1">
            <br>
            <button id="filtrarEgr" class="btn btn-secondary" onclick="filtrarM()"><b>Filtrar</b></button>
          </div>
          <div class="span1">
            <br>
            <button id="reset" class="btn btn-secondary" onclick="reset('Muertes')"><b>Reset</b></button>
          </div>
        </div>
      </div>   
      <div id="contenedorMuertes"></div>
      <div id="myTableMuertes">
        <table class="table table-striped" style="box-shadow: 1px -2px 15px 1px;">
          <thead>
            <tr>
              <th scope="col">Fecha Muerte</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Causa Muerte</th>
              <td scope="col"></td>
            </tr>
          </thead>
          <tbody id="paginadoMuertes">
            <script>
              cargaMuertes();
            </script>
          </tbody>
        </table>
        <div class="pagination pagination-mini pagination-centered">
        <ul>
          <?php
          echo paginador('registromuertes',$feedlot,$conexion);
          ?>
        </ul>
      </div>
      </div>
  </div>
</div>