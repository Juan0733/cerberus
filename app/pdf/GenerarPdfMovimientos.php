<?php

// Optionally define the filesystem path to your system fonts
// otherwise tFPDF will use [path to tFPDF]/font/unifont/ directory
// define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");
require_once "../../vendor/autoload.php";
require_once "../../config/app.php";
require_once('tfpdf/tfpdf.php');
use App\Models\MovimientoModel;
use App\Models\UsuarioModel;
use App\Models\VehiculoModel;
use App\Services\MovimientoService;

class PDF extends tFPDF{
    public $usuario;
    public $vehiculo;
    public $fechaInicio;
    public $fechaFin;

    function __construct($fechaInicio, $fechaFin, $usuario='', $vehiculo='', $orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->usuario = $usuario;
        $this->vehiculo = $vehiculo;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    function Header()
    {
        $pageWidth = $this->GetPageWidth();

        if ($this->PageNo() == 1) {
            $this->Image('../views/img/imgPdf/3.jpg', 0, 0, $pageWidth);

            $this->SetFont('DejaVu', 'B', 50);
            $this->SetTextColor(0, 22, 41); 
            $this->setXY(190, 13);
            $this->Cell(30, 10, 'INFORME', 0, 0);

            $this->SetFont('DejaVu', 'B', 13);
            $this->SetTextColor(255, 255, 255);
            $this->setXY(157,13);
            $this->Cell(30, 60, 'PERIODO REPORTE: Desde '.date('d-m-Y', strtotime($this->fechaInicio))." hasta ".date('d-m-Y', strtotime($this->fechaFin)), 0, 0);

            if($this->usuario){
                $this->dibujarInformacionUsuario();
            }else if($this->vehiculo){
                $this->dibujarInformacionVehiculo();
            }

            $this->SetFont('DejaVu', 'B', 18);
            $this->SetY(65);
            $this->SetTextColor(0, 22, 41);
            $this->Cell(30, 60,'REPORTES DE INGRESO Y SALIDA:', 0, 0);

            $this->SetY(100);
            $this->dibujarCabeceraTabla();

        } else {
            $this->Image('../views/img/imgPdf/6.jpg', 0, 0, $pageWidth); 
            
            $this->SetY(40);
            $this->dibujarCabeceraTabla();
        }
    }

    function dibujarInformacionUsuario(){

        $this->setY(13);
        $this->SetTextColor(0, 22, 41);
        $this->Cell(30, 60, 'DATOS DEL USUARIO:', 0, 0);

        $this->SetFont('DejaVu', '', 14);

        $this->setXY(20, 23);
        $this->Cell(30, 60, "Tipo documento: ".$this->usuario['tipo_documento'], 0, 0);

        $this->setXY(157, 23);
        $this->Cell(30, 60, 'Número documento: '.$this->usuario['numero_documento'], 0, 0);
    
        $this->setXY(20, 33);
        $this->Cell(30, 60, "Nombres: ".$this->usuario['nombres'], 0, 0);

        $this->setXY(157, 33);
        $this->Cell(30, 60, "Apellidos: ".$this->usuario['apellidos'], 0, 0);

        $this->setXY(20, 43);
        $this->Cell(30, 60, 'Número telefóno: '.$this->usuario['telefono'], 0, 0);

         $this->setXY(157, 43);
        $this->Cell(30, 60, 'Grupo usuario: '.$this->usuario['grupo'], 0, 0);
    }

    function dibujarInformacionVehiculo(){

        $this->setY(13);
        $this->SetTextColor(0, 22, 41);
        $this->Cell(30, 60, 'DATOS DEL VEHÍCULO:', 0, 0);

        $this->SetFont('DejaVu', '', 14);
    
        $this->setXY(20, 23);
        $this->Cell(30, 60, "Número placa: ".$this->vehiculo['numero_placa'], 0, 0);

        $this->setXY(20, 33);
        $this->Cell(30, 60, "Tipo vehículo: ".$this->vehiculo['tipo_vehiculo'], 0, 0);
    }

    function dibujarCabeceraTabla(){
        $this->SetFont('DejaVu', '', 10.5);
        $this->SetFillColor(0, 22, 41); 
        $this->SetTextColor(255, 255, 255); 
        $this->SetDrawColor(255, 255, 255);

        $anchoColumnas = [40, 26, 26, 26, 30, 40, 40, 26, 26]; 
        $nombresColumnas = [
            "FECHA Y HORA", 
            "TIPO MOVIM.",
            "PUERTA", 
            "TIPO DOC.", 
            "NÚMERO DOC.", 
            "NOMBRES", 
            "APELLIDOS", 
            "VEHÍCULO", 
            "RELACIÓN VEH."
        ];

        // Imprime los encabezados
        foreach ($nombresColumnas as $index => $columna) {
            $this->Cell($anchoColumnas[$index], 7, $columna, 1, 0, 'C', true);  
        }

        $this->Ln(10);
    }

    function dibujarContenidoTabla($datos) {
        $this->SetTextColor(5, 5, 5); 
        $this->SetDrawColor(175, 175, 175);

        foreach ($datos as $dato) {
            // Verificar si hay que hacer un salto de página
            if ($this->GetY() > $this->PageBreakTrigger - 10) {
                $this->AddPage();
            }

            // Dibujar las celdas
            $this->Cell(40, 7, $dato['fecha_registro'], 1, 0, 'C');
            $this->Cell(26, 7, $dato['tipo_movimiento'], 1, 0, 'C');
            $this->Cell(26, 7, $dato['puerta_registro'], 1, 0, 'C');
            $this->Cell(26, 7, $dato['tipo_documento'], 1, 0, 'C');
            $this->Cell(30, 7, $dato['fk_usuario'], 1, 0, 'C');
            $this->Cell(40, 7, $dato['nombres'], 1, 0, 'C');
            $this->Cell(40, 7, $dato['apellidos'], 1, 0, 'C');
            $this->Cell(26, 7, $dato['fk_vehiculo'], 1, 0, 'C');
            $this->Cell(26, 7, $dato['relacion_vehiculo'], 1, 1, 'C'); // Última celda con salto de línea
        }
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('DejaVu', 'I', 9);
        $this->Cell(0, 10, 'Pág. '. $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    function generarPdf($datos){
        $this->AliasNbPages();
        $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $this->AddFont('DejaVu', 'B', 'DejaVuSansCondensed-Bold.ttf', true);
        $this->AddFont('DejaVu', 'I', 'DejaVuSerifCondensed-Italic.ttf', true);
        $this->AddPage();
        $this->dibujarContenidoTabla($datos);
        $this->Output('D', 'reporte_'.date('Ymd_His').'.pdf');
    }
}

try {
    $objetoUsuario = new UsuarioModel();
    $objetoVehiculo = new VehiculoModel();
    $objetoMovimiento = new MovimientoModel();
    $objetoServicio = new MovimientoService();

    $respuesta = $objetoUsuario->validarTiempoSesion();
    if($respuesta['tipo'] == 'ERROR'){
        header('Location: ../../sesion-expirada');
        exit();
    }

    $respuesta = $objetoUsuario->validarAccesoUsuario('generar_pdf_movimientos');
    if($respuesta['tipo'] == 'ERROR'){
        header('Location: ../../acceso-denegado');
        exit();
    }
    
    $parametros = $objetoServicio->sanitizarParametros()['parametros'];

    if(!isset($parametros['fecha_inicio']) || !isset($parametros['fecha_fin'])){
        header("Location: ../../informes-listado");
        exit();
    }

    if(isset($parametros['numero_documento'])){
        $respuesta = $objetoUsuario->consultarUsuario($parametros['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            header("Location: ../../informes-listado");
            exit();
        }

        $pdf = new PDF($parametros['fecha_inicio'], $parametros['fecha_fin'], $respuesta['usuario']);

    }elseif(isset($parametros['numero_placa'])){
        $respuesta = $objetoVehiculo->consultarVehiculo($parametros['numero_placa']);
        if($respuesta['tipo'] == 'ERROR'){
            header("Location: ../../informes-listado");
            exit();
        }

        $pdf = new PDF($parametros['fecha_inicio'], $parametros['fecha_fin'], '', $respuesta['vehiculo']);

    }else{
        $pdf = new PDF($parametros['fecha_inicio'], $parametros['fecha_fin']);
    }
    
    $respuesta= $objetoMovimiento->consultarMovimientos($parametros);
    if($respuesta['tipo'] == 'ERROR'){
        header("Location: ../../informes-listado");
        exit();
    }

    $pdf->generarPdf($respuesta['movimientos']);

} catch (\Throwable $th) {
    header("Location: ../../informes-listado");
    exit();
}


