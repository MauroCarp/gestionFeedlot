<?php
    
    include('../includes/conexion.php');


    if($_POST['accion'] == 'cargarData'){

        $id = $_POST['idAnimal'];

        $tabla = $_POST['tabla'];
         
        $sql = "SELECT * FROM  $tabla WHERE id = '$id'";
    
        $query = mysqli_query($conexion,$sql);
    
        $resultado = mysqli_fetch_array($query);
    
        echo json_encode($resultado);

    }


    if($_POST['accion'] == 'modificarData'){
        
        $data = json_decode($_POST['data'], true);

        $id = $data['idAnimal'];

        $tabla = $_POST['tabla'];

        $set = '';
        foreach ($data as $key => $value) {
            
            if($key != 'idAnimal')
                $set .= $key." = '".$value."',";
                
        }

        $set =  substr($set, 0, -1);
        
        $sql = "UPDATE $tabla SET $set WHERE id = '$id'";

        if(mysqli_query($conexion,$sql)){
            
            echo 'ok';

        }else{

            echo mysqli_error($conexion);
            echo 'error';

        };
    
    }
    


?>