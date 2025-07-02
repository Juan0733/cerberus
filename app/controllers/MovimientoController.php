<?php
require_once "../../config/app.php";
require_once "../../autoload.php";

use app\models\MovimientoModel;
use app\models\UsuarioModel;
use app\services\MovimientoService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	
	$objetoMovimiento = new MovimientoModel();
    $objetoServicio = new MovimientoService();
    $objetoUsuario = new UsuarioModel();

    $operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
    unset($_POST['operacion']);

    $respuesta = $objetoUsuario->validarTiempoSesion();
    if($respuesta['tipo'] == 'ERROR'){
        echo json_encode($respuesta);
        exit();
    }

    $respuesta = $objetoUsuario->validarPermisosUsuario($operacion);
    if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
        return $respuesta;
        
    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Acceso Denegado'){
        header('Location: ../../acceso-denegado');
        exit();
    }

    if ($operacion == 'registrar_entrada_peatonal') {
        $respuesta = $objetoServicio->sanitizarDatosRegistroMovimientoPeatonal();
        if ($respuesta['tipo'] == 'ERROR') {
            echo json_encode($respuesta);
            exit();
        }
        echo json_encode($objetoMovimiento->registrarEntradaPeatonal($respuesta['datos_movimiento']));
        
    }elseif($operacion == 'registrar_entrada_vehicular') {
        $respuesta = $objetoServicio->sanitizarDatosRegistroMovimientoVehicular();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoMovimiento->registrarEntradaVehicular($respuesta['datos_movimiento']));
    }elseif($operacion == "registrar_salida_peatonal"){
         $respuesta = $objetoServicio->sanitizarDatosRegistroMovimientoPeatonal();
        if ($respuesta['tipo'] == 'ERROR') {
            echo json_encode($respuesta);
            exit();
        }
        echo json_encode($objetoMovimiento->registrarSalidaPeatonal($respuesta['datos_movimiento']));
    }elseif($operacion == 'registrar_salida_vehicular'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroMovimientoVehicular();
        if ($respuesta['tipo'] == 'ERROR') {
            echo json_encode($respuesta);
            exit();
        }
        echo json_encode($objetoMovimiento->registrarSalidaVehicular($respuesta['datos_movimiento']));
    }
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoMovimiento = new MovimientoModel();
    $objetoServicio = new MovimientoService();
    $objetoUsuario = new UsuarioModel();

    $operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
    unset($_GET['operacion']);

    $respuesta = $objetoUsuario->validarTiempoSesion();
    if($respuesta['tipo'] == 'ERROR'){
        echo json_encode($respuesta);
        exit();
    }

    $respuesta = $objetoUsuario->validarPermisosUsuario($operacion);
    if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
        return $respuesta;
        
    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Acceso Denegado'){
        header('Location: ../../acceso-denegado');
        exit();
    }
    
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

    }elseif($operacion == 'validar_usuario_apto_salida'){
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
        
        echo json_encode($objetoMovimiento->validarUsuarioAptoSalida($respuesta['parametros']['numero_documento']));

    }elseif($operacion == 'consultar_movimientos'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['fecha_inicio']) || !isset($respuesta['parametros']['fecha_fin'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoMovimiento->consultarMovimientos($respuesta['parametros']));
    }elseif($operacion == 'consultar_movimientos_usuarios'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['fecha']) || !isset($respuesta['parametros']['jornada']) || !isset($respuesta['parametros']['tipo_movimiento'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoMovimiento->consultarMovimientosUsuarios($respuesta['parametros']));
    }
}
