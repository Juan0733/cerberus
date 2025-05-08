<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\MovimientoModel;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion']) && $_POST['operacion'] != "") {
	
	$objetoMovimiento = new MovimientoModel();
    $operacion = $objetoMovimiento->limpiarDatos($_POST['operacion']);

    if ($operacion == 'registrar_entrada_peatonal') {
        if (!isset($_POST['documento_peaton'], $_POST['observacion']) || $_POST['documento_peaton'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            echo json_encode($respuesta);
            exit();
        }

        $numeroDocumento = $objetoMovimiento->limpiarDatos($_POST['documento_peaton']);
        $observacion = $objetoMovimiento->limpiarDatos($_POST['observacion']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-z0-9 ]{0,100}",
                'cadena' => $observacion
            ]
        ];

        if (!$objetoMovimiento->verificarDatos($datos)) {
            $respuesta = [
                "tipo" => "ERROR",
                'titulo' => "Formato Inválido",
                'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
            ];
            echo json_encode($respuesta);
            exit();
        }

        $datosEntrada = [
            'numero_documento' => $numeroDocumento,
            'observacion' => $observacion
        ];

        echo json_encode($objetoMovimiento->registrarEntradaPeatonal($datosEntrada));
        
    } else {
        $respuesta = [
            "tipo" => "ERROR",
            "titulo" => 'Operación no válida',
            "mensaje" => 'La operación solicitada no es válida.',
        ];
        echo json_encode($respuesta);
        exit();
    }
}
