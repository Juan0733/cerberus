<?php
require_once "../../config/app.php";
require_once "../../autoload.php";

use app\models\PermisoUsuarioModel;
use app\models\UsuarioModel;
use app\services\PermisoUsuarioService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
    $objetoPermiso = new PermisoUsuarioModel();
    $objetoServicio = new PermisoUsuarioService();
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
    
    if($operacion == 'registrar_permiso_usuario') {
        $respuesta = $objetoServicio->sanitizarDatosRegistroPermisoUsuario();
        if ($respuesta['tipo'] == 'ERROR') {
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoPermiso->registrarPermisoUsuario($respuesta['datos_permiso']));
        
    }
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoPermiso = new PermisoUsuarioModel();
    $objetoServicio = new PermisoUsuarioService();
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

    if($operacion == 'consultar_permisos_usuarios'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['fecha'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoPermiso->consultarPermisosUsuarios($respuesta['parametros']));

    }else if($operacion == 'aprobar_permiso_usuario'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['codigo_permiso'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoPermiso->aprobarPermisoUsuario($respuesta['parametros']['codigo_permiso']));

    }else if($operacion == 'desaprobar_permiso_usuario'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['codigo_permiso'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoPermiso->desaprobarPermisoUsuario($respuesta['parametros']['codigo_permiso']));

    }else if($operacion == 'consultar_permiso_usuario'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['codigo_permiso'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoPermiso->consultarPermisoUsuario($respuesta['parametros']['codigo_permiso']));

    }else if($operacion == 'consultar_notificaciones_permisos_usuario'){
        
        echo json_encode($objetoPermiso->consultarNotificacionesPermisosUsuario());
    }
}