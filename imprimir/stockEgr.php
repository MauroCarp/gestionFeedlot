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


$sql = $_GET['sql'];
$filtros = $_GET['filtros'];

    $pdf = new FPDF('P','mm','A4'); 
    $pdf->AddPage();
    $pdf->SetFillColor(222,222,222);
    $pdf->SetTitle(utf8_decode('Listado de Egresos'));
    $pdf->SetDisplayMode('fullpage', 'single');
    $pdf->SetAutoPageBreak(1,1);
    $pdf->SetFont('Times','B',11);
    $pdf->SetX(10);

    if($_SESSION['feedlot'] == 'Acopiadora Pampeana' OR $_SESSION['feedlot'] == 'Acopiadora Hoteleria'){

        $pdf->Image('../img/logoAcopiadora.jpg',10,10,30);
    
    }else{
    
        $pdf->Image('../img/logo.png',10,10,30);

    }
    $pdf->Cell(130,7,utf8_decode(''),0,0,'L',0);
    $pdf->Cell(60,7,utf8_decode('Jorge Cornale'),0,1,'R',0);
    $pdf->Ln(6);
    $pdf->SetFont('Times','B',18);
    if ($feedlot == 'Acopiadora Pampeana' OR $feedlot == 'Acopiadora Pampeana Hoteleria') {
        # code...
        $pdf->Cell(190,10,utf8_decode('Feedlot: '.$feedlot.' - Doña Juana'),0,1,'L',0);
    }else{
        $pdf->Cell(190,10,'Feedlot: '.$feedlot,0,1,'L',0);
    }
    $pdf->Cell(190,10,utf8_decode('Listado de Egresos - '.$filtros),0,1,'L',0);
    $pdf->SetFont('helvetica','B',12);
    $pdf->SetX(10);
    $pdf->Cell(35,10,'Fecha Egreso',0,0,'L',0);
    $pdf->Cell(25,10,'Cantidad',0,0,'L',0);
    $pdf->Cell(35,10,'Peso Prom.',0,0,'L',0);
    $pdf->Cell(40,10,'Destino',0,1,'L',0);
    $pdf->SetX(10);
    $pdf->Cell(195,.01,'',1,1,'L',0);
    $pdf->SetX(10);

    $pdf->SetFont('Helvetica','',10);

    $query = mysqli_query($conexion,$sql);
    
    if(mysqli_num_rows($query)>0){

        $color = 0;
        $totalCantidad = 0;
        $totalPNeto = 0;
        
        while($fila = mysqli_fetch_array($query)){
		
            $tropa = $fila['tropa'];
		
            $sql2 = "SELECT SUM(peso) AS pesoTotal FROM egresos WHERE tropa = '$tropa'";
    
            $query2 = mysqli_query($conexion,$sql2);
    
            $resultadosEgr = mysqli_fetch_array($query2);

                $pdf->Cell(35,8,formatearFecha($fila['fecha']),0,0,'L',$color);
                $pdf->Cell(25,8,$fila['cantidad'],0,0,'C',$color);
                $pdf->Cell(35,8,$fila['pesoPromedio']." Kg",0,0,'C',$color);
                $pdf->Cell(100,8,$fila['destino'],0,1,'L',$color);


                if ($color == 1) {
                    $color = 0;
                }else{
                    $color = 1;
                }

            
                $totalCantidad += $fila['cantidad'];
				
				if ($feedlot == 'Acopiadora Pampeana') {
					
					$totalPNeto += ($fila['pesoPromedio'] * $fila['cantidad']);

				}else{
					
					$totalPNeto += $resultadosEgr['pesoTotal'];
					
				}
        }
        $pdf->Cell(195,.01,'',1,1,'L',0);
        $pdf->SetFont('Helvetica','B',10);
        $pdf->Cell(35,8,'Subtotales:',0,0,'R',0);
        $pdf->Cell(25,8,$totalCantidad." Animales",0,0,'C',0);
        $pdf->Cell(35,8,number_format(($totalPNeto / $totalCantidad),2,",",".")." Kg",0,0,'C',0);
        $pdf->Cell(40,8,'Peso Neto: '.number_format($totalPNeto,2,",",".")." Kg",0,0,'L',0);
    }
    $pdf->Output();
    
?>