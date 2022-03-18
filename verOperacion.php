<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
require("includes/arrays.php");

$fecha = $_GET['fecha'];

function mostrarReceta($id_receta,$archivo,$conexion){

  $sql = "SELECT nombre FROM mixer_recetas WHERE id_receta = '$id_receta' AND archivo = '$archivo'";
  
  $query = mysqli_query($conexion,$sql);

  $resultado = mysqli_fetch_array($query);

  
  return $resultado['nombre'];

}

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>JORGE CORNALE - GESTION DE FEEDLOT</title>
    <link rel="icon" href="img/ico.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/ico.ico" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-2.2.4.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/chart/dist/Chart.bundle.js"></script>
    <script src="js/chart/samples/utils.js"></script>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 10px;
      }

      .tablasOperaciones{

        height:250px;
        overflow-y:scroll;
      
      }


    </style>
    <script type="text/javascript">
    
    function mostrar(id) {
      $("#" + id).show(200);
    }

    function cargarReceta(id_receta,archivo){

      url = 'recetas.ajax.php';

      data = 'idReceta=' + id_receta + '&archivo=' + archivo;

      $.ajax({
        type:'POST',

        url:url,

        data:data,

        success: function(resultado){

          var resultadoParse = JSON.parse(resultado);
          
          var nombre = resultadoParse['nombre'];

          $('#nombreReceta').html(nombre);
          
          var contenido = "<table class='table-striped' style='width:100%;'>";
          
          contenido    += "<thead style='background-color:#d7f0c0;font-size:1.3em;'><th>Ingrediente</th><th>Cantidad</th>";
          contenido    += "<tbody style='text-align:center;'>";

          
          for (let index = 1; index < 20; index++) {

            if (resultadoParse['ingrediente' + index] != null) {
              
              contenido    +=   "<tr><td>" + resultadoParse['ingrediente' + index] + "</td>";

              contenido    +=   "<td>" + resultadoParse['cantidad' + index] + " Kg</td></tr>";

            }

          }

              contenido    += "<tbody></table>";
              
              $('#ingredientes').append(contenido);
          
        }
      });

    }

    function cargarCarga(id_carga,archivo){
      
      url = 'cargas.ajax.php';

      data = 'idCarga=' + id_carga + '&archivo=' + archivo;

      $.ajax({
        type:'POST',

        url:url,

        data:data,

        success: function(resultado){

          var resultadoParse = JSON.parse(resultado);

          if(resultadoParse['mixer'] == 'mixer1'){
            
            var mixer = '456ST';
            var mixer2 = 'Autoconsumo';
        
          }else{

            var mixer = 'Autoconsumo';
            var mixer2 = '456ST';

          }          
          var fecha = resultadoParse['fecha'];
          var hora = resultadoParse['hora'];
          var cantidad = resultadoParse['cantidad'];
          var ideal = resultadoParse['ideal'];
          var ingrediente = resultadoParse['ingrediente'];

          $('#id_carga').val(id_carga);

          $('#mixerCarga').html("<option value='" + mixer + "' selected>" + mixer + "</option><option value='" + mixer2 + "'>" + mixer2 + "</option>");          
          $('#fechaCarga').val(fecha);
          $('#horaCarga').val(hora);
          $('#cantidadCarga').val(cantidad);
          $('#ingredienteCarga').val(ingrediente);
          $('#idealCarga').val(ideal);

        }
      });

    }

    function cargarDescarga(id_descarga,archivo){
      
      url = 'descargas.ajax.php';

      data = 'idDescarga=' + id_descarga + '&archivo=' + archivo;

      $.ajax({
        type:'POST',

        url:url,

        data:data,

        success: function(resultado){

          var resultadoParse = JSON.parse(resultado);

          if(resultadoParse['mixer'] == 'mixer1'){
          
            var mixer = '456ST';
            var mixer2 = 'Autoconsumo';
          
          }else{

            var mixer = 'Autoconsumo';
            var mixer2 = '456ST';

          }

          var fecha = resultadoParse['fecha'];
          var hora = resultadoParse['hora'];
          var cantidad = resultadoParse['cantidad'];
          var lote = resultadoParse['lote'];
          var animales = resultadoParse['animales'];
          var operario = resultadoParse['operario'];



          $('#id_descarga').val(id_descarga);
          $('#mixerDescarga').html("<option value='" + mixer + "' selected>" + mixer + "</option><option value='" + mixer2 + "'>" + mixer2 + "</option>");
          $('#fechaDescarga').val(fecha);
          $('#horaDescarga').val(hora);
          $('#cantidadDescarga').val(cantidad);
          $('#animales').val(animales);
          $('#lote').val(lote);
          $('#operario').val(operario);

        }
      });

    }


       

    </script>
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php
          include("includes/nav.php");
          ?>
        </div>
      </div>
    </div>
    <div class="container" style="padding-top: 50px;z-index:-1  ">
      <h1 style="display: inline-block;">RACIONES</h1>
      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>
      <div class="hero-unit" style="padding-top: 10px;margin-bottom: 5px;">
        <div class="well form-inline">

          <label>Mixer</label>

          <select name="mixer" id="mixer" class="input-small">

            <option value="">Seleccionar Mixer</option>
            
            <option value="mixer1">456ST</option>

            <option value="mixer2">Autoconsumo</option>

          </select>
          

          <label>Carga/Descarga</label>

          <select name="tipo" id="tipo" class="input-medium">

            <option value="cargaDescarga">Cargas/Descargas</option>
            
            <option value="carga">Cargas</option>

            <option value="descarga">Descargas</option>

          </select>
          

          <label class="lotes">Lotes</label>

          <select multiple="multiple" id="lotes" size="3" class="lotes" class="input-small">
          <?php

            $sqlLotes = "SELECT DISTINCT(lote) FROM mixer_descargas WHERE fecha = '$fecha' ORDER BY lote ASC";
            $queryLotes = mysqli_query($conexion,$sqlLotes);

            while($lote = mysqli_fetch_array($queryLotes)){

              $loteNum = $lote['lote'];

              echo "<option value='$loteNum'>$loteNum</option>";

            }
      
          ?>

          </select>


          <button type="submit" class="btn" id='filtrar'>Filtrar</button>
      
        </div>
            
          <button class="btn btn-default" id='btnTablaCargas'><b>Cargas <span style='color:green;'><b>&uarr;</b></span></b></button><br>

          <div class="tablasOperaciones" id="tablaCargas">

            <table class="table table-striped tablasOps">
                
                <thead>
                                    
                    <th>N°</th>

                    <th>Mixer</th>

                    <th>Fecha</th>
                    
                    <th>Hora</th>
                    
                    <th>Receta</th>

                    <th></th>

                </thead>

                <tbody>
                <?php
                    $cont = 1;

                    $sqlCargas = "SELECT * FROM mixer_cargas WHERE fecha = '$fecha' GROUP BY id_carga ORDER BY hora ASC";

                    $queryCargas = mysqli_query($conexion,$sqlCargas);

                    while($cargas = mysqli_fetch_array($queryCargas)){ 
                        
                        $mixer     = ($cargas['mixer'] == 'mixer1') ? '456ST' : 'Autoconsumo';
                        
                        $id_receta = $cargas['id_receta'];

                        $archivo   = $cargas['archivo'];

                        
                    ?>
                    <tr>
                    
                        <td><?php echo $cont;?></td>

                        <td><?php echo $mixer;?></td>
                    
                        <td><?php echo formatearFecha($cargas['fecha']);?></td>

                        <td><?php echo $cargas['hora'];?></td>
    
                        <td>
                        <?php

                          if ($mixer == 'Autoconsumo') { ?>

                            <button class="btn btn-default"> - </button>
                            
                          <?php

                          }else{ ?>

                            <button class="btn btn-default" data-toggle="modal" data-target="#modalReceta" onclick="cargarReceta('<?php echo $id_receta;?>','<?php echo $archivo;?>')"><?php echo mostrarReceta($id_receta,$archivo,$conexion);?></button>  

                         <?php }
                        ?>
                        </td>  
                        

                        <td>

                        <button class="btn btn-default btnVerOperacion" data-toggle="modal" data-target="#modalVerOperacion" operacion="carga" fechaOperacion='<?php echo $cargas['fecha'];?>' idOperacion='<?php echo $cargas['id_carga'];?>'><i class="icon-eye"></i></button>  

                        <button class="btn btn-default" data-toggle="modal" data-target="#modalCarga" onclick="cargarCarga('<?php echo $cargas['id'];?>','<?php echo $archivo;?>')"><i class="icon-pencil"></i></button>  
                        </td>
                        
                    <?php

                      $cont++;
                    
                    }

                    ?>
                </tbody>  
            </table>

          </div>

          <hr>

          <button class="btn btn-default" id='btnTablaDescargas'><b>Descargas <span style='color:blue'>&darr;</span></b></button>

          <div class="tablasOperaciones" id="tablaDescargas">

            <table class="table table-striped tablasOps">
                
                <thead>
                                    
                    <th>N°</th>

                    <th>Mixer</th>

                    <th>Fecha</th>
                    
                    <th>Hora</th>
                  
                    <th></th>

                </thead>

                <tbody>
                <?php
                    $cont = 1;
                    $sqlDescargas = "SELECT * FROM mixer_descargas WHERE fecha = '$fecha' GROUP BY id_descarga ORDER BY hora ASC, lote ASC";
                    
                    $queryDescargas = mysqli_query($conexion,$sqlDescargas);

                    while($descargas = mysqli_fetch_array($queryDescargas)){ 
                        
                        $mixer = ($descargas['mixer'] == 'mixer1') ? '456ST' : 'Autoconsumo';

                    ?>
                    <tr>
                    
                        <td><?php echo $cont;?></td>

                        <td><?php echo $mixer;?></td>
                    
                        <td><?php echo formatearFecha($descargas['fecha']);?></td>

                        <td><?php echo $descargas['hora'];?></td>

                        <td>

                        <button class="btn btn-default btnVerOperacion" data-toggle="modal" data-target="#modalVerOperacion" operacion='descarga' fechaOperacion='<?php echo $descargas['fecha'];?>' idOperacion='<?php echo $descargas['id_descarga'];?>'><i class="icon-eye"></i></button>  
                        <button class="btn btn-default" data-toggle="modal" data-target="#modalDescarga" onclick="cargarDescarga('<?php echo $descargas['id'];?>','<?php echo $archivo;?>')"><i class="icon-pencil"></i></button>  
                        </td>                       


                    <?php
                      $cont++;
                    
                    }

                    ?>
                </tbody>  
            </table>

          </div>
        
          <hr>
        
        <a href="raciones.php" class="btn btn-default">Volver</a>
    </div>
    

    <!-- MODAL RECETA -->

    <div class="modal fade" style="width: 350px;margin: 0 auto;margin-left:-175px;z-index:99;" id="modalReceta" tabindex="-1" role="dialog" aria-hidden="true">
                    
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <h2 class="modal-title">Receta</h2>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            
          </div>
          
          <div class="modal-body">
          
          <div class="row-fluid">
            
            <div class="span5"><h3>Nombre: </h3></div>
            
            <div class="span5" id='nombreReceta' style="font-size:1.5em;font-weight:bold;"></div>
                    
          </div>
          
          <div class="row-fluid">

            <div class="span12" id="ingredientes">
            
            </div>

          </div>
                    
          </div>
          
        </div>
        
      </div>

    </div>



    <!-- MODAL MODIFICAR CARGA -->


    <div class="modal fade" style="width: 350px;margin: 0 auto;margin-left:-175px;z-index:99;" id="modalCarga" tabindex="-1" role="dialog" aria-hidden="true">
                    
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <h4 class="modal-title">Modificar Registro de Carga</h4>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            
          </div>
          
          <div class="modal-body">

            <div class="row-fluid">
            <input type="hidden" id="id_carga">
              <div class="form-group">
            
                <label for="mixerCarga"><b>Mixer</b></label>
            
                <select class="form-control" id="mixerCarga">
                
                    <option value="456ST">456ST</option>
                
                    <option value="Autoconsumo">Autoconsumo</option>
                
                </select>             
                
              </div>
            
              <div class="form-group">
            
                <label for="fechaCarga"><b>Fecha</b></label>
            
                <input type="date" class="form-control" id="fechaCarga">
            
              </div>
            
              <div class="form-group">
            
                <label for="horaCarga"><b>Hora</b></label>
            
                <input type="text" class="form-control" id="horaCarga" readonly>
            
              </div>
              
              <div class="form-group">
            
                <label for="ingredienteCarga"><b>Ingrediente</b></label>
            
                <input type="text" class="form-control" id="ingredienteCarga">
            
              </div>
            
              <div class="form-group">
            
                <label for="cantidadCarga"><b>Cant. Kg</b></label>
            
                <input type="number" class="form-control" id="cantidadCarga">
            
              </div>
              
              <div class="form-group">
            
                <label for="idealCarga"><b>Ideal</b></label>
            
                <input type="number" class="form-control" id="idealCarga">
            
              </div>

              <div class="form-group">
            
                <button class="btn btn-succes" id="modificarCarga">Modificar</button>
            
              </div>
            
            </div>
        
          </div>
          
        </div>
        
      </div>

    </div>


    <!-- MODAL MODIFICAR DESCARGA -->

    <div class="modal fade" style="width: 350px;margin: 0 auto;margin-left:-175px;z-index:99;" id="modalDescarga" tabindex="-1" role="dialog" aria-hidden="true">
                    
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <h4 class="modal-title">Modificar Registro de Descarga</h4>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            
          </div>
          
          <div class="modal-body">

            <div class="row-fluid">
                  <input type="hidden" id="id_descarga">
              <div class="form-group">
            
                <label for="mixerDescarga"><b>Mixer</b></label>
                
                <select class="form-control" id="mixerDescarga">
                    <option value="456ST">456ST</option>
                    <option value="Autoconsumo">Autoconsumo</option>
                </select>     

              </div>
            
              <div class="form-group">
            
                <label for="fechaDescarga"><b>Fecha</b></label>
            
                <input type="date" class="form-control" id="fechaDescarga">
            
              </div>
            
              <div class="form-group">
            
                <label for="horaDescarga"><b>Hora</b></label>
            
                <input type="text" class="form-control" id="horaDescarga" readonly>
            
              </div>
              
              <div class="form-group">
            
                <label for="lote"><b>Lote</b></label>
            
                <input type="text" class="form-control" id="lote">
            
              </div>
            
              <div class="form-group">
            
                <label for="cantidadDescarga"><b>Cant. Kg</b></label>
            
                <input type="number" class="form-control" id="cantidadDescarga">
            
              </div>
              
              <div class="form-group">
            
                <label for="animales"><b>Animales</b></label>
            
                <input type="number" class="form-control" id="animales">
            
              </div>
              
              <div class="form-group">
            
                <label for="operario"><b>Operario</b></label>
            
                <input type="text" class="form-control" id="operario">
            
              </div>

              <div class="form-group">
            
                <button class="btn btn-succes" id="modificarDescarga">Modificar</button>
            
              </div>
            
            </div>
        
          </div>
          
        </div>
        
      </div>

    </div>

    <!-- MODAL VER OPERACION -->

    <div class="modal fade" style="width: 800px;margin: 0 auto;margin-left:-400px;z-index:99;" id="modalVerOperacion" tabindex="-1" role="dialog" aria-hidden="true">
                    
      <div class="modal-dialog" role="document">
      
        <div class="modal-content">
        
          <div class="modal-header">
          
            <h4 class="modal-title">Detalle Operaci&oacute;n</h4>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            
          </div>
          
          <div class="modal-body">

            <div class="row-fluid">

            <table class="table table-striped tablaVerOperacion">
                
                <thead>
                                    
                </thead>

                <tbody>

                </tbody>  

            </table>


            </div>
        
          </div>
          
        </div>
        
      </div>

    </div>




    <script type="text/javascript">

    $(function () {

      $('.lotes').css('display','none');

      $('#tipo').change(function(){
          
        if($(this).val() == 'descarga'){
          
          $('.lotes').css('display','inline-block');

        }else{

          $('.lotes').css('display','none');

        }

      });


      $('#btnTablaDescargas').click(()=>{
        
        $('#tablaDescargas').toggle(1000);
        
      });

      $('#btnTablaCargas').click(()=>{
        
        $('#tablaCargas').toggle(1000);
        
      });



    });

    $('#modificarCarga').click(()=>{
      
      var id_carga = $('#id_carga').val();
      var mixerCarga = $('#mixerCarga').val();
      var fechaCarga = $('#fechaCarga').val();
      var horaCarga = $('#horaCarga').val();
      var ingredienteCarga = $('#ingredienteCarga').val();
      var cantidadCarga = $('#cantidadCarga').val();
      var idealCarga = $('#idealCarga').val();

      
      url = 'cargas.ajax.php';

      data = 'idCarga=' + id_carga +'&mixer=' + mixerCarga +'&fecha=' + fechaCarga +'&hora=' + horaCarga +'&ingrediente=' + ingredienteCarga +'&cantidad=' + cantidadCarga +'&ideal=' + idealCarga + '&archivo=' + '&accion=modificar';
      console.log(data);
      $.ajax({
        type:'POST',

        url:url,

        data:data,

        success: function(resultado){

          window.location = 'verOperacion.php?fecha=' + fechaCarga;

        }
      });


    });


    $('#modificarDescarga').click(()=>{
      
      var id_descarga = $('#id_descarga').val();
      var mixerDescarga = $('#mixerDescarga').val();
      var fechaDescarga = $('#fechaDescarga').val();
      var horaDescarga = $('#horaDescarga').val();
      var lote = $('#lote').val();
      var cantidadDescarga = $('#cantidadDescarga').val();
      var animales = $('#animales').val();
      var operario = $('#operario').val();

      
      url = 'descargas.ajax.php';

      data = 'idDescarga=' + id_descarga +'&mixer=' + mixerDescarga +'&fecha=' + fechaDescarga +'&hora=' + horaDescarga +'&lote=' + lote +'&cantidad=' + cantidadDescarga +'&animales=' + animales + '&operario=' + operario + '&accion=modificar';
      console.log(data);
      $.ajax({
        type:'POST',

        url:url,

        data:data,

        success: function(resultado){

          window.location = 'verOperacion.php?fecha=' + fechaDescarga;

        }
      });


    });

    $('#filtrar').click(()=>{
      var data = [];

      
      if($('#mixer').val() != ''){

        var mixer = $('#mixer').val();        

        data.push('mixer=' + mixer);
      
      } 

      var tipo = 'tipo=' + $('#tipo').val();

      data.push(tipo);

      if($('#tipo').val() == 'descarga'){

        var lotes = $('#lotes').val();

        if(lotes != null){

          lotes = lotes.join(',');
                    
          data.push('lotes=' + lotes);
          
        }
      
      }

      var fecha = '<?php echo $_GET['fecha'];?>';

      var url = 'filtroOperaciones.ajax.php';
      
      data = data.join('&');
      
      data += '&fecha=' + fecha;

      console.log(data);

      $(".well").after('<div class="loading">Un momento, por favor...</div>');

      $.ajax({
      type:'POST',
      url:url,
      data:data,
      success: function(result){
          
          $('#btnTablaCargas').remove();        
          $('#btnTablaDescargas').remove();   
          $('#tablaCargas').remove();  
          $('#tablaDescargas').remove();     
          $('hr').remove();
          $('.loading').remove();
          $(".well").after(result);
          $('footer').insertBefore('<hr>');


        }

      });
       

    });


    $('.tablasOps').on('click','.btnVerOperacion',function(){

      $('.tablaVerOperacion thead').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');


      let id = $(this).attr('idOperacion');
      
      let fecha = $(this).attr('fechaOperacion');

      let operacion = $(this).attr('operacion');

      let data = `operacion=${operacion}&idOperacion=${id}&fecha=${fecha}`;

      let url = 'ajax/verOperacion.ajax.php';

      $.ajax({
        method:'post',
        url:url,
        data:data,
        success:function(response){
          console.log(response);
          
            let thead = '<th>Mixer</th><th>Fecha</th><th>Hora</th><th>Lote</th><th>Cantidad</th><th>Animales</th><th>Operario</th>';

            if(operacion == 'carga'){

              thead = '<th>Mixer</th><th>Fecha</th><th>Hora</th><th>Ingrediente</th><th>Cantidad</th><th>Ideal</th>';

              $('.tablaVerOperacion thead').html(thead);

            }else{

              $('.tablaVerOperacion thead').html(thead);

            }

              $('.tablaVerOperacion tbody').html(response);
            
        }

      })

    });

   </script>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
  </body>
</html>
