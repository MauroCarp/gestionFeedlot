<div class="row-fluid">

      <div class="span12">

        <table class="table table-striped">

          <thead>

            <th>Fecha</th>

            <th>Operario</th>

            <th>Formula</th>

            <th>Kilos</th>

            <th></th>

            <th></th>

          </thead>

          <tbody>

            <form action="raciones.php?accion=ingresoMixer" method="POST">
            
              <tr>
              
                <td>
              
                    <input type="date" class="form-control" id="fecha" name="fecha" style="height:34px;">

                </td>

                <td>
              
                  <select class="form-control" id="operario" name="operario">

                    <option value="">Seleccionar Operario</option>

                  <select>

                  <input type="text" class="form-control" id="otroOperario" name="otroOperario"  placeholder="Otro Operario">


                </td>

                <td>
              
                  <select class="form-control" id="formula" name="formula">

                    <option value="">Seleccionar Formula</option>

                  <select>

                </td>
                
                <td>
              
                    <input type="number" class="form-control input-small" id="kilos" name="kilos" style="height:34px;" placeholder="Kilos">

                </td>

                <td colspan="2">

                  <button class="btn btn-default btn-block" id="cargarMixer">Cargar</button>

                </td>

              </tr>
            
            </form>
            <?php
            
              $sql = "SELECT * FROM mixer WHERE feedlot = '$feedlot' ORDER BY fecha ASC";

              $query = mysqli_query($conexion,$sql);

              while($resultado = mysqli_fetch_array($query)){

                $redondeosMixer = $resultado['redondeo'];
                
                $redondeosMixer = explode(",", $redondeosMixer);
                
                $id = $resultado['id'];

                $fecha = formatearFecha($resultado['fecha']);
                
                $formula =(nombreFormula($resultado['formula'],$conexion));
                
                $operario = $resultado['operario'];
                
                $kilos = $resultado['kilos'];
                
                echo "<tr>

                        <td><b>$fecha</b></td>

                        <td><b>$operario</b></td>

                        <td><b>$formula</b></td>

                        <td><b>$kilos Kg</b></td>

                        <td>
  
                          <a href='#' data-toggle='modal' data-target='#modalVerMixer$id' onclick='verModalMixer($id)'><span class='icon-eye'></span></a>
  
                        </td>

                        <td>
  
                          <a href='raciones.php?accion=eliminarMixer&id=$id' onclick=\"return confirm('Eliminar Registro?');\"><span class='icon-bin2'></span></a>
  
                        </td>

                      </tr>";

              ?>

              <div class="modal fade zindex-<?php echo $resultado['id'];?>" id="modalVerMixer<?php echo $resultado['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modalVerMixer" aria-hidden="true" style="width:1150px;height:fit-content;margin-left:-575px;background-color:transparent">

                <div class="modal-content">

                  <div class="modal-body" style="height:fit-content;max-height:unset;overflow-y:hidden;">

                    <h3 id="exampleModalLabel" style="margin-top: 5px;">Formula <?php echo(nombreFormula($resultado['formula'],$conexion));?></h3>

                    <form method="POST" action="raciones.php?accion=cargarRedondeo&id=<?php echo $resultado['id']?>">
                    
                      <?php 

                        $formulaMixer = $resultado['formula'];

                        $sqlInsumos = "SELECT * FROM mixer INNER JOIN formulas ON mixer.formula = formulas.id WHERE formulas.id = '$formulaMixer'";

                        $queryInsumos = mysqli_query($conexion,$sqlInsumos);

                        $filaInsumos = mysqli_fetch_array($queryInsumos);

                        $porcentajeMSinsumo = tomaPorcentajeMS('p1',$filaInsumos['p1'],$conexion);

                      ?>

                      <div class="row-fluid">

                        <div class="span12">

                          <b>Composici&oacute;n de la dieta en base a <?php echo $resultado['kilos'];?> Kilos  -  Margen de Error: <input type="number" step="0.01" name="margenError<?php echo $resultado['id'];?>" class="input-mini" value="<?php echo $resultado['margen'];?>" /> %</b>    

                        </div>

                      </div> 

                      <div class="row-fluid" style="border-bottom: 2px solid #7D7D7D">

                        <div class="span2"><b>Producto</b></div>
                        
                        <div class="span1" style="line-height: 1em;"><b>% en la Dieta</b></div>
                        
                        <div class="span1"><b>% MS</b></div>
                        
                        <div class="span1"><b>Kilos</b></div>
                        
                        <div class="span1"><b>Kg Real</b></div>
                        
                        <div class="span1" style="line-height: 1em;"><b>Dieta Final</b></div>
                        
                        <div class="span1"><b>Dif. Kg</b></div>
                        
                        <div class="span1"><b>Dif. %</b></div>
                        
                        <div class="span1" style="line-height: 1em;"><b>% MS Insumo</b></div>
                        
                        <div class="span1"><b>Kg MS</b></div>
                        
                        <div class="span1" style="line-height: 1em;"><b>% MS en Dieta</b></div>

                      </div>

                      <div class="row-fluid" style="border-bottom: 1px solid #7D7D7D">
                        
                        <div class="span2">

                        <?php

                        $nombreInsumo = nombreInsumo('p1',$filaInsumos['p1'],$conexion);

                        $tipo = obtenerTipoInsumo($nombreInsumo,$conexion);

                        if ($tipo == 'Premix') {
                          
                          echo 'Premix '.$nombreInsumo;

                        }else{

                          echo nombreInsumo('p1',$filaInsumos['p1'],$conexion);

                        }
                        
                        ?>

                        </div>

                        <div class="span1 cantPorc<?php echo $resultado['id'];?>"><?php echo $filaInsumos['por1']." %";?></div>

                        <div class="span1 porceMS<?php echo $resultado['id'];?>"><?php echo porcentajeMS($filaInsumos['por1'],$porcentajeMSinsumo);?> %</div> 

                        <div class="span1 cantKilos<?php echo $resultado['id'];?>"><?php echo round(($filaInsumos['por1']*$resultado['kilos'])/100,2);?></div>
                      

                        <!-- REDONDEO -->
                        <?php
                        
                        if ($resultado['redondeo'] == "") {

                        ?>
                        
                        <div class="span1"><input type="number" step="0.01" class="input-mini" style="margin-bottom: 0" name="redondeo1"></div>

                        <div class="span1"></div>

                        <div class="span1"></div>

                        <div class="span1"></div>

                        <div class="span1"><span class="MS<?php echo $resultado['id'];?>"><?php echo $porcentajeMSinsumo;?></span> %</div>
                        <?php

                        }else{ 

                        ?>

                        <div class="span1">
                        
                          <input type="number" step="0.01" class="input-mini inputRedondedo<?php echo $resultado['id'];?>" style="margin-bottom: 0" name="redondeo1" value="<?php echo $redondeosMixer[0]?>">
                        
                        </div> 

                        <div class="span1  dietaFinal<?php echo $resultado['id'];?>"><?php echo $redondeosMixer[0];?></div>

                        
                        <div class="span1"><?php echo $redondeosMixer[0] - (round(($filaInsumos['por1']*$resultado['kilos'])/100,2))." Kg";?></div>
                        
                        <div class="span1"><span class="difPorce<?php echo $resultado['id'];?>">

                          <?php echo round((($redondeosMixer[0] * 100) / (($filaInsumos['por1']*$resultado['kilos'])/100)-100),2); ?></span> %
                          
                        </div>
                        
                        <div class="span1"><span class="MS<?php echo $resultado['id'];?>"><?php echo $porcentajeMSinsumo;?></span> %</div>
                        
                        <div class="span1 kilosMS<?php echo $resultado['id'];?>"><?php 
                         echo round(((tomaPorcentajeMS('p1',$filaInsumos['p1'],$conexion) * $redondeosMixer[0]) / 100),2);
                        ?> Kg</div>
                        
                        <div class="span1" id="totalPorcMS<?php echo $resultado['id'];?>_1"></div>

                        <?php
                        }
                        ?>

                      </div>

                      <?php 
                      
                      for ($i=1; $i < 11 ; $i++) { 

                        $producto = "p".($i+1);

                        $porcentaje = "por".($i+1);

                        $redondeo = "redondeo".($i+1);
                        
                        if($filaInsumos[$producto] == NULL){
                          
                          break;
                        
                        }

                        $porcentajeMSinsumo = tomaPorcentajeMS($producto,$filaInsumos[$producto],$conexion);

                        if($filaInsumos[$producto] != ''){ ?>

                      <div class="row-fluid" style="border-bottom: 1px solid #7D7D7D">

                        <div class="span2">
                        
                        <?php

                        $nombreInsumo = nombreInsumo($producto,$filaInsumos[$producto],$conexion);

                        $tipo = obtenerTipoInsumo($nombreInsumo,$conexion);
                        if ($tipo == 'Premix') {
                          
                          echo 'Premix '.$nombreInsumo;

                        }else{

                          echo $nombreInsumo;

                        }
                        
                        ?>
                        
                        </div>

                        <div class="span1 cantPorc<?php echo $resultado['id'];?>"><?php echo $filaInsumos[$porcentaje]." %";?></div>

                        <div class="span1 porceMS<?php echo $resultado['id'];?>"><?php echo porcentajeMS($filaInsumos[$porcentaje],$porcentajeMSinsumo);?> %</div>

                        <div class="span1 cantKilos<?php echo $resultado['id'];?>"><?php echo round(($filaInsumos[$porcentaje]*$resultado['kilos'])/100,2);?></div>

                        <!-- REDONDEO -->

                        <?php

                        if ($resultado['redondeo'] == "") {

                        ?>

                      <div class="span1"><input type="number" step="0.01" class="input-mini" style="margin-bottom: 0" name="<?php echo $redondeo;?>"></div>

                        <div class="span1"></div>

                        <div class="span1"></div>

                        <div class="span1"></div>

                        <div class="span1"><span class="MS<?php echo $resultado['id'];?>"><?php echo tomaPorcentajeMS($producto,$filaInsumos[$producto],$conexion)?></span> %</div>
                        <?php

                        }else{ 

                        ?>

                        <div class="span1">
                          
                          <input type="number" step="0.01" class="input-mini inputRedondedo<?php echo $resultado['id'];?>" style="margin-bottom: 0" name="<?php echo $redondeo;?>" value="<?php echo $redondeosMixer[$i]?>">
                          
                        </div> 

                        <div class="span1 dietaFinal<?php echo $resultado['id'];?>"><?php echo $redondeosMixer[$i];?></div>

                        <div class="span1"><?php echo $redondeosMixer[$i] - (round(($filaInsumos[$porcentaje]*$resultado['kilos'])/100,2))." Kg";?></div>

                        <div class="span1"><span class="difPorce<?php echo $resultado['id'];?>"><?php echo round((($redondeosMixer[$i] * 100) / (($filaInsumos[$porcentaje]*$filaInsumos['kilos'])/100)-100),2); ?></span> %</div>

                        <div class="span1"><span class="MS<?php echo $resultado['id'];?>"><?php echo tomaPorcentajeMS($producto,$filaInsumos[$producto],$conexion)?></span> %</div>

                        <div class="span1 kilosMS<?php echo $resultado['id'];?>">

                          <?php
                            echo round(((tomaPorcentajeMS($producto,$filaInsumos[$producto],$conexion) * $redondeosMixer[$i]) / 100),2);
                          ?>

                          Kg</div>

                        <div class="span1" id="totalPorcMS<?php echo $resultado['id']."_".($i+1);?>"></div>

                        <?php

                        }

                        ?>

                      </div>

                      <?php  
                        }

                      }

                      ?>

                      <div class="row-fluid" style="font-size:.8em;">

                        <div class="span2"><b>TOTALES</b></div>

                        <div class="span1"><b id="totalCantPorc<?php echo $resultado['id'];?>"></b></div>

                        <div class="span1"><b id="porceMStotal<?php echo $resultado['id'];?>"></b></div>

                        <div class="span1"><b id="totalCantKilos<?php echo $resultado['id'];?>"></b></div>

                        <div class="span1"><b id="totalKilosReal<?php echo $resultado['id'];?>"></b></div>

                        <div class="span1"><b id="dietaFinal<?php echo $resultado['id'];?>"></b></div>

                        <div class="span1"></div>

                        <div class="span1"></div>

                        <div class="span1"></div>

                        <div class="span1"><b id="kilosMS<?php echo $resultado['id'];?>"></b></div>

                        <div class="span1"><b id="totalMSporc<?php echo $resultado['id'];?>"></b></div>

                      </div>

                      <button type="submit" class="btn btn-default" style=": right;margin-top: 10px;">Cargar</button>
                      
                      <a href="#" class="btn btn-default" style=": right;margin-top: 10px;margin-right: 5px;" onclick="imprimirMixer('<?php echo $resultado['id'];?>')">Imprimir</a>

                      <br><br>

                    </form>
                  
                  </div>

                </div>
              
              </div>


              <?php

            }

            ?>
          </tbody>

        </table>

      </div>

    </div>

<script>

$(document).ready(function() {
    
    $('#otroOperario').css('display','none');

    $('#operario').change(function(){

      var valor = $(this).val();

      if(valor == 'otroOperario'){

        $('#otroOperario').css('display','block');
        
      }else{
        
        $('#otroOperario').css('display','none');

      }

    });

    var feedlot = '<?php echo $feedlot?>';
        
    cargarSelect('formulas',feedlot);
    
    cargarSelect('operarios',feedlot);

});

</script>