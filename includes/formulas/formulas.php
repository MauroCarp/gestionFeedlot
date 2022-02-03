function formatearFecha($fecha){
    if ($fecha == NULL) {
        $fechaFormateada = '';
    }else{  
        $fechaFormateada = date("d-m-Y",strtotime($fecha));
    }
  return $fechaFormateada;
}

function nombreInsumo($productoN,$productoResultado,$conexion){
    $sql = "SELECT * FROM formulas INNER JOIN insumos ON formulas.$productoN = insumos.id WHERE insumos.id = '$productoResultado'";
    $query = mysqli_query($conexion,$sql);
    $fila = mysqli_fetch_array($query);
    $resultado = $fila['insumo'];
    return $resultado;
}

function formatearNum($numero){
    $numeroFormateado = number_format($numero,2,",",".");
    return $numeroFormateado;
}

function precioInsumo($productoN,$productoResultado,$conexion){
    $sql = "SELECT * FROM formulas INNER JOIN insumos ON formulas.$productoN = insumos.id WHERE insumos.id = '$productoResultado'";
    $query = mysqli_query($conexion,$sql);
    $fila = mysqli_fetch_array($query);
    $resultado = $fila['precio'];
    return $resultado;
}

function porceMS($id_producto,$porcentaje,$conexion){

$sql = "SELECT porceMS FROM insumos WHERE id = '$id_producto'";

$query = mysqli_query($conexion,$sql);

$resultado = mysqli_fetch_array($query);

$porceMSinsumo = $resultado['porceMS'];

$porceMS = $porcentaje * ($porceMSinsumo / 100);

return $porceMS;
}   

function tomaPorcentajeMS($productoN,$productoResultado,$conexion){
    $sql = "SELECT * FROM formulas INNER JOIN insumos ON formulas.$productoN = insumos.id WHERE insumos.id = '$productoResultado'";
    $query = mysqli_query($conexion,$sql);
    $fila = mysqli_fetch_array($query);
    $resultado = $fila['porceMS'];
    return $resultado;
}