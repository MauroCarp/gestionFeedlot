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

    
$cantidadIngreso = 0;
$pesoTotalIngreso = 0;
$pesoPromedioIngreso = 0; 
$kgMinIng = 1000000;
$kgMinEgr = 1000000;
$kgMaxIng = 0;
$kgMaxEgr = 0;
    
$sql = "SELECT cantidad, pesoPromedio FROM registroingresos WHERE feedlot = '$feedlot' AND tropa != 'Stock Inicial' ORDER BY id ASC";
$query = mysqli_query($conexion,$sql);
while($resultado = mysqli_fetch_array($query)){

$cantidadIngreso += $resultado['cantidad'];
$pesoTotalIngreso += $resultado['cantidad'] * $resultado['pesoPromedio'];


$kgMinIng = ($kgMinIng > $resultado['pesoPromedio']) ? $resultado['pesoPromedio'] : $kgMinIng;
$kgMaxIng = ($kgMaxIng < $resultado['pesoPromedio']) ? $resultado['pesoPromedio'] : $kgMaxIng;

}

$pesoPromedioIngreso = ($pesoTotalIngreso / $cantidadIngreso);


$cantidadEgreso = 0;
$pesoTotalEgreso = 0;
$pesoPromedioEgreso = 0; 
    
$sql = "SELECT cantidad, pesoPromedio FROM registroegresos WHERE feedlot = '$feedlot' ORDER BY id ASC";
$query = mysqli_query($conexion,$sql);

while($resultado = mysqli_fetch_array($query)){

$cantidadEgreso += $resultado['cantidad'];
$pesoTotalEgreso += $resultado['cantidad'] * $resultado['pesoPromedio'];

$kgMinEgr = ($kgMinEgr > $resultado['pesoPromedio']) ? $resultado['pesoPromedio'] : $kgMinEgr;
$kgMaxEgr = ($kgMaxEgr < $resultado['pesoPromedio']) ? $resultado['pesoPromedio'] : $kgMaxEgr;

}

$pesoPromedioEgreso = ($pesoTotalEgreso / $cantidadEgreso);

$diferenciaIngEgr = ($pesoPromedioEgreso - $pesoPromedioIngreso);

$cantidadMuertes = 0; 
   


    $pdf = new FPDF('P','mm','A4'); 
    $pdf->AddPage();
    $pdf->SetFillColor(222,222,222);
    $pdf->SetTitle(utf8_decode('Listado de Muertes'));
    $pdf->SetDisplayMode('fullpage', 'single');
    $pdf->SetAutoPageBreak(1,1);
    $pdf->SetFont('Times','B',11);
    $pdf->SetX(10);
    
    $pdf->Image('../img/logo1.png',10,10,30);

    $pdf->Cell(130,7,utf8_decode(''),0,0,'L',0);
    $pdf->Cell(60,7,utf8_decode('Jorge Cornale'),0,1,'R',0);
    $pdf->Ln(6);
    $pdf->SetFont('Times','B',18);
    if($_SESSION['feedlot'] == 'Acopiadora Pampeana' OR $_SESSION['feedlot'] == 'Acopiadora Hoteleria'){
        # code...
        $pdf->Cell(190,10,utf8_decode('Feedlot: '.$feedlot.' - Doña Juana'),0,1,'L',0);
    }else{
        $pdf->Cell(190,10,'Feedlot: '.$feedlot,0,1,'L',0);
    }
    $pdf->Cell(190,10,utf8_decode('Stock General  Ingresos / Egresos'),0,1,'L',0);
    
    
    
    
    $pdf->Cell(195,.01,'',1,1,'L',0);

    $pdf->SetFont('helvetica','B',18);
    $pdf->SetX(10);
    $pdf->Cell(40,10,'Ingresos',0,1,'L',0);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(50,10,'Total Ingresos: ',0,0,'L',0);
    $pdf->Cell(25,10,number_format($cantidadIngreso,0,",",".")." Animales",0,1,'L',0);
    $pdf->Cell(50,10,'Kg Neto Ingreso:',0,0,'L',0);
    $pdf->Cell(25,10,number_format($pesoTotalIngreso,0,",",".")." Kg",0,1,'L',0);
    $pdf->Cell(50,10,'Kg Ingreso Promedio:',0,0,'L',0);
    $pdf->Cell(25,10,number_format($pesoPromedioIngreso,0,",",".")." Kg",0,1,'L',0);
    $pdf->Cell(50,10,'Peso Min:',0,0,'L',0);
    $pdf->Cell(25,10,number_format($kgMinIng,0,",",".")." Kg",0,1,'L',0);
    $pdf->Cell(50,10,'Peso Max:',0,0,'L',0);
    $pdf->Cell(25,10,number_format($kgMaxIng,0,",",".")." Kg",0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Cell(195,.01,'',1,1,'L',0);
    $pdf->SetX(10);

    $pdf->SetFont('helvetica','B',18);
    $pdf->SetX(10);
    $pdf->Cell(40,10,'Egresos',0,1,'L',0);
    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(50,10,'Total Egresos: ',0,0,'L',0);
    $pdf->Cell(25,10,number_format($cantidadEgreso,0,",",".")." Animales",0,1,'L',0);
    $pdf->Cell(50,10,'Kg Neto Egreso:',0,0,'L',0);
    $pdf->Cell(25,10,number_format($pesoTotalEgreso,0,",",".")." Kg",0,1,'L',0);
    $pdf->Cell(50,10,'Kg Egreso Promedio:',0,0,'L',0);
    $pdf->Cell(25,10,number_format($pesoPromedioEgreso,0,",",".")." Kg",0,1,'L',0);
    $pdf->Cell(50,10,'Peso Min:',0,0,'L',0);
    $pdf->Cell(25,10,number_format($kgMinEgr,0,",",".")." Kg",0,1,'L',0);
    $pdf->Cell(50,10,'Peso Max:',0,0,'L',0);
    $pdf->Cell(25,10,number_format($kgMaxEgr,0,",",".")." Kg",0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Ln(6);

    $pdf->Cell(195,.01,'',1,1,'L',0);
    $pdf->SetX(10);


    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(50,10,'Diferencia Kg Ing/Egr: ',0,0,'L',0);
    $pdf->Cell(25,10,number_format($diferenciaIngEgr,0,",",".")." Kg",0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Cell(195,.01,'',1,1,'L',0);
    $pdf->SetX(10);
    $pdf->Ln(6);

    $pdf->Output();
    
?>