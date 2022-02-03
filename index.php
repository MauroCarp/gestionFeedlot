<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");


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
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
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
      <div class="row-fluid">
        <div class="span4 btn-index" align="center">
          <a href="stock.php">
            <img src="img/icon-vaca.png" width="155px" height="auto" alt="Stock">
            <h4>STOCK</h4>
          </a>
        </div>
        <div class="span4 btn-index" align="center">
          <a href="status.php">
            <img src="img/icon-vacuna.png" width="181px" height="auto" alt="Status Sanitario">
            <h4>STATUS SANITARIO</h4>
          </a>
        </div>
        <div class="span4 btn-index" align="center">
          <a href="raciones.php">
            <img src="img/icon-pastura.png" width="132px" height="auto" alt="Raciones">
            <h4>RACIONES</h4>
          </a>
        </div>
      </div>
      
      <hr>

      <div class="hero-unit" style="padding-top: 10px;">
        <h2>ALERTAS</h2>
        <?php
        include("alertas.php"); 
        ?>
     </div>
      <hr>

      <footer>
        <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
      </footer>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>
