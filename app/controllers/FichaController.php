<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\FichaModel;
use app\services\FichaService;

header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoFicha = new FichaModel();
    $objetoServicio = new FichaService();

    $operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
    unset($_GET['operacion']);

    if($operacion == 'consultar_fichas'){

        echo json_encode($objetoFicha->consultarFichas());

    }elseif($operacion == 'consultar_ficha'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['numero_ficha'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFicha->consultarFicha($respuesta['parametros']['numero_ficha']));

    }
}