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

$tropa = $_GET['tropa'];

$tabla = $_GET['seccion'];

$sql = "SELECT * FROM $tabla WHERE tropa = '$tropa' ORDER BY hora ASC";

$query = mysqli_query($conexion,$sql);

$pdf = new FPDF('P','mm','A4');	
$pdf->AddPage();
$pdf->SetFillColor(222,222,222);
$pdf->SetTitle(utf8_decode('Detalle de Tropa'));
$pdf->SetDisplayMode('fullpage', 'single');
$pdf->SetAutoPageBreak(1,1);
$pdf->SetFont('Times','B',11);
$pdf->SetX(10);
$pdf->Image('../img/logo1BN.png',10,10,30);
$pdf->Cell(130,7,utf8_decode(''),0,0,'L',0);
$pdf->Cell(60,7,utf8_decode('Jorge Cornale'),0,1,'R',0);
$pdf->Ln(5);
$pdf->SetFont('Times','B',18);
$pdf->Cell(190,10,'Feedlot: '.$feedlot,0,1,'L',0);
$pdf->Cell(190,10,utf8_decode('Detalle de Tropa - Tropa: '.$tropa),0,1,'L',0);
$pdf->SetFont('helvetica','B',12);
$pdf->SetX(10);

if($tabla == 'ingresos'){
  $pdf->Cell(40,10,'IDE',0,0,'L',0);
  $pdf->Cell(27,10,'Num. DTE.',0,0,'L',0);
  $pdf->Cell(22,10,'Peso',0,0,'L',0);
  $pdf->Cell(25,10,'Raza',0,0,'L',0);
  $pdf->Cell(27,10,'Sexo',0,0,'L',0);
  $pdf->Cell(30,10,'Estado',0,0,'L',0);
  $pdf->Cell(20,10,'Hora',0,1,'L',0);
} 

if($tabla == 'egresos'){
  $pdf->Cell(35,10,'IDE',0,0,'L',0);
  $pdf->Cell(22,10,'Peso',0,0,'C',0);
  $pdf->Cell(25,10,'Raza',0,0,'C',0);
  $pdf->Cell(20,10,'Sexo',0,0,'C',0);
  $pdf->Cell(25,10,'GMD Total',0,0,'C',0);
  $pdf->Cell(25,10,'GPV Total',0,0,'C',0);
  $pdf->Cell(25,10,'Destino',0,0,'C',0);
  $pdf->Cell(20,10,'Hora',0,1,'C',0);
} 

$pdf->SetX(10);
$pdf->Cell(197,0.3,'',1,1,'L',1);
$pdf->Ln(0.5);
$pdf->SetX(10);
$pdf->SetFont('helvetica','',10);

$pdf->SetFillColor(222,222,222);
$fill = true;

while($resultado = mysqli_fetch_array($query)){

    $color = ($fill) ? 1 : 0;

    $pdf->SetX(10);
    
    if($tabla == 'ingresos'){
    $pdf->Cell(40,7,$resultado['IDE'],0,0,'L',$color);
    $pdf->Cell(27,7,$resultado['numDTE'],0,0,'L',$color);
    $pdf->Cell(22,7,$resultado['peso'],0,0,'L',$color);
    $pdf->Cell(25,7,$resultado['raza'],0,0,'L',$color);
    $pdf->Cell(27,7,$resultado['sexo'],0,0,'L',$color);
    $pdf->Cell(30,7,$resultado['estadoAnimal'],0,0,'L',$color);
    $pdf->Cell(20,7,$resultado['hora'],0,1,'L',$color);
    }

    if($tabla == 'egresos'){
    $pdf->Cell(35,7,$resultado['IDE'],0,0,'L',$color);
    $pdf->Cell(22,7,$resultado['peso'],0,0,'C',$color);
    $pdf->Cell(25,7,$resultado['raza'],0,0,'C',$color);
    $pdf->Cell(20,7,$resultado['sexo'],0,0,'C',$color);
    $pdf->Cell(25,7,$resultado['gdmTotal'],0,0,'C',$color);
    $pdf->Cell(25,7,$resultado['gpvTotal'],0,0,'C',$color);
    $pdf->Cell(25,7,$resultado['destino'],0,0,'C',$color);
    $pdf->Cell(20,7,$resultado['hora'],0,1,'C',$color);
    }



    $fill = !$fill;

}

$pdf->SetFont('Helvetica','',11);
$pdf->Output();

?>