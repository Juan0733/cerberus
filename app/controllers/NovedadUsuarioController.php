<?php
require_once "../../config/app.php";
require_once "../../vendor/autoload.php";

use App\Models\NovedadUsuarioModel;
use App\Models\UsuarioModel;
use App\Services\NovedadUsuarioService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
    $objetoNovedad= new NovedadUsuarioModel();
    $objetoServicio = new NovedadUsuarioService();
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
    
    if($operacion == 'registrar_novedad_usuario') {
        $respuesta = $objetoServicio->sanitizarDatosRegistroNovedadUsuario();
        if ($respuesta['tipo'] == 'ERROR') {
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoNovedad->registrarNovedadUsuario($respuesta['datos_novedad']));
        
    } else {
        $respuesta = [
            "tipo" => "ERROR",
            "titulo" => 'Operación no válida',
            "mensaje" => 'Lo sentimos, la operación solicitada no es válida.'
        ];
        echo json_encode($respuesta);
    }


	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoNovedad= new NovedadUsuarioModel();
    $objetoServicio = new NovedadUsuarioService();
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

    if($operacion == 'consultar_novedades_usuario'){
        $respuesta = $objetoServicio->sanitizarParametros();
        echo json_encode($objetoNovedad->consultarNovedadesUsuario($respuesta['parametros']));

    }else if($operacion == 'consultar_novedad_usuario'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['codigo_novedad'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoNovedad->consultarNovedadUsuario($respuesta['parametros']['codigo_novedad']));
    }
}