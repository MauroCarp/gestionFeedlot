<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
require("includes/arrays.php");
require('verTropa.backend.php');

require 'head.php';

?>

    <div class="container" style="padding-top: 50px;">
      
      <h1 style="display: inline-block;">STOCK</h1>
      
      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>
      
      <div class="hero-unit" style="padding-top: 10px;margin-bottom: 5px;">
      
        <h2>Tropa <?php echo $tropa;?></h2>

        <div class="bs-docs-example">
          
          <?php
          
          if ($seccion == 'ingresos') { ?>
          
            <div class="totales">
            
              <div class="row-fluid">
              
                <div class="span6"><b>- R.E.N.S.P.A: </b><?php echo $renspa;?></div>
              
                  <div class="span6"><b>- ADPV: </b><?php echo number_format($adpv,2,",",".")." Kg";?></div>
              
                </div>
              
                <div class="row-fluid" style="background-color:#eeeeee">
              
                  <div class="span6"><b>- Fecha de Ingreso: </b><?php echo formatearFecha($fechaIngreso);?></div>
                
                  <div class="span6"><b>- Total Ingreso: </b><?php echo number_format($cantIng,0,",",".")." Animales";?></div>
              
                </div>
              
                <div class="row-fluid">
              
                <div class="span6"><b>- Proveedor: </b><?php echo $proveedor;?></div>
              
                  <div class="span6"><b>- Origen: </b><?php echo $origen;?></div>
              
                </div>
              
                <div class="row-fluid" style="background-color:#eeeeee">
              
                  <div class="span6"><b>- Estado: </b><?php echo $estado;?></div>
              
                  <div class="span6"><b>- Corral: </b><?php echo $corral;?></div> 
              
                </div>
              
                <div class="row-fluid">
              
                  <div class="span6"><b>- Kg Neto Ingreso: </b><?php echo number_format($totalPesoIng,0,",",".")." Kg";?></div>
              
                  <div class="span6"><b>- Peso Min: </b><?php echo $pesoMin." Kg";?></div>
                  
                </div>
                
                <div class="row-fluid">
                  
                  <div class="span6"><b>- Kg Ingreso Promedio: </b><?php echo number_format($kgIngProm,2,",",".")." Kg";?></div>
              
                  <div class="span6"><b>- Peso Max.: </b><?php echo $pesoMax." Kg";?></div>
              
                </div>
              
                <div class="row-fluid" style="background-color:#eeeeee">
              
                  <div class="span12"><b>- Notas: </b><?php echo $notas;?></div>
              
                </div>
              
                <div class="row-fluid" style="margin-top: 5px;">
              
                  <div class="span6">
                
                    <a href="#" data-toggle="modal" data-target="#modificarTropa" class="btn btn-default" onclick="zindexModal()"><b>Modificar</b></a>
              
                  </div>
              
                </div>
                
                
                <div class="modal fade" id="modificarTropa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width: 450px;">
                
                  <div class="modal-dialog" role="document">
                  
                    <div class="modal-content">
                  
                      <div class="modal-header">
                  
                        <h2 class="modal-title" id="exampleModalLabel">Modificar Tropa</h2>
                  
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                  
                      </div>
                  
                      <form style="margin-bottom: 10px;" method="POST" action="verTropa.php?accion=modificar&tropa=<?php echo $tropa?>">
                  
                        <div class="modal-body">    
                  
                          <div class="row-fluid">
                  
                            <div class="span6">
                  
                              <div class="control-group">
                  
                                <label class="control-label formulario" for="inputTropa">Tropa:</label>
                  
                                  <div class="controls">
                  
                                    <input type="text" id="inputTropa" name="tropa"  value="<?php echo $tropa;?>" required autofocus>
                  
                                  </div>
                  
                              </div>
                  
                            </div>
                  
                            <div class="span6">
                  
                              <div class="control-group">
                  
                                <label class="control-label formulario" for="inputFechaIng">Fecha Ingreso:</label>
                  
                                <div class="controls">
                
                                  <input type="date" id="inputFechaIng" name="fechaIngreso" value="<?php echo $fechaIngreso?>" required>
                
                                </div>
                  
                              </div>           
                  
                            </div>   
                  
                          </div>
                  
                          <div class="row-fluid">
                  
                            <div class="span6">
                  
                              <div class="control-group">
                  
                                <label class="control-label formulario" for="inputRenspa">R.E.N.S.P.A:</label>
                  
                                <div class="controls">
                
                                  <input type="text" id="inputRenspa" name="renspa" value="<?php echo $renspa;?>">
                
                                </div>
                  
                              </div>           
                  
                            </div>
                
                            <div class="span6">
                  
                              <div class="control-group">
                  
                                <label class="control-label formulario" for="inputAdpv">ADPV:</label>
                  
                                <div class="controls">
                
                                  <input type="number" step="0.01" id="inputAdpv" name="adpv" value="<?php echo $adpv;?>">
                
                                </div>
                
                              </div>           
                
                            </div>  
                  
                          </div>
                  
                          <div class="row-fluid">
                
                            <div class="span6">
                  
                              <div class="control-group">
                  
                                <label class="control-label formulario" for="inputOrigen">Origen:</label>
                  
                                <div class="controls">
                
                                  <input type="text" id="inputOrigen" name="origen" value="<?php echo $origen;?>" >
                
                                </div>
                  
                              </div>           
                  
                            </div>
                
                            <div class="span6">
                
                              <div class="control-group">
                  
                                <label class="control-label formulario" for="inputProveedor">Proveedor:</label>
                  
                                <div class="controls">
                
                                  <input type="text" id="inputProveedor" name="proveedor" value="<?php echo $proveedor;?>" >
                
                                </div>
                  
                              </div>           
                  
                            </div>
                
                          </div>
                
                          <div class="row-fluid">
                
                            <div class="span6">
                  
                              <div class="control-group">
                  
                                <label class="control-label formulario" for="inputEstado">Estado:</label>
                  
                                <div class="controls">
                
                                  <input type="text" id="inputEstado" name="estado" value="<?php echo $estado;?>">
                
                                </div>
                  
                              </div>           
                  
                            </div>
                
                            <div class="span6">
                
                              <div class="control-group">
                  
                                <label class="control-label formulario" for="inputCorral">Corral:</label>
                  
                                <div class="controls">
                
                                  <input type="number" id="inputCorral" name="corral" value="<?php echo $corral;?>">
                
                                </div>
                  
                              </div>           
                
                            </div>
                
                          </div>
                
                          <div class="row-fluid">
                
                            <div class="span6">
                  
                              <div class="control-group">
                  
                                <label class="control-label formulario" for="inputNotas">Notas:</label>
                  
                                <div class="controls">
                
                                  <input type="text" id="inputNotas"  class="input-large" name="notas"  value="<?php echo $notas; ?>">
                
                                </div>
                
                              </div>           
                  
                            </div>
                
                          </div>
                  
                        </div>
                  
                        <div class="modal-footer" style="padding: 10px 15px 10px 0;">
                
                          <button type="submit" class="btn btn-default"><b>Modificar</b></button>
                
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
                        </div>
                  
                      </form>
                  
                    </div>
                  
                  </div>
                  
                </div>

              </div>

              <a href="#" class="btn btn-default btn-small" style="margin-top: 10px;margin-bottom: -5px;" id="verDetalles"><b>Detalle de Tropa</b></a>
            
              <div id="detalleTropa" style="display:none;" class="row-fluid">
                
                <div class="span12" style="height: 250px;overflow-y: scroll;margin-top:10px;">
                  <a  href="imprimir/imprimirTropa.php?tropa=<?php echo $tropa;?>&seccion=ingresos" target="_blank"  style="float:right;font-size:1.3em;"  class="btn btn-default"><span class="icon-printer iconos"></span></a>
                  <a  href="exportar/detalleTropa.php?tropa=<?php echo $tropa;?>&seccion=ingresos" target="_blank"  style="float:right;font-size:1.3em;"  class="btn btn-default"><span class="icon-file-excel iconos"></span></a>
                  <table class="table table-striped table-hover">
                    <thead>
                      <th>IDE</th>
                      <th>Num. DTE</th>
                      <th>Peso</th>
                      <th>Raza</th>
                      <th>Sexo</th>
                      <th>Estado</th>
                      <th>Hora</th>
                      <th></th>
                    </thead>
                    <tbody>
                      <?php
                      $detalleIng = "SELECT id,id,IDE,numDTE,peso,raza,sexo,estadoAnimal,hora FROM ingresos WHERE tropa = '$tropa' ORDER BY hora ASC,peso ASC";
                      $queryDetalleIng = mysqli_query($conexion,$detalleIng);
                      while ($filaDetalle = mysqli_fetch_array($queryDetalleIng)) { ?>
                      <tr>
                        <td><?php echo $filaDetalle['IDE'];?></td>
                        <td><?php echo $filaDetalle['numDTE'];?></td>
                        <td><?php echo $filaDetalle['peso'];?></td>
                        <td><?php echo $filaDetalle['raza'];?></td>
                        <td><?php echo $filaDetalle['sexo'];?></td>
                        <td><?php echo $filaDetalle['estadoAnimal'];?></td>
                        <td><?php echo $filaDetalle['hora'];?></td>
                        <td><a style="cursor:pointer;font-size:18px;" class="btnEditarAnimal" data-toggle="modal" data-target="#modalEditarAnimal" idAnimal="<?php echo $filaDetalle['id'];?>" seccion="ingresos"><span class="icon-pencil iconos"></span></a></td>
                      </tr>  
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                
                </div>
                
              </div>

          <?php 
          }

          if ($seccion == 'egresos') { ?>

            <div class="totales">
              
              <div class="row-fluid">
                <div class="span6"><b>- Fecha de Egreso: </b><?php echo formatearFecha($fechaEgreso);?></div>
                <div class="span6"><b>- Total Egreso: </b><?php echo number_format($cantEgr,0,",",".")." Animales";?></div>
              </div>
              
              <div class="row-fluid" style="background-color:#eeeeee">
                <div class="span6"><b>- Kg Neto Egreso: </b><?php echo number_format($totalPesoEgr,0,'','.')." Kg";?></div>
                <div class="span6"><b>- Peso Min.: </b><?php echo $pesoMinEgr." Kg";?></div> 
              </div>
              
              <div class="row-fluid">
                <div class="span6"><b>- Kg Egreso Promedio: </b><?php echo formatearNum($kgEgrProm)." Kg";?></div>
                <div class="span6"><b>- Peso Max.: </b><?php echo $pesoMaxEgr." Kg";?></div>
              </div>

            </div>

            <a href="#" class="btn btn-default btn-small" style="margin-top: 10px;margin-bottom: -5px;" id="verDetalles"><b>Detalle de Tropa</b></a>

            <div id="detalleTropa" style="display:none;" class="row-fluid">
              
              <div class="span12" style="height: 250px;overflow-y: scroll;margin-top:10px;">
                
                <a  href="imprimir/imprimirTropa.php?tropa=<?php echo $tropa;?>&seccion=egresos" target="_blank"  style="float:right;font-size:1.3em;"  class="btn btn-default"><span class="icon-printer iconos"></span></a>
                <a  href="exportar/detalleTropa.php?tropa=<?php echo $tropa;?>&seccion=egresos" target="_blank"  style="float:right;font-size:1.3em;"  class="btn btn-default"><span class="icon-file-excel iconos"></span></a>
                
                <table class="table table-striped table-hover">
                  <thead>
                    <th>IDE</th>
                    <th>Peso</th>
                    <th>Raza</th>
                    <th>Sexo</th>
                    <th>GMD Total</th>
                    <th>GPV Total</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Hora</th>
                    <th></th>
                  </thead>
                  <tbody>
                    <?php
                    $detalleIng = "SELECT id,IDE,peso,raza,sexo,hora,gdmTotal,gpvTotal,origen,destino FROM egresos WHERE tropa = '$tropa' ORDER BY hora ASC,peso ASC";
                    $queryDetalleIng = mysqli_query($conexion,$detalleIng);
                    while ($filaDetalle = mysqli_fetch_array($queryDetalleIng)) { ?>
                    <tr>
                      <td><?php echo $filaDetalle['IDE'];?></td>
                      <td><?php echo $filaDetalle['peso'];?></td>
                      <td><?php echo $filaDetalle['raza'];?></td>
                      <td><?php echo $filaDetalle['sexo'];?></td>
                      <td><?php echo $filaDetalle['gdmTotal'];?></td>
                      <td><?php echo $filaDetalle['gpvTotal'];?></td>
                      <td><?php echo $filaDetalle['origen'];?></td>
                      <td><?php echo $filaDetalle['destino'];?></td>
                      <td><?php echo $filaDetalle['hora'];?></td>
                      <td><a style="cursor:pointer;font-size:18px;"  class="btnEditarAnimal" data-toggle="modal" data-target="#modalEditarAnimal" idAnimal="<?php echo $filaDetalle['id'];?>" seccion="egresos"><span class="icon-pencil iconos"></span></a></td>

                    </tr>  
                    <?php
                    }
                    ?>
                  </tbody>
                </table>

              </div>

            </div>
           
          <?php 
          }
          ?>
          
          <hr>
          
          <?php
          
          if ($seccion == 'ingresos') { ?>
          
            <div class="row-fluid">
              <div class="span7">
                <div id="canvas-holder" style="width:100%;display: inline-block;">
                  <canvas id="canvasRaza"></canvas>
                </div>
              </div>
              <div class="span5">
                <div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">
                  <canvas id="chart-area"></canvas>
                </div>
              </div>
            </div>

            <hr>

            <div class="row-fluid">
              <div class="span7">
                <div id="canvas-holder" style="width:100%;display: inline-block;">
                  <canvas id="canvasIncremento"></canvas>
                </div>
              </div>
              <div class="span5">
                <div id="canvas-holder" style="width:100%">
                  <canvas id="chart-areaPesos"></canvas>
                </div>
                <div class="row-fluid">
                  <div class="span4"></div>
                  <div class="span2">
                    <input type="number" class="input-mini" id="pesoDesde" value="0" onblur="calculaCPS()">
                  </div>
                  <div class="span2">
                    <input type="number" class="input-mini" id="pesoHasta" value="0" onblur="calculaCPS()">
                  </div>
                  <div class="span4"></div>
                </div>
                <div class="row-fluid">
                  <div class="span12" style="text-align: center;">
                    <button class="btn btn-secondary" id="calcularCant" value="">Calcular</button>
                  </div>
                </div>
              </div>
            </div>

            <a href="stock.php?seccion=ingreso" class="btn btn-default btn-large">Volver</a>

          <?php 
          }
          if ($seccion == 'egresos') { ?>

            
            <div class="row-fluid">
            
              <div class="span7">

                <div id="canvas-holder" style="width:100%;display: inline-block;">

                  <canvas id="canvasRazaEgr"></canvas>

                </div>

              </div>

              <div class="span5">

                <div id="canvas-holder" style="width:100%;display: inline-block;vertical-align: top;">

                <canvas id="chart-areaEgr"></canvas>

                </div>

              </div>

            </div>

            <hr>

            <a href="stock.php?seccion=egreso" class="btn btn-default btn-large">Volver</a>

          <?php 
          }
          ?>
            <span class="ir-arriba icon-arrow-up2"></span>

        </div>

        <hr>

      </div>

    </div>

    
    
    
  </body>
  
  <!-- MODAL -->

  <div class="modal fade" id="modalEditarAnimal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width:600px;margin-top:50px;">
              
    <div class="modal-dialog" role="document">
    
      <div class="modal-content">
    
        <div class="modal-header">
    
          <h2 class="modal-title" id="exampleModalLabel">Editar Animal</h2>
    
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    
        </div>
        
        <div class="modal-body" id="bodyModal">    
        
          <div id="animalesEgresos" style="display:none;">

            <div class="row-fluid">
    
              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputPesoEditar">Peso:</label>
    
                    <div class="controls">
    
                      <input type="text" class="dataEditar" id="inputPesoEditar" name="peso"  value="" required autofocus>
                      <input type="hidden" class="dataEditar" id="idAnimalEditar" name="idAnimal">

                    </div>
    
                </div>
    
              </div>

              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputGdmTotalEditar">Gdm Total:</label>
    
                    <div class="controls">
    
                      <input type="number" class="dataEditar"  step="0.01" id="inputGdmTotalEditar" name="gmdTotal"  value="">
    
                    </div>
    
                </div>
    
              </div>

              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputGpvTotalEditar">Gpv Total:</label>
    
                    <div class="controls">
    
                      <input type="number" class="dataEditar" step="0.01" id="inputGpvTotalEditar" name="gpvTotal"  value="">
    
                    </div>
    
                </div>
    
              </div> 
    
            </div>

            <div class="row-fluid">
    
              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputRazaEditar">Raza:</label>
    
                    <div class="controls">
    
                      <input type="text" class="dataEditar" id="inputRazaEditar" name="raza"  value="" required>
    
                    </div>
    
                </div>
    
              </div>

              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputSexoEditar">Sexo:</label>
    
                    <div class="controls">
    
                      <input type="text" class="dataEditar"  step="0.01" id="inputSexoEditar" name="sexo"  value="">
    
                    </div>
    
                </div>
    
              </div>

              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputOrigenEditar">Origen:</label>
    
                    <div class="controls">
    
                      <input type="text" class="dataEditar" id="inputOrigenEditar" name="origen"  value="">
    
                    </div>
    
                </div>
    
              </div>
    
            </div>

            <div class="row-fluid">
    
              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputProveedorEditar">Proveedor:</label>
    
                    <div class="controls">
    
                      <input type="text" class="dataEditar" id="inputProveedorEditar" name="proveedor"  value="">
    
                    </div>
    
                </div>
    
              </div>

              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputDestinoEditar">Destino:</label>
    
                    <div class="controls">
    
                      <input type="text" class="dataEditar" id="inputDestinoEditar" name="destino"  value="">
    
                    </div>
    
                </div>
    
              </div> 
    
            </div>
          
          </div>

          <div id="animalesIngresos" style="display:none;">

            <div class="row-fluid">
    
              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputPesoEditar">Peso:</label>
    
                    <div class="controls">
    
                      <input type="text" class="dataEditar" id="inputPesoEditar" name="peso"  value="" required autofocus>
                      <input type="hidden" class="dataEditar" id="idAnimalEditar" name="idAnimal">

                    </div>
    
                </div>
    
              </div>

              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputRazaEditar">Raza:</label>
    
                    <div class="controls">
    
                      <input type="text" class="dataEditar" id="inputRazaEditar" name="raza"  value="" required>
    
                    </div>
    
                </div>
    
              </div>

              <div class="span4">
    
                <div class="control-group">
    
                  <label class="control-label formulario" for="inputSexoEditar">Sexo:</label>
    
                    <div class="controls">
    
                      <input type="text" class="dataEditar" id="inputSexoEditar" name="sexo"  value="" required>
    
                    </div>
    
                </div>
    
              </div> 
    
            </div>

          </div>

        </div>
  
        <div class="modal-footer" style="padding: 10px 15px 10px 0;">

          <button type="submit" class="btn btn-default" id="btnEditarAnimal"><b>Modificar</b></button>

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

        </div>
          
      </div>
    
    </div>
    
  </div>


  <script type="text/javascript">
      
      let  btnDetalles = document.getElementById('verDetalles');
      
      btnDetalles.addEventListener('click',function(){
      
        $('#detalleTropa').toggle(500);
      
      });

      $(document).ready(function(){

        $('.ir-arriba').click(function(){
          $('body, html').animate({
            scrollTop: '0px'
          }, 300);
        });
        
        $(window).scroll(function(){
          if( $(this).scrollTop() > 0 ){
            $('.ir-arriba').slideDown(300);
          } else {
            $('.ir-arriba').slideUp(300);
          }
        });
        
      });

        function zindexModal(){
        
          $("#modificarTropa").css('z-index','1');
        
        }
          
      $(document).ready(function(){
          $(".modal").each(function(){
            $(this).css('z-index',0);
          })  
        });

      //INGRESOS
        <?php
        if ($seccion == 'ingresos') { 
          ?>
      // SEXO

          let config = {
            type: 'pie',
            data: {
              datasets: [{
                data: [
                <?php
                if ($seccion == 'ingresos') {
                  $sqlMacho = "SELECT COUNT(sexo) AS macho FROM ingresos WHERE sexo = 'Macho' AND tropa = '$tropa'";
                  $queryMacho = mysqli_query($conexion,$sqlMacho);
                  $resultado = mysqli_fetch_array($queryMacho);
                  $macho = $resultado['macho'];

                  $sqHemb = "SELECT COUNT(sexo) AS hembra FROM ingresos WHERE sexo = 'Hembra' AND tropa = '$tropa'";
                  $querHemb = mysqli_query($conexion,$sqHemb);
                  $resultado = mysqli_fetch_array($querHemb);
                  $hembra = $resultado['hembra'];
                }

                $resultado = $macho.",".$hembra.",";
                echo $resultado;

                ?>
                ],
                backgroundColor: [
                window.chartColors.red,
                window.chartColors.orange,
                ],
                label: 'Sexo'
              }],
              labels: [
              'Macho',
              'Hembra'
              ]
            },
            options: {
              responsive: true,
              title: {
                display: true,
                text: 'Cant. Segun Sexo'
              },
              plugins:{
                labels:{
                  render:'percentage',
                  fontColor:'white'
                }
              }
            }
          };

      // CANTIDAD SEGUN PESO
        var cantPesos = {
          type: 'doughnut',
          data: {
            datasets: [{
              data: [
              <?php echo $resultado;?>
              ],
              backgroundColor: [
                '#FF6D88',
                '#F8A233',
              ],
              label: 'Dataset 1'
            }],
            labels: [
              'Macho',
              'Hembra'
            ]
          },
          options: {
            circumference: Math.PI,
            rotation: -Math.PI,
            responsive: true,
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Cantidad según Sexo, y Peso'
            },
            animation: {
              animateScale: true,
              animateRotate: true
            },
            plugins:{
                labels:{
                  render:'percentage',
                  fontColor:'white'
                }
            }

          }
        };  

      // RAZAS
        <?php
          $sqlRazas = "SELECT raza FROM razas ORDER BY raza ASC";
          $queryRazas = mysqli_query($conexion,$sqlRazas);
          $labelsRaza = "";
          $cantXraza = "";
          while ($razas = mysqli_fetch_array($queryRazas)) {
            $labelsRaza = $labelsRaza.",'".$razas['raza']."'";  
            ${$razas['raza']} = cantRaza($razas['raza'],'ingresos',$tropa,$conexion);
            $cantXraza = $cantXraza.",".${$razas['raza']};
          }
          $labelsRaza = substr($labelsRaza, 1);
          $cantXraza = substr($cantXraza, 1);
          ?>
          let razas = [
          <?php
          echo $labelsRaza;
          ?>
          ];
          let color = Chart.helpers.color;
          let barChartData = {
            labels: [
            <?php
            echo $labelsRaza;
            ?>
            ],
            datasets: [{
              label: 'Cantidad',
              backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
              borderColor: window.chartColors.red,
              borderWidth: 1,
              data: [
              <?php
                echo $cantXraza;
              ?>
              ]
            }]

          };
      
      
          // INCREMENTO

        var configInc = {
          type: 'line',
          data: {
            labels: [

            <?php
            $fechaHoy = date("Y-m-d");
            $ingreso = new DateTime("$fechaIngreso");
            $hoy = new DateTime("$fechaHoy");
            $diferencia = $ingreso->diff($hoy);
            $diferencia = $diferencia->days;
            $fechaSumada = $fechaIngreso;
            $contador = 1;
            $pesos = "";
            $labels = "";
            $pesoInicial = $kgIngProm;

            $pesoTemp = $kgIngProm;
            $array = array();

            if ($diferencia > 5) {
              while ($fechaSumada < $fechaHoy) {
                $contador++;
                $pesoTemp += ($adpv*5);
                $array[$fechaSumada] = $pesoTemp;
                $fechaSumada = date("Y-m-d",strtotime($fechaSumada."+ 5 days"));
                $ultimaFecha = $fechaSumada;

              }

              function endKey($array){
                  end($array);
                  return key( $array );
              }
              $ultimaFecha = endKey($array);

              $ultima = new DateTime("$ultimaFecha");
              $hoy = new DateTime("$fechaHoy");
              $diferencia = $ultima->diff($hoy);
              $diferencia = $diferencia->days;

              $pesoTemp = $pesoTemp + ($adpv*$diferencia);

              $array[$fechaHoy] = $pesoTemp;

              foreach ($array as $fechas => $kilos) {
                $labels = $labels.",'".formatearFecha($fechas)."'";
                $pesos = $pesos.",".$kilos;
              }

              $labels = substr($labels,1);
              $pesos = substr($pesos,1);

            }else{
            $labels = "'".formatearFecha($fechaIngreso)."','".formatearFecha($fechaHoy)."'";
            $ultimaFecha = $fechaHoy;
            $pesos = $pesoTemp.",";
            $pesoTemp = $pesoTemp + ($adpv*$diferencia);
            $pesos = $pesos.$pesoTemp;
            }



            echo $labels;
            ?>

            ],
            datasets: [{
              label: 'Incremento de peso, basado en ADPV <?php echo $adpv." Kg";?>',
              backgroundColor: window.chartColors.red,
              borderColor: window.chartColors.red,
              data: [
                <?php

                echo $pesos;

                ?>
              ],
              fill: false,
            }]
          },
          options: {
            responsive: true,
            title: {
              display: true,
              text: 'Incremento de Peso'
            },
            tooltips: {
              mode: 'index',
              intersect: false,
            },
            hover: {
              mode: 'nearest',
              intersect: true
            },
            scales: {
              xAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: 'Fecha'
                }
              }],
              yAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: 'Peso'
                }
              }]
            }
          }
        };

        <?php
        }
        ?>

     //EGRESOS
        <?php
        if ($seccion == 'egresos') {
        include('includes/charts/tropaEgr.php');
        }
        ?>

        function calculaCPS(){
          var desde = $('#pesoDesde').val();
          var hasta = $('#pesoHasta').val();
          var tropa = <?php echo "'".$tropa."'";?>;

          var datos = 'tropa=' + tropa + '&desde=' + desde + '&hasta=' + hasta;
          var url = 'cantidadSegunPeso.php';

          $.ajax({
            type:'POST',
            url:url,
            data:datos,
            success: function(datos){
              datos = datos.split(",");
              myDoughnut.data.datasets[0].data[0] = datos[0];
              myDoughnut.data.datasets[0].data[1] = datos[1];
              myDoughnut.update();
            }
          });
        } 
         
        window.onload = function() {
            
          <?php if ($seccion == 'ingresos') { ?>
              
              let cantidadPesos = document.getElementById('chart-areaPesos').getContext('2d');
              window.myDoughnut = new Chart(cantidadPesos, cantPesos);

              let sexo = document.getElementById('chart-area').getContext('2d');
              window.myPie = new Chart(sexo, config);
              
              let adpv = document.getElementById('canvasIncremento').getContext('2d');
              window.myLine = new Chart(adpv, configInc);

              let raza = document.getElementById('canvasRaza').getContext('2d');
              window.myBar = new Chart(raza, {
                type: 'horizontalBar',
                data: barChartData,
                options: {
                  responsive: true,
                  legend: {
                    position: 'top',
                  },
                  title: {
                    display: true,
                    text: 'Cant. Segun Raza'
                  },
                  scaleShowValues: true,
                  scales: {
                    xAxes: [{
                      ticks: {
                        autoSkip: false
                      }
                    }]
                  }
                }
              });


              document.getElementById('calcularCant').addEventListener('click', function() {
                var desde = $('#pesoDesde').val();
                var hasta = $('#pesoHasta').val();
                var tropa = <?php echo "'".$tropa."'";?>;

                var datos = 'tropa=' + tropa + '&desde=' + desde + '&hasta=' + hasta;
                var url = 'cantidadSegunPeso.php';

                $.ajax({
                  type:'POST',
                  url:url,
                  data:datos,
                  success: function(datos){
                    datos = datos.split(",");
                    myDoughnut.data.datasets[0].data[0] = datos[0];
                    myDoughnut.data.datasets[0].data[1] = datos[1];
                    myDoughnut.update();
                  }
                });   
              });
              
          <?php 
            }

            if ($seccion == 'egresos') { ?>
              var sexoEgr = document.getElementById('chart-areaEgr').getContext('2d');
              window.myPie = new Chart(sexoEgr, configEgr);

              var razaEgr = document.getElementById('canvasRazaEgr').getContext('2d');
              window.myBar = new Chart(razaEgr, {
                type: 'horizontalBar',
                data: barChartDataEgr,
                options: {
                  responsive: true,
                  legend: {
                    position: 'top',
                  },
                  title: {
                    display: true,
                    text: 'Cant. Segun Raza'
                  },
                  scaleShowValues: true,
                  scales: {
                    xAxes: [{
                      ticks: {
                        autoSkip: false
                      }
                    }]
                  }
                }
              });
            <?php
            }
          ?>
            
        };

   </script>
  <script src="js/verStock.js"></script>

</html>
