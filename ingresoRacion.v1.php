<div class="row-fluid">
  <div class="12">
    <form method="POST" class="form-horizontal" action="raciones.php?accion=ingresar">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label class="control-label formulario" for="inputFechaIng">Fecha Ingreso:</label>
            <div class="controls">
              <input type="date" class="input-medium" id="inputFechaIng" name="fechaIngreso" placeholder="Fecha Ingreso" autofocus required>
            </div>
          </div>           
                
          <div class="control-group">
            <label class="control-label formulario" for="inputOperario">Operario:</label>
            <div class="controls">
              <select id="inputOperario" class="input-medium" name="operario" required>
                <option value="">Seleccionar Operario</option>
                <?php
                  $sqlOperarios = "SELECT nombre FROM operarios WHERE feedlot = '$feedlot' ORDER BY nombre ASC";
                  $queryOperarios = mysqli_query($conexion,$sqlOperarios);
                  while ($operarios = mysqli_fetch_array($queryOperarios)) { ?>
                  }
                      <option value="<?php echo $operarios['nombre'];?>"><?php echo $operarios['nombre'];?></option>
                  <?php
                }  
                ?>
                <option value="otro">Otro</option>
              </select>
              <input type="text" class="form-control input-medium otroOperario" id="mostrarOperario" name="operarioOtro" value="">
            </div>
          </div>           
          <div class="control-group">
            <label class="control-label formulario" for="inputCorral">Corral:</label>
            <div class="controls">
              <input type="text" class="input-medium" id="inputCorral" name="corral">
            </div>
          </div>           
        </div>

        <div class="row-fluid">
          <div class="span6">
            <div class="control-group">
            <label class="control-label formulario" for="inputTurno">Turno:</label>
            <div class="controls">
              <select id="inputTurno" name="turno" class="input-medium" required>
                <option value="Ma&ntilde;ana">Ma&ntilde;ana</option>
                <option value="Tarde">Tarde</option>
              </select>
            </div>
          </div>     
            <div class="control-group">
              <label class="control-label formulario" for="inputFormula">Formula:</label>
              <div class="controls">
                <select class="form-control" name="formula" required>
                  <option value="">Seleccionar Formula</option>
                  <?php
                    $sqlFormula = "SELECT * FROM formulas ORDER BY tipo ASC, nombre ASC";
                    $queryFromula = mysqli_query($conexion,$sqlFormula);
                    $tipo = "";
                    while ($filaForm = mysqli_fetch_array($queryFromula)) {
                      if ($tipo != $filaForm['tipo']) { ?>
                        <optgroup label="<?php echo $filaForm['tipo'];?>"></optgroup>
                      <?php 
                      } 
                      ?>
                      <option value="<?php echo $filaForm['id'];?>"><?php echo $filaForm['nombre'];?></option>
                      
                    <?php 
                    $tipo = $filaForm['tipo'];
                  }
                  ?>
                </select>
              </div>
            </div>  
            <div class="control-group">
              <label class="control-label formulario" for="inputKilos">Kilos:</label>
              <div class="controls">
                <input type="text" class="input-medium" id="inputKilos" name="kilos" required>
              </div>
            </div>          
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
            <button type="submit" class="btn btn-large btn-block btn-primary">Ingresar Registro</button>
          </div>
        </div>
    </form>
  </div>
  
  <div class="row-fluid">
      <div class="span12">
        <table class="table table-striped">
          <thead>
            <th>Op. N°</th>
            <th>Fecha</th>
            <th>Turno</th>
            <th>Operario</th>
            <th>Formula</th>
            <th>Corral</th>
            <th></th>
            <th></th>
          </thead>
          <tbody>
            <?php
            $sqlRegistro = "SELECT * FROM raciones WHERE feedlot = '$feedlot' ORDER BY fecha DESC";
            $queryRegistro = mysqli_query($conexion, $sqlRegistro);
            $opNum = 1;

            while ($resultadoRegistro = mysqli_fetch_array($queryRegistro)) {
              $id = $resultadoRegistro['formula'];
              $redondeos = $resultadoRegistro['redondeo'];
              $redondeos = explode(",", $redondeos);
              ?>
              <tr>
                <td><?php echo $opNum; ?></td>
                <td><?php echo formatearFecha($resultadoRegistro['fecha']);?></td>
                <td><?php echo $resultadoRegistro['turno'];?></td>
                <td><?php echo $resultadoRegistro['operario'];?></td>
                <td style="color:#00C513"><?php echo nombreFormula($id,$conexion);?></td>
                <td><?php echo $resultadoRegistro['corral'];?></td>
                <td><span class="icon-pencil iconos" style="cursor:pointer;" data-toggle="modal" data-target="#modificarIngreso<?php echo $resultadoRegistro['id'];?>" onclick="zindexModal('<?php echo $resultadoRegistro['id'];?>')"></span></td>
                <td><a href="raciones.php?accion=eliminar&id=<?php echo $resultadoRegistro['id']?>"  onclick="return confirm('¿Eliminar Registro?');"><span class="icon-bin2 iconos"></span></a></td>
              </tr>

              <div class="modal fade modalFormula zindex-<?php echo $resultadoRegistro['id'];?>" style="width: 600px;margin-left: -300px;" id="modificarIngreso<?php echo $resultadoRegistro['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"    aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2 class="modal-title" id="exampleModalLabel">Modificar Racion</h2>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      </button>
                    </div>
                    <form style="padding-left: 0;" method="POST" action="raciones.php?accion=modificarIngreso&id=<?php echo $resultadoRegistro['id']?>">
                      <div class="modal-body">
                        <div class="cuerpo-modal" style="width: 100%;text-align: left;">
                          <div class="row-fluid">
                            <div class="span2">
                              <b>Fecha:</b>
                            </div>
                            <div class="span4">
                              <input type="date" class="input-medium" name="fechaIngreso" value="<?php echo $resultadoRegistro['fecha'];?>" autofocus>
                            </div>
                            <div class="span2">
                              <b>Turno:</b>
                            </div>
                            <div class="span1">
                                <select name="turno" class="input-medium">
                                  <option value="Ma&ntilde;ana">Ma&ntilde;ana</option>
                                  <option value="Tarde">Tarde</option>
                                </select>
                            </div>
                          </div>
                          <div class="row-fluid">
                            <div class="span2">
                              <b>Operario:</b>
                            </div>
                            <div class="span4">
                              <select id="inputOperarioModal" class="input-medium" name="operario">
                                <option value="<?php echo $resultadoRegistro['operario'];?>"><?php echo $resultadoRegistro['operario'];?></option>
                                <?php
                                $sqlOperarios = "SELECT nombre FROM operarios WHERE feedlot = '$feedlot' ORDER BY nombre ASC";
                                $queryOperarios = mysqli_query($conexion,$sqlOperarios);
                                while ($operarios = mysqli_fetch_array($queryOperarios)) { ?>

                                    <option value="<?php echo $operarios['nombre'];?>"><?php echo $operarios['nombre'];?></option>
                                
                                <?php
                                
                              }  
                              
                              ?>
                              <option value="otro">Otro</option>
                            </select>
                            <input type="text" class="form-control input-medium otroOperario" id="mostrarOperarioModal" name="operarioOtro" value="">
                            </div>
                            <div class="span2">
                              <b>Corral:</b>
                            </div>
                            <div class="span3">
                              <input type="text" class="input-medium" id="inputCorral" name="corral" value="<?php echo $resultadoRegistro['corral'];?>">
                            </div>
                          </div>
                          <div class="row-fluid">
                            <div class="span2">
                              <b>Formula:</b>
                            </div>
                            <div class="span4">
                              <input type="text" class="input-medium" id="inputFormula" name="formula" value="<?php echo nombreFormula($resultadoRegistro['formula'],$conexion);?>" readonly> 
                            </div>
                             <div class="span2">
                              <b>Kilos:</b>
                            </div>
                            <div class="span4">
                              <input type="number" step="0.01" class="input-medium" id="inputFormula" name="kilos" value="<?php echo $resultadoRegistro['kilos'];?>">
                            </div>
                          </div>
                        </div> 
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Modificar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php
              $opNum ++;
            }
            ?>
          </tbody>
        </table>
      </div>
  </div>
</div>