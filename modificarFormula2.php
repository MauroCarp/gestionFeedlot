<?php
$sql = "SELECT * FROM formulas WHERE id = '$id'";
$query = mysqli_query($conexion,$sql);
$resultadoFormula = mysqli_fetch_array($query);
?>

<div class="row-fluid">
    <div class="span8" style="border-right:1px solid grey;">
        <span style="font-size: 20px;"><b>Modificar Formula</b></span>
      <form method="POST" id="cargaFormula" action="raciones.php?accion=modificarFormula&id=<?php echo $id;?>">
        <div class="span1">
          <b>Tipo:</b>
        </div>
        <div class="span4">
          <select class="form-control" name="tipo" id="selectTipoFormula" required>
            <option value="<?php echo $resultadoFormula['tipo']?>"><?php echo $resultadoFormula['tipo']?></option>
            <?php
            $sqlTipo = "SELECT * FROM tipoformula ORDER BY tipo ASC";
            $queryTipo = mysqli_query($conexion,$sqlTipo);
                while ($filaTipo = mysqli_fetch_array($queryTipo)) { ?>
                  <option value="<?php echo $filaTipo['tipo'];?>"><?php echo $filaTipo['tipo'];?></option>
                <?php }
            ?>
            <option value="otro">Otro</option>
          </select>
          <input type="text" name="tipoOtra" class="form-control tipoFormulaOtro" id="mostrarOtro" value="" placeholder="Otro Tipo">
        </div>
        <div class="span5">
          <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="<?php echo $resultadoFormula['nombre']?>" required>
        </div>
        <div class="row-fluid">
          <div class="span12">
            <b>Composici&oacute;n de la Dieta</b>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span3"><b>Producto</b></div>
          <div class="span2"><b>%</b></div>
          <div class="span2"><b>% TC</b></div>
          <div class="span2"><b>Precio TC</b></div>
          <div class="span2"><b>Precio %</b></div>
        </div>
        <!-- PRODUCTOS -->
        <div class="contenedor-producto">
          <!-- PRODUCTO 1 -->
          <div class="row-fluid producto">
            <div class="span3 ">
              <select class="form-control select-insumos input-medium" name="producto" id="producto0" onblur="CargarProductos(this.value,this.id);">
                <option value="<?php echo $resultadoFormula['p1'];?>"><?php echo nombreInsumo('p1',$resultadoFormula['p1'],$conexion);?></option>
                <?php
                $sql = "SELECT * FROM insumos ORDER BY insumo ASC";
                $query = mysqli_query($conexion,$sql);
                $insumos = array();
                while ($resultado = mysqli_fetch_array($query)) {
                  $insumos[] = $resultado['insumo'];
                }
                $insumos = array_unique($insumos);
                $insumos = array_values($insumos);

                for ($i=0; $i < sizeof($insumos) ; $i++) { 
                  $ultimaFecha = ultimaFecha($insumos[$i],$conexion);
                  $resultado = traeDatos($ultimaFecha,$insumos[$i],$conexion);  
                ?>
                  <option value="<?php echo $resultado['id']?>"><?php echo $resultado['insumo']?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="span2">
              <input type="text" class="form-control input-small porcentajes" id="porcentaje0" name="porcentaje" value="<?php echo $resultadoFormula['por1'];?>" onblur="controlCero('porcentaje0')" required/>
            </div>
            <div class="span2">
              <input type="text" style="font-weight: bold" class="form-control input-small porcentajesTC" id="porcentajeTC0" value="0" readonly />
            </div>
            <div class="span2" id="precio0">
            </div>
            <div class="span2">
              <input type="text"  style="font-weight: bold" value="0" id="precioPor0" class="input-small importe_linea" readonly>
            </div>
            <div class="span1">
            </div>
          </div>
          <!-- FIN PRODUCTO 1 -->
          <!-- DEMAS PRODUCTOS -->
          <?php
          for ($a=1; $a < 11 ; $a++) { 
              $producto = "p".($a+1);
              $porcentaje = "por".($a+1);
              if($resultadoFormula[$producto] != ''){ ?>
                <div class="row-fluid producto<?php echo $a;?>">
                  <div class="span3 ">
                    <select class="form-control select-insumos input-medium" name="producto<?php echo $a;?>" id="producto<?php echo $a;?>" onblur="CargarProductos(this.value,this.id);">
                      <option value="<?php echo $resultadoFormula[$producto];?>"><?php echo nombreInsumo($producto,$resultadoFormula[$producto],$conexion);?></option>
                      <?php
                      $sql = "SELECT * FROM insumos ORDER BY insumo ASC";
                      $query = mysqli_query($conexion,$sql);
                      $insumos = array();
                      while ($resultado = mysqli_fetch_array($query)) {
                        $insumos[] = $resultado['insumo'];
                      }
                      $insumos = array_unique($insumos);
                      $insumos = array_values($insumos);

                      for ($n=0; $n < sizeof($insumos) ; $n++) { 
                        $ultimaFecha = ultimaFecha($insumos[$n],$conexion);
                        $resultado = traeDatos($ultimaFecha,$insumos[$n],$conexion);  
                      ?>
                        <option value="<?php echo $resultado['id']?>"><?php echo $resultado['insumo']?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="span2">
                    <input type="text" class="form-control input-small porcentajes" id="porcentaje<?php echo $a;?>" name="porcentaje<?php echo $a;?>" value="<?php echo $resultadoFormula[$porcentaje];?>" onblur="controlCero('porcentaje<?php echo $a;?>')" required/>
                  </div>
                  <div class="span2">
                    <input type="text" style="font-weight: bold" class="form-control input-small porcentajesTC" id="porcentajeTC<?php echo $a;?>" value="0" readonly />
                  </div>
                  <div class="span2" id="precio<?php echo $a;?>">
                  </div>
                  <div class="span2">
                    <input type="text"  style="font-weight: bold" value="0" id="precioPor<?php echo $a;?>" class="input-small importe_linea" readonly>
                  </div>
                  <div class="span1">
                    <span class="icon-bin2" style="cursor: pointer;" onclick="eliminarProducto('producto<?php echo $a;?>')"></span>
                  </div>
                </div>
          <?php }
            }
          ?>
        </div>
        <!--- AGUA -->
        <div class="row-fluid producto">
          <div class="span3 ">
            <input type="text" class="input-medium" readonly value="Agua">
          </div>
          <div class="span2">
            <input type="text" class="form-control input-small" id="porcentajeAgua" name="porcentajeAgua" value="<?php echo $resultadoFormula['agua'];?>"/>
          </div>
          <div class="span2">
            <input type="text" style="font-weight: bold" class="form-control input-small" id="porcentajeAguaTC" readonly />
          </div>
        </div>
        <div class="row-fluid">
          <div class="span3"></div>
          <div class="span3">
            <input type="text" class="form-control input-small" id="totalPorcentaje" readonly>
          </div>
        </div>
        <hr>
        <div class="row-fluid">
          <div class="span6">
            <button type="button" class="btn btn-inverse  btn-agregarProducto">Agregar Producto</button>
          </div>
          <div class="span1" style="text-align: right;">
            <input type="button" class="btn btn-inverse" value="Resetear" onclick="resetear()"/>
          </div>
          <div class="span2" style="text-align: right;">
            <input type="button" class="btn btn-inverse" value="Calcular" onclick="calcular_total()"/>
          </div>
          <div class="span3">
            <b>$ </b><input type="text"  style="font-weight: bold;" id="total" name="total" class="input-small" value="<?php echo $resultadoFormula['precio'];?>" readonly/>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span8"></div>
          <div class="span4">
            <button type="submit" class="btn btn-large btn-default botonCarga">Modificar Formula</button>
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
              <td><a href="#" data-toggle="modal" data-target="#formula<?php echo $fila['id'];?>" onclick="cargarMS(<?php echo $fila['id'];?>)"><span class="icon-eye"></span></a></td>
              <td style="padding-right: 50px;"><a href="raciones.php?accion=eliminarFormula&id=<?php echo $fila['id'];?>" onclick="return confirm('¿Eliminar Registro?');"><span class="icon-cross"></span></a></td>
            </tr>

            <div class="modal fade zindex-<?php echo $fila['id'];?>" style="width: 1000px;margin: 0 auto;margin-left:-500px;" id="formula<?php echo $fila['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modalFormula" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2 class="modal-title" id="modalFormula">Formula <?php echo $fila['tipo']." - ".$fila['nombre'];?></h2>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div id="dieta">
                        <div class="row-fluid">
                          <div class="span12">
                            <b>Composici&oacute;n de la dieta | Precio por Kilo: $<span id="precioKilo<?php echo $fila['id'];?>"><?php echo formatearNum($fila['precio']);?></span> | Precio por Kilo MS: $ <span id="precioMS<?php echo $fila['id'];?>"> </span> | Total % de MS: <span id="totalPorMS<?php echo $fila['id'];?>"></span> %</b><br>
                            <b>Fecha Realizada: <?php echo formatearFecha($fila['fecha']);?></b>   
                          </div>
                        </div>
                        <div class="row-fluid" style="border-bottom: 2px solid #7D7D7D">
                          <div class="span2"><b>Producto</b></div>
                          <div class="span2"><b>Cant. %</b></div>
                          <div class="span2"><b>% TC</b></div>
                          <div class="span1"><b>$ TC</b></div>
                          <div class="span1"><b>$ %</b></div>
                          <div class="span2"><b>% MS</b></div>
                          <div class="span2"><b>% MS Total</b></div>
                        </div>
                        <div class="row-fluid" style="border-bottom: 1px solid #7D7D7D">
                          <div class="span2"><?php echo nombreInsumo('p1',$fila['p1'],$conexion);?></div>
                           <div class="span2"><span class="porce<?php echo $fila['id'];?>"><?php echo number_format($fila['por1'],2,",",".");?></span> %</div>
                          <div class="span2" id="porceTC<?php echo $fila['id'];?>"><?php echo number_format(porceTC($fila['agua'],$fila['por1']),2,",",".");?> %</div>
                          <div class="span1"><?php echo "$ ".number_format(precioInsumo('p1',$fila['p1'],$conexion),2,",",".");?></div>
                          <div class="span1 precioPorc<?php echo $fila['id'];?>"><?php echo "$ ".number_format((porceTC($fila['agua'],$fila['por1']) * precioInsumo('p1',$fila['p1'],$conexion))/100,2,",",".")?></div>
                          <div class="span2 porcMS<?php echo $fila['id'];?>_0"><?php 
                          $porMS = tomaPorcentajeMS('p1',$fila['p1'],$conexion);
                          echo $porMS." %";?></div>
                          <div class="span2 totalMS<?php echo $fila['id'];?>">
                            <?php echo formatearNum(((porceTC($fila['agua'],$fila['por1'])*$porMS)/100))." %";?>
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
                              <div class="span2"><?php echo nombreInsumo($producto,$fila[$producto],$conexion);?></div>
                              <div class="span2"><span class="porce<?php echo $fila['id'];?>"><?php echo formatearNum($fila[$porcentaje]);?></span> %</div>
                              <div class="span2" id="porceTC<?php echo $fila['id'];?>"><?php echo formatearNum(porceTC($fila['agua'],$fila[$porcentaje]));?> %</div>
                              <div class="span1"><?php echo "$ ".number_format(precioInsumo($producto,$fila[$producto],$conexion),2,",",".");?></div>
                              <div class="span1 precioPorc<?php echo $fila['id'];?>"><?php echo "$ ".number_format(((porceTC($fila['agua'],$fila[$porcentaje]) * precioInsumo($producto,$fila[$producto],$conexion))/100),2,",",".");?></div>
                              <div class="span2 porcMS<?php echo $fila['id']."_".$i;?>"><?php
                              ${"porMS".$i+1} = tomaPorcentajeMS($producto,$fila[$producto],$conexion);
                              echo ${"porMS".$i+1}." %";?></div>
                              <div class="span2 totalMS<?php echo $fila['id'];?>">
                                <?php echo formatearNum(((porceTC($fila['agua'],$fila[$porcentaje])*${"porMS".$i+1})/100))." %";?>
                              </div>
                            </div>
                        <?php  }
                        }
                        ?>
                        <div class="row-fluid" style="border-bottom: 1px solid #7D7D7D">
                          <div class="span2">Agua</div>
                          <div class="span2"><span id="agua<?php echo $fila['id'];?>"><?php echo $fila['agua'];?></span> %</div>
                          <div class="span2"><?php echo formatearNum(porceTC($fila['agua'],$fila['agua']));?> %</div>
                          <div class="span2"></div>
                          <div class="span2"></div>
                          <div class="span2"></div>
                        </div>
                        <div class="row-fluid">
                          <div class="span5" style="font-size: .6em;">
                            <p>*Valores en base a 1 Kilo de Formula.</p>
                          </div>
                        </div>
                        <a href="raciones.php?seccion=formulas&accion=modificar&id=<?php echo $fila['id'];?>" class="btn btn-secondary">Modificar</a>
                        <a href="compararDietas.php?id=<?php echo $fila['id'];?>" class="btn btn-secondary">Comparar</a>
                        <a href="#" class="btn btn-secondary" onclick="imprimirFormula('<?php echo $fila['id'];?>')">Imprimir</a>
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
 