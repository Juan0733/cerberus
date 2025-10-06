<?php
require_once "../../config/app.php";
require_once "../../vendor/autoload.php";

use App\Models\MotivoIngresoModel;
use App\Models\RolOperacionModel;
use App\Models\UsuarioModel;
use App\Services\MainService;


header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoMotivo = new MotivoIngresoModel();
    $objetoServicio = new MainService();
    $objetoUsuario = new UsuarioModel();
    $objetoRolOperacion = new RolOperacionModel();

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

    $respuesta = $objetoRolOperacion->validarAccesoOperacion($operacion);
    if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
        echo json_encode($respuesta);
        exit();
        
    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Operación No Encontrada'){
        if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../404');
            exit();
        }

    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Acceso Denegado'){
        if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../acceso-denegado');
            exit();
        }
    }

    if($operacion == 'consultar_motivos_ingreso'){
        echo json_encode($objetoMotivo->consultarMotivosIngreso());

    }
}