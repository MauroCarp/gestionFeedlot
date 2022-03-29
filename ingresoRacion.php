<div class="row-fluid">

      <div class="span5" style="padding-right:25px;border-right: solid 1px black">

        <form method="POST" class="form-horizontal" action="ingresoMixer1.php" enctype="multipart/form-data">              
          
          <div class="row-fluid">

            <div class="span6">

              <label for="file-uploadIng" class="btn btn-primary" style="font-size:1em;">

                  <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo

              </label>

              <input id="file-uploadIng" onchange="cambiar('file-uploadIng','infoIng')" type="file" name="file" style='display: none;' required/>

            </div>
            
            <div class="span6">
            
              <div id="infoIng" style="text-align: left;font-weight: bold;">No se eligi&oacute; archivo.</div>
            
            </div>

          </div> 

          <br>

          <div class="row-fluid">
            
            <div class="span6">

              <label for="selectMixer" style="font-size:1.3em;line-height:1.5em;"><b>Seleccionar Mixer:</b></label>

            </div>
            
            <div class="span6">
            
              <select name="mixer" id='selectMixer'>

                <option value="mixer1">456ST</option>

                <option value="mixer2">Autoconsumo</option>

              </select>
            
            </div>
              
          </div>

          <br>

          <div class="row-fluid">
          
            <div class="span3" id="mixer2cantidad" style="display:none">

              <label for="cantidad"><b>Cantidad de Animales</b></label>

              <input type="number" id="cantidad" name="cantidad" maxlength="4" size="4">

            </div>
            
          </div>

          <div class="row-fluid">

            <div class="span12">

              <button type="submit" name="submit" class="btn btn-large btn-block btn-primary" accept=".xls,.xlsx">Cargar Registro</button>

            </div>

          </div>

        </form>

      </div>

      <div class="span6" style="padding-top:0;margin-top:0">
        
        <table class="table table-striped">
          <thead>
          
            <th>Op. N°</th>

            <th>Fecha</th>

            <th></th>
            
          </thead>
          <tbody>

          <?php

            $fechaOperaciones = array();

            $sqlCargas = "SELECT DISTINCT(fecha) as fecha FROM mixer_cargas ORDER BY fecha DESC";
            
            $queryCargas = mysqli_query($conexion,$sqlCargas);
            
            while($cargas = mysqli_fetch_array($queryCargas)){
              
              $fecha = $cargas['fecha'];

              $fechaOperaciones[] = $fecha;

            }

            $sqlDescargas = "SELECT DISTINCT(fecha) as fecha FROM mixer_descargas ORDER BY fecha DESC";
            
            $queryDescargas = mysqli_query($conexion,$sqlDescargas);
            
            while($descargas = mysqli_fetch_array($queryDescargas)){
              
              $fecha = $descargas['fecha'];

              $fechaOperaciones[] = $fecha;

            }

            $fechaOperaciones = array_unique($fechaOperaciones);
            $fechaOperaciones = array_values($fechaOperaciones);

            ?>




        
        <?php

        $num_items_by_page = 7;
        $total_rows = sizeof($fechaOperaciones);

        if ($total_rows > 0) {

            $page = false;
        
            //examino la pagina a mostrar y el inicio del registro a mostrar
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
            }
        
            if (!$page) {
                $start = 0;
                $page = 1;
            } else {
                $start = ($page - 1) * $num_items_by_page;
            }
            //calculo el total de paginas
            $total_pages = ceil($total_rows / $num_items_by_page);
        
            for ($a=$start; $a < ($start + $num_items_by_page) ; $a++) { 

              if(isset($fechaOperaciones[$a])){
               
                echo "
                <tr>

                  <td>".($a+1)."</td>
                  
                  <td><b>".formatearFecha($fechaOperaciones[$a])."</b></td>

                  <td>

                    <a href='verOperacion.php?fecha=".$fechaOperaciones[$a]."'>
                    
                      <span class='icon-eye iconos' style='cursor:pointer;'></span>
                    
                    </a>
                  
                  </td>

                </tr>";
              
              }
            }
            echo "</tbody></table>";

            //pongo el numero de registros total, el tamano de pagina y la pagina que se muestra
            echo '<ul class="pagination">';
        
            if ($total_pages > 1) {
                if ($page != 1) {
                    echo '<li class="page-item"><a class="page-link" href="raciones.php?page='.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
                }
        
                for ($i=1;$i<=$total_pages;$i++) {
                    if ($page == $i) {
                        echo '<li class="page-item active"><a class="page-link" href="#">'.$page.'</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="raciones.php?page='.$i.'">'.$i.'</a></li>';
                    }
                }
        
                if ($page != $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="raciones.php?page='.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
                }
            }
            echo '</ul>';
            echo '</nav>';
        }
?>


      </div>

</div>