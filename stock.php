<?php

require 'stock.backend.php';

require 'head.php';

?>

  <body>
    
  <script src="js/stock.js"></script>

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

              <div class="row-fluid">

                <div class="span6">

                  <div class="bs-docs-example">
                      
                      <div class="breadcrumb">
                  
                      <?php 
                    
                      //include("ingresoManual.php");
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


        
              <?php }  
        
      }
        
        ?>
        
            });

    
        function filtrarIng(){
    
          $('#myTableIngresos').hide();
    
          $('#paginadorIngresos').hide();
    
          $('#contenedorIngresos').show();

          let desde;
    
          let hasta;
    
          let renspa;
    
          let proveedor;
    
          let orden;
    
          let datos = [];


    
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

        let cargarIng = document.getElementById('btnIngresos');
    
        cargarIng.addEventListener('click',cargaIngresos());


    
        let cargarEgr = document.getElementById('btnEgresos');
    
        cargarEgr.addEventListener('click',cargaEgresos());


    
        let cargarMuertes = document.getElementById('btnMuertes');
    
        cargarMuertes.addEventListener('click',cargaMuertes());
    
    </script>

  </body>

  <script src="js/muertes.js"></script>

</html>

