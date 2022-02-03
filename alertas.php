<table class="table" style="border-spacing: 10px;font-size: 20px;"> 
         <thead>
           <th>Tropa N°</th>
           <th>Cantidad</th>
           <th>Fecha Ingreso</th>
           <th>Procedimiento</th>
           <th>Fecha Realizado</th>
           <th>Proxima Fecha</th>
         </thead>
       <tbody>
          <?php 

            $sqlQuery = "SELECT * FROM status WHERE feedlot = '$feedlot'";

            $query = mysqli_query($conexion,$sqlQuery);
            echo mysqli_error($conexion);
            while ($fila = mysqli_fetch_array($query)) {

                  $diasDiferencia = diferenciaDias($fila['fechaRealizado']);
                  $esVencidoValido = esVencido($diasDiferencia,$fila['procedimiento']);
                  $esProximoValido = esProximo($diasDiferencia,$fila['procedimiento']);


                  if ($fila['notificado'] == 0) {
                  
                  if($fila['procedimiento'] == 'Metafilaxis'){
                    $proximaFecha = strtotime ('+7 day',strtotime($fila['fechaRealizado']));
                    $proximaFecha = date('d-m-Y', $proximaFecha);
                  }

                  if($fila['procedimiento'] == '1er Dosis'){
                    $proximaFecha = strtotime ('+15 day',strtotime($fila['fechaRealizado']));
                    $proximaFecha = date('d-m-Y', $proximaFecha);
                  } 
                    
                  $tropa = $fila['tropa'];
                  $sqlFecha = "SELECT MAX(fecha) AS fecha FROM ingresos INNER JOIN status ON ingresos.tropa = status.tropa WHERE status.tropa = '$tropa'";
                  $queryFecha = mysqli_query($conexion,$sqlFecha);
                  $resultado = mysqli_fetch_array($queryFecha);


                  if (!$fila['fechaRealizado']) { ?>
                    <tr class="alert alert-danger alerta-vencido">
                        <td style="line-height: 30px;font-size: 18px;text-align: center;"><?php echo $fila['tropa'];?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo $fila['animales'];?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo formatearFecha($resultado['fecha']);?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo "S/Procedimiento";?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo "-";?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo "-";?></td>
                        <td style="line-height: 30px;font-size: 18px;"><a href="status.php?accion=notificar&tropa=<?php echo $fila['tropa']?>" class="btn btn-danger" onclick="return confirm('¿Cancelar Alerta?');">Notificar</a></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                 <?php }

                  if ($esVencidoValido) {
                    ?>
                      <tr class="alert alert-danger alerta-vencido">
                        <td style="line-height: 30px;font-size: 18px;text-align: center;"><?php echo $fila['tropa'];?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php 
                        echo $fila['animales'];?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php 
                        echo ($tipoSesion != 'balanza') ? formatearFecha($fila['fecha']) : formatearFecha($resultado['fecha']);?>
                        </td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo $fila['procedimiento'];?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo formatearFecha($fila['fechaRealizado']);?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo formatearFecha($proximaFecha);?></td>
                        <td style="line-height: 30px;font-size: 18px;"><a href="status.php?accion=notificar&tropa=<?php echo $fila['tropa']?>" class="btn btn-danger" onclick="return confirm('¿Cancelar Alerta?');">Notificar</a></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                  <?php }
                  
                  if ($esProximoValido) {
                    ?>
                      <tr class="alert alert-warning alerta-proximo">
                        <td style="line-height: 30px;font-size: 18px;text-align: center;"><?php echo $fila['tropa'];?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php 
                        echo $fila['animales'];?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php 
                        echo ($tipoSesion != 'balanza') ? formatearFecha($fila['fecha']) : formatearFecha($resultado['fecha']);?>
                        </td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo $fila['procedimiento'];?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo formatearFecha($fila['fechaRealizado']);?></td>
                        <td style="line-height: 30px;font-size: 18px;"><?php echo formatearFecha($proximaFecha);?></td>
                        <td style="line-height: 30px;font-size: 18px;"><a href="status.php?accion=notificar&tropa=<?php echo $fila['tropa']?>" class="btn btn-warning" onclick="return confirm('¿Cancelar Alerta?');">Notificar</a></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>

                  <?php }
                  }
                }
              ?>
       </tbody>
     </table>