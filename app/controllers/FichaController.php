<?php
require_once "../../config/app.php";
require_once "../../vendor/autoload.php";

use App\Models\FichaModel;
use App\Models\UsuarioModel;
use App\Services\FichaService;

header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoFicha = new FichaModel();
    $objetoServicio = new FichaService();
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