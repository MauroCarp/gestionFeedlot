<?php
  
  $id = $_GET['id'];

  $sql = "SELECT * FROM premix WHERE id = '$id'";

  $query = mysqli_query($conexion,$sql);

  $resultado = mysqli_fetch_array($query);

?>

<div class="row-fluid">

    <div class="span8" style="border-right:1px solid grey;">

      <form method="POST" action="raciones.php?accion=actualizarPremix&id=<?php echo $id;?>">

        <div class="span1">

          <b>Premix:</b>

        </div>

        <div class="span4" style="padding-left:15px;">

          <input type="text" name="nombre" class="form-control" value="<?php echo $resultado['nombre'];?>" required>

        </div>

        <div class="row-fluid">

          <div class="span12">

            <b>Composici&oacute;n</b>

          </div>

        </div>

        <div class="row-fluid">

          <div class="span3"><b>Insumo</b></div>

          <div class="span2"><b>Kilos</b></div>

          <div class="span2"><b>$ Precio</b></div>

          <div class="span2"><b>$ T</b></div>
          
          <div class="span2"><b>%</b></div>

        </div>

        <div class="contenedor-insumoPre">


          <div class="row-fluid insumoPre">

            <div class="span3 ">

              <select class="form-control select-insumos input-medium" name="insumoPre" id="insumoPre0" onchange="cargarPrecioInsumoPremix(this.value,this.id);">

                <option value="<?php echo $resultado['p1'];?>"><?php echo dataInsumoPremix($resultado['p1'],'nombre',$conexion);?></option>

                <?php

                $sqlInsumo = "SELECT id, nombre FROM insumospremix ORDER BY nombre ASC";

                $queryInsumo = mysqli_query($conexion,$sqlInsumo);


                while($resultadoInsumo = mysqli_fetch_array($queryInsumo)){

                    echo "<option value=".$resultadoInsumo['id'].">".$resultadoInsumo['nombre']."</option>";

                }

                ?>
              </select>

            </div>

            <div class="span2">

              <input type="text" class="form-control input-small kilosPre" style="font-weight: bold" id="kilosPre0" name="kilosPre" class="input-small" onchange="calcularPrecioKilo(this.value,this.id)" value="<?php echo $resultado['kg1'];?>">

            </div>

            <div class="span2">

              <input type="text" class="form-control input-small preciosPre" id="precioPre0" name="precioPre" disabled="true" required/>

            </div>
            
            <div class="span2">

              <input type="text" class="form-control input-small preciosKilosPre" id="precioKilosPre0" name="precioKilosPre" value="0" disabled="true"/>

            </div>


            <div class="span2">

              <input type="text" class="form-control input-small totalPorcePre" id="totalPorcePre0" name="totalPorcePre" value="0" disabled="true"/>

            </div>

            <div class="span1">
                

            </div>

          </div>

          <?php
          
                for ($i=2; $i < 11 ; $i++) { 

                  $insumo = 'p'.$i;
                  
                  $kg = 'kg'.$i;

                  if($resultado[$insumo] == null){
                    break;
                  }

          ?>

          <div class="row-fluid insumoPre<?php echo $i;?>">

            <div class="span3 ">

              <select class="form-control select-insumos input-medium" name="insumoPre<?php echo $i;?>" id="insumoPre<?php echo $i;?>" onchange="cargarPrecioInsumoPremix(this.value,this.id);">

                <option value="<?php echo $resultado[$insumo];?>"><?php echo dataInsumoPremix($resultado[$insumo],'nombre',$conexion);?></option>

                <?php

                $sqlInsumo = "SELECT id, nombre FROM insumospremix ORDER BY nombre ASC";

                $queryInsumo = mysqli_query($conexion,$sqlInsumo);


                while($resultadoInsumo = mysqli_fetch_array($queryInsumo)){

                    echo "<option value=".$resultadoInsumo['id'].">".$resultadoInsumo['nombre']."</option>";

                }

                ?>
              </select>

            </div>

            <div class="span2">

              <input type="text" class="form-control input-small kilosPre" style="font-weight: bold" id="kilosPre<?php echo $i;?>" name="kilosPre<?php echo $i;?>" class="input-small" onchange="calcularPrecioKilo(this.value,this.id)" value="<?php echo $resultado[$kg];?>">

            </div>

            <div class="span2">

              <input type="text" class="form-control input-small preciosPre" id="precioPre<?php echo $i;?>" name="precioPre" disabled="true" required/>

            </div>

            <div class="span2">

              <input type="text" class="form-control input-small preciosKilosPre" id="precioKilosPre<?php echo $i;?>" name="precioKilosPre" disabled="true"/>

            </div>

            <div class="span2">

              <input type="text" class="form-control input-small totalPorcePre" id="totalPorcePre<?php echo $i;?>" name="totalPorcePre" disabled="true"/>

            </div>

            <div class="span1">

              <i class="icon-bin2" style="cursor:pointer" id="eliminarInsumo<?php echo $i;?>" onclick="eliminarInsumo(this.id)"></i>

            </div>

          </div>

          <?php
           }
          ?>

        </div>
      
        <div class="row-fluid">
        
          <div class="span3" style="text-align:right;">

            <b>TOTALES:</b>
          
          </div>
          
          <div class="span2">
                
            <input type="text"  style="font-weight: bold" id="kilosTotales" class="input-small" readonly>

          </div>

          <div class="span2"></div>
          
          <div class="span2">
          
            <input type="text"  style="font-weight: bold" id="precioTotal" name="precioTotal" class="input-small" readonly>
          
          </div>
          
          <div class="span2">
          
            <input type="text"  style="font-weight: bold" value="0" id="porceTotal" class="input-small" readonly>

          </div>
        
        </div>
        
        <hr>
          
        <div class="row-fluid">

          <div class="span6">

            <button type="button" class="btn btn-inverse btnAgregarInsumo" id="btnAgregarInsumo">+ Agregar Insumo</button>

          </div>

          <div class="span6">

            <div class="span2">

              <b>%MS:</b>

            </div>

            <div class="span4">

              <input type="number" name="porcentajeMSPre" class="form-control input-small" value="<?php echo $resultado['ms'];?>">

            </div>

          </div>

        </div> 

        <br>

        <div class="row-fluid">

          <div class="span8"></div>

          <div class="span4">

            <button type="submit" class="btn btn-large btn-default btnCargarPremix">Modificar Premix</button>

          </div>

        </div>

      </form>

    </div>

    <div class="span4">
      
      <div class="row-fluid" style="height: 300px;max-height: 300px;overflow-y: scroll;">
                
          <div class="span12">
          
            <table class="table table-hover">

              <thead>

                <th>Premix</th>

                <th></th>

                <th></th>
                
                <th></th>

              </thead>

              <tbody>

                <?php

                $sqlFormulas = "SELECT * FROM premix ORDER BY nombre ASC";

                $queryFormulas = mysqli_query($conexion,$sqlFormulas);
                
                while($fila = mysqli_fetch_array($queryFormulas)){ ?>

                    <td><?php echo $fila['nombre']?></td>

                    <td>
                    
                      <a href="#" data-toggle="modal" data-target="#premix<?php echo $fila['id'];?>" onclick='calcularPorcentajeModal(<?php echo $fila['id'];?>)'>
                    
                        <span class="icon-eye"></span>
                    
                      </a>
                    
                    </td>
                    
                    <td>
                    
                    <a href="raciones.php?accion=modificarPremix&id=<?php echo $fila['id'];?>&seccion=premix">
                      
                      <span class="icon-pencil"></span>
                    
                    </a>
                    
                    </td>

                    <td style="padding-right: 50px;">
                    
                      <a href="raciones.php?accion=eliminarPremix&id=<?php echo $fila['id'];?>&nombre=<?php echo $fila['nombre'];?>" onclick="return confirm('¿Eliminar Registro?');">
                      
                        <span class="icon-cross"></span>
                        
                      </a>
                    
                    </td>

                  </tr>
                            
                  <!-- VER PREMIX -->
                  
                  <div class="modal fade" style="width: 600px;margin-left:-300px;height:450px;z-index:99!important;background-color:transparent;" id="premix<?php echo $fila['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">

                      <div class="modal-dialog" style="width:auto;" role="document">

                        <div class="modal-content">

                          <div class="modal-header">

                            <h3 class="modal-title" id="modalFormula">Premix <?php echo $fila['nombre'];?> | %MS <?php echo $fila['ms'];?> | $/Kg $<?php echo number_format($fila['precio'],2);?></h3>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                          </div>

                          <div class="modal-body">

                            <div class="row-fluid">

                              <div class="span3">

                                <b>Insumo</b>

                              </div>

                              <div class="span2">

                                <b>Kilos</b>

                              </div>

                              <div class="span2">

                                <b>$/Kg</b>

                              </div>

                              <div class="span2">

                                <b>$/T</b>

                              </div>
                              
                              <div class="span3">

                                <b>%</b>

                              </div>

                            </div>

                            <?php

                            $id = $fila['id'];
                            
                            $kilosTotal = 0;
                            
                            $precioTotal = 0;

                            $sql = "SELECT * FROM premix WHERE id = '$id'";
                            
                            $query = mysqli_query($conexion,$sql);

                            while($resultado = mysqli_fetch_array($query)){ 

                              
                              for ($i=1; $i < 11 ; $i++) { 
                                
                                $insumo = 'p'.$i;
                                
                                $kilos = 'kg'.$i;

                                if($resultado[$insumo] != null){

                                  $nombre = dataInsumoPremix($resultado[$insumo],'nombre',$conexion);

                                  $kilos = $resultado[$kilos];

                                  $kilosTotal += $kilos;

                                  $precio = dataInsumoPremix($resultado[$insumo],'precio',$conexion);
                                  
                                  $precioKilos = ($kilos * $precio);
                                  
                                  $precioTotal += $precioKilos;

                                  echo "<div class='row-fluid'>
                                  
                                          <div class='span3'>

                                          <b>$nombre</b>
                                          
                                          </div>

                                          <div class='span2'>
                                          
                                          <span class='kilos$id' id='kilos$i'>$kilos</span> Kg
                                          
                                          </div>

                                          <div class='span2'>
                                          
                                          $ $precio
                                          
                                          </div>

                                          <div class='span2'>
                                          
                                          $ $precioKilos

                                          </div>

                                          <div class='span2'>
                                          
                                          <span class='porcentaje$id'></span> %

                                          </div>
                                    
                                        </div>";
                                }else{
                                  
                                  break;

                                }
                                
                              }

                                


                            }
                            
                            ?>

                            <div class="row-fluid" style="background-color:rgb(235,235,235);">
                            
                              <div class="span3">

                                <b>Totales</b>

                              </div>
                            
                              <div class="span2">

                                <b><?php echo $kilosTotal;?> Kg</b>

                              </div>
                            
                              <div class="span2">


                              </div>
                            
                              <div class="span2">

                                <b>$ <?php echo $precioTotal;?></b>

                              </div>

                              <div class="span2">

                                <b id="porcentajeTotal<?php echo $id?>"></b>

                              </div>

                            </div>
                            
                            <hr>
                            
                            <div class="row-fluid">
                            
                              <div class="span6">
                              
                                <button class="btn btn-default" onclick='imprimirPremix(<?php echo $id; ?>)'>Imprimir</button>

                              </div>

                            </div>

                          </div>

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
      
      <div class="row-fluid">
      
        <div class="span12">
                
          <button class="btn btn-default" id="btnNuevoInsumo" data-toggle="modal" data-target="#nuevoInsumo">Nuevo Insumo</button>

        </div>

      </div>
    </div> 

</div>

<div class="modal fade" style="width: 500px;margin-left:-250px;height:400px;z-index:99!important;background-color:transparent;" id="nuevoInsumo" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">

  <div class="modal-dialog" style="width:auto;" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h3 class="modal-title" id="modalNuevoInsumo">Nuevo Insumo</h3>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">

        <div class="row-fluid">

          <div class="span8">

            <b>Insumo</b>

          </div>

          <div class="span4">

            <b>Precio</b>

          </div>

        </div>
        
        <form action="raciones.php?accion=nuevoInsumoPremix" method="POST">
          
          <div class="row-fluid">
          
            <div class="span8">
            
              <input type="text" class="form-control" name="nombre" required placeholder="Nombre Insumo">
            
            </div>
            
            <div class="span4">
            
              <input type="number" class="form-control" name="precio" required placeholder="Precio Insumo">
            
            </div>
          
          </div>

          <div class="row-fluid">
          
            <div class="span6">
                
                <button class="btn btn-inverse" type="submit">Agregar Insumo</button>
             
            </div>
          
          </div>

        </form>

      </div>

    </div>

  </div>

</div>


 
 <script>
 $(document).ready(function(){
  
  actualizarValores()


});
 </script>