<?php
include("includes/init_session.php");
require("includes/conexion.php");
require("includes/funciones.php");
include("includes/arrays.php");


$seccion = $_GET['seccion'];
$accionValido = array_key_exists("accion", $_REQUEST);



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
      <h1 style="display: inline-block;">IMPORTAR / EXPORTAR DATOS</h1> 
      <h4 style="display: inline-block;float: right;"><?php echo "<b>".$feedlot."</b> -  Fecha: ".$fechaDeHoy;?></h4>
      <hr>

      <div class="hero-unit" style="padding-top: 10px;">
        <div class="row-fluid">
          <div class="span12">
              <h1><b>
                <?php 
                if($seccion == 'todos'){
                    echo "Base de datos completa";
                  }else{
                    echo strtoupper($seccion);
                  }
                  ?>
                  
                </b></h1><br>
              <div class="span5" style="border:2px solid green;border-radius:20px;padding: 20px;"> 
                <h2 style="margin-top: 0px;">Exportar</h2>
                  <?php
                  if($seccion == 'todos'){ ?>
                    <a href="exportarTodo.php" class="btn btn-theme">
                    Exportar Base de datos completa</a>
                  <?php
                  }else{ ?>
                    <a href="exportar.php?seccion=<?php echo $seccion;?>" class="btn btn-theme">
                    "Exportar datos de"<?php echo  ucwords($seccion);?>
                    </a>
                  <?php
                  }
                  ?>
              </div>
              <div class="span5">
                <?php
                  if ($seccion == "todos") { ?>
                    <form action="importarTodo.php" method="post" enctype="multipart/form-data">
                 <?php }else{ ?>
                    <form action="importar.php?seccion=<?php echo $seccion;?>" method="post" enctype="multipart/form-data">
                 <?php
                  }
                ?>
                  <fieldset style="border:2px solid green;border-radius:20px;padding: 20px;"> 
                  <h2 style="margin-top: 0px;">Importar</h2>
                    <input type="file" class="default" name="exportado" required><br>
                    <input type="submit" value="Subir archivo" class="btn btn-theme"></input>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
      <hr>
      <footer>
        <p>Gesti&oacute;n de FeedLots - Jorge Cornale - 2018</p>
      </footer>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/alert.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/dropdown.js"></script>
    <script src="js/scrollspy.js"></script>
    <script src="js/tab.js"></script>
    <script src="js/tooltip.js"></script>
    <script src="js/popover.js"></script>
    <script src="js/button.js"></script>
    <script src="js/collapse.js"></script>
    <script src="js/carousel.js"></script>
    
  </body>
</html>