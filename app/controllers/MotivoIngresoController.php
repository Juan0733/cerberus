<?php
require_once "../../config/app.php";
require_once "../../autoload.php";

use app\models\MotivoIngresoModel;
use app\services\MotivoIngresoService;
use app\models\UsuarioModel;


header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoMotivo = new MotivoIngresoModel();
    $objetoServicio = new MotivoIngresoService();
    $objetoUsuario = new UsuarioModel();

    $operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
    unset($_GET['operacion']);

    $respuesta = $objetoUsuario->validarTiempoSesion();
    if($respuesta['tipo'] == 'ERROR'){
       if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../sesion-expirada');
            exit();
        }
    }

    if($operacion == 'consultar_motivos_ingreso'){
        echo json_encode($objetoMotivo->consultarMotivosIngreso());

    }
}