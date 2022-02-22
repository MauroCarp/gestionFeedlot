<?php
include('../includes/init_session.php');
include('../includes/conexion.php');
require "../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
 
$tropa = $_GET['tropa'];

$tabla = $_GET['seccion'];

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
    ->setCreator("Gestion de Feedlot")
    ->setLastModifiedBy('Mauro Gonzalez') // última vez modificado por
    ->setTitle('Detalle de Tropa')
    ->setSubject('Detalle de Tropa')
    ->setDescription('Lista de Animales de la Tropa')
    ->setKeywords('Tropa Animales')
    ->setCategory('Tropas');

    
$hoja = $documento->getActiveSheet();

$hoja->setTitle("Detalle de Tropa");
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

if($tabla == 'ingresos'){
    $hoja->setCellValue('A2', 'IDE');
    $hoja->setCellValue('B2', 'Num. DTE');
    $hoja->setCellValue('C2', 'Peso');
    $hoja->setCellValue('D2', 'Raza');
    $hoja->setCellValue('E2', 'Sexo');
    $hoja->setCellValue('F2', 'Estado');
    $hoja->setCellValue('G2', 'Hora');
    
    $hoja->getStyle('A2:G2')->applyFromArray($styleHeader);
    $hoja->mergeCells('B1:G1');
    
}
if($tabla == 'egresos'){
    $hoja->setCellValue('A2','IDE');
    $hoja->setCellValue('B2','Peso');
    $hoja->setCellValue('C2','Raza');
    $hoja->setCellValue('D2','Sexo');
    $hoja->setCellValue('E2','GMD Total');
    $hoja->setCellValue('F2','GPV Total');
    $hoja->setCellValue('G2','Destino');
    $hoja->setCellValue('H2','Hora');
    
    $hoja->getStyle('A2:H2')->applyFromArray($styleHeader);
    $hoja->mergeCells('B1:H1');
    
}

$hoja->setCellValue('B1', $feedlot.'- Detalle de Tropa - '.$tropa);

$hoja->getRowDimension('1')->setRowHeight(75);
$hoja->getColumnDimension('A')->setWidth(30);
$hoja->getColumnDimension('B')->setWidth(18);
$hoja->getColumnDimension('C')->setWidth(17);
$hoja->getColumnDimension('D')->setWidth(20);
$hoja->getColumnDimension('E')->setWidth(25);
$hoja->getColumnDimension('F')->setWidth(12);
$hoja->getColumnDimension('G')->setWidth(15);

if($tabla == 'egresos')
    $hoja->getColumnDimension('H')->setWidth(15);


$i = 3;

$sql = "SELECT * FROM $tabla WHERE tropa = '$tropa' ORDER BY hora ASC";

$query = mysqli_query($conexion, $sql);

if(mysqli_num_rows($query)>0){

    while($respuesta = mysqli_fetch_array($query)){
                
        if($tabla == 'ingresos'){
        
            $hoja->setCellValue('A'.$i, $respuesta['IDE']);
            $hoja->setCellValue('B'.$i, $respuesta['numDTE']);
            $hoja->setCellValue('C'.$i, $respuesta['peso']);
            $hoja->setCellValue('D'.$i, $respuesta['raza']);
            $hoja->setCellValue('E'.$i, $respuesta['sexo']);
            $hoja->setCellValue('F'.$i, $respuesta['estadoAnimal']);
            $hoja->setCellValue('G'.$i, $respuesta['hora']);

            $hoja->getStyle('A'.$i.':G'.$i)->applyFromArray($styleBody);
        
        }

        if($tabla == 'egresos'){
        
            $hoja->setCellValue('A'.$i, $respuesta['IDE']);
            $hoja->setCellValue('B'.$i, $respuesta['peso']);
            $hoja->setCellValue('C'.$i, $respuesta['raza']);
            $hoja->setCellValue('D'.$i, $respuesta['sexo']);
            $hoja->setCellValue('E'.$i, $respuesta['gdmTotal']);
            $hoja->setCellValue('F'.$i, $respuesta['gpvTotal']);
            $hoja->setCellValue('G'.$i, $respuesta['destino']);
            $hoja->setCellValue('H'.$i, $respuesta['hora']);

            $hoja->getStyle('A'.$i.':H'.$i)->applyFromArray($styleBody);
        
        }
            $i++;
        
    }

}

$hoja->getStyle('D1:D'.$i)->applyFromArray($alineacion);

$nombreDelDocumento = "Detalle de Tropa.xlsx";
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