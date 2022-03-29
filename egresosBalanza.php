
  <h3><b>Egresos por balanza</b></h3>

  <form name="f1" class="form-horizontal" method="POST" action="subirEgreso.php" enctype="multipart/form-data"> 
    
  <div class="row-fluid">
    
    <div class="span4">
    
      <label for="file-uploadEgr" class="btn btn-primary btn-block"><i class="fas fa-cloud-upload-alt"></i>Seleccionar archivo</label>
      
      <input id="file-uploadEgr" onchange="cambiar('file-uploadEgr','infoEgr')" type="file" name="fileEgr" style='display: none;' required/>
    
    </div>
    
    <div class="span5" id="infoEgr" style="text-align: left;font-weight: bold;">Seleccionar Archivo</div>
    
    <div class="span3">
  
      <button type="submit" class="btn btn-primary btn-block" name="submitEgr"><b>Cargar</b></button>
  
    </div>
    
    </div>
    
  </form>

  <hr>

  <a href="#" data-toggle="modal" data-target="#modalCargaManual" class="descargarPlanillas"  seccion="egresos"><h5>Descargar Planilla Egresos Manual</h5></a>

  <!-- <a href="planillas/egresos.cvs" download="Planilla Egresos.csv"><h5>Descargar Planilla Egresos Manual</h5></a> -->

