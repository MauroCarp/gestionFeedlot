<div class="row-fluid">
  <div class="span12">
    <h2 style="text-decoration: underline;"><b>Muertes</b></h2>
    <form name="f1" class="form-horizontal" method="POST" action="stock.php?accion=muertes"> 
      <div class="row-fluid">
        <div class="span4">
          <div class="control-group">
            <label class="control-label formulario" for="inputFechaIng">Fecha Muerte:</label>
            <div class="controls">
              <input type="date" id="inputFechaIng" name="fechaMuerte" placeholder="Fecha Muerte" autofocus required>
            </div>
          </div>           
        </div>
        <div class="span3">
          <div class="control-group">
            <label class="control-label formulario" for="inputCantMuertes">Cant. Animales:</label>
            <div class="controls">
              <input type="number" id="inputCantMuertes" class="input-small" name="muertes" placeholder="Cantidad de animales" required>
            </div>
          </div>           
        </div>
        <div class="span3">
          <div class="control-group">
            <label class="control-label formulario" for="inputCausa">Causa de Muerte:</label>
            <div class="controls">
              <select name="causaMuerte" id="selectCausaMuerte" class="form-control input-medium">
                <option value="">Seleccionar Causa Muerte</option>
                <?php
                $sqlCausa = "SELECT causa FROM causas ORDER BY causa ASC";
                $queryCausa = mysqli_query($conexion,$sqlCausa);
                while ($causa = mysqli_fetch_array($queryCausa)) { ?>

                  <option value="<?php echo $causa['causa'];?>"><?php echo $causa['causa'];?></option>
                
                <?php 
                }
                ?>
                <option value="otro">OTRO</option>
              </select>
              <input type="text" class="form-control input-medium causaMuerteOtro" id="mostrarOtra" name="causaMuerteOtro" value="">
            </div>
          </div>           
        </div>
        <button type="submit" class="btn btn-large btn-block btn-primary">Cargar</button>
      </div>
    </form>
    <ul class="totales">
      <li><b>- Total Muertes: </b><?php echo number_format($cantMuertes,0,",",".");?></li>
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

      var config = {
        type: 'pie',
        data: {
          datasets: [{
            data: [
            <?php
            $causas = getLabels($feedlot,$conexion);

            $causasCant = array();
            foreach ($causas as $key => $value) {
              $keyCausa = $value;
              $sql = "SELECT COUNT(tropa) as cantidad FROM muertes WHERE feedlot = '$feedlot' AND causaMuerte = '$value'";
              $query = mysqli_query($conexion,$sql);
              echo mysqli_error($conexion);
              $resultado = mysqli_fetch_array($query);
              $causasCant[$keyCausa] = $resultado['cantidad'];
            }

            $cantidadCausa = array();
            $labels = array();
            foreach ($causasCant as $causa => $cantidad) {
               $cantidadCausa[] = $cantidad; 
               $labels[] = "'".$causa."'";
              }
              $cantidadCausa = implode(',',$cantidadCausa);
              $labels = implode(',',$labels);
            echo $cantidadCausa;
            ?>
            ],
            backgroundColor: [
            <?php 
            $sqlCant = "SELECT COUNT(causa) AS cantidad FROM causas";
            $queryCant = mysqli_query($conexion,$sqlCant);
            $cantidad = mysqli_fetch_array($queryCant);
            $cant = $cantidad['cantidad'];
            $colores = array();
            function color_rand() {
             return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }
            for ($i=0; $i < $cant ; $i++) { 
              $colores[] = color_rand();
            }
            for ($i=0; $i < $cant ; $i++) {
              echo "'".$colores[$i]."',";
            }
            ?>
            ],
            label: 'Dataset 1'
          }],
          labels: [
          <?php
          echo $labels;
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
              <?php
              $queryCausa2 = mysqli_query($conexion,$sqlCausa);
              while ($causa2 = mysqli_fetch_array($queryCausa2)) { ?>
              <option value="<?php echo $causa2['causa'];?>"><?php echo $causa2['causa'];?></option>  
              <?php
              }
              ?>
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