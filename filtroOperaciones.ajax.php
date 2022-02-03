<?php
include('includes/conexion.php');
include('includes/funciones.php');
include("includes/init_session.php");

$tabla = 'mixer_cargas';


$fecha = $_POST['fecha'];

$mixer = (array_key_exists('mixer',$_POST)) ? $_POST['mixer'] : null;

$mixerSql = ($mixer != null) ? "mixer = '$mixer'" : "mixer IN ('mixer1','mixer2')"; 

$tipo = $_POST['tipo'];

$sqlLotes = '';

$id = 'tablaCargas';

$btn = 'btnTablaCargas';

$title = 'Cargas';

$arrow = "green'>&uarr;";

$sql = "SELECT * FROM $tabla WHERE $mixerSql AND fecha = '$fecha' ORDER BY hora ASC";

if($tipo == 'descarga'){

    $tabla = 'mixer_descargas';

    $id = 'tablaDescargas';

    $btn = 'btnTablaDescargas';
    
    $title = 'Descargas';

    $arrow = "blue'>&darr;";
    
    $lotesValido = array_key_exists('lotes',$_POST);
    
    $sqlLotes = '';

    if($lotesValido){

        $lotes = $_POST['lotes'];

        $sqlLotes = "AND lote IN ($lotes)";

    }

    $sql = "SELECT * FROM $tabla WHERE $mixerSql AND fecha = '$fecha' $sqlLotes ORDER BY hora ASC, lote ASC";
}
//EJECUTAMOS LA CONSULTA DE BUSQUEDA
if($tipo != 'cargaDescarga'){
        
    $query = mysqli_query($conexion,$sql);
    echo "<button class='btn btn-default' id='".$btn."'><b>".$title." <span style='color:".$arrow."</span></b></button>

    <div class='tablasOperaciones' id='".$id."'>
    <table class='table table-striped'>
        
        <thead>
                            
            <th>N°</th>

            <th>Mixer</th>

            <th>Fecha</th>
            
            <th>Hora</th>";
            
            if($tipo == 'descarga'){

                echo "<th>Lote</th>";
            
            }
            
            echo "<th>Cantidad</th>";

            if($tipo == 'descarga'){

                echo "<th>Animales</th>
                
                <th>Operario</th>";
            
            }else{
                
                echo "<th>Ideal</th>
                
                <th>Receta</th>";

            }

        echo "</thead>

        <tbody>";

        $cont = 1;
        

        while($resultado = mysqli_fetch_array($query)){ 
            
            $mixer = ($resultado['mixer'] == 'mixer1') ? '456ST' : 'Autoconsumo';


            echo "<tr>
            
                <td>$cont</td>

                <td>$mixer</td>
            
                <td>".formatearFecha($resultado['fecha'])."</td>

                <td>".$resultado['hora']."</td>";

                if($tipo == 'descarga'){
                
                    echo "<td>".$resultado['lote']."</td>";
                
                }

                echo "<td>".$resultado['cantidad']." Kg'</td>";

                if($tipo == 'descarga'){

                    echo "<td>".$resultado['animales']."</td>

                    <td>".$resultado['operario']."</td>";
    
                
                }else{
                    
                    echo "<td>".$resultado['ideal']."</td>

                    <td>".$resultado['id_receta']."</td>";
    
                }

              $cont++;
            
            }

        
        echo "</tbody>  
    </table>

  </div>";
}else{

    echo "Proximamente";
}



// echo $sql;




?>