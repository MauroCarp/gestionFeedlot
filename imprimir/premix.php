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

function dataInsumoPremix($id,$campo,$conexion){

	$sql = "SELECT $campo FROM insumospremix WHERE id = '$id'";

	$query = mysqli_query($conexion,$sql);

	$resultado = mysqli_fetch_array($query);

	return $resultado[$campo];

}	

$id = $_GET['id'];

$sql = "SELECT * FROM premix WHERE id = '$id'";
$query = mysqli_query($conexion,$sql);
$fila = mysqli_fetch_array($query);

$totalKilos = 0;

for ($i=1; $i < 11 ; $i++) { 
    
    $kg = 'kg'.$i;

    $kilos = $fila[$kg];

    $totalKilos += $kilos;

}

$totalPrecio = 0;
$totalPorcentaje = 0;

    $pdf = new FPDF('P','mm','A4'); 
    $pdf->AddPage();

    $pdf->SetFillColor(222,222,222);
    $pdf->SetTitle(utf8_decode('Premix'));
    $pdf->SetDisplayMode('fullpage', 'single');
    $pdf->SetAutoPageBreak(1,1);
    $pdf->SetFont('Helvetica','B',11);
    $pdf->SetX(10);
    $pdf->Image('../img/logoAcopiadora.jpg',10,10,30);
    $pdf->Cell(130,7,utf8_decode(''),0,0,'L',0);
    $pdf->Cell(60,7,utf8_decode('Jorge Cornale'),0,1,'R',0);
    $pdf->Ln(6);
    $pdf->SetFont('Helvetica','B',18);
    $pdf->Cell(190,10,'Feedlot: '.$feedlot,0,1,'L',0);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetX(10);
    $pdf->SetFont('Helvetica','B',14);
    $pdf->Cell(190,10,'Premix - '.$fila['nombre'], 0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Cell(40,8,'Fecha Realizada: '.formatearFecha($fila['fecha']),0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Ln(2);
    $pdf->Cell(40,6,'%MS: '.$fila['ms'].'% | $Kg  $'.number_format($fila['precio'],2),0,1,'L',0);
    $pdf->Ln(2);
    $pdf->SetX(11);
    $pdf->Cell(50,0.01,'',1,1,'L',0);
    $pdf->SetX(10);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(40,9,'Insumo',0,0,'L',0);
    $pdf->Cell(25,9,'Kilos',0,0,'C',0);
    $pdf->Cell(25,9,'$/Kg',0,0,'C',0);
    $pdf->Cell(25,9,'$/T',0,0,'C',0);
    $pdf->Cell(25,9,'%',0,0,'C',0);
    $pdf->SetX(10);
    $pdf->Cell(140,.01,'',1,1,'C',0);
    $pdf->SetX(10);
    $pdf->SetFont('Helvetica','',10);
    $pdf->SetFillColor(247,247,247);
    $pdf->Ln(7);
    $pdf->SetFillColor(247,247,247);
    $pdf->Cell(40,9, dataInsumoPremix($fila['p1'],'nombre',$conexion),0,0,'L',1);
    $pdf->SetFillColor(236,236,236);
    $pdf->Cell(25,9,$fila['kg1'].' Kg',0,0,'C',1);
    
    $precioInsumo = dataInsumoPremix($fila['p1'],'precio',$conexion);
    
    $pdf->SetFillColor(247,247,247);
    $pdf->Cell(25,9,'$ '.$precioInsumo,0,0,'C',1);
    $pdf->SetFillColor(236,236,236);
    
    $precioKilos = $precioInsumo * $fila['kg1'];

    $totalPrecio += $precioKilos;
    
    $pdf->Cell(25,9,'$ '.$precioKilos,0,0,'C',1);
    $pdf->SetFillColor(247,247,247);

    $porcentaje = ($fila['kg1'] * 100) / $totalKilos;

    $totalPorcentaje += $porcentaje;

    $pdf->Cell(25,9,number_format($porcentaje,2),0,1,'C',1);

    for ($i=2; $i < 11 ; $i++) { 

        $insumo = 'p'.$i;

        $kg = 'kg'.$i;

        if ($fila[$insumo] == '') 
            break;
        

        $pdf->SetFillColor(247,247,247);
        $pdf->Cell(40,9, dataInsumoPremix($fila[$insumo],'nombre',$conexion),0,0,'L',1);
        $pdf->SetFillColor(236,236,236);
        $pdf->Cell(25,9,$fila[$kg].' Kg',0,0,'C',1);
        
        $precioInsumo = dataInsumoPremix($fila[$insumo],'precio',$conexion);
        
        $pdf->SetFillColor(247,247,247);

        $pdf->Cell(25,9,'$ '.$precioInsumo,0,0,'C',1);

        $pdf->SetFillColor(236,236,236);

        $precioKilos = $precioInsumo * $fila[$kg];

        $totalPrecio += $precioKilos;

        $pdf->Cell(25,9,'$ '.$precioKilos,0,0,'C',1);
        $pdf->SetFillColor(247,247,247);

        $porcentaje = ($fila[$kg] * 100) / $totalKilos;

        $totalPorcentaje += $porcentaje;
        $pdf->Cell(25,9,number_format($porcentaje,2),0,1,'C',1);

    }

    $pdf->SetX(10);
    $pdf->SetFont('helvetica','B',10);
    $pdf->SetFillColor(247,247,247);
    
    $pdf->Cell(40,9,'Totales',0,0,'L',1);
    $pdf->SetFillColor(236,236,236);
    $pdf->Cell(25,9,$totalKilos.' Kg',0,0,'C',1);
    $pdf->SetFillColor(236,236,236);
    $pdf->Cell(25,9,'',0,0,'C',1);
    $pdf->SetFillColor(236,236,236);
    $pdf->Cell(25,9,'$ '.$totalPrecio,0,0,'C',1);
    $pdf->SetFillColor(236,236,236);
    $pdf->Cell(25,9,$totalPorcentaje.' %',0,0,'C',1);
  
 
    $pdf->Output();
    
?>
    