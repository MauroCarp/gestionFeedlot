<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("lib/fpdf/fpdf.php");

function formatearFecha($fecha){
	if ($fecha == NULL) {
		$fechaFormateada = '';
	}else{	
  		$fechaFormateada = date("d-m-Y",strtotime($fecha));
	}
  return $fechaFormateada;
}

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

	$pdf = new FPDF('P','mm','A4');	
	$pdf->AddPage();
	$pdf->SetFillColor(222,222,222);
	$pdf->SetTitle(utf8_decode('Status Sanitario'));
	$pdf->SetDisplayMode('fullpage', 'single');
	$pdf->SetAutoPageBreak(1,1);
	$pdf->SetFont('Times','B',11);
	$pdf->SetX(10);
	$pdf->Cell(130,7,utf8_decode('Gestión de Feedlots'),0,0,'L',0);
	$pdf->Cell(60,7,utf8_decode('Jorge Cornale'),0,1,'R',0);
	$pdf->Ln(1);
	$pdf->SetFont('Times','B',18);
	$pdf->Cell(190,10,'Feedlot: '.$feedlot,0,1,'L',0);
	$pdf->Cell(190,10,utf8_decode('Status Sanitario - Periodo: '.formatearFecha($desde)." / ".formatearFecha($hasta)),0,1,'L',0);
	$pdf->SetFont('helvetica','B',12);
	$pdf->SetX(10);
	$pdf->Cell(40,10,'Tropa',0,0,'L',0);
	$pdf->Cell(27,10,'Fecha Ing.',0,0,'L',0);
	$pdf->Cell(22,10,'Cantidad',0,0,'L',0);
	$pdf->Cell(25,10,'Operario',0,0,'L',0);
	$pdf->Cell(27,10,'Metafilaxis',0,0,'L',0);
	$pdf->Cell(30,10,'1er Dosis',0,0,'L',0);
	$pdf->Cell(20,10,'Refuerzo',0,1,'L',0);
	$pdf->SetX(10);
	$pdf->Cell(190,.01,'',1,1,'L',0);
	$pdf->SetX(10);

	$pdf->SetFont('Helvetica','',11);


     $sql = "SELECT * FROM status WHERE feedlot = '$feedlot' ORDER BY fechaIngreso ASC, tropa DESC"; 
     $query = mysqli_query($conexion,$sql);
     echo mysqli_error($conexion);
      $tropa = "";
      $color = 0;
      while ($resultado = mysqli_fetch_array($query)) {
	    if ($tropa != $resultado['tropa']) {
        	$tropaTemp = $resultado['tropa'];
        	$tropaLong = strlen($resultado['tropa']);

        	if ($tropaLong > 21) {
        		$pdf->Ln(1);
		    	$pdf->MultiCell(40,5,$resultado['tropa'],0,'L',$color);
			    $posicionYactual = $pdf->GetY();
			    $posicionCelda = $posicionYactual - 11;
			    $pdf->SetY($posicionCelda);
			    $pdf->Ln(1);
			    $pdf->SetX(50);
        	}else{
        		$pdf->Ln(1);
        		$pdf->Cell(40,10,$resultado['tropa'],0,0,'L',$color);	
        	}
			$pdf->Cell(27,10,formatearFecha($resultado['fechaIngreso']),0,0,'L',$color);
			$pdf->Cell(23,10,$resultado['animales'],0,0,'C',$color);
			$pdf->Cell(25,10,$resultado['operario'],0,0,'L',$color);
			$pdf->SetFont('Arial','B',11);
			if($resultado['metafilaxis']){ 
				$pdf->SetTextColor(0,255,0);
				$pdf->Cell(27,10,'V',0,0,'C',$color);
            }else{ 
            	$pdf->SetTextColor(255,0,0);
				$pdf->Cell(27,10,'X',0,0,'C',$color);
			}

			if($resultado['vacuna']){ 
				$pdf->SetTextColor(0,255,0);
				$pdf->Cell(30,10,'V',0,0,'C',$color);
            }else{ 
            	$pdf->SetTextColor(255,0,0);
				$pdf->Cell(30,10,'X',0,0,'C',$color);
			}

			if($resultado['refuerzo']){ 
				$pdf->SetTextColor(0,255,0);
				$pdf->Cell(20,10,'V',0,1,'C',$color);
            }else{ 
            	$pdf->SetTextColor(255,0,0);
				$pdf->Cell(20,10,'X',0,1,'C',$color);
			}
			$pdf->SetFont('Helvetica','',11);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetX(10);
			
			if ($color == 1) {
				$color = 0;
			}else{
				$color = 1;
			}
		}

		$tropa = $resultado['tropa'];
		
      }
	$pdf->SetFont('Times','',10);
	


	$pdf->Output();
	
?>