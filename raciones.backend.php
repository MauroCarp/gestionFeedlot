<?php
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

  // INGRESO MIXER

  if ($accion == "ingresoMixer") { 

    $fecha = $_POST['fecha'];

    $formula = $_POST['formula'];
    
    $kilos = $_POST['kilos'];

    $operario = $_POST['operario'];

    $otroOperario = $_POST['otroOperario'];

    if ($operario == 'otroOperario') {

      $operario = $otroOperario;

      $sqlNueva = "INSERT INTO operarios(feedlot,nombre) VALUES ('$feedlot','$operario')";

      mysqli_query($conexion,$sqlNueva);

    }


    $sql = "INSERT INTO mixer(feedlot,fecha,operario,formula,kilos) 

    VALUES ('$feedlot','$fecha','$operario','$formula','$kilos')";

    mysqli_query($conexion,$sql);

    echo "<script>
	    window.location = 'raciones.php?seccion=mixer';
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

    $margen = $_POST['margenError'];

    $id = $_GET['id'];

    $sqlRedondeo = "UPDATE mixer SET

    redondeo = '$redondeo',
    
    margen = '$margen'

    WHERE id = '$id'";

    $queryRedondeo = mysqli_query($conexion,$sqlRedondeo);

    echo "<script>
	    window.location = 'raciones.php?seccion=mixer';
    </script>";
  }

  if ($accion == 'eliminarMixer'){

    $id = $_GET['id'];

    $sql = "DELETE FROM mixer WHERE id = '$id'";

    $query = mysqli_query($conexion,$sql);

    echo "<script>

	    window.location = 'raciones.php?seccion=mixer';

    </script>";



  }

  // INGRESO RACIONES DESDE MIXER

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



  /////// INSUMOS  ////////

    if ($accion == 'nuevoInsumo') {

      $insumo = $_POST['nombre'];

      $precio = $_POST['precio'];

      $porceMS = $_POST['porMS'];

      $proteina = $_POST['proteina'];

      $tipo = $_POST['tipoInsumo'];

      $tipo = ($tipo == 'otroTipo') ? $_POST['otroTipo'] : $tipo;

      
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

      $sql = "INSERT INTO insumos(feedlot,insumo,tipo,precio,porceMS,Pr,fecha) VALUES ('$feedlot','$insumo','$tipo','$precio','$porceMS','$proteina','$fecha')";

      mysqli_query($conexion,$sql);


      $sqlRegistro = "INSERT INTO registroinsumo(insumo,precio,porceMS,fecha) VALUES ('$insumo','$precio','$porceMS','$fecha')";
      
      mysqli_query($conexion,$sqlRegistro);

      echo "<script>

        window.location = 'raciones.php?seccion=insumos';

      </script>";



  }

  if ($accion == "modificarInsumo") {

    $id = $_GET['id'];

    $insumo = $_POST['nombre'];

    $precio = $_POST['precio'];

    $porceMS = $_POST['porMS'];

    $proteina = $_POST['proteina'];

    $tipo = $_POST['tipoInsumo'];

    $tipo = ($tipo == 'otroTipo') ? $_POST['otroTipo'] : $tipo;


    $sql = "UPDATE insumos SET
    insumo = '$insumo',
    tipo = '$tipo',
    precio = '$precio',
    porceMS = '$porceMS',
    Pr = '$proteina',
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

  /*********
                FORMULA
                            *********/


  if ($accion == 'nuevaFormula') {

    $nombre = $_POST['nombre'];

    $tipoFormula = $_POST['tipo'];

    $otroTipo = $_POST['tipoOtra'];


    if ($tipoFormula == 'otro') {

      $tipoFormula = $otroTipo;

      $sqlNueva = "INSERT INTO tipoformula(tipo) VALUES ('$tipoFormula')";

      $queryNueva = mysqli_query($conexion,$sqlNueva);
      
    }


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

    $total = $_POST['total'];

    $fechaFormula = date("Y-m-d");

    $sql = "INSERT INTO formulas(fecha,nombre,tipo,precio) VALUES ('$fechaFormula','$nombre','$tipoFormula','$total')";
    
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
            
      $total = $_POST['total'];   
      
      $tipoFormula = $_POST['tipo'];
      $otroTipo = $_POST['tipoOtra'];
      
      if ($tipoFormula == 'otro') {
        
        $tipoFormula = $otroTipo;
        
        $sqlNueva = "INSERT INTO tipoFormula(tipo) VALUES ('$tipoFormula')";
        
        mysqli_query($conexion,$sqlNueva);
        
      }
      
      $fechaFormula = date("Y-m-d");

      $sql = "DELETE FROM formulas WHERE id = '$id'";

      mysqli_query($conexion,$sql);


      $sql = "INSERT INTO formulas(fecha,nombre,tipo,precio) VALUES ('$fechaFormula','$nombre','$tipoFormula','$total')";

      $query = mysqli_query($conexion,$sql);

    
      $sqlDatos = "SELECT id FROM formulas WHERE tipo = '$tipoFormula' AND nombre = '$nombre'";
      $queryDatos = mysqli_query($conexion,$sqlDatos);

      $fila = mysqli_fetch_array($queryDatos);

      $id = $fila['id'];
      
      for ($i=0; $i < sizeof($productos) ; $i++) {

        $producto = "p".($i+1);

        $sqlProductos = "UPDATE formulas SET $producto = '$productos[$i]' WHERE id = '$id'"; 

        mysqli_query($conexion,$sqlProductos);

      }

      for ($i=0; $i < sizeof($porcentajes) ; $i++) {

        $porcentaje = "por".($i+1);


        $sqlPorc = "UPDATE formulas SET $porcentaje = '$porcentajes[$i]' WHERE id = '$id'"; 

        mysqli_query($conexion,$sqlPorc);


      }      
    
      echo "<script>
	    window.location = 'raciones.php?seccion=formulas';
    </script>";

  }

  if ($accion == 'eliminarFormula') {
    
    $id = $_GET['id'];
    
    $sqlFormula = "DELETE FROM formulas WHERE id = '$id'";
    
    mysqli_query($conexion,$sqlFormula);
    
    echo "<script>
	    window.location = 'raciones.php?seccion=formulas';
    </script>";
  }


  /*********
                PREMIX
                            *********/
  if ($accion == 'nuevoPremix'){
    
    $nombre = $_POST['nombre'];
    
    $ms = $_POST['porcentajeMSPre'];

    $precioTotal = substr($_POST['precioTotal'],1);

    $insumos = array();

    $rows = array();
    
    $values = array();

    $insumos[] = $_POST['insumoPre'];

    $rows[] = 'p1';
    
    
    for ($i=1; $i <=10 ; $i++) { 

      $insumo = "insumoPre".$i;
      
      if (isset($_POST[$insumo])) {
        
        $insumos[] = $_POST[$insumo];
        
        $rows[] = 'p'.($i+1); 
        
      }
      
    }
    
    $rows[] = 'kg1';

    $kilos = array();

    $kilos[] = $_POST['kilosPre'];

    for ($a=1; $a <=30 ; $a++) { 

      $kilo = "kilosPre".$a;

      if (isset($_POST[$kilo])) {

        $kilos[] = $_POST[$kilo];

        $rows[] = 'kg'.($a+1);

      }

    }

    $rows = implode(',',$rows);

    $insumos = implode(',',$insumos);

    $precioKilo = ($precioTotal / array_sum($kilos) );

    $kilos = implode(',',$kilos);

    $fecha = date("Y-m-d");
    
    $sql = "INSERT INTO premix(fecha,nombre,precio,ms,$rows) VALUES ('$fecha','$nombre','$precioKilo','$ms',$insumos,$kilos)";

    $query = mysqli_query($conexion,$sql);

    $sql = "INSERT INTO insumos(feedlot,insumo,tipo,precio,porceMS,fecha) VALUES('$feedlot','$nombre','Premix','$precioKilo','$ms','$fecha')";
        
    $query = mysqli_query($conexion,$sql);
    
    echo "<script>
    
      window.location = 'raciones.php?seccion=premix';
    
    </script>";  
    
  
  }

  if ($accion == 'actualizarPremix'){
    
    $id = $_GET['id'];
    
    $nombre = $_POST['nombre'];
    
    $ms = $_POST['porcentajeMSPre'];

    $precioTotal = substr($_POST['precioTotal'],1);

    $insumos = array();
    
    $values = array();

    $insumos[] = $_POST['insumoPre'];
    
    for ($i=1; $i <=10 ; $i++) { 

      $insumo = "insumoPre".$i;
      
      if (isset($_POST[$insumo])) {
        
        $insumos[] = $_POST[$insumo];
                
      }
      
    }
    
    $kilos = array();

    $kilos[] = $_POST['kilosPre'];

    for ($a=1; $a <=30 ; $a++) { 

      $kilo = "kilosPre".$a;

      if (isset($_POST[$kilo])) {

        $kilos[] = $_POST[$kilo];

      }

    }

    $precioKilo = ($precioTotal / array_sum($kilos) );

    $fecha = date("Y-m-d");
    
    $sql = "UPDATE premix SET

      fecha = '$fecha',

      nombre = '$nombre',

      precio = '$precioKilo',

      ms = '$ms'

    WHERE id = '$id'";

    $query = mysqli_query($conexion,$sql);

    for ($i=0; $i < 10 ; $i++) {
      
      $producto = "p".($i+1);
      
      if(array_key_exists($i,$kilos)){

        $sqlProductos = "UPDATE premix SET $producto = '$insumos[$i]' WHERE id = '$id'"; 
        
      }else{
        
        $sqlProductos = "UPDATE premix SET $producto = NULL WHERE id = '$id'"; 

      }
      
      mysqli_query($conexion,$sqlProductos);
      
    }
    
    for ($i=0; $i < 10 ; $i++) {
      
      $kg = "kg".($i+1);
      
      if(array_key_exists($i,$kilos)){

        $sql = "UPDATE premix SET $kg = '$kilos[$i]' WHERE id = '$id'"; 
        
      }else{
        
        $sql = "UPDATE premix SET $kg = NULL WHERE id = '$id'"; 

      }
      
      mysqli_query($conexion,$sql);
      

    }

    echo "<script>
    
      window.location = 'raciones.php?seccion=premix';
    
    </script>";  
    
  
  }

  if ($accion == 'eliminarPremix'){

    $id = $_GET['id'];

    $nombre = $_GET['nombre'];

    $sql = "DELETE FROM premix WHERE id = '$id'";
    
    mysqli_query($conexion,$sql);

    $sql = "DELETE FROM insumos WHERE insumo = '$nombre'";

    mysqli_query($conexion,$sql);

       
    echo "<script>
	    window.location = 'raciones.php?seccion=premix';
    </script>";

    

  }

  if($accion == 'nuevoInsumoPremix'){

    $nombre = $_POST['nombre'];

    $precio = $_POST['precio'];

    $sql = "INSERT INTO insumospremix(nombre,precio) VALUES ('$nombre','$precio')";

    mysqli_query($conexion,$sql);

    echo "<script>
	    window.location = 'raciones.php?seccion=premix';
    </script>";

  }

}
 
$seccionValido = array_key_exists('seccion',$_REQUEST);
  if ($seccionValido) {
    $seccion = $_GET['seccion'];
  }else{
    $seccion = '';
  }