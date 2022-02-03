<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
include("includes/arrays.php");
$fecha = date('Y-m-d');
$accionValido = array_key_exists("accion", $_REQUEST);



//// INGRESO RACIONES /////
$operariosValidos = array();

foreach ($operarios as $nombreFeedlot => $operario) {
 if ($nombreFeedlot == $feedlot) {
   foreach ($operario as $operarios) {
    $operariosValidos[] = $operarios;
  }
 } 
}

if ($accionValido) {
  $accion = $_GET['accion'];


  if ($accion == "ingresar") {
    $fecha = $_POST['fechaIngreso'];
    $turno = $_POST['turno'];
    $formula = $_POST['formula'];
    $corral = $_POST['corral'];
    $kilos = $_POST['kilos'];
    

    $operario = $_POST['operario'];
    $otroOperario = $_POST['operarioOtro'];

    if ($operario == 'otro') {
      $operario = $otroOperario;
      $sqlNueva = "INSERT INTO operarios(feedlot,nombre) VALUES ('$feedlot','$operario')";
      $queryNueva = mysqli_query($conexion,$sqlNueva);

    }


    $sql = "INSERT INTO raciones(feedlot,fecha,turno,operario,formula,corral,kilos) 
    VALUES ('$feedlot','$fecha','$turno','$operario','$formula','$corral','$kilos')";
    $query = mysqli_query($conexion,$sql);
    echo mysqli_error($conexion);

    echo "<script>
	    window.location = 'raciones.php?seccion=ingreso';
    </script>";
  }

  if ($accion == 'modificarIngreso') {
    $id = $_GET['id'];
    $fecha = $_POST['fechaIngreso'];
    $turno = $_POST['turno'];
    $corral = $_POST['corral'];
    $kilos = $_POST['kilos'];

    $operario = $_POST['operario'];
    $otroOperario = $_POST['operarioOtro'];

    if ($operario == 'otro') {
      $operario = $otroOperario;
      $sqlNueva = "INSERT INTO operarios(feedlot,nombre) VALUES ('$feedlot','$operario')";
      $queryNueva = mysqli_query($conexion,$sqlNueva);

    }


    $sqlModificar = "UPDATE raciones SET
    fecha = '$fecha',
    turno = '$turno',
    operario = '$operario',
    corral = '$corral',
    kilos = '$kilos'
    WHERE id = '$id'";
    $queryModificar = mysqli_query($conexion,$sqlModificar);
    echo mysqli_error($conexion);

    echo "<script>
	    window.location = 'raciones.php';
    </script>";

  }

  if ($accion == 'eliminar') {

    if (isset($_GET['archivo'])) {
      
      $archivo = $_GET['archivo'];

      $sql = "DELETE FROM mixer_cargas WHERE archivo = '$archivo'";

      mysqli_query($conexion,$sql);

      $sql = "DELETE FROM mixer_descargas WHERE archivo = '$archivo'";

      mysqli_query($conexion,$sql);
      
      $sql = "DELETE FROM mixer_recetas WHERE archivo = '$archivo'";

      mysqli_query($conexion,$sql);
      
    }else{

      
      $id = $_GET['id'];
      $sqlEliminar = "DELETE FROM raciones WHERE id = '$id'";
      $queryEliminar = mysqli_query($conexion,$sqlEliminar);
      
    }


    echo "<script>
	    window.location = 'raciones.php?seccion=ingreso';
    </script>";
  }

  if ($accion == 'cargarRedondeo') {
    $redondeo = array();
    for ($i=1; $i <= 30; $i++) { 
      $numero = "redondeo".$i;
     if (isset($_POST[$numero])) {
         $redondeo[] = $_POST[$numero];
        }
    }

    $redondeo = implode(",", $redondeo);

    $redondeoAgua = $_POST['redondeoAgua'];
    $margen = $_POST['margenError'];

    $id = $_GET['id'];
    $sqlRedondeo = "UPDATE raciones SET
    redondeo = '$redondeo',
    redondeoAgua = '$redondeoAgua',
    margen = '$margen'
    WHERE id = '$id'";
    $queryRedondeo = mysqli_query($conexion,$sqlRedondeo);


    echo "<script>
	    window.location = 'raciones.php?seccion=mixer';
    </script>";
  }


/////// INSUMOS  ////////

  if ($accion == 'nuevoInsumo') {
    $insumo = $_POST['insumo'];
    $precio = $_POST['precio'];
    $porceMS = $_POST['porceMS'];
    
    $sqlValido = "SELECT COUNT(insumo) AS valido FROM insumos WHERE insumo = '$insumo'";
    $queryValido =  mysqli_query($conexion,$sqlValido);
    $insumoValido = mysqli_fetch_array($queryValido);

    if ($insumoValido['valido']) { ?>
    <script type="text/javascript">
          alert("Ya existe un Insumo con ese nombre. Agregar numero, ejemplo, Insumo 1.");
          window.location = 'raciones.php?seccion=insumos';
        </script>
    <?php
    die();
    }
    $sql = "INSERT INTO insumos(feedlot,insumo,precio,porceMS,fecha) VALUES ('$feedlot','$insumo','$precio','$porceMS','$fecha')";
    mysqli_query($conexion,$sql);

    $sqlRegistro = "INSERT INTO registroinsumo(insumo,precio,porceMS,fecha) VALUES ('$insumo','$precio','$porceMS','$fecha')";
    mysqli_query($conexion,$sqlRegistro);



    echo "<script>
	    window.location = 'raciones.php?seccion=insumos';
    </script>";


  }

  if ($accion == "modificarInsumo") {
    $id = $_GET['id'];
    
    $insumo = $_POST['insumo'];
    $precio = $_POST['precio'];
    $porceMS = $_POST['porceMS'];

    $sql = "UPDATE insumos SET
    precio = '$precio',
    porceMS = '$porceMS',
    fecha = '$fecha'
    WHERE id = '$id'";
    mysqli_query($conexion,$sql);

    $sqlRegistro = "INSERT INTO registroinsumo(insumo,precio,porceMS,fecha) VALUES ('$insumo','$precio','$porceMS','$fecha')";
    mysqli_query($conexion,$sqlRegistro);

    echo "<script>
	    window.location = 'raciones.php?seccion=insumos';
    </script>";

  }

  if ($accion == "eliminarInsumo") {
    $id = $_GET['id'];
    $insumo = $_GET['isumo'];
    $sql = "DELETE FROM insumos WHERE id = '$id'";
    mysqli_query($conexion,$sql);

    $sql = "DELETE FROM registroinsumo WHERE insumo = '$insumo'";
    mysqli_query($conexion,$sql);


    echo "<script>
	    window.location = 'raciones.php?seccion=insumos';
    </script>";
  }

  if ($accion == "eliminarRegistro") {
    $id = $_GET['id'];
    $sql = "DELETE FROM registroinsumo WHERE id = '$id'";
    mysqli_query($conexion,$sql);

    echo "<script>
	    window.location = 'raciones.php?seccion=insumos';
    </script>";

  }

//////  FORMULA  /////
  if ($accion == 'nuevaFormula') {
    $nombre = $_POST['nombre'];

    $productos = array();
    $productos[] = $_POST['producto'];
    for ($i=1; $i <=30 ; $i++) { 
      $producto = "producto".$i;
        if (isset($_POST[$producto])) {
         $productos[] = $_POST[$producto];
        }
      }

    if (isset($_POST['productoN'])) {
      $productos[] = $_POST['productoN']; 
      for ($i=1; $i <=30 ; $i++) { 
        $productoN = "productoN".$i;
          if (isset($_POST[$productoN])) {
           $productos[] = $_POST[$productoN];
          }
        }
    }

      $porcentajes = array();

      $porcentajes[] = $_POST['porcentaje'];
      for ($a=1; $a <=30 ; $a++) { 
      $porcentaje = "porcentaje".$a;
        if (isset($_POST[$porcentaje])) {
         $porcentajes[] = $_POST[$porcentaje];
        }
      }

    if (isset($_POST['porcentajeN'])) {
      $porcentajes[] = $_POST['porcentajeN'];
      for ($a=1; $a <=30 ; $a++) { 
      $porcentajeN = "porcentajeN".$a;
        if (isset($_POST[$porcentajeN])) {
         $porcentajes[] = $_POST[$porcentajeN];
        }
      }
    }

      $porcentajeAgua = $_POST['porcentajeAgua'];
      $total = $_POST['total'];

      $tipoFormula = $_POST['tipo'];
      $otroTipo = $_POST['tipoOtra'];

      if ($tipoFormula == 'otro') {
        $tipoFormula = $otroTipo;
        $sqlNueva = "INSERT INTO tipoFormula(tipo) VALUES ('$tipoFormula')";
        $queryNueva = mysqli_query($conexion,$sqlNueva);

      }

      $fechaFormula = date("Y-m-d");
      $sql = "INSERT INTO formulas(fecha,nombre,tipo,agua,precio) VALUES ('$fechaFormula','$nombre','$tipoFormula','$porcentajeAgua','$total')";
      $query = mysqli_query($conexion,$sql);
      
      $sqlDatos = "SELECT id FROM formulas WHERE tipo = '$tipoFormula' AND nombre = '$nombre'";
      $queryDatos = mysqli_query($conexion,$sqlDatos);
      $fila = mysqli_fetch_array($queryDatos);
      $id = $fila['id'];


      for ($i=0; $i < sizeof($productos) ; $i++) {
        $producto = "p".($i+1);
        $sqlProductos = "UPDATE formulas SET $producto = '$productos[$i]' WHERE id = '$id'"; 
        $queryProductos = mysqli_query($conexion,$sqlProductos);
        echo mysqli_error($conexion);
      }

      for ($i=0; $i < sizeof($porcentajes) ; $i++) {
        $porcentaje = "por".($i+1);

        $sqlPorc = "UPDATE formulas SET $porcentaje = '$porcentajes[$i]' WHERE id = '$id'"; 
        $queryPorc = mysqli_query($conexion,$sqlPorc);
        echo mysqli_error($conexion);
      }      

      echo "<script>
	    window.location = 'raciones.php?seccion=formulas';
    </script>";

    }

  if ($accion == 'modificarFormula') {
      $id = $_GET['id'];
      $nombre = $_POST['nombre'];

      $productos = array();
      $productos[] = $_POST['producto'];
      for ($i=1; $i <=30 ; $i++) { 
        $producto = "producto".$i;
          if (isset($_POST[$producto])) {
           $productos[] = $_POST[$producto];
          }
        }
     

        $porcentajes = array();

        $porcentajes[] = $_POST['porcentaje'];
        for ($a=1; $a <=30 ; $a++) { 
        $porcentaje = "porcentaje".$a;
          if (isset($_POST[$porcentaje])) {
           $porcentajes[] = $_POST[$porcentaje];
          }
        }

      

        $porcentajeAgua = $_POST['porcentajeAgua'];
        $total = $_POST['total'];   

        $tipoFormula = $_POST['tipo'];
        $otroTipo = $_POST['tipoOtra'];

        if ($tipoFormula == 'otro') {
          $tipoFormula = $otroTipo;
          $sqlNueva = "INSERT INTO tipoFormula(tipo) VALUES ('$tipoFormula')";
          $queryNueva = mysqli_query($conexion,$sqlNueva);
        }

        $fechaFormula = date("Y-m-d");
        $sql = "DELETE FROM formulas WHERE id = '$id'";
        mysqli_query($conexion,$sql);

        $sql = "INSERT INTO formulas(fecha,nombre,tipo,agua,precio) VALUES ('$fechaFormula','$nombre','$tipoFormula','$porcentajeAgua','$total')";
        $query = mysqli_query($conexion,$sql);
      
        $sqlDatos = "SELECT id FROM formulas WHERE tipo = '$tipoFormula' AND nombre = '$nombre'";
        $queryDatos = mysqli_query($conexion,$sqlDatos);
        $fila = mysqli_fetch_array($queryDatos);
        $id = $fila['id'];

        
        for ($i=0; $i < sizeof($productos) ; $i++) {
          $producto = "p".($i+1);
          $sqlProductos = "UPDATE formulas SET $producto = '$productos[$i]' WHERE id = '$id'"; 
          $queryProductos = mysqli_query($conexion,$sqlProductos);
        }

        for ($i=0; $i < sizeof($porcentajes) ; $i++) {
          $porcentaje = "por".($i+1);

          $sqlPorc = "UPDATE formulas SET $porcentaje = '$porcentajes[$i]' WHERE id = '$id'"; 
          $queryPorc = mysqli_query($conexion,$sqlPorc);
          echo mysqli_error($conexion);
        }      
      echo "<script>
	    window.location = 'raciones.php?seccion=formulas';
    </script>";
  }

  if ($accion == 'eliminarFormula') {
    $id = $_GET['id'];
    $sqlFormula = "DELETE FROM formulas WHERE id = '$id'";
    $queryFormula = mysqli_query($conexion,$sqlFormula);
    echo mysqli_error($conexion);
    
    echo "<script>
	    window.location = 'raciones.php?seccion=formulas';
    </script>";
  }
}

  

 
  $seccionValido = array_key_exists('seccion',$_REQUEST);
    if ($seccionValido) {
      $seccion = $_GET['seccion'];
    }else{
      $seccion = '';
    }

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>JORGE CORNALE - GESTION DE FEEDLOTS</title>
    <link rel="icon" href="img/ico.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="#" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>



    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
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
    <div class="container" style="padding-top: 50px;">
      <h1 style="display: inline-block;">Raciones</h1>
      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>
      <hr style="padding:0;margin-top:0;">
      <div class="hero-unit" style="padding-top: 10px;">
        <div class="bs-docs-example">
          <ul id="myTab" class="nav nav-tabs">
            <li <?php if($seccion == 'ingreso' OR $seccion == ''){ echo "class=\"active\"";}?>><a href="#ingresos" data-toggle="tab" class="labels">Ingreso</a></li>
            <li <?php if($seccion == 'insumos'){ echo "class=\"active\"";}?>><a href="#insumos" data-toggle="tab" class="labels">Insumos</a></li>
            <li <?php if($seccion == 'formulas'){ echo "class=\"active\"";}?>><a href="#formulas" data-toggle="tab" class="labels">Formulas</a></li>
          </ul>
          <div id="myTabContent" class="tab-content">
            
            <div class="tab-pane fade <?php if($seccion == 'insumos'){ echo 'active in';}?>" id="insumos">
              <?php include("insumos.php");?>
            </div>

            <div class="tab-pane fade <?php if($seccion == 'formulas'){ echo 'active in';}?>" id="formulas">
              <?php 
              if ($accionValido) {
                if ($accion == "modificar") {
                  $id = $_GET['id'];
                  include("modificarFormula2.php");
                }
              }else{
                include("formulas2.php");
              }
              ?>
            </div>

            <div class="tab-pane fade <?php if($seccion == 'ingreso' OR $seccion == ''){ echo 'active in';}?>" id="ingresos">
              <?php include("ingresoRacion.php");?>
            </div>

          </div>
        </div>
      </div>
    <hr>
    <footer>
      <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
    </footer>
    </div> <!-- /container -->

  <script type="text/javascript">

    function calcularPrecioPorcentaje(precioTC,porcentajeTC){
        let precioPorcentaje = (porcentajeTC * precioTC) / 100;
        return precioPorcentaje;
    }
      let inputAgua = document.getElementById('porcentajeAgua');
      inputAgua.addEventListener('blur',()=>{
        let i = 0;
        let totalPorcentaje = $('#totalPorcentaje').val();
        let agua = $('#porcentajeAgua').val();
        let porcentajeTotal = parseFloat(totalPorcentaje) + parseFloat(agua);
        $('.porcentajes').each(()=>{
          let porcentaje = parseFloat($('#porcentaje' + i).val());
          let precioTC = $('#precio' + i + ' input').val();


          let porcentajeTC = (porcentaje * 100) / porcentajeTotal;
          $('#porcentajeTC' + i).val(porcentajeTC.toFixed(2));

          let precioPorcentaje = calcularPrecioPorcentaje(precioTC,porcentajeTC);

          $('#precioPor' + i).val(precioPorcentaje.toFixed(2));
          i += 1; 
        })

        $('#porcentajeAguaTC').val(((agua*100)/porcentajeTotal).toFixed(2)); 
      })


      $(document).ready(function(){

        var totalPorcentaje = calculoPorTotal();

       if (totalPorcentaje < 100) {
            $('.botonCarga').attr('disabled',true);
            console.log('ready TRUE');
        }

        // OTRO TIPO DE FORMULA
        $(".tipoFormulaOtro").hide();
        $("#selectTipoFormula").change(function(){
          $(".tipoFormulaOtro").hide();
          var tipo = $(this).val();
          if (tipo == "otro") {
              $("#mostrarOtro").show();
          }
          });
        // OCULTAR MODAL 
        $(".modal").each(function(){
          $(this).css('z-index',0);
          })  
        

        // OTRO OPERARIO
        $(".otroOperario").hide();
        $("#inputOperario").change(function(){
          $(".otroOperario").hide();
          var causa = $(this).val();
          if (causa == "otro") {
              $("#mostrarOperario").show();
          }
        });

        // OTRO OPERARIO MODAL
        $(".otroOperario").hide();
        $("#inputOperarioModal").change(function(){
        $(".otroOperario").hide();
        var causa = $(this).val();
        if (causa == "otro") {
            $("#mostrarOperarioModal").show();
        }
        });



      });


      <?php
        $sqlInsumo = "SELECT * FROM insumos ORDER BY insumo ASC";
        $queryInsumo = mysqli_query($conexion,$sqlInsumo);
        $insumos = array();
        while ($resultado = mysqli_fetch_array($queryInsumo)) {
          $insumos[] = $resultado['insumo'];
        }
        $insumos = array_unique($insumos);
        $insumos = array_values($insumos);
      ?>
        
        var contador = 0;
        var div;
        <?php if ($accionValido) {
                if ($accion == 'modificar') { ?>
                  $(document).ready(function(){

                    $('.select-insumos').each(function(){
                    contador++;
                  });
                });
         <?php }
              }else{ ?>
                contador = 1;  
              <?php
              }
              ?>

        $('.btn-agregarProducto').click(function( event ) {
           div = '<div class="row-fluid producto' + contador +'">';

          div += '<div class="span3">';

          div += '<select class="form-control select-insumos input-medium" name="producto' + contador +'" id="producto' + contador + '" onblur="CargarProductos(this.value,this.id);">';

          div += '<option value="">Seleccionar Insumo</option>';

          <?php 
          for ($i=0; $i < sizeof($insumos) ; $i++) { 
          $ultimaFecha = ultimaFecha($insumos[$i],$conexion);
          $resultadoInsumo = traeDatos($ultimaFecha,$insumos[$i],$conexion);
          ?>
          div += '<option value="<?php echo $resultadoInsumo['id'];?>"><?php echo $resultadoInsumo['insumo'];?></option>';
          <?php } ?>
          div += '</select></div>';

          div += '<div class="span2">';

          div += '<input type="text" class="form-control input-small porcentajes" id="porcentaje' + contador + '" name="porcentaje' + contador + '" value="0" onblur="controlCero(\'porcentaje' + contador + '\')" disabled="true" required/></div>';

          div += '<div class="span2">';

          div += '<input type="text" style="font-weight: bold" class="form-control input-small porcentajesTC" id="porcentajeTC' + contador + '" value="0" readonly/></div>';

          div += '<div class="span2" id="precio' + contador + '"></div>';

          div += '<div class="span2"><input type="text" style="font-weight: bold" value="0" id="precioPor' + contador + '" class="input-small importe_linea" readonly></div>'; 

          div += '<div class="span1"><span class="icon-bin2" style="cursor: pointer;" onclick="eliminarProducto(\'producto' + contador + '\')"></span></div>';
         $('.contenedor-producto').append(div)
           contador ++; 
        });


        <?php
        require_once('js/raciones.php');
 
        if ($accionValido) {
          if ($accion == "modificar") { ?>
            $(document).ready(function(){
              var contadorInsumo = 0;
              var contadorAjax = 0;
              var totalPorcentaje = 0;
              
              // PORCENTAJES
                totalPorcentaje = calculoPorTotal();
                $('#totalPorcentaje').val(totalPorcentaje.toFixed(0));
                var agua = $('#porcentajeAgua').val();
              
              // PORCENTAJES CON AGUA
                cargarPorcentajeConAgua();
                $('#porcentajeAguaTC').val(calcularPorcentajeConAgua(agua,agua,totalPorcentaje).toFixed(2));

              // PRECIO TC
                $('.select-insumos').each(function(){
                  var idProducto = $(this).val();
                  var contenedorPrecio = '#precio' + contadorInsumo;

                  $.ajax({
                      type: "POST",
                      url: 'consulta.php',
                      data: 'insumo='+idProducto,
                      success: function(resp){
                          $(contenedorPrecio).html(resp);
                      }
                  });
                  
                  let precioPor = $('#precio' + contadorInsumo + ' input[name=precioTC]').val();
                  contadorInsumo++;
                });

              // PRECIO %
                cargarPreciosConAgua(agua,totalPorcentaje);

            });              
        <?php 
          }
        }?>

        function cambiar(id,info){
          var pdrs = document.getElementById(id).files[0].name;
          document.getElementById(info).innerHTML = pdrs;
        }
            

        var mixer = (document).getElementById('selectMixer');
        
        mixer.addEventListener('change',()=>{

          var tipoMixer = $('#selectMixer').val();

          if(tipoMixer == 'mixer2'){

            $('#mixer2cantidad').css('display','block');

            $('form').attr('action','ingresoMixer2.php');

          }else{

            $('form').attr('action','ingresoMixer1.php');

            $('#mixer2cantidad').css('display','none');


          }

        });

        $('.collapse').css('display','block');


        $(document).ready(function($){
            $(document).ready(function() {
                $('.mi-selector').select2();
            });
        });
    </script>    
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    
  </body>
</html>
