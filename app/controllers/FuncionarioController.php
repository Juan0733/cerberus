<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\FuncionarioModel;
use app\services\FuncionarioService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	
	$objetoFuncionario = new FuncionarioModel();
    $objetoServicio = new FuncionarioService();

    $operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
    unset($_POST['operacion']);

    if($operacion == 'registrar_funcionario'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroFuncionario();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->registrarFuncionario($respuesta['datos_funcionario']));

    }elseif($operacion == 'auto_registrar_funcionario'){
        $respuesta = $objetoServicio->sanitizarDatosAutoRegistroFuncionario();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->registrarFuncionario($respuesta['datos_funcionario']));

    }else if($operacion == 'actualizar_funcionario'){
        $respuesta = $objetoServicio->sanitizarDatosActualizacionFuncionario();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->actualizarFuncionario($respuesta['datos_funcionario']));
        
    }else if($operacion == 'habilitar_funcionario'){
        $respuesta = $objetoServicio->sanitizarDatosHabilitacionFuncionario();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->habilitarFuncionario($respuesta['datos_funcionario']));
    }


}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoFuncionario = new FuncionarioModel();
    $objetoServicio = new FuncionarioService();

    $operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
    unset($_GET['operacion']);
    
    if($operacion == 'consultar_funcionarios'){
        $respuesta = $objetoServicio->sanitizarParametros();
        echo json_encode($objetoFuncionario->consultarFuncionarios($respuesta['parametros']));

    }elseif($operacion == 'consultar_funcionario'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['numero_documento'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->consultarFuncionario($respuesta['parametros']['numero_documento']));

    }elseif($operacion == 'conteo_total_brigadistas'){
        echo json_encode($objetoFuncionario->conteoTotalBrigadistas());

    }elseif($operacion == 'inhabilitar_funcionario'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['numero_documento'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->inhabilitarFuncionario($respuesta['parametros']['numero_documento']));
    }


}