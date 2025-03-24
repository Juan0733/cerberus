<?php


require('fpdf.php');


$peticion_ajax=true;
$id_persona =(isset($_GET['id_persona'])) ? $_GET['id_persona'] : 0;
$fecha_inicio =(isset($_GET['fecha_inicio'])) ? $_GET['fecha_inicio'] : 0;
$fecha_final =(isset($_GET['fecha_final'])) ? $_GET['fecha_final'] : 0;

/*---------- Incluyendo configuraciones ----------*/
require_once "../../config/app.php";
require_once "../../autoload.php";



require_once "../models/mainModel.php";
use app\models\mainModel;
$insMainModel = new mainModel();


$enlace_conexion = new mysqli("localhost", "root", "", "cerberus_bdd");
			

$consultar_datos = $insMainModel->consultarDatosUsuario($id_persona, ["nombres","apellidos","tipo_documento", "num_identificacion", "permanencia", "tipo_documento","telefono","fecha_hora_ultimo_ingreso"]);

/* if ($consultar_datos[0] = "no_encontrado") {
   exit();
}
 */
$reportes = $enlace_conexion->query("SELECT DISTINCT
    rep.fecha_hora_reporte AS FEC_Y_HORA_ING,
    IF(rep.id_reporte_relacion LIKE 'RV%', 'N/A', 'N/A') AS TIPO_VEHIC,
    IF(rep.id_reporte_relacion LIKE 'RV%', 'N/A', 'N/A') AS PLACA_VEHIC,
    IF(rep.id_reporte_relacion LIKE 'RV%', 'N/A', 'N/A') AS ROL_ING,
    IF(rep.id_reporte_relacion LIKE 'RV%', rv.fecha_hora_reporte, rsp.fecha_hora_reporte) AS FEC_Y_HORA_SAL,
    IF(rep.id_reporte_relacion LIKE 'RV%', vp.tipo_vehiculo, 'N/A') AS TIPO_VEHIC2,
    IF(rep.id_reporte_relacion LIKE 'RV%', rv.placa_vehiculo, 'N/A') AS PLACA_VEHIC2,
    IF(rep.id_reporte_relacion LIKE 'RV%', rv.rol_en_el_vehiculo, 'N/A') AS ROL_SAL
FROM reporte_entrada_salida AS rep
LEFT JOIN reporte_entrada_salida AS rsp
    ON rsp.id_reporte = rep.id_reporte_relacion
    AND rep.tipo_reporte = 'ENTRADA'
    AND rsp.tipo_reporte = 'SALIDA'
LEFT JOIN reporte_entrada_salida_vehicular AS rv
    ON rep.id_reporte_relacion = rv.id_reporte
    AND rep.tipo_reporte = 'ENTRADA'
LEFT JOIN vehiculos_personas AS vp
    ON rv.placa_vehiculo = vp.placa_vehiculo 
WHERE (rep.tipo_reporte = 'ENTRADA' OR rv.tipo_reporte = 'ENTRADA')
    AND (rep.num_identificacion_persona = '$id_persona' OR rv.num_identificacion_persona = '$id_persona')
    AND rep.fecha_hora_reporte BETWEEN '$fecha_inicio' AND '$fecha_final'

UNION ALL

SELECT DISTINCT
    rev.fecha_hora_reporte AS FEC_Y_HORA_ING,
    IF(rev.id_reporte_relacion LIKE 'RP%', 'N/A', vp.tipo_vehiculo) AS TIPO_VEHIC,
    IF(rev.id_reporte_relacion LIKE 'RP%', 'N/A', rev.placa_vehiculo) AS PLACA_VEHIC,
    IF(rev.id_reporte_relacion LIKE 'RP%', 'N/A', rev.rol_en_el_vehiculo) AS ROL_ING,
    IF(rev.id_reporte_relacion LIKE 'RP%', rp.fecha_hora_reporte, rsv.fecha_hora_reporte) AS FEC_Y_HORA_SAL,
    IF(rev.id_reporte_relacion LIKE 'RP%', 'N/A', vsp.tipo_vehiculo) AS TIPO_VEHIC2,
    IF(rev.id_reporte_relacion LIKE 'RP%', 'N/A', rsv.placa_vehiculo) AS PLACA_VEHIC2,
    IF(rev.id_reporte_relacion LIKE 'RP%', 'N/A', rsv.rol_en_el_vehiculo) AS ROL_SAL
    
FROM reporte_entrada_salida_vehicular AS rev
LEFT JOIN reporte_entrada_salida_vehicular AS rsv
    ON rsv.id_reporte = rev.id_reporte_relacion
    AND rev.tipo_reporte = 'ENTRADA'
    AND rsv.tipo_reporte= 'SALIDA'
LEFT JOIN reporte_entrada_salida AS rp
    ON rev.id_reporte_relacion = rp.id_reporte
    AND rev.tipo_reporte = 'ENTRADA'
LEFT JOIN vehiculos_personas AS vp
    ON rev.placa_vehiculo = vp.placa_vehiculo 
LEFT JOIN vehiculos_personas AS vsp
    ON rsv.placa_vehiculo = vsp.placa_vehiculo 
WHERE (rev.tipo_reporte = 'ENTRADA' OR rp.tipo_reporte = 'ENTRADA')
    AND (rev.num_identificacion_persona = '$id_persona' OR rp.num_identificacion_persona = '$id_persona')
    AND rev.fecha_hora_reporte BETWEEN '$fecha_inicio' AND '$fecha_final'
    
ORDER BY FEC_Y_HORA_SAL DESC;");




class PDF extends FPDF
{
    public $fechaInicio;
    public $fechaFin;

    function __construct($fechaInicio, $fechaFin, $orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    function Header()
    {
        $pageWidth = $this->GetPageWidth();

        if ($this->PageNo() == 1) {
            $this->Image('../views/img/imgPdf/3.jpg', 0, 0, $pageWidth); 
        } else {
            $this->Image('../views/img/imgPdf/6.jpg', 0, 0, $pageWidth); 
            $this->Ln(30);
            $this->SetFont('Arial', '', 10);
            $this->SetFillColor(0, 22, 41);
            $this->SetTextColor(255, 255, 255);
            $this->SetDrawColor(255, 255, 255);

            $widths = [50, 30, 30, 30, 50, 30, 30, 30]; 
            $texts = [
                "FEC. Y HORA ING", 
                "TIPO VEHÍC.", 
                "PLACA VEHÍC.", 
                "ROL ING.", 
                "FEC. Y HORA SAL.", 
                "TIPO VEHÍC.", 
                "PLACA VEHÍC.", 
                "ROL SAL."
            ];

            $lineHeight = 7;

            // Dibujar el encabezado de la tabla
            foreach ($texts as $index => $text) {
                $this->Cell($widths[$index], $lineHeight, utf8_decode($text), 1, 0, 'C', true);  
            }
            $this->Ln(10); 
        }
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9  );
        $this->Cell(0, 10, 'Registros del: ' . $this->fechaInicio . ' al ' . $this->fechaFin . utf8_decode(' - Pág. ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }
}

// Definición de las fechas
$fechaInicio = $fecha_inicio;
$fechaFin = $fecha_final;

// Creación del objeto PDF con la configuración de orientación, unidad, tamaño y fechas
$pdf = new PDF($fechaInicio, $fechaFin, 'L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage(); 
$pdf->SetFont('Arial', 'B', 50);
$pdf->SetTextColor(0, 22, 41); 
$pdf->setXY(190,13);
$pdf->Cell(30, 10, utf8_decode('INFORME'), 0, 0);

$pdf->SetFont('Arial', 'B', 20);
$pdf->SetTextColor(255, 255, 255); // Azul (ejemplo RGB)
$pdf->setXY(157,13);
$pdf->Cell(30, 60, utf8_decode('FECHA Y HORA :    ' . date('d/m/Y H:i:s')), 0, 0);


$pdf->setXY(9,13);
$pdf->SetTextColor(0, 22, 41);
$pdf->Cell(30, 60, utf8_decode('DATOS DEL USUARIO:'), 0, 0);

// Cabecera de la tabla
$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(0, 22, 41); 
$pdf->SetTextColor(255, 255, 255); 
$pdf->SetDrawColor(255, 255, 255);

//Fuentes datos de el usuario:
$pdf->SetFont('Arial', '', 14);
//Nombres Usuario 
$pdf->setXY(20,23);
$pdf->SetTextColor(0, 22, 41);
$pdf->Cell(30, 60, utf8_decode('Nombres : '.$consultar_datos[2]["nombres"]), 0, 0);

//Apellidos de usuario
$pdf->setXY(20,33);
$pdf->SetTextColor(0, 22, 41);
$pdf->Cell(30, 60, utf8_decode('Apellidos : '.$consultar_datos[2]["apellidos"]), 0, 0);

//Numero identificacion de usuario
$pdf->setXY(20,43);
$pdf->SetTextColor(0, 22, 41);
$pdf->Cell(30, 60, utf8_decode($consultar_datos[2]['tipo_documento'].' : '.$consultar_datos[2]["num_identificacion"]), 0, 0);

//Rol de usuario
$pdf->setXY(157,23);
$pdf->SetTextColor(0, 22, 41);
$pdf->Cell(30, 60, utf8_decode('N° Tel. : '.$consultar_datos[2]['telefono']), 0, 0);


//Rol de usuario
$pdf->setXY(157,33);
$pdf->SetTextColor(0, 22, 41);
$pdf->Cell(30, 60, utf8_decode('Rol del usuario : '.$consultar_datos[2]['nombres']), 0, 0);

//Fecha y hora ultimo ingreso usuario
$pdf->setXY(157,43);
$pdf->SetTextColor(0, 22, 41);
$pdf->Cell(30, 60, utf8_decode('Fecha y hora ultimo ingreso : '.$consultar_datos[2]['fecha_hora_ultimo_ingreso']), 0, 0);



$pdf->SetFont('Arial', 'B', 18);
$pdf->setXY(9,65);
$pdf->SetTextColor(0, 22, 41);
$pdf->Cell(30, 60, utf8_decode('REPORTES DE INGRESO Y SALIDA:'), 0, 0);

// Definir los anchos personalizados para cada celda


$pdf->SetFont('Arial', '', 10.5);
$pdf->setXY(10,100);
$pdf->SetTextColor(255, 255, 255);

$widths = [50, 30, 30, 30, 50, 30, 30, 30]; 
$texts = [
    "FEC. Y HORA ING", 
    "TIPO VEHÍC.", 
    "PLACA VEHÍC.", 
    "ROL ING.", 
    "FEC. Y HORA SAL.", 
    "TIPO VEHÍC.", 
    "PLACA VEHÍC.", 
    "ROL SAL."
];

$lineHeight = 7;  

// Imprime los encabezados
foreach ($texts as $index => $text) {
    $pdf->Cell($widths[$index], $lineHeight, utf8_decode($text), 1, 0, 'C', true);  
}
$pdf->Ln(5);

$pdf->SetTextColor(5, 5, 5); 
$pdf->SetDrawColor(175, 175, 175);

$pdf->Ln(4);

$fechaInicioObj = new DateTime($fechaInicio);
$fechaFinObj = new DateTime($fechaFin);
$paginaActual = 2;
$contador = 0;
while ($datos = $reportes->fetch_object()) {
    $fecha_hora_ingreso = new DateTime($datos->FEC_Y_HORA_ING);
    $fecha_hora_salida= new DateTime($datos->FEC_Y_HORA_SAL);
    $pdf->Cell($widths[0], $lineHeight, utf8_decode($fecha_hora_ingreso->format('d / M / Y H:i a')), 1, 0, 'C');
    $pdf->Cell($widths[1], $lineHeight, utf8_decode(TIPOS_VEHICULOS["$datos->TIPO_VEHIC"]), 1, 0, 'C');
    $pdf->Cell($widths[2], $lineHeight, utf8_decode($datos->PLACA_VEHIC), 1, 0, 'C');
    $pdf->Cell($widths[3], $lineHeight, utf8_decode($datos->ROL_ING), 1, 0, 'C');
    $pdf->Cell($widths[0], $lineHeight, utf8_decode($fecha_hora_salida->format('d / M / Y H:i a')), 1, 0, 'C');
    $pdf->Cell($widths[1], $lineHeight, utf8_decode($datos->TIPO_VEHIC2), 1, 0, 'C');
    $pdf->Cell($widths[2], $lineHeight, utf8_decode($datos->PLACA_VEHIC2), 1, 0, 'C');
    $pdf->Cell($widths[3], $lineHeight, utf8_decode($datos->ROL_SAL), 1, 0, 'C');
    $pdf->Ln($lineHeight);
}
// Definir el nombre del archivo
$nombre_archivo = 'reporte_' . $consultar_datos[2]['num_identificacion'] . '_' . date('Ymd_His') . '.pdf';

// Generar el PDF y guardarlo con el nombre definido
try {
    // Código para generar el PDF
    $pdf->Output('D', 'reporte.pdf');
} catch (Exception $e) {
    echo "Error generando el PDF: " .$id_persona. $e->getMessage();
}

$pdf->Output('I', $nombre_archivo);
?>
