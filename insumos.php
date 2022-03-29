<div class="row-fluid">
  <div class="span6" style="border-right: solid 1px #A8A8A8;height: 480;max-height: 480px;overflow-y: scroll;">                      
    <table class="table table-striped" style="font-weight: bold;">
      <thead>
        <th>Insumo</th>
        <th>Precio</th>
        <th>% MS</th>
        <th></th>
      </thead>
      <tbody>
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

          <tr>
            <td><?php echo utf8_encode($resultado['insumo']);?></td>
            <td><?php echo "$ ".number_format($resultado['precio'],2)?></td>
            <td><?php echo $resultado['porceMS']." %"?></td>
            <td><a href="#" data-toggle="modal" data-target="#modal-modificarInsumo<?php echo $resultado['id'];?>" onclick="zindexModal(<?php echo $resultado['id'];?>)"><span class="icon-pencil"></span></a></td>
            <td><a href="raciones.php?accion=eliminarInsumo&isumo=<?php echo $resultado['insumo'];?>&id=<?php echo $resultado['id'];?>" onclick="return confirm('¿Eliminar Insumo?');"><span class="icon-cross"></span></a></td>

          </tr>

            
            <div class="modal fade zindex-<?php echo $resultado['id'];?>" id="modal-modificarInsumo<?php echo $resultado['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="height:auto;width:640px;background-color:transparent;">
            
              <div class="modal-dialog" role="document">
             
                <div class="modal-content">
             
                  <div class="modal-header">
             
                    <h2 class="modal-title" id="exampleModalLabel">Modificar Insumo</h2>
             
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             
                    </button>
             
                  </div>
              
                  <form style="margin-bottom: 10px;" method="POST" action="raciones.php?accion=modificarInsumo&id=<?php echo $resultado['id'];?>">
                    
                    <div class="modal-body">    

                      <div class="row-fluid">

                              <div class="span6">
                              
                                <div class="form-group">

                                  <label for="nombre"><b>Nombre:</b></label>

                                  <input type="text" class="form-control" name="nombre" value='<?php echo utf8_encode($resultado['insumo']);?>'>

                                </div>
                                
                                <div class="form-group">

                                  <label for="precio"><b>Precio:</b></label>

                                  <input type="text" class="form-control" name="precio" value='<?php echo $resultado['precio'];?>'>

                                </div>

                                <div class="form-group">

                                  <label for="proteina"><b>Proteina:</b></label>

                                  <input type="text" class="form-control" name="proteina" value='<?php echo $resultado['Pr'];?>'>

                                </div>
                                

                              </div>

                              <div class="span6">
                              
                                <div class="form-group">

                                  <label for="selectTipoInsumo"><b>Tipo:</b></label>

                                  <select type="text" class="form-control selectTipoInsumo" name="tipoInsumo">

                                    <option value="<?php echo $resultado['tipo'];?>"><?php echo $resultado['tipo'];?></option>

                                  </select>

                                </div>
                              
                                <div class="form-group campoOtro" style="display:none;">

                                  <label for="otroTipo"><b>Otro Tipo:</b></label>

                                  <input type="text" class="form-control" name='otroTipo'>

                                </div>
                                
                                <div class="form-group">

                                  <label for="porMS"><b>% MS:</b></label>

                                  <input type="text" class="form-control" name="porMS" value='<?php echo $resultado['porceMS'];?>'>

                                </div>

                              </div>
                      
                      </div>

                    <div class="modal-footer" style="padding: 10px 15px 10px 0;">

                      <button type="submit" class="btn btn-primary">Modificar</button>

                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    </div>

                  </form>

                </div>

              </div>

            </div>

        <?php  }
        ?>
       
      </tbody>

    </table>

  
  </div>

  <div class="span6" style="height: 450;max-height: 450px;overflow-y: scroll;">
    <h3>Historial de Precios de Insumos</h3>
        <table class="table table-striped">
          <thead style="font-weight: bold;">
            <th>Fecha Actulizaci&oacute;n</th>
            <th>Insumo</th>
            <th>$ TC</th>
            <th>% MS</th>
            <th>$ MS</th>
            <th></th>
          </thead>
          <tbody>
    <?php
      $sqlRegistros = "SELECT * FROM registroinsumo ORDER BY fecha DESC, insumo ASC";
      $queryRegistros = mysqli_query($conexion,$sqlRegistros);
      while ($filaRegistros = mysqli_fetch_array($queryRegistros)) { ?>
        <tr>
          <td><?php echo formatearFecha($filaRegistros['fecha']);?></td>
          <td><?php echo $filaRegistros['insumo'];?></td>
          <td><?php echo "$ ".number_format($filaRegistros['precio'],2);?></td>
          <td><?php echo $filaRegistros['porceMS']." %";?></td>
          <td><?php 
          if ($filaRegistros['porceMS'] != 0) {
              echo "$ ".number_format((100 *$filaRegistros['precio']) / $filaRegistros['porceMS'],2);
          }else{
              echo "$ 0";
                }
          ?> 
          </td> 
          <td><a href="raciones.php?accion=eliminarRegistro&id=<?php echo $filaRegistros['id'];?>" onclick="return confirm('¿Eliminar registro?')"><span class="icon-cross"></span></a></td>
        </tr>    
          
     <?php }
    ?>
          </tbody>
        </table>
  </div>

  <div class="span12">
    
    <div class="span6">
    
      <button type="submit" class="btn btn-medium btn-primary" id="agregarInsumo" style="float:right;margin-top:5px;margin-right:25px;" data-toggle="modal" data-target="#modal-agregarInsumo" onclick="zIndexModalNuevoInsumo()">+ Agregar Insumo</button>

    </div>
    
    <div class="span6"></div>

  </div>
  
