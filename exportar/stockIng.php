<?php
include('../includes/init_session.php');
include('../includes/conexion.php');
require "../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
 
function formatearFecha($fecha){
    if ($fecha == NULL) {
        $fechaFormateada = '';
    }else{  
        $fechaFormateada = date("d-m-Y",strtotime($fecha));
    }
  return $fechaFormateada;
}

$sqlQuery = $_GET['sql'];
$filtros = $_GET['filtros'];
$query = mysqli_query($conexion, $sqlQuery);

$styleHeader = [
    'font'  => [
        'bold'  => true,
        'color' => array('rgb' => '797979'),
        'size'  => 12,
        'name'  => 'Verdana'
    ],
    'fill' => [
        'fillType' => Fill::FILL_GRADIENT_LINEAR,
        'startColor' => [
            'argb' => 'F1F1F1',
        ],
        'endColor' => [
            'argb' => 'E8E8E8',
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_MEDIUM,
        ],
    ],
];
$styleBody = [
    'font'  => [
        'bold'  => true,
        'color' => array('rgb' => '373737'),
        'size'  => 10.5,
        'name'  => 'Verdana'
    ],
    'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'ededed']
    ),
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];
$styleFooter = [
    'font'  => [
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 12,
        'name'  => 'Verdana'
    ],
    'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'E9E9E9']
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];
$alineacion = [
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ]
];
$cabezera = [
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ]
];

$documento = new Spreadsheet();
$documento
    ->getProperties()
    ->setCreator("Gestion de Feedlots")
    ->setLastModifiedBy('Mauro Gonzalez') // última vez modificado por
    ->setTitle('Lista Stock de Ingresos')
    ->setSubject('Ingresos')
    ->setDescription('Lista de Ingresos')
    ->setKeywords('Stock Lista Ingresos')
    ->setCategory('Ingresos');

    
$hoja = $documento->getActiveSheet();

$hoja->setTitle("Ingresos");
// Generate an image
if($_SESSION['feedlot'] == 'Acopiadora Pampeana' OR $_SESSION['feedlot'] == 'Acopiadora Hoteleria'){

    $gdImage = imagecreatefromjpeg('../img/logoAcopiadora.jpg');

}else{

    $gdImage = imagecreatefromjpeg('../img/logo.jpg');

}

// Add a drawing to the worksheet
$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing();
$drawing->setName('Sample image');
$drawing->setDescription('Sample image');
$drawing->setImageResource($gdImage);
$drawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG);
$drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
$drawing->setHeight(99);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($hoja);

$hoja->getStyle('A1:C1')->applyFromArray($styleHeader);
$hoja->getStyle('B1')->applyFromArray($cabezera);
$hoja->setCellValue('A2', 'Tropa');
$hoja->setCellValue('B2', 'Fecha');
$hoja->setCellValue('C2', 'Cantidad');
$hoja->setCellValue('D2', 'Peso Prom.');
$hoja->setCellValue('E2', 'Renspa');
$hoja->setCellValue('F2', 'ADPV');
$hoja->setCellValue('G2', 'Estado');
$hoja->setCellValue('H2', 'Proveedor');

$hoja->getStyle('A2:H2')->applyFromArray($styleHeader);
$hoja->mergeCells('B1:H1');


if($_SESSION['feedlot'] == 'Acopiadora Pampeana' OR $_SESSION['feedlot'] == 'Acopiadora Hoteleria'){

    $hoja->setCellValue('B1', $feedlot.' - Doña Juana - Listado de Ingresos - '.$filtros);

}else{

    $hoja->setCellValue('B1', $feedlot.'- Listado de Ingresos - '.$filtros);

}



$hoja->getRowDimension('1')->setRowHeight(75);
$hoja->getColumnDimension('A')->setWidth(30);
$hoja->getColumnDimension('B')->setWidth(18);
$hoja->getColumnDimension('C')->setWidth(17);
$hoja->getColumnDimension('D')->setWidth(20);
$hoja->getColumnDimension('E')->setWidth(20);
$hoja->getColumnDimension('F')->setWidth(12);
$hoja->getColumnDimension('G')->setWidth(15);
$hoja->getColumnDimension('H')->setWidth(30);


$i = 3;

if(mysqli_num_rows($query)>0){

    $totalCantidad = 0;
    $totalPNeto = 0;
    while($fila = mysqli_fetch_array($query)){

            $tropa = $fila['tropa'];
                
            $sql2 = "SELECT SUM(peso) AS pesoTotal FROM ingresos WHERE tropa = '$tropa'";

            $query2 = mysqli_query($conexion,$sql2);
                
            $resultadosIng = mysqli_fetch_array($query2);

            $hoja->setCellValue('A'.$i, $fila['tropa']);
            $hoja->setCellValue('B'.$i, formatearFecha($fila['fecha']));
            $hoja->setCellValue('C'.$i, $fila['cantidad']);
            $hoja->setCellValue('D'.$i, $fila['pesoPromedio']);
            $hoja->setCellValue('E'.$i, $fila['renspa']);
            $hoja->setCellValue('F'.$i, $fila['adpv']);
            $hoja->setCellValue('G'.$i, $fila['estado']);
            $hoja->setCellValue('H'.$i, $fila['proveedor']);

            $hoja->getStyle('A'.$i.':H'.$i)->applyFromArray($styleBody);


            $totalCantidad += $fila['cantidad'];
				
            if ($feedlot == 'Acopiadora Pampeana') {
                
                $totalPNeto += ($fila['pesoPromedio'] * $fila['cantidad']);

            }else{
                
                $totalPNeto += $resultadosIng['pesoTotal'];
                
            }


            $i++;
        
    }
}
$hoja->setCellValue('A'.$i, 'Subtotales:');
$hoja->setCellValue('C'.$i, number_format($totalCantidad,0,",","."));
$hoja->setCellValue('D'.$i, number_format(($totalPNeto / $totalCantidad),2,",",".").' Kg');
$hoja->setCellValue('E'.$i, 'Peso Neto Total: '.number_format($totalPNeto,2,",",".").' Kg');
$hoja->getStyle('A'.$i.':H'.$i)->applyFromArray($styleFooter);
$hoja->mergeCells('A'.$i.':B'.$i);
$hoja->mergeCells('E'.$i.':H'.$i);

$hoja->getStyle('D1:D'.$i)->applyFromArray($alineacion);

$nombreDelDocumento = "Lista-StockIngresos.xlsx";
/**
 * Los siguientes encabezados son necesarios para que
 * el navegador entienda que no le estamos mandando
 * simple HTML
 * Por cierto: no hagas ningún echo ni cosas de esas; es decir, no imprimas nada
 */
 
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
header('Cache-Control: max-age=0');
 
$writer = IOFactory::createWriter($documento, 'Xlsx');
$writer->save('php://output');
exit;