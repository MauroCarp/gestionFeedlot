<h3><b>Muertes por balanza</b></h3>

<form name="f1" class="form-horizontal" method="POST" action="subirMuertes.php" enctype="multipart/form-data"> 

  <div class="row-fluid">
    
    <div class="span12">
    
      <div class="control-group"> 
      
        <label class="control-label" style="font-size:1.1em;"><b>Causa de Muerte:</b></label>
      
        <div class="controls">
      
          <select name="causaMuerte" id="selectCausaMuerte" class="form-control input-large">
      
            <option value="">Seleccionar Causa Muerte</option>
      
              <option value="Accidente">Accidente</option>
      
              <option value="Digestivo">Digestivo</option>
      
              <option value="Ingreso">Ingreso</option>
      
              <option value="Nervioso">Nervioso</option>
      
              <option value="Rechazo">Rechazo</option>
      
              <option value="Respiratorio">Respiratorio</option>
      
              <option value="Sin Diagnostico">Sin Diagnostico</option>
      
              <option value="Sin Hallazgo">Sin Hallazgo</option>
      
              <option value="Otro">Otro</option>
      
          </select>
      
        </div>
      
      </div>           
    
    </div>

  </div>

  <div class="row-fluid">

    <div class="span4">
      
      <label for="file-uploadMuertes" class="btn btn-default btn-block">
          <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo
      </label>
      
      <input id="file-uploadMuertes" onchange="cambiar('file-uploadMuertes','infoMuertes')" type="file" name="fileMuertes" style='display: none;' required/>
    
    </div>
    
    <div class="span5">
      
      <div class="span" id="infoMuertes" style="text-align: left;font-weight: bold;">Seleccionar archivo</div>
      
    </div>

    
    <div class="span3">

      <button type="submit" class="btn btn-default btn-block" name="submitIng"><b>Cargar</b></button>
      
    </div>


  </div>

</form>
  