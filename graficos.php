<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
require("includes/arrays.php");
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>JORGE CORNALE - GESTION DE FEEDLOTS</title>
    <link rel="icon" href="img/ico.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/ico.ico" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/chart/dist/Chart.bundle.js"></script>
    <script src="js/chart/samples/utils.js"></script>
    <script type="text/javascript" src="js/tableSorter/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="js/tableSorter/jquery.tablesorter.widgets.js"></script>
    <script src="js/tab.js"></script>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 10px;
      }
    </style>
    <script type="text/javascript">
    
    function mostrar(id) {
      $("#" + id).show(200);
    }
    
    $(function() {
      $("#myTable").tablesorter();
    });          
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
      <div class="hero-unit" style="padding-top: 10px;margin-bottom: 5px;">
        <a href="muertes2.php">Grafico de Torta</a><br>
        <a href="muertes3.php">Grafico de Barras Vertical</a><br>
        <a href="muertes4.php">Grafico de Linea</a><br>
        <a href="muertes5.php">Grafico de Dona</a><br>
        <a href="muertes6.php">Grafico de Combinacion Linea y Barra</a><br>
      </div>
      <footer>
        <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
      </footer>
    </div>

    <script type="text/javascript">
      


        $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        })


    </script>
    






    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/alert.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/dropdown.js"></script>
    <script src="js/scrollspy.js"></script>
    <script src="js/tooltip.js"></script>
    <script src="js/popover.js"></script>
    <script src="js/button.js"></script>
    <script src="js/collapse.js"></script>
    <script src="js/carousel.js"></script>
    
  </body>
</html>
