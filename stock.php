<?php

require 'stock.backend.php';

require 'head.php';

?>

    <script src="js/stock.js"></script>

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

              <div class="row-fluid">

                <div class="span6">

                  <div class="bs-docs-example">
                      
                      <div class="breadcrumb">
                  
                      <?php 
                    
                      include("ingresoBalanza.php");
                                          
                      ?>
                
                    </div>
                    
                  </div>

                </div>
              
                <div class="span6">

                  <div class="bs-docs-example">
                    
                    <div class="breadcrumb">
                    
                    <?php
                        require 'infoIngresos.php';
                    ?>
                    
                    </div>

                  </div>

                </div>
              
              </div>

              <?php 
                
                require 'tablaIngresos.php';

              ?>
              
            </div>

            <div class="tab-pane fade <?php if($seccion == 'egreso'){ echo 'active in';}?>" id="egresos">

              <div class="row-fluid">

                <div class="span6">

                  <div class="bs-docs-example">
                      
                      <div class="breadcrumb">

                        <?php 
                        
                          //include("egresos.php");
              
                          include("egresosBalanza.php");
              
                        ?>
    
                    </div>
              
                  </div>
              
                </div>

                <div class="span6">

                    <div class="bs-docs-example">
                        
                        <div class="breadcrumb">

                          <?php 
                                          
                            include("infoEgresos.php");
                
                          ?>
      
                      </div>
                
                    </div>

                </div>

              </div>
            
              <?php 
                
                require 'tablaEgresos.php';

              ?>
            </div>

            <div class="tab-pane fade <?php if($seccion == 'muerte'){ echo 'active in';}?>" id="muertes">
            
              <div class="row-fluid">

                <div class="span6">

                  <div class="bs-docs-example">
                      
                      <div class="breadcrumb">

                        <?php 
                        
                          include("muertesBalanza.php");

                        ?>

                    </div>

                  </div>

                </div>

                <div class="span6">

                    <div class="bs-docs-example">
                        
                        <div class="breadcrumb">

                          <?php 
                                          
                            include("infoMuertes.php");

                          ?>

                      </div>

                    </div>

                </div>

              </div>

                <?php 

                require 'tablaMuertes.php';

                ?>
      
            </div> 
    
    
          </div>
    
          <hr>
      
        </div>
    
        <span class="ir-arriba icon-arrow-up2"></span>
    
       </div>
    
    </div>

    <script type="text/javascript">

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
                <?php 
                }  
        
              }
        
              ?>
        
        });

    
        function filtrarIng(){
          

          $('#myTableIngresos').hide();
    
          $('#paginadorIngresos').hide();
    
          $('#contenedorIngresos').show();

          let desde, hasta, renspa, proveedor, estado, pesoMin, pesoMax, orden
    
          let datos = [];
    
          desde = $('#desde').val();
    
          hasta = $('#hasta').val();
    
          renspa = $('#renspa').val();
    
          proveedor = $('#proveedor').val();

          estado = $('#estado').val();
          
          pesoMin = $('#pesoMin').val();
          
          pesoMax = $('#pesoMax').val();
    
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
    
          if (estado != "") {
    
            datos.push('estado=' + estado);
    
          }
    
          if (proveedor != "") {
    
            datos.push('proveedor=' + proveedor);
    
          }
    
          if (pesoMax != 0 && pesoMin < pesoMax) {
    
            datos.push('pesoMin=' + pesoMin);
            datos.push('pesoMax=' + pesoMax);
    
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
    
          let desde;
    
          let hasta;
    
          let destino;
    
          let orden;
    
          let datosEgr = [];
    
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
    
          let urlEgr = 'generarEgresos.php';
    
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
    
          let datosPag;
    
          let desde;
    
          let urlPaginador = 'paginador.php';
    
          desde = (pagina * 8) + 1;
    
          if (pagina == 0) {
    
            desde = (pagina * 8);
    
          }


    
          var contenedor = '#paginadoIng';
    
          if (seccion == 'muertes') {
    
            contenedor = '#paginadoMuertes';
    
            urlPaginador = 'paginadorMuertes.php';
    
          }
          
          
          if (seccion == 'registroegresos') {
    
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

        let cargarIng = document.getElementById('btnIngresos');
    
        cargarIng.addEventListener('click',cargaIngresos());


        let cargarEgr = document.getElementById('btnEgresos');
    
        cargarEgr.addEventListener('click',cargaEgresos());

    
        let cargarMuertes = document.getElementById('btnMuertes');
    
        cargarMuertes.addEventListener('click',cargaMuertes());
    
        
    </script>

    <!-- MODAL CARGA MANUAL -->
        
    <div class="modal fade" id="modalCargaManual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999">

      <div class="modal-dialog" role="document">

        <div class="modal-content">

          <div class="modal-header">

            <h4 class="modal-title" id="exampleModalLabel">Aviso</h4>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            </button>

          </div>

          <div class="modal-body">
            <p style="font-weight:bold"> 
              Recorda renombrar el archivo, con el nombre de la tropa.
            </p>
          </div>

          <div class="modal-footer" style="padding: 0; padding-right: 15px;">

            <a href="#" id="descargarPlanillaManual"  download="" class="btn btn-secondary"><h5>Descargar Planilla</h5></a>

          </div>

        </div>

      </div>

    </div>

  </body>

  <script src="js/muertes.js"></script>

</html>

