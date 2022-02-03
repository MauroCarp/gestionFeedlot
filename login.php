<?php
include("includes/conexion.php");

$seEnvioInfo = sizeof($_REQUEST) > 0;
$feedlotValido = array_key_exists('feedlot', $_GET);
$accionValido = array_key_exists('accion', $_GET);
if( $seEnvioInfo ) {
  if($feedlotValido){ 
    session_start();
    $feedlot = $_GET['feedlot'];
    $sqlTipo = "SELECT tipo FROM login WHERE feedlot = '$feedlot'";
    $queryTipo = mysqli_query($conexion,$sqlTipo);
    $tipo = mysqli_fetch_array($queryTipo);

    $_SESSION['logged'] = TRUE;
    $_SESSION['feedlot'] = $feedlot;
    $_SESSION['tipo'] = $tipo['tipo'];

    echo "<script>
	    window.location = 'index.php';
    </script>";
  }

  if ($accionValido) {
    $accion = $_GET['accion'];
    if ($accion == 'nueva') {
        
    $feedlot = $_POST['feedlot'];
    $tipo = $_POST['tipo'];

        $sql = "INSERT INTO login(feedlot,tipo) VALUES ('$feedlot','$tipo')";
        $query = mysqli_query($conexion,$sql);
        }

        echo "<script>
          window.location = 'login.php';
        </script>";
    }
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="img/ico.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/ico.ico" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JORGE CORNALE - GESTION DE FEEDLOTS -</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        background-image: url(img/login-bg1.jpg);
        background-size: 100%;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
    </style>
  </head>

  <body class="text-center">
    <form class="form-signin">
      <img class="mb-4" src="img/logoAcopiadora.jpg" alt="" width="300" height="">
      <h4 class="h3 mb-3 font-weight-ligth">Seleccione Feedlot</h4>
      <select class="form-control" name="feedlot" required autofocus>
        <?php
          $sql = "SELECT feedlot FROM login ORDER BY feedlot ASC";
          $query = mysqli_query($conexion,$sql);
          while ($fila = mysqli_fetch_array($query)) { ?>
          
            <option value="<?php echo $fila['feedlot'];?>"><?php echo $fila['feedlot'];?> </option>

         <?php }
        ?>
      </select>
      <hr>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
      <br>
      <p class="mt-5 mb-3 text-muted">&copy; Gestion de Feedlots 2019</p>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>