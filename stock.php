<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
require("includes/arrays.php");

$accionValido = array_key_exists("accion", $_REQUEST);
$fechaHoy = date("Y-m-d");
if ($accionValido) {
  $accion = $_GET['accion'];
  //*** INGRESOS  **//
  if ($accion == 'cargarManual') {
    $tropa = $_POST['tropa'];
    $fechaIngreso = $_POST['fechaIngreso'];
    $renspa = $_POST['renspa'];
    $adpv = ($_POST['adpv'] == "") ? 0 : $_POST['adpv'];
    $cantidad = $_POST['cantidad'];
    $raza = $_POST['raza'];
    $origen = $_POST['origen'];
    $proveedor = $_POST['proveedor'];
    $peso = $_POST['peso'];
    $estado = $_POST['estado'];
    $corral = $_POST['corral'];
    $notas = $_POST['notas'];


    if ($fechaIngreso > $fechaHoy) { ?>
      <script type="text/javascript">
        alert("La fecha de Ingreso es POSTERIOR a la fecha de HOY. Carga Fallida.");
        window.location = 'stock.php';
      </script>
    <?php 
    die();
    }
    if ($_POST['otraRaza'] != "") {
      $raza = $_POST['otraRaza'];

      $sqlRaza = "INSERT INTO razas(raza) VALUES('$raza')";
      mysqli_query($conexion,$sqlRaza);
    }

    $pesoPromedio = $peso / $cantidad;
    for ($i=0; $i < $cantidad; $i++) { 
      $sqlIngreso = "INSERT INTO ingresos(feedlot,tropa,adpv,renspa,peso,raza,estado,origen,proveedor,notas,corral,fecha) VALUES ('$feedlot','$tropa','$adpv','$renspa','$pesoPromedio','$raza','$estado','$origen','$proveedor','$notas','$corral','$fechaIngreso')";
      $queryIngreso = mysqli_query($conexion,$sqlIngreso);
    }

      $sqlStatus = "INSERT INTO status(feedlot,tropa,fechaIngreso,animales) VALUES ('$feedlot','$tropa','$fechaIngreso','$cantidad')";
      $queryStatus = mysqli_query($conexion,$sqlStatus);
     header("Location:stock.php?seccion=ingreso");
  }

  if ($accion == "modificarIngreso") {
    $id = $_GET['id'];
    $fechaIngreso = $_POST['fechaIngreso'];
    $cantidad = $_POST['cantidad'];
    $origen = $_POST['origen'];
    $proveedor = $_POST['proveedor'];
    $peso = $_POST['pesoIngreso'];
    $sqlIngreso = "UPDATE stock SET
    fecha = '$fechaIngreso',
    cantidad = '$cantidad',
    origen = '$origen',
    proveedor = '$proveedor',
    pesoIngreso = '$peso' WHERE id = '$id'";
    $queryIngreso = mysqli_query($conexion,$sqlIngreso);
    header("Location:stock.php?seccion=ingreso");
  }

  if ($accion == 'eliminarIngreso') {
    $tropa = $_GET['tropa'];

    $sqlEliminar = "DELETE FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    mysqli_query($conexion,$sqlEliminar);

    $sqlEliminarStatus = "DELETE FROM status WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    mysqli_query($conexion,$sqlEliminarStatus);

    $sqlEliminarRegistro = "DELETE FROM registroingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    mysqli_query($conexion,$sqlEliminarRegistro);

    header("Location:stock.php?seccion=ingreso");
    }

//**** EGRESOS ***/

  if ($accion == 'egreso') {
    $tropa = $_POST['tropa'];
    $fechaEgreso = $_POST['fechaEgreso'];
    $cantidad = $_POST['cantidad'];
    $raza = $_POST['raza'];
    $peso = $_POST['peso'];
    $corral = $_POST['corral'];
    $destino = $_POST['destino'];


    if ($fechaEgreso > $fechaHoy) { ?>
      <script type="text/javascript">
        alert("La fecha de Ingreso es POSTERIOR a la fecha de HOY. Carga Fallida.");
        window.location = 'stock.php';
      </script>
    <?php 
    die();
    }
    if ($_POST['otraRaza'] != "") {
      $raza = $_POST['otraRaza'];

      $sqlRaza = "INSERT INTO razas(raza) VALUES('$raza')";
      mysqli_query($conexion,$sqlRaza);
    }

    $pesoPromedio = $peso / $cantidad;
    for ($i=0; $i < $cantidad; $i++) { 
      $sqlEgreso = "INSERT INTO egresos(feedlot,tropa,fecha,corral,raza,destino,peso) VALUES ('$feedlot','$tropa','$fechaEgreso','$corral','$raza','$destino','$pesoPromedio')";
      $queryEgreso = mysqli_query($conexion,$sqlEgreso);
      echo mysqli_error($conexion);
    }
    header("Location:stock.php?seccion=egreso");

  }

  if ($accion == "modificarEgreso") {
    $id = $_GET['id'];
    $fechaEgreso = $_POST['fechaEgreso'];
    $egresos = $_POST['egreso'];
    $destino = $_POST['destino'];
    $pesoEgreso = $_POST['pesoEgreso'];
    $sqlEgreso = "UPDATE stock SET
    fecha = '$fechaEgreso',
    egreso = '$egresos',
    destino = '$destino',
    pesoEgreso = '$pesoEgreso' WHERE id = '$id'";
    $queryEgreso = mysqli_query($conexion,$sqlEgreso);
    header("Location:stock.php?seccion=egreso");
  }


  if ($accion == 'eliminarEgreso') {
    $tropa = $_GET['tropa'];

    $sqlEliminar = "DELETE FROM egresos WHERE tropa = '$tropa'";
    mysqli_query($conexion,$sqlEliminar);

    $sqlEliminar = "DELETE FROM registroegresos WHERE tropa = '$tropa'";
    mysqli_query($conexion,$sqlEliminar);





    header("Location:stock.php?seccion=egreso");
    }

//*** MUERTES ***/
  if ($accion == 'muertes') {
      $fechaMuerte = $_POST['fechaMuerte'];
      $muertes = $_POST['muertes'];
      $causaMuerte = $_POST['causaMuerte'];
      $otraCausaMuerte = $_POST['causaMuerteOtro'];

      if ($causaMuerte == 'otro') {
        $causaMuerte = $otraCausaMuerte;
        $sqlNueva = "INSERT INTO causas(causa) VALUES ('$causaMuerte')";
        $queryNueva = mysqli_query($conexion,$sqlNueva);
      }

 
      $sqlMuertes = "INSERT INTO muertes(feedlot,fecha,muertes,causaMuerte) VALUES ('$feedlot','$fechaMuerte','$muertes','$causaMuerte')";
      $queryMuertes = mysqli_query($conexion,$sqlMuertes);

      header("Location:stock.php?seccion=muerte");
    }

    if ($accion == "modificarMuerte") {
      $id = $_GET['id'];
      $fechaMuerte = $_POST['fechaMuerte'];
      $muertes = $_POST['muertes'];
      $causaMuerte = $_POST['causaMuerte'];
      $sqlMuerte = "UPDATE muertes SET
      fecha = '$fechaMuerte',
      muertes = '$muertes',
      causaMuerte = '$causaMuerte' WHERE id = '$id'";
      $queryMuerte = mysqli_query($conexion,$sqlMuerte);
      header("Location:stock.php?seccion=muerte");
    }

    if ($accion == 'eliminarMuerte') {
      
      $tropa = $_GET['tropa'];
      $sqlEliminar = "DELETE FROM muertes WHERE tropa = '$tropa'";
      mysqli_query($conexion,$sqlEliminar);

      $sqlEliminar = "DELETE FROM registromuertes WHERE tropa = '$tropa'";
      mysqli_query($conexion,$sqlEliminar);

      header("Location:stock.php?seccion=muerte");
    }
/****************////


  

}


