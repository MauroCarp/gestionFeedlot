<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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

$id = $_GET['id'];
$totalMS = $_GET['totalMS'];

$sqlInsumos = "SELECT tipo,nombre,mixer.fecha as fecha, kilos, margen, redondeo,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,por1,por2,por3,por4,por5,por6,por7,por8,por9,por10,por11 FROM mixer LEFT JOIN formulas ON mixer.formula = formulas.id WHERE mixer.id = '$id'";

$queryInsumos = mysqli_query($conexion,$sqlInsumos);

echo mysqli_error($conexion);

$filaInsumos = mysqli_fetch_array($queryInsumos);

$totalPorcentaje = 0;
$totalMS = 0;
$totalKilos = 0;
$totalFinal = 0;
$totalDiferencia = 0;
$totalPorcentajeMS = 0;
$totalKilosMS = 0;
$redondeosMixer = $filaInsumos['redondeo'];
$redondeosMixer = explode(",", $redondeosMixer);

    $pdf = new FPDF('L','mm','A4'); 
    $pdf->AddPage();
    $pdf->SetFillColor(222,222,222);
    $pdf->SetTitle(utf8_decode('Mixer'));
    $pdf->SetDisplayMode('fullpage', 'single');
    $pdf->SetAutoPageBreak(1,1);
    $pdf->SetFont('Helvetica','B',11);
    $pdf->SetX(10);
    $pdf->Image('../img/logo.png',10,10,30);
    $pdf->Cell(130,7,utf8_decode(''),0,0,'L',0);
    $pdf->Cell(60,7,utf8_decode('Jorge Cornale'),0,1,'R',0);
    $pdf->Ln(6);
  
    $pdf->SetFont('Helvetica','B',18);
    $pdf->Cell(190,10,'Feedlot: '.$feedlot,0,1,'L',0);
    $pdf->Cell(190,10,utf8_decode('Formula '.$filaInsumos['tipo'].' - '.$filaInsumos['nombre']),0,1,'L',0);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetX(10);
    $pdf->Cell(40,8,'Fecha de Carga: '.formatearFecha($filaInsumos['fecha']),0,1,'L',0);
    $pdf->SetX(10);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(40,6,utf8_decode('Composición').' de la dieta en base a : '.$filaInsumos['kilos'].' Kg - Margen de Error: '.$filaInsumos['margen'].'%',0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Ln(1);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(30,9,'Producto',0,0,'L',1);
    $pdf->Cell(25,9,'% en Dieta',0,0,'C',1);
    $pdf->Cell(20,9,'% MS',0,0,'C',1);

    if ($filaInsumos['redondeo'] != '') {
        
        $pdf->Cell(20,9,'Kilos',0,0,'C',1);
        $pdf->Cell(20,9,'Kg Real',0,0,'C',1);
        $pdf->Cell(25,9,'Dieta Final',0,0,'C',1);
        $pdf->Cell(20,9,'Dif. Kg',0,0,'C',1);
        $pdf->Cell(15,9,'Dif %',0,0,'C',1);
        $pdf->Cell(30,9,'% MS Insumo',0,0,'C',1);
        $pdf->Cell(20,9,'Kg MS',0,0,'C',1);
        $pdf->Cell(35,9,'% MS en la Dieta',0,1,'C',1);
        
    }else{

        $pdf->Cell(20,9,'Kilos',0,1,'C',1);
    
    }
    
    $pdf->SetX(10);

    $pdf->SetFont('helvetica','',10);
    $pdf->SetFillColor(236,236,236);
    $pdf->Cell(30,9,nombreInsumo('p1',$filaInsumos['p1'],$conexion),0,0,'L',1);
    $pdf->SetFillColor(245,245,245);
    $pdf->Cell(25,9,$filaInsumos['por1'].' %',0,0,'C',1);
    $pdf->SetFillColor(236,236,236);
    
    $porcentajeMS = number_format(porceMS($filaInsumos['p1'],$filaInsumos['por1'],$conexion),2);

    $pdf->Cell(20,9,$porcentajeMS.' %',0,0,'C',1);
    $pdf->SetFillColor(245,245,245);

    $totalPorcentaje += $filaInsumos['por1'];
    $totalMS += number_format(porceMS($filaInsumos['p1'],$filaInsumos['por1'],$conexion),2);
    $totalKilos += round(($filaInsumos['por1']*$filaInsumos['kilos'])/100,2);


    if ($filaInsumos['redondeo'] != '') {

        $pdf->Cell(20,9,round(($filaInsumos['por1']*$filaInsumos['kilos'])/100,2).' Kg',0,0,'C',1);
        $pdf->SetFillColor(236,236,236);
        $pdf->Cell(20,9,$redondeosMixer[0].' Kg',0,0,'C',1);
        $pdf->SetFillColor(245,245,245);
        $pdf->Cell(25,9,$redondeosMixer[0].' Kg',0,0,'C',1);
        $pdf->SetFillColor(236,236,236);
        $pdf->Cell(20,9,$redondeosMixer[0] - (round(($filaInsumos['por1']*$filaInsumos['kilos'])/100,2))." Kg",0,0,'C',1);
        $pdf->SetFillColor(245,245,245);
        $pdf->Cell(15,9,round((($redondeosMixer[0] * 100) / (($filaInsumos['por1']*$filaInsumos['kilos'])/100)-100),2).' %',0,0,'C',1);
        $pdf->SetFillColor(236,236,236);
        
        $porcentajeMSInsumo = tomaPorcentajeMS('p1',$filaInsumos['p1'],$conexion); 
        
        $pdf->Cell(30,9,$porcentajeMSInsumo.' %',0,0,'C',1);                
        $pdf->SetFillColor(245,245,245);
        
        $kilosMS = round(((tomaPorcentajeMS('p1',$filaInsumos['p1'],$conexion) * $redondeosMixer[0]) / 100),2);
        
        $pdf->Cell(20,9,$kilosMS.' Kg',0,0,'C',1);                     
        $pdf->SetFillColor(236,236,236);
        
        $porcentajeMSDieta = number_format($porcentajeMS * ($porcentajeMSInsumo / 100),2);
        
        $pdf->Cell(35,9,$porcentajeMSDieta.' %',0,1,'C',1);                          
        
        $totalFinal += $redondeosMixer[0];
        $totalDiferencia += $redondeosMixer[0   ] - (round(($filaInsumos['por1'] * $filaInsumos['kilos'])/100,2));
        $totalKilosMS += $kilosMS;
        $totalPorcentajeMS += $porcentajeMSDieta;

    }else{
        
        $pdf->Cell(20,9,round(($filaInsumos['por1']*$filaInsumos['kilos'])/100,2).' Kg',0,1,'C',1);
        $pdf->SetFillColor(236,236,236);

    }

    for ($i=1; $i < 11 ; $i++) { 
        $producto = "p".($i+1);
        $porcentaje = "por".($i+1);
        $redondeo = "redondeo".($i+1);
        if($filaInsumos[$producto] != ''){ 

            $pdf->SetFillColor(236,236,236);
            $pdf->Cell(30,9,nombreInsumo($producto,$filaInsumos[$producto],$conexion),0,0,'L',1);
            $pdf->SetFillColor(245,245,245);
            $pdf->Cell(25,9,$filaInsumos[$porcentaje]." %",0,0,'C',1);
            $pdf->SetFillColor(236,236,236);

            $porcentajeMS =number_format(porceMS($filaInsumos[$producto],$filaInsumos[$porcentaje],$conexion),2);

            $pdf->Cell(20,9,$porcentajeMS.' %',0,0,'C',1);
            $pdf->SetFillColor(245,245,245);

            $totalPorcentaje += $filaInsumos[$porcentaje];
            $totalMS += number_format(porceMS($filaInsumos[$producto],$filaInsumos[$porcentaje],$conexion),2);
            $totalKilos += round(($filaInsumos[$porcentaje]*$filaInsumos['kilos'])/100,2);

            if ($filaInsumos['redondeo'] != '') {

                $pdf->Cell(20,9,round(($filaInsumos[$porcentaje]*$filaInsumos['kilos'])/100,2).' Kg',0,0,'C',1);
                $pdf->SetFillColor(236,236,236);
                $pdf->Cell(20,9,$redondeosMixer[$i].' Kg',0,0,'C',1);
                $pdf->SetFillColor(245,245,245);
                $pdf->Cell(25,9,$redondeosMixer[$i].' Kg',0,0,'C',1);
                $pdf->SetFillColor(236,236,236);
                $pdf->Cell(20,9,$redondeosMixer[$i] - (round(($filaInsumos[$porcentaje] * $filaInsumos['kilos'])/100,2))." Kg",0,0,'C',1);
                $pdf->SetFillColor(245,245,245);
                $pdf->Cell(15,9,round((($redondeosMixer[$i] * 100) / (($filaInsumos[$porcentaje] * $filaInsumos['kilos'])/100)-100),2).' %',0,0,'C',1);
                $pdf->SetFillColor(236,236,236);
                
                $porcentajeMSInsumo = tomaPorcentajeMS($producto,$filaInsumos[$producto],$conexion); 
                
                $pdf->Cell(30,9,$porcentajeMSInsumo.' %',0,0,'C',1);                
                
                $kilosMS = round(((tomaPorcentajeMS($producto,$filaInsumos[$producto],$conexion) * $redondeosMixer[$i]) / 100),2);
                $pdf->SetFillColor(245,245,245);
                $pdf->Cell(20,9,$kilosMS.' Kg',0,0,'C',1);         
                $pdf->SetFillColor(236,236,236);
                
                $porcentajeMSDieta = number_format($porcentajeMS * ($porcentajeMSInsumo / 100),2);
                
                $pdf->Cell(35,9,$porcentajeMSDieta.' %',0,1,'C',1);      
                
                $totalFinal += $redondeosMixer[$i];
                $totalDiferencia += $redondeosMixer[$i] - (round(($filaInsumos[$porcentaje] * $filaInsumos['kilos'])/100,2));
                $totalKilosMS += $kilosMS;
                $totalPorcentajeMS += $porcentajeMSDieta;                    
            
            }else{

                $pdf->Cell(20,9,round(($filaInsumos[$porcentaje]*$filaInsumos['kilos'])/100,2).' Kg',0,1,'C',1);
                $pdf->SetFillColor(236,236,236);
            }
        }
    }

    $pdf->SetFont('helvetica','B',10);
    $pdf->SetFillColor(0,0,0);
    $pdf->Cell(260,0.01,'',0,1,'C',1);
    $pdf->SetFillColor(247,247,247);
    $pdf->Cell(30,9,'Totales',0,0,'L',1);
    $pdf->Cell(25,9,$totalPorcentaje.' %',0,0,'C',1);
    $pdf->Cell(20,9,$totalMS.' %',0,0,'C',1);
    $pdf->Cell(20,9,$totalKilos.' Kg',0,0,'C',1);
    
    if ($filaInsumos['redondeo'] != '') {
        
        $pdf->Cell(20,9,$totalFinal.' Kg',0,0,'C',1);
        $pdf->Cell(25,9,'',0,0,'L',1);
        $pdf->Cell(20,9,$totalDiferencia.' Kg',0,0,'C',1);
        $pdf->Cell(15,9,'',0,0,'L',1);
        $pdf->Cell(30,9,'',0,0,'C',1);
        $pdf->Cell(20,9,$totalKilosMS.' Kg',0,0,'C',1);
        $pdf->Cell(35,9,$totalPorcentajeMS.' %',0,1,'C',1);
    
    }

    $pdf->Output();
    
?>
    
 