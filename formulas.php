<div class="row-fluid">

    <div class="span8" style="border-right:1px solid grey;">

      <form method="POST" action="raciones.php?accion=nuevaFormula">

        <div class="span1">

          <b>Tipo:</b>

        </div>

        <div class="span4">

          <select class="form-control" name="tipo" id="selectTipoFormula" required>

            <option value="">Seleccionar Tipo</option>

            <?php

            $sqlTipo = "SELECT * FROM tipoformula ORDER BY tipo ASC";

            $queryTipo = mysqli_query($conexion,$sqlTipo);

                while ($filaTipo = mysqli_fetch_array($queryTipo)) { ?>

                  <option value="<?php echo $filaTipo['tipo'];?>"><?php echo $filaTipo['tipo'];?></option>

                <?php }

            ?>

            <option value="otro">Otro</option>

          </select>

          <input type="text" name="tipoOtra" class="form-control tipoFormulaOtro" id="mostrarOtro" style="display:none;" value="" placeholder="Otro Tipo">

        </div>

        <div class="span5">
          <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>

        <div class="row-fluid">
          <div class="span12">
            <b>Composici&oacute;n de la Dieta</b>
          </div>
        </div>

        <div class="row-fluid">

          <div class="span3"><b>Producto</b></div>

          <div class="span2"><b>%</b></div>

          <div class="span2"><b>% MS</b></div>

          <div class="span2"><b>Precio TC</b></div>

          <div class="span2"><b>Precio %MS</b></div>

        </div>

        <div class="contenedor-producto">

          <div class="row-fluid producto">

            <div class="span3 ">

              <select class="form-control select-insumos input-medium mi-selector" name="producto" id="producto0" onchange="cargarPrecioProducto(this.value,this.id);">

                <option value="" style="font-size:.5em!important;">Seleccionar Insumo</option>

              </select>

            </div>

            <div class="span2">

              <input type="text" class="form-control input-small porcentajes" id="porcentaje0" name="porcentaje" value="0" onblur="infoMSinsumo('porcentaje0')" disabled="true" required/>

            </div>

            <div class="span2">

              <input type="text" style="font-weight: bold" class="form-control input-small porcentajesMS" id="porcentajeMS0" value="0" readonly />

            </div>

            <div class="span2" id="precio0">


            </div>

            <div class="span2">

              <input type="text"  style="font-weight: bold" value="0" id="precioPor0" class="input-small importe_linea" readonly>

            </div>

            <div class="span1">

            </div>

          </div>

        </div>

        <div class="row-fluid">

          <div class="span3"></div>

          <div class="span3">

            <input type="text" class="form-control input-small" id="totalPorcentaje" value="0" readonly>

          </div>

        </div>

        <hr>

        <div class="row-fluid">

          <div class="span6">

            <button type="button" class="btn btn-inverse btnAgregarProducto" id="btnAgregarProducto">Agregar Producto</button>

          </div>

          <div class="span1" style="text-align: right;">

            <input type="button" class="btn btn-inverse" value="Resetear" onclick="resetear()"/>

          </div>

          <div class="span2" style="text-align: right;">

            <input type="button" class="btn btn-inverse" value="Calcular" onclick="calcular_total()"/>

          </div>

          <div class="span3">

            <b>$ </b><input type="text"  style="font-weight: bold;" id="total" name="total" class="input-small" readonly/>

          </div>

        </div> 

        <br>

        <div class="row-fluid">

          <div class="span8"></div>

          <div class="span4">

            <button type="submit" class="btn btn-large btn-primary botonCarga">Cargar Formula</button>

          </div>

        </div>

      </form>

    </div>

    <div class="span4" style="height: 300px;max-height: 300px;overflow-y: scroll;">

      <table class="table table-hover">

        <thead>

          <th>Formulas</th>

          <th></th>

          <th></th>

        </thead>

        <tbody>

          <?php

          $sqlFormulas = "SELECT * FROM formulas ORDER BY tipo ASC, nombre ASC";

          $queryFormulas = mysqli_query($conexion,$sqlFormulas);

          $tipo = '';

          while($fila = mysqli_fetch_array($queryFormulas)){ 

            $id = $fila['id'];

            if($fila['tipo'] != $tipo){ ?>

            <tr>

              <td><b><?php echo $fila['tipo']?></b></td>

              <td></td>

              <td></td>

              <td></td>

            </tr>

            <?php

            }?>

            <tr>

              <td><?php echo $fila['nombre']?></td>

              <td>
              
                <a href="#" data-toggle="modal" data-target="#formula<?php echo $id;?>" onclick="cargarMS(<?php echo $id;?>)">
              
                  <span class="icon-eye"></span>
              
                </a>
              
              </td>

              <td style="padding-right: 50px;">
              
                <a href="raciones.php?accion=eliminarFormula&id=<?php echo $id;?>" onclick="return confirm('¿Eliminar Registro?');">
                
                  <span class="icon-cross"></span>
                  
                </a>
              
              </td>

            </tr>
            

            <!-- MODAL FORMULA  -->
            
            <div class="modal fade zindex-<?php echo $id;?>" style="width: 1350px;height:500px;margin: 0 auto;margin-left:-675px;z-index:99!important;background-color:transparent" id="formula<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="modalFormula" aria-hidden="true">

                <div class="modal-dialog" style="width:auto;" role="document">

                  <div class="modal-content">

                    <div class="modal-header">

                      <h2 class="modal-title" id="modalFormula">Formula <?php echo $fila['tipo']." - ".$fila['nombre'];?></h2>

                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">

                      <div id="dieta">

                        <div class="row-fluid">

                          <div class="span12">

                            <b>
                            Composici&oacute;n de la dieta | Precio por Kilo: $
                            
                            <span id="precioKilo<?php echo $id;?>">

                            </span> 
                            
                            | Precio por Kilo MS: $ 
                            
                            <span id="precioMS<?php echo $id;?>"> 
                                                          
                            </span> 
                            
                            | Total % de MS: 
                            
                            <span id="totalPorMS<?php echo $id;?>"></span>
                             
                             %</b>
                             
                             <br>

                            <b>Fecha Realizada: <?php echo formatearFecha($fila['fecha']);?></b>  

                          </div>

                        </div>

                        <div class="row-fluid" style="border-bottom: 2px solid #7D7D7D">
                          <div class="span2"><b>Producto</b></div>

                          <div class="span2"><b>% en la Dieta</b></div>

                          <div class="span2"><b>% MS</b></div>

                          <div class="span1" style="line-height:1em;"><b>Precio Insumo</b></div>

                          <div class="span1" style="line-height:1em;"><b>$/Kg MS</b></div>

                          <div class="span2"><b>% MS Insumo</b></div>
                          
                          <div class="span2"><b>% MS en la Dieta</b></div>
                        
                        </div>
                        
                        <div class="row-fluid" style="border-bottom: 1px solid #7D7D7D">

                          <div class="span2">
                          
                            <?php 
                            
                                $nombreInsumo = nombreInsumo('p1',$fila['p1'],$conexion);

                                $tipo = obtenerTipoInsumo($nombreInsumo,$conexion);

                                if ($tipo == 'Premix') {
                                  
                                  echo 'Premix '.utf8_encode($nombreInsumo);

                                }else{

                                  echo utf8_encode(nombreInsumo('p1',$fila['p1'],$conexion));

                                }

                              ?>
                          
                          </div>

                          <div class="span2">
                          
                            <span class="porce<?php echo $id;?>" id="porce<?php echo $id."_1"; ?>"><?php echo number_format($fila['por1'],2,",",".");?></span> %
                          
                          </div>

                          <div class="span2 porcentajesMS<?php echo $id;?>" id="porceMS<?php echo $id;?>">
                          
                            <?php 
                            
                            $porcentajeMS = porceMS($fila['p1'],$fila['por1'],$conexion);

                            echo number_format($porcentajeMS,2,",",".")." %";

                            ?>
                            
                          </div>

                          <div class="span1 preciosInsumos<?php echo $id;?>">
                          
                            <?php
                            
                            $precioInsumo = precioInsumo('p1',$fila['p1'],$conexion);

                            echo "$ ".number_format($precioInsumo,2,",",".");
                            
                            ?>
                            
                          </div>

                          <div class="span1 precioKgMS<?php echo $id;?>">
                          <?php
                            $porMS = obtenerMSinsumo($fila['p1'],$conexion);
                            
                            $precioKgMS = (100 * $precioInsumo) / $porMS;

                            echo "$ ".number_format($precioKgMS,2,',','.');        
                            
                          ?>
                          </div>

                          <div class="span2 porcMS<?php echo $id;?>_0" style="text-align:center;">
                          
                            <?php 

                              echo $porMS." %";
                            
                            ?>
                          
                          </div>

                          <div class="span2 totalMS<?php echo $id;?>" id="totalMS<?php echo $id;?>_1" style="text-align:center;">

                          </div>

                        </div>

                        <?php 
                        for ($i=1; $i < 11 ; $i++) { 

                          $producto = "p".($i+1);

                          $porcentaje = "por".($i+1);

                          if($fila[$producto] != ''){ 

                            $precioInsumo = precioInsumo($producto,$fila[$producto],$conexion);

                            $porcentajeMS = tomaPorcentajeMS($producto,$fila[$producto],$conexion);

                            ?>

                            <div class="row-fluid" style="border-bottom: 1px solid #7D7D7D">

                              <div class="span2">
                              <?php 
                              
                                $nombreInsumo = nombreInsumo($producto,$fila[$producto],$conexion);

                                $tipo = obtenerTipoInsumo($nombreInsumo,$conexion);

                                if ($tipo == 'Premix') {
                                  
                                  echo 'Premix '.utf8_encode($nombreInsumo);

                                }else{

                                  echo utf8_encode(nombreInsumo($producto,$fila[$producto],$conexion));

                                }
                              
                              ?>
                              
                              </div>

                              <div class="span2"><span class="porce<?php echo $id;?>" id="porce<?php echo $id."_".($i+1); ?>"><?php echo formatearNum($fila[$porcentaje]);?></span> %</div>

                              <div class="span2 porcentajesMS<?php echo $id;?>" id="porceMS<?php echo $id;?>"><?php echo formatearNum(porceMS($fila[$producto],$fila[$porcentaje],$conexion));?> %</div>

                              <div class="span1 preciosInsumos<?php echo $id;?>"><?php echo "$ ".number_format($precioInsumo,2,",",".");?></div>

                              <div class="span1 precioKgMS<?php echo $id;?>">
                              <?php 
                                
                                ${"porMS".($i+1)} = obtenerMSinsumo($fila[$producto],$conexion);

                                $precioKgMS = (100 * $precioInsumo) / ${"porMS".($i+1)};

                                echo "$ ".number_format($precioKgMS,2,',','.');        

                              ?>
                              </div>

                              <div class="span2 porcMS<?php echo $id."_".$i;?>" style="text-align:center;"><?php
                              ${"porMS".($i+1)} = obtenerMSinsumo($fila[$producto],$conexion);

                              echo ${"porMS".($i+1)}." %";?></div>

                              <div class="span2 totalMS<?php echo $id;?>" id="totalMS<?php echo $id;?>_<?php echo ($i + 1);?>" style="text-align:center;">

                              </div>
                            </div>
                        <?php  }
                        }
                        ?>

                        <div class="row-fluid">

                          <div class="span5" style="font-size: .6em;">

                            <p>*Valores en base a 1 Kilo de Formula.</p>

                          </div>

                        </div>

                        <a href="raciones.php?seccion=formulas&accion=modificar&id=<?php echo $id;?>" class="btn btn-secondary">Modificar</a>

                        <a href="compararDietas.php?id=<?php echo $id;?>" class="btn btn-secondary">Comparar</a>

                        <a href="#" class="btn btn-secondary" onclick="imprimirFormula('<?php echo $id;?>')">Imprimir</a>

                      </div>

                    </div>

                  </div>

                </div>

            </div>

            <?php
            $tipo = $fila['tipo'];
          }
          ?>
        </tbody>

      </table>

    </div> 

</div>
 
 <script>
 $(document).ready(function(){

  selectInsumos('producto0');

  });
 </script>