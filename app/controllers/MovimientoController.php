<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\MovimientoModel;
use app\services\MovimientoService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	
	$objetoMovimiento = new MovimientoModel();
    $objetoServicio = new MovimientoService();

    $operacion = $objetoServicio->limpiarDatos($_POST['operacion']);

    if ($operacion == 'registrar_entrada_peatonal') {
        $respuesta = $objetoServicio->sanitizarDatosMovimientoPeatonal();
        if ($respuesta['tipo'] == 'ERROR') {
            echo json_encode($respuesta);
            exit();
        }
        echo json_encode($objetoMovimiento->registrarEntradaPeatonal($respuesta['dato_entrada']));
        
    }elseif($operacion == 'registrar_entrada_vehicular') {
        $respuesta = $objetoServicio->sanitizarDatosMovimientoVehicular();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoMovimiento->registrarEntradaVehicular($respuesta['datos_entrada']));
    }
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoMovimiento = new MovimientoModel();
    $objetoServicio = new MovimientoService();

    $operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
    if($operacion == 'validar_usuario_apto_entrada'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(empty($respuesta['parametros'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }
        
        echo json_encode($objetoMovimiento->validarUsuarioAptoEntrada($respuesta['parametros']['numero_documento']));
    }
}
