<?php
require_once "../../config/app.php";
require_once "../../vendor/autoload.php";

use App\Models\MovimientoModel;
use App\Models\UsuarioModel;
use App\Services\MovimientoService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	
	$objetoMovimiento = new MovimientoModel();
    $objetoServicio = new MovimientoService();
    $objetoUsuario = new UsuarioModel();

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

    $respuesta = $objetoUsuario->validarAccesoUsuario($operacion);
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
       if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../sesion-expirada');
            exit();
        }
    }

    $respuesta = $objetoUsuario->validarAccesoUsuario($operacion);
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

    }elseif($operacion == 'consultar_movimiento'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['codigo_movimiento'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoMovimiento->consultarMovimiento($respuesta['parametros']['codigo_movimiento']));

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
