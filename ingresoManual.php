<h3 style="text-decoration: underline;cursor: pointer;" id="abrirManual"><b>Manual</b></h3>
<div id="cargaManual" style="display:none;">
  <form name="f1" class="form-horizontal" method="POST" action="stock.php?accion=cargarManual"> 
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputTropa">Tropa:</label>
          <div class="controls">
            <input type="text" id="inputTropa" class="input-large" name="tropa" placeholder="Tropa" required autofocus>
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputFechaIng">Fecha Ingreso:</label>
          <div class="controls">
            <input type="date" id="inputFechaIng" name="fechaIngreso" placeholder="Fecha Ingreso" required>
          </div>
        </div>           
      </div>   
    </div>
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputRenspa">R.E.N.S.P.A:</label>
          <div class="controls">
            <input type="text" id="inputRenspa" name="renspa" placeholder="R.E.N.S.P.A">
          </div>
        </div>           
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputAdpv">ADPV:</label>
          <div class="controls">
            <input type="number" step="0.01" id="inputAdpv" name="adpv" placeholder="a.d.p.v">
          </div>
        </div>           
      </div>  
    </div>
    <div class="row-fluid">   
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputCantidad">Cant. Animales:</label>
          <div class="controls">
            <input type="number" id="inputCantidad" name="cantidad" placeholder="Cantidad de animales" required>
          </div>
        </div>           
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputRaza">Raza:</label>
          <div class="controls">
            <select name="raza" id="razas">
              <option value="">Selec. Raza</option>
              <?php
              $sqlRaza = "SELECT * FROM razas ORDER BY raza ASC";
              $queryRaza = mysqli_query($conexion, $sqlRaza);
              while ($raza = mysqli_fetch_array($queryRaza)) { ?>
                <option value="<?php echo $raza['raza'];?>"><?php echo $raza['raza'];?></option>
             <?php }
              ?>
              <option value="otro">Otro</option>
            </select>
            <input type="text" name="otraRaza" id="otraRaza" placeholder="Nueva Raza" style="display: none;">
          </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputOrigen">Origen:</label>
          <div class="controls">
            <input type="text" id="inputOrigen" name="origen" placeholder="Origen" >
          </div>
        </div>           
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputProveedor">Proveedor:</label>
          <div class="controls">
            <input type="text" id="inputProveedor" name="proveedor" placeholder="Proveedor" >
          </div>
        </div>           
      </div>
    </div>
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputPeso">Peso:</label>
          <div class="controls">
            <input type="number" step="0.01" id="inputPeso" name="peso" placeholder="Peso" required>
          </div>
        </div>           
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputEstado">Estado:</label>
          <div class="controls">
            <input type="text" id="inputEstado" name="estado" placeholder="Estado">
          </div>
        </div>           
      </div>
    </div>
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputCorral">Corral:</label>
          <div class="controls">
            <input type="number" id="inputCorral" name="corral" placeholder="Corral">
          </div>
        </div>           
      </div>
      <div class="span6">
        <div class="control-group">
          <label class="control-label formulario" for="inputNotas">Notas:</label>
          <div class="controls">
            <input type="text" id="inputNotas"  class="input-large" name="notas" placeholder="Notas">
          </div>
        </div>           
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <input type="submit" class="btn btn-large btn-block btn-primary" value="Cargar"/>
      </div>
    </div>
</form>
</div>
<hr>