   <?php
$menu = array();
$menu['Stock'] = 'stock.php';
$menu['Status Sanitario'] = 'status.php';
$menu['Raciones'] = 'raciones.php';
//$menu['Imp/Exp'] = 'datos.php?seccion=todos';
$menu['Salir'] = 'logout.php';


 ?>
 <a class="brand" href="index.php" style="font-size:25px;"><b>GESTION DE FEEDLOTS - JORGE CORNALE</b></a>
 <div class="nav-collapse collapse">
            <ul class="nav">
              <?php
                 foreach ($menu as $titulo => $valor) { 
                  if ($titulo == 'Raciones' OR $titulo == 'Salir') { ?>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" style="font-size:20px;" 
                       href="<?php echo $valor;?>"><b><?php echo $titulo; ?></b></a>
                    </li>
                  <?php }else{
                  ?>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle flecha" style="font-size:20px;" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><b><?php echo $titulo;?></b></a>
                        <ul class="dropdown-menu">
                          <?php
                          if ($titulo == 'Status Sanitario') { ?>
                          
                          <li><a class="dropdown-item" style="font-size:18px;" href="<?php echo $valor;?>">Registros</a></li>
                          <li><a class="dropdown-item" style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modal-StatusSanitario">Imprimir Status</a>
                          </li>
                          </li>                            
                          <?php
                          }else{ ?>
                          <li><a class="dropdown-item" style="font-size:18px;" href="<?php echo $valor;?>">Ingresar Registro</a></li>
                          <li><a class="dropdown-item" style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modal-<?php echo $titulo;?>">Informe</a>
                          </li>
                          <?php 
                          }
                          ?>
                        </ul>
                      </li>
                          <?php
                          }}
                          ?>
            </ul>
</div>

<div class="modal fade" id="modal-Stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Informe de Stock</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <form style="margin-bottom: 10px;" method="POST" action="informe.php?seccion=stock">
        <div class="modal-body">
          <span style="display: block;line-height: 10px;"><b>Periodo</b></span>
          <input type="date" name="desde" required/>
          <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
          <input type="date" name="hasta" required/>
          <hr style="margin:0;">
          <h4 style="cursor: pointer;" onclick="comparacion('Stock')">Comparar</h4>
          <div id="compararStock" style="display:none;">  
            <span style="display: block;line-height: 10px;"><b>Periodo 2</b></span>
            <input type="date" name="desdeComp"/>
            <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
            <input type="date" name="hastaComp"/>
          </div>
        </div>

        <div class="modal-footer" style="padding: 0; padding-right: 15px;">
          <button type="submit" class="btn btn-primary">Generar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-StatusSanitario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 0">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Informe de Status</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <form style="margin-bottom: 10px;" method="POST" action="imprimirStatus.php" target="_blank">
        <div class="modal-body">
          <span style="display: block;line-height: 10px;"><b>Periodo</b></span>
          <input type="date" name="desde" required/>
          <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
          <input type="date" name="hasta" required/>
        </div>

        <div class="modal-footer" style="padding: 0; padding-right: 15px;">
          <button type="submit" class="btn btn-primary">Imprimir</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-Raciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Informe de Raciones</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <form style="margin-bottom: 10px;" method="POST" action="informe.php?seccion=racion">
        <div class="modal-body">
          <span style="display: block;line-height: 10px;"><b>Periodo</b></span>
          <input type="date" name="desde" required/>
          <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
          <input type="date" name="hasta" required/>
          <hr style="margin:0;">
          <h4 style="cursor: pointer;" onclick="comparacion('Racion')">Comparar</h4>
          <div id="compararRacion" style="display:none;">  
            <span style="display: block;line-height: 10px;"><b>Periodo 2</b></span>
            <input type="date" name="desdeComp"/>
            <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
            <input type="date" name="hastaComp"/>
          </div>
        </div>

        <div class="modal-footer" style="padding: 0; padding-right: 15px;">
          <button type="submit" class="btn btn-primary">Generar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>




<!--/.nav-collapse -->



