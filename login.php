<?php
include("includes/conexion.php");


$seEnvioInfo = sizeof($_REQUEST) > 0;

$feedlotValido = array_key_exists('feedlot', $_GET);

$accionValido = array_key_exists('accion', $_GET);


if(isset($_POST["btnIngresar"])){

  if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"])){

    $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

    $tabla = "login";

    $item = "user";

    $valor = $_POST["ingUsuario"];

    $sql = "SELECT * FROM $tabla  WHERE $item = '$valor'";

    $query = mysqli_query($conexion,$sql);

    $respuesta = mysqli_fetch_array($query);

    if($respuesta["user"] == $_POST["ingUsuario"] && $respuesta["pass"] == $encriptar){

      session_start();

      $feedlot = $respuesta['feedlot'];
      
      $_SESSION['logged'] = TRUE;
  
      $_SESSION['feedlot'] = $feedlot;
  
      $_SESSION['tipo'] = $respuesta['tipo'];
    
      echo "<script>
  
        let date = new Date()
  
        date.setTime(date.getTime()+(30*24*60*60*1000))
  
        let expires = date.toGMTString()
      
        document.cookie = `feedlot = ".$feedlot.";path=/gestionFeedlot;Expires=` + expires
        
        window.location = 'index.php'
      
      </script>";

    }else{

      echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';

    }

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
    <title>JORGE CORNALE - GESTION DE FEEDLOT -</title>

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
        overflow-y:hidden;
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

    <form class="form-signin" method="POST" action="login.php">

      <img class="mb-4" src="img/logo1.png" alt="" width="300" height="">

      <h4 class="h3 mb-3 font-weight-ligth">Usuario</h4>
      <input type="text" name="ingUsuario" id="ingUsuario" value="Jcornale">

      <h4 class="h3 mb-3 font-weight-ligth">Contrase&ntilde;a</h4>
      <input type="password" name="ingPassword" id="ingPassword" required autofocus>
      
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnIngresar">Ingresar</button>

    </form>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>