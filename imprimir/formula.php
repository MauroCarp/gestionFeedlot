<?php
include("../includes/init_session.php");
include("../includes/conexion.php");
include("../lib/fpdf/fpdf.php");

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

function calcularPrecioPorcentaje($precioTC,$porcentajeTC){
    $precioPorcentaje = ($porcentajeTC * $precioTC) / 100;
    return $precioPorcentaje;
}

function obtenerMSinsumo($id_insumo,$conexion){

	$sql = "SELECT porceMS FROM insumos WHERE id = '$id_insumo'";

	$query = mysqli_query($conexion,$sql);

	$resultado = mysqli_fetch_array($query);

	$msInsumo = $resultado['porceMS'];

	return $msInsumo;

}

$id = $_GET['id'];

$precioPor = $_GET['precioPor'];

$precioKgMSDieta = $_GET['precioKgMS'];

$totalMS = $_GET['totalMS'];



$sql = "SELECT * FROM formulas WHERE id = '$id'";
$query = mysqli_query($conexion,$sql);
$fila = mysqli_fetch_array($query);

$precioInsumoTotal = 0;

    $pdf = new FPDF('P','mm','A4'); 
    $pdf->AddPage();

    $pdf->SetFillColor(222,222,222);
    $pdf->SetTitle(utf8_decode('Formulas'));
    $pdf->SetDisplayMode('fullpage', 'single');
    $pdf->SetAutoPageBreak(1,1);
    $pdf->SetFont('Helvetica','B',11);
    $pdf->SetX(10);
    $pdf->Image('../img/logo1.png',10,10,30);
    $pdf->Cell(130,7,utf8_decode(''),0,0,'L',0);
    $pdf->Cell(60,7,utf8_decode('Jorge Cornale'),0,1,'R',0);
    $pdf->Ln(6);
    $pdf->SetFont('Helvetica','B',18);
    $pdf->Cell(190,10,'Feedlot: '.$feedlot,0,1,'L',0);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetX(10);
    $pdf->Cell(190,10,'Formula: '.$fila['tipo'].' - '.$fila['nombre'],0,1,'L',0);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetX(10);
    $pdf->Cell(40,8,'Fecha Realizada: '.formatearFecha($fila['fecha']),0,1,'L',0);
    $pdf->SetX(10);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(40,6,utf8_decode('Composición').' de la dieta:',0,1,'L',0);
    $pdf->SetX(11);
    $pdf->Cell(50,0.01,'',1,1,'L',0);
    $pdf->SetX(10);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(40,9,'Producto',0,0,'L',0);
    $pdf->Cell(25,9,'% en la Dieta',0,0,'C',0);
    $pdf->Cell(25,9,'% MS',0,0,'C',0);
    $pdf->Cell(25,9,'Precio Insumo',0,0,'C',0);
    $pdf->Cell(25,9,'$/Kg MS',0,0,'C',0);
    $pdf->Cell(25,9,'% MS Insumo',0,0,'C',0);
    $pdf->Cell(30,9,'% MS en la Dieta',0,1,'C',0);
    $pdf->SetX(10);
    $pdf->Cell(195,.01,'',1,1,'C',0);
    $pdf->SetX(10);
    $pdf->SetFont('Helvetica','',10);
    $pdf->SetFillColor(247,247,247);

    $pdf->Cell(40,9,nombreInsumo('p1',$fila['p1'],$conexion),0,0,'L',1);

    $pdf->SetFillColor(236,236,236);

    $pdf->Cell(25,9,number_format($fila['por1'],2,',','.').' %',0,0,'C',1);

    $pdf->SetFillColor(247,247,247);

    $porcentajeMS = porceMS($fila['p1'],$fila['por1'],$conexion);

    $pdf->Cell(25,9,formatearNum($porcentajeMS)." %",0,0,'C',1);

    $pdf->SetFillColor(236,236,236);

    $precioInsumo = precioInsumo('p1',$fila['p1'],$conexion);

    $precioInsumoTotal += $precioInsumo * ($fila['por1'] / 100);

    $pdf->Cell(25,9,'$ '.formatearNum($precioInsumo),0,0,'C',1);

    $pdf->SetFillColor(247,247,247);

    $porMS = obtenerMSinsumo($fila['p1'],$conexion);
                            
    $precioKgMS = (100 * $precioInsumo) / $porMS;

    $pdf->Cell(25,9,"$ ".number_format($precioKgMS,2,',','.'),0,0,'C',1);

    $pdf->SetFillColor(236,236,236);

    $porceMSInsumo = tomaPorcentajeMS('p1',$fila['p1'],$conexion);

    $pdf->Cell(25,9,$porceMSInsumo." %",0,0,'C',1);

    $pdf->SetFillColor(247,247,247);

    $porcentajeMSDieta = ($porcentajeMS * 100) / $totalMS;         

    $pdf->Cell(30,9,formatearNum($porcentajeMSDieta).' %',0,1,'C',1);

    $pdf->SetFillColor(222,222,222);
    $pdf->Cell(195,.2,'',0,1 ,'',1);

    for ($i=1; $i < 11 ; $i++) { 
      $producto = "p".($i+1);
      $porcentaje = "por".($i+1);

      if($fila[$producto] != ''){ 

        $precioInsumo = precioInsumo($producto,$fila[$producto],$conexion);

        $precioInsumoTotal += $precioInsumo * ($fila[$porcentaje] / 100);

        $porcentajeMS = porceMS($fila[$producto],$fila[$porcentaje],$conexion);

        $porcentajeInsumo = porceMS($fila[$producto],$fila[$porcentaje],$conexion);
       
        $pdf->SetFillColor(247,247,247);

        $pdf->Cell(40,9,nombreInsumo($producto,$fila[$producto],$conexion),0,0,'L',1);

        $pdf->SetFillColor(236,236,236);

        $pdf->Cell(25,9,number_format($fila[$porcentaje],2,",",".")." %",0,0,'C',1);

        $pdf->SetFillColor(247,247,247);

        $pdf->Cell(25,9,formatearNum($porcentajeMS)." %",0,0,'C',1);

        $pdf->SetFillColor(236,236,236);

        $pdf->Cell(25,9,"$ ".number_format($precioInsumo,2,",","."),0,0,'C',1);

        $pdf->SetFillColor(247,247,247);

        $porMS = obtenerMSinsumo($fila[$producto],$conexion);
                            
        $precioKgMS = (100 * $precioInsumo) / $porMS;
    
        $pdf->Cell(25,9,"$ ".number_format($precioKgMS,2,',','.'),0,0,'C',1);

        $pdf->SetFillColor(236,236,236);

        $porceMSInsumo = tomaPorcentajeMS($producto,$fila[$producto],$conexion);

        $pdf->Cell(25,9,$porceMSInsumo." %",0,0,'C',1);

        $pdf->SetFillColor(247,247,247);
        
        $porcentajeMSDieta = ($porcentajeMS * 100) / $totalMS;         

        $pdf->Cell(30,9,formatearNum($porcentajeMSDieta).' %',0,1,'C',1);

        $pdf->SetFillColor(222,222,222);

        $pdf->Cell(195,.2,'',0,1 ,'',1);

        
        }
    }
    $pdf->SetFillColor(247,247,247);
    $pdf->SetFont('Helvetica','',8);
    $pdf->Cell(40,8,'*Valores en base a 1 Kilo de Formula.',0,1,'L',0);
    $pdf->SetFont('Helvetica','b',12);
    $pdf->SetFillColor(247,247,247);
    $pdf->Cell(43,10,'Precio por Kilo:',0,0,'L',1);
    $pdf->SetFillColor(236,236,236);
    $pdf->Cell(150,10,'   $ '.formatearNum($precioInsumoTotal),0,1,'L',1); 
    $pdf->Cell(43,10,'Precio por Kilo MS: ',0,0,'L',1);
    $pdf->SetFillColor(247,247,247);
    $pdf->Cell(150,10,'   $ '.number_format($precioKgMSDieta,2,',','.'),0,1,'L',1); 
    $pdf->Cell(43,10,'Total % de MS:',0,0,'L',1);
    $pdf->SetFillColor(236,236,236);
    $pdf->Cell(150,10,'  '.number_format($totalMS,2,',','.').' %',0,1,'L',1);
 
    $pdf->Output();
    
?>