<?php
require("includes/conexion.php");
require("includes/functions.php");
?>
<?php
/*$esAccionValido = array_key_exists('accion', $_GET);
if ($esAccionValido) {
    $renspa = $_GET['renspa'];
    $campania = $_GET['campania'];
    $noti = "notiBruce";
    $fecha = "fechaBruce";
    if ($campania == "tuber") {
        $noti = "notiTuber";
        $fecha = "fechaTuber";
    }

    $sqlQuery = "UPDATE notificados SET 
    `$noti` = '0',
    `$fecha` = ''
    WHERE renspaNoti = '$renspa'";
    $query = mysqli_query($conexion,$sqlQuery);
    header("Location:notificados.php");
}*/
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Sistema Fissa</title>
    <link rel="icon" href="img/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"/>
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
    <div class="container">
      <div class="row-fluid">
        <div class="span12" align="center">
          <img src="img/logo.png" width="400px" height="auto" alt="Isologotipo F.I.S.S.A">
      <hr>
        </div>
      </div>

        <div class="hero-unit">
            <table class="table table-striped">
                <thead>
                    <th>Renspa</th>  
                    <th>Establecimiento</th>
                    <th>Propietario</th>
                    <th>Campaña Notificada</th>
                    <th>Fecha de Notificac&oacute;n</th>    
                    <!--<th></th>-->
                </thead>
                <?php
                $sqlQuery = "SELECT * FROM establecimientos INNER JOIN brucelosis ON establecimientos.renspa = brucelosis.renspaBruce WHERE notificado = 1 ORDER BY fechaNotificado ASC";
                $query = mysqli_query($conexion, $sqlQuery);
                echo mysqli_error($conexion);
                while ($fila = mysqli_fetch_array($query)) {
                    echo "<tr><td>".$fila['renspa']."</td>";
                    echo "<td>".$fila['nombre_establecimiento']."</td>";
                    echo "<td>".$fila['propietario']."</td>";
                    echo "<td>Brucelosis</td>";
                    echo "<td>".$fila['fechaNotificado']."</td>";
                    /*echo "<td><a href=\"notificados.php?renspa=".$fila['renspa']."&campania=bruce&accion=cancelar\">x</a></td></tr>";*/
                    }

                
                $sqlQuery = "SELECT * FROM establecimientos INNER JOIN tuberculosis ON establecimientos.renspa = tuberculosis.renspaTuber WHERE notificado = 1 ORDER BY fechaNotificado ASC";
                $query = mysqli_query($conexion, $sqlQuery);

                while ($fila = mysqli_fetch_array($query)) {
                    echo "<tr><td>".$fila['renspa']."</td>";
                    echo "<td>".$fila['nombre_establecimiento']."</td>";
                    echo "<td>".$fila['propietario']."</td>";
                    echo "<td>Tuberculosis</td>";
                    echo "<td>".$fila['fechaNotificado']."</td>";
                    /*echo "<td><a href=\"notificados.php?renspa=".$fila['renspa']."&campania=bruce&accion=cancelar\">x</a></td></tr>";*/
                    }
                ?>
            </table>
        </div>

      <hr>

      <footer>
        <p>Fissa - 2018</p>
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