<?php
require_once "../../config/app.php";
require_once "../../vendor/autoload.php";

use App\Models\FuncionarioModel;
use App\Models\UsuarioModel;
use App\Models\RolOperacionModel;
use App\Services\FuncionarioService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	
	$objetoFuncionario = new FuncionarioModel();
    $objetoServicio = new FuncionarioService();
    $objetoUsuario = new UsuarioModel();
    $objetoRolOperacion = new RolOperacionModel();

    $operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
    unset($_POST['operacion']);

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

    if($operacion == 'registrar_funcionario_individual'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroFuncionarioIndividual();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->registrarFuncionarioIndividual($respuesta['datos_funcionario']));

    }elseif($operacion == 'registrar_funcionario_carga_masiva'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroFuncionarioCargaMasiva();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->registrarFuncionarioCargaMasiva($respuesta['datos_funcionarios']));

    }else if($operacion == 'actualizar_funcionario'){
        $respuesta = $objetoServicio->sanitizarDatosActualizacionFuncionario();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->actualizarFuncionario($respuesta['datos_funcionario']));
        
    }else if($operacion == 'habilitar_funcionario'){
        $respuesta = $objetoServicio->sanitizarDatosHabilitacionUsuario();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoFuncionario->habilitarFuncionario($respuesta['datos_usuario']));
    }


}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoFuncionario = new FuncionarioModel();
    $objetoServicio = new FuncionarioService();
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