</div>

<!-- MODAL AGREGAR INSUMO -->

<div class="modal fade" id="modal-agregarInsumo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="height:auto;width:640px;background-color:transparent;">
 
  <div class="modal-dialog" role="document">

    <div class="modal-content" style="padding:10px; ">

      <div class="modal-header">

        <h2 class="modal-title" id="exampleModalLabel">Agregar Insumo</h2>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

        </button>

      </div>

      <form method="POST" action="raciones.php?accion=nuevoInsumo">
        
        <div class="row-fluid">

                <div class="span6">
                
                  <div class="form-group">

                    <label for="nombre"><b>Nombre:</b></label>

                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">

                  </div>
                  
                  <div class="form-group">

                    <label for="precio"><b>Precio:</b></label>

                    <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio">

                  </div>

                  <div class="form-group">

                    <label for="proteina"><b>Proteina:</b></label>

                    <input type="text" class="form-control" id="proteina" name="proteina" placeholder="Proteina">

                  </div>
                  

                </div>

                <div class="span6">
                
                  <div class="form-group">

                    <label for="selectTipoInsumo"><b>Tipo:</b></label>

                    <select type="text" class="form-control selectTipoInsumo" id="selectTipoInsumo" name="tipoInsumo">
                    </select>

                  </div>
                
                  <div class="form-group campoOtro" id="campoOtro" style="display:none;">

                    <label for="otroTipo"><b>Otro Tipo:</b></label>

                    <input type="text" class="form-control" id="otroTipo" name='otroTipo' placeholder="Otro Tipo">

                  </div>
                  
                  <div class="form-group">

                    <label for="porMS"><b>% MS:</b></label>

                    <input type="text" class="form-control" id="porMS" name="porMS" placeholder="% MS">

                  </div>

                </div>
        
        </div>
              
        <div class="row-fluid">
        
          <div class="span12">
          
                <button type="submit" class="btn btn-large btn-primary">Agregar Insumo</button>
          
          </div>

        </div>
      
      </form>

    </div>
  
  </div>

</div>

