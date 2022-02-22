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
            'color' => ['rgb' => 'F4F4F4']
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
    ->setCreator("Gestion de Feedlot")
    ->setLastModifiedBy('Mauro Gonzalez') // última vez modificado por
    ->setTitle('Lista Stock de Egresos')
    ->setSubject('Egresos')
    ->setDescription('Lista de Egresos')
    ->setKeywords('Stock Lista Egresos')
    ->setCategory('Egresos');

    
$hoja = $documento->getActiveSheet();

$hoja->setTitle("Egresos");
// Generate an image
// Generate an image

$gdImage = imagecreatefromjpeg('../img/logo1.jpg');


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
$hoja->setCellValue('A2', 'Fecha');
$hoja->setCellValue('B2', 'Cantidad');
$hoja->setCellValue('C2', 'Peso Prom.');
$hoja->setCellValue('D2', 'Destino');

$hoja->getStyle('A2:D2')->applyFromArray($styleHeader);
$hoja->mergeCells('B1:D1');


$hoja->setCellValue('B1', $feedlot.'- Listado de Egresos - '.$filtros);



$hoja->getRowDimension('1')->setRowHeight(75);
$hoja->getColumnDimension('A')->setWidth(30);
$hoja->getColumnDimension('B')->setWidth(18);
$hoja->getColumnDimension('C')->setWidth(17);
$hoja->getColumnDimension('D')->setWidth(45);

$i = 3;

if(mysqli_num_rows($query)>0){

    $totalCantidad = 0;
    $totalPNeto = 0;
    while($fila = mysqli_fetch_array($query)){
       
        $hoja->setCellValue('A'.$i, formatearFecha($fila['fecha']));
        $hoja->setCellValue('B'.$i, $fila['cantidad']);
        $hoja->setCellValue('C'.$i, $fila['pesoPromedio']);
        $hoja->setCellValue('D'.$i, $fila['destino']);


        $hoja->getStyle('A'.$i.':D'.$i)->applyFromArray($styleBody);

        $totalCantidad += $fila['cantidad'];
            
        $totalPNeto += ($fila['pesoPromedio'] * $fila['cantidad']);

        $i++;
    }


}
$hoja->setCellValue('A'.$i, 'Subtotales:');
$hoja->setCellValue('B'.$i, $totalCantidad);
$hoja->setCellValue('C'.$i, number_format(($totalPNeto / $totalCantidad),2,",",".").' Kg');
$hoja->setCellValue('D'.$i, 'Peso Neto Total: '.number_format($totalPNeto,2,",",".").' Kg');
$hoja->getStyle('A'.$i.':D'.$i)->applyFromArray($styleFooter);

$hoja->getStyle('C1:C'.$i)->applyFromArray($alineacion);


$nombreDelDocumento = "Lista-StockEgresos.xlsx";
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