$cantIng = 0;
$cantEgr = 0;
$cantMuertes = 0;
$totalPesoIng = 0;
$totalPesoEgr = 0;
$kgIngProm = 0;
$kgEgrProm = 0;
$diferenciaIngEgr = 0;
$pesoTotalIng = 0;
$pesoTotalEgr = 0;

  $sqlIng = "SELECT SUM(cantidad) AS cantidadConStockInicial FROM registroingresos WHERE feedlot = '$feedlot' ORDER BY fecha ASC";
  $queryIng = mysqli_query($conexion,$sqlIng);
  $resultados = mysqli_fetch_array($queryIng);

  $cantIngConStockInicial = $resultados['cantidadConStockInicial'];
  

  if ($feedlot == "Acopiadora Pampeana") {
  
    $sqlIng = "SELECT cantidad, pesoPromedio FROM registroingresos WHERE feedlot = '$feedlot' AND tropa != 'Stock Inicial' ORDER BY fecha ASC";

    $queryIng = mysqli_query($conexion,$sqlIng);
    
    while($resultados = mysqli_fetch_array($queryIng)){

      $cantidad = $resultados['cantidad'];
      $pesoPromedio = $resultados['pesoPromedio'];

      $cantIng += $cantidad;
      $pesoTotalIng += ($cantidad * $pesoPromedio);

    };



    $sqlEgr = "SELECT cantidad, pesoPromedio FROM registroegresos WHERE feedlot = '$feedlot' ORDER BY fecha ASC";

    $queryEgr = mysqli_query($conexion,$sqlEgr);

    
    while($resultados = mysqli_fetch_array($queryEgr)){
      
      $cantidadEgr = $resultados['cantidad'];
      $pesoPromedioEgr = $resultados['pesoPromedio'];
      

      $cantEgr += $cantidadEgr;
      $pesoTotalEgr += ($cantidadEgr * $pesoPromedioEgr);

    };


  }else{

    $sqlIng = "SELECT COUNT(feedlot) AS cantidad, SUM(peso) AS pesoTotal FROM ingresos WHERE feedlot = '$feedlot' AND tropa != 'Stock Inicial' ORDER BY fecha ASC";

    $queryIng = mysqli_query($conexion,$sqlIng);
    $resultados = mysqli_fetch_array($queryIng);
    $pesoTotalIng = $resultados['pesoTotal'];
    $cantIng = $resultados['cantidad'];

    $sqlEgr = "SELECT COUNT(feedlot) AS cantidad, SUM(peso) AS pesoTotal FROM egresos WHERE feedlot = '$feedlot' ORDER BY fecha ASC";
    $queryEgr = mysqli_query($conexion,$sqlEgr);
    $resultados = mysqli_fetch_array($queryEgr);
    $cantEgr = $resultados['cantidad'];
    $pesoTotalEgr = $resultados['pesoTotal'];


  }

  


  $sqlMuertes = "SELECT SUM(cantidad) as cantidad FROM registromuertes WHERE feedlot = '$feedlot' ORDER BY fecha ASC";
  $queryMuertes = mysqli_query($conexion,$sqlMuertes);
  $resultados = mysqli_fetch_array($queryMuertes);
  $cantMuertes = $resultados['cantidad'];
  

  $stock = 0;

  if ($cantIng > 0) {
  $kgIngProm = ($pesoTotalIng/$cantIng);
  }
  $kgIngProm = round($kgIngProm, 2);

  if ($cantEgr > 0) {
  $kgEgrProm = ($pesoTotalEgr/$cantEgr);
  }

  $kgEgrProm = round($kgEgrProm, 2);

  if ($kgEgrProm > $kgIngProm) {
    $diferenciaIngEgr = $kgEgrProm - $kgIngProm;  
  }

  if ($cantIngConStockInicial != 0) {
    $stock += $cantIngConStockInicial;
  }
  
  if ($cantEgr != 0 AND $stock != 0) {
    $stock = ($stock - $cantEgr);   
  }
  if ($cantMuertes != 0 AND $stock != 0) {
    $stock = ($stock - $cantMuertes); 
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
    </style>
    <script type="text/javascript">


    function cambiar(id,info){
    var pdrs = document.getElementById(id).files[0].name;
    document.getElementById(info).innerHTML = pdrs;
    }


    function mostrar(id) {
      $("#" + id).show(200);
    }
        

    desde = (0 * 12);

    function cargaIngresos(){
      $('#paginadoIng').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
      datosPag = 'desde=' + desde; 
      var urlPaginador = 'paginador.php';
      $.ajax({
      type:'POST',
      url:urlPaginador,
      data:datosPag,
      success: function(datosPag){
        $('#paginadoIng').html(datosPag);
      }
      });
    }

    function cargaEgresos(){
      $('#paginadoEgr').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
      datosPagEgr = 'desde=' + desde; 
      var urlPaginador = 'paginadorEgr.php';
      $.ajax({
      type:'POST',
      url:urlPaginador,
      data:datosPagEgr,
      success: function(datosPagEgr){
        $('#paginadoEgr').html(datosPagEgr);
      }
      });
    }
    function cargaMuertes(){
      $('#paginadoMuertes').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
      datosPagM = 'desde=' + desde; 
      var urlPaginadorMuertes = 'paginadorMuertes.php';
      $.ajax({
      type:'POST',
      url:urlPaginadorMuertes,
      data:datosPagM,
      success: function(datosPagM){
        $('#paginadoMuertes').html(datosPagM);
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
    <div class="container" style="padding-top: 50px;">
      <h1 style="display: inline-block;">STOCK</h1>
      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>
      <div class="hero-unit" style="padding-top: 10px;margin-bottom: 5px;">
        <h2>Stock: <?php echo number_format($stock,0,",",".");?> Animales</h2>

        <div class="bs-docs-example">
              <ul id="myTab" class="nav nav-tabs">
                <li <?php if($seccion == 'ingreso' OR $seccion == ''){ echo "class=\"active\"";}?>><a href="#ingresos" data-toggle="tab" id="btnIngresos"><b>Ingresos</b></a></li>
                <li <?php if($seccion == 'egreso'){ echo "class=\"active\"";}?>><a href="#egresos" data-toggle="tab" id="btnEgresos"><b>Egresos</b></a></li>
                <li <?php if($seccion == 'muerte'){ echo "class=\"active\"";}?>><a href="#muertes" data-toggle="tab" id="btnMuertes"><b>Muertes</b></a></li>
              </ul>


          <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade <?php if($seccion == 'ingreso' OR $seccion == ''){ echo 'active in';}?>" id="ingresos">
              <?php 
                //include("ingresoManual.php");
                include("ingresoBalanza.php");
              ?>
              
            </div>

            <div class="tab-pane fade <?php if($seccion == 'egreso'){ echo 'active in';}?>" id="egresos">
              <?php 
                //include("egresos.php");
                include("egresosBalanza.php");
                ?>
            </div>

            <div class="tab-pane fade <?php if($seccion == 'muerte'){ echo 'active in';}?>" id="muertes">
              <?php include("muertesBalanza.php");?>
            </div> 
          </div>
          <hr>
          <footer>
            <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
          </footer>
        </div>
          <span class="ir-arriba icon-arrow-up2"></span>
      </div>
    </div>

    <script type="text/javascript">

     /* var ingresoManual = document.getElementById('abrirManual');
      ingresoManual.addEventListener('click',function(){
        $("#cargaManual").toggle(1);
      });

       var ingresoManualEgr = document.getElementById('abrirManualEgr');
      ingresoManualEgr.addEventListener('click',function(){
        $("#cargaManualEgr").toggle(1);
      });
*/
      var ingresoBalanza = document.getElementById('abrirBalanza');
      ingresoBalanza.addEventListener('click',function(){
        $("#cargaBalanza").toggle(1);
      });

    //   var raza = document.getElementById('razas');
    //   raza.addEventListener('change',function(){
    //   var valorRaza = $(this).val();
    //   console.log(valorRaza);

    //   if (valorRaza == 'otro') {
    //     $("#otraRaza").show(1);
    //   }else{
    //     $("#otraRaza").hide(1);
    //   }
    // });

        $(document).ready(function(){

          // OTRA CAUSA MUERTE
            $(".causaMuerteOtro").hide();
            $("#selectCausaMuerte").change(function(){
              $(".causaMuerteOtro").hide();
              var causa = $(this).val();
              if (causa == "otro") {
                  $("#mostrarOtra").show();
              }
            });

          //MOSTRAR FILTROS TABLA INGRESOS 
            $("#contFiltrosIng").hide();
            
            $("#filtrosIng").on('click',function(){
              $("#contFiltrosIng").toggle(500);
            })

          // MOSTRAR FILTROS TABLA EGRESOS
            $("#contFiltrosEgr").hide();
            $("#filtrosEgr").on('click',function(){
              $("#contFiltrosEgr").toggle(500);
            })

          // MOSTRAR FILTROS TABLA MUERTES
            $("#contFiltrosM").hide();
            $("#filtrosM").on('click',function(){
              $("#contFiltrosM").toggle(500);
            })

            


          <?php
          if (empty($_GET) OR $_GET['seccion'] == "ingreso") { ?>
          // CARGA REGISTROS INGRESOS
            cargaIngresos();
          <?php
            }else{ 
              if ($_GET['seccion'] == "egreso") { ?>
          // CARGA REGISTROS EGRESOS
            cargaEgresos();      
            <?php
            }
            
            if ($_GET['seccion'] == "muerte") { ?>
          // CARGA REGISTROS MUERTES
            cargaMuertes();

          <?php }  
          }
          ?>
        });

        


        function filtrarIng(){
          $('#myTableIngresos').hide();
          $('#paginadorIngresos').hide();
          $('#contenedorIngresos').show();

          var desde;
          var hasta;
          var renspa;
          var proveedor;
          var orden;
          var datos = [];
          
          desde = $('#desde').val();
          hasta = $('#hasta').val();
          renspa = $('#renspa').val();
          proveedor = $('#proveedor').val();
          orden = $('input:radio[name=orden]:checked').val();

          if (desde != "") {
            datos.push('desde=' + desde);
          }
          if (hasta != "") {
            datos.push('hasta=' + hasta);
          }
          if (renspa != "") {
            datos.push('renspa=' + renspa);
          }
          if (proveedor != "") {
            datos.push('proveedor=' + proveedor);
          }
          datos.push('orden=' + orden);

          datos = datos.join('&');
          $('#contenedorIngresos').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
          var url = 'generarIngresos.php';
          $.ajax({
          type:'POST',
          url:url,
          data:datos,
          success: function(datos){
            $('#contenedorIngresos').html(datos);
          }
          });
        };

        function filtrarEgr(){
          $('#myTableEgresos').hide();
          $('#paginadorEgresos').hide();
          $('#contenedorEgresos').show();

          var desde;
          var hasta;
          var destino;
          var orden;
          var datosEgr = [];
          
          desde = $('#desdeEgr').val();
          hasta = $('#hastaEgr').val();
          destino = $('#destino').val();
          orden = $('input:radio[name=ordenEgr]:checked').val();

          if (desde != "") {
            datosEgr.push('desde=' + desde);
          }
          if (hasta != "") {
            datosEgr.push('hasta=' + hasta);
          }
          if (destino != "") {
            datosEgr.push('destino=' + destino);
          }
          datosEgr.push('orden=' + orden);

          datosEgr = datosEgr.join('&');
          console.log(datosEgr);


          var urlEgr = 'generarEgresos.php';
          $('#contenedorEgresos').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
          $.ajax({
          type:'POST',
          url:urlEgr,
          data:datosEgr,
          success: function(datosEgr){
            $('#contenedorEgresos').html(datosEgr);
          }
          });
        };

        function filtrarM(){
          $('#myTableMuertes').hide();
          $('#paginadorMuertes').hide();
          $('#contenedorMuertes').show();

          var desde;
          var hasta;
          var causa;
          var orden;
          var datosM = [];
          
          desde = $('#desdeM').val();
          hasta = $('#hastaM').val();
          causa = $('#causa').val();
          orden = $('input:radio[name=ordenM]:checked').val();

          if (desde != "") {
            datosM.push('desde=' + desde);
          }
          if (hasta != "") {
            datosM.push('hasta=' + hasta);
          }
          if (causa != "") {
            datosM.push('causa=' + causa);
          }
          datosM.push('orden=' + orden);

          datosM = datosM.join('&');
          console.log(datosM);


          var urlM = 'generarMuertes.php';
          $('#contenedorMuertes').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
          $.ajax({
          type:'POST',
          url:urlM,
          data:datosM,
          success: function(datosM){
            $('#contenedorMuertes').html(datosM);
          }
          });
        };

        function reset(seccion){
          $('#myTable' + seccion).show();
          $('#paginador' + seccion).show();
          $('#contenedor' + seccion).hide();
        }

        function paginar(pagina,seccion){
          var datosPag;
          var desde;
          var urlPaginador = 'paginador.php';
          desde = (pagina * 12) + 1;
          if (pagina == 0) {
            desde = (pagina * 12);
          }

          var contenedor = '#paginadoIng';
          if (seccion == 'muertes') {
            contenedor = '#paginadoMuertes';
            urlPaginador = 'paginadorMuertes.php';
          }
          if (seccion == 'egresos') {
            contenedor = '#paginadoEgr';
            urlPaginador = 'paginadorEgr.php';
          }
          $(contenedor).html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');

          datosPag = 'desde=' + desde; 
          console.log(datosPag);

          $.ajax({
          type:'POST',
          url:urlPaginador,
          data:datosPag,
          success: function(datosPag){
            $(contenedor).html(datosPag);
          }
          });

        };


        $(document).ready(function() {    
          $('.paginador').on('click', function(){
              //Añadimos la imagen de carga en el contenedor
              $('#content').html('<div class="loading"><img src="images/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
       
              $.ajax({
                  type: "POST",
                  url: "ajax.php",
                  success: function(data) {
                      //Cargamos finalmente el contenido deseado
                      $('#content').fadeIn(1000).html(data);
                  }
              });
              return false;
          });              
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

        var cargarIng = document.getElementById('btnIngresos');
        cargarIng.addEventListener('click',cargaIngresos());

        var cargarEgr = document.getElementById('btnEgresos');
        cargarEgr.addEventListener('click',cargaEgresos());

        var cargarMuertes = document.getElementById('btnMuertes');
        cargarMuertes.addEventListener('click',cargaMuertes());
    </script>
    






    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
