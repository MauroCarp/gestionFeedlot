<div id="cargaBalanza">

  <h3>Ingresos por Balanza</h3>
  
  <form name="f1" class="form-horizontal" method="POST" action="subirIngreso.php" enctype="multipart/form-data"> 

    <div class="row-fluid">

      <div class="span5">

        <b>ADPV: </b>

        <input type="number" name="adpv" class="input-mini">

      </div>

        <div class="span7">
      
        <b>R.E.N.S.P.A:</b>
      
        <input type="text" name="renspa" placeholder="R.E.N.S.P.A">

      </div>

    </div>

    <br>

    <div class="row-fluid">
        
      <div class="span4">

          <label for="file-uploadIng" class="btn btn-default btn-block">

            <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo

          </label>

          <input id="file-uploadIng" onchange="cambiar('file-uploadIng','infoIng')" type="file" name="fileIng" style='display: none;' required/>

      </div>

      <div class="span5" id="infoIng" style="text-align: left;font-weight: bold;">Seleccionar archivo</div>

      
      <div class="span3">
        
        <button type="submit" class="btn btn-default btn-block" name="submitIng"><b>Cargar</b></button>

      </div>

    </div>

  </form>

</div>
<hr>
<div id="cargaManual">

  <a href="#" data-toggle="modal" data-target="#modalCargaManual" class="descargarPlanillas" seccion="ingresos"><h5>Descargar Planilla Ingresos Manual</h5></a>

</div>
