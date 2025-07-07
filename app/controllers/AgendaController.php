<?php
require_once "../../config/app.php";
require_once "../../autoload.php";

use app\models\AgendaModel;
use app\services\AgendaService;
use app\models\UsuarioModel;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	
	$objetoAgenda = new AgendaModel();
    $objetoServicio = new AgendaService();
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
        echo json_encode($respuesta);
        exit();
        
    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Acceso Denegado'){
        header('Location: ../../acceso-denegado');
        exit();
    }

    if($operacion == 'registrar_agenda_grupal'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroAgendaGrupal();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoAgenda->registrarAgendaGrupal($respuesta['datos_agenda']));

    }elseif($operacion == 'registrar_agenda_individual'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroAgendaIndividual();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoAgenda->registrarAgendaIndividual($respuesta['datos_agenda']));

    }elseif($operacion == 'actualizar_agenda'){
        $respuesta = $objetoServicio->sanitizarDatosActualizacionAgenda();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoAgenda->actualizarAgenda($respuesta['datos_agenda']));
    }

}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoAgenda = new AgendaModel();
    $objetoServicio = new AgendaService();
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
        echo json_encode($respuesta);
        exit();
        
    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Acceso Denegado'){
        header('Location: ../../acceso-denegado');
        exit();
    }

    if($operacion == 'eliminar_agenda'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['codigo_agenda'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoAgenda->eliminarAgenda($respuesta['parametros']['codigo_agenda']));

    }elseif($operacion == 'consultar_agenda'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['codigo_agenda'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoAgenda->consultarAgenda($respuesta['parametros']['codigo_agenda']));

    }elseif($operacion == 'consultar_agendas'){
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

        echo json_encode($objetoAgenda->consultarAgendas($respuesta['parametros']));
    }
}