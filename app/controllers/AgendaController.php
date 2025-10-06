<?php
require_once "../../config/app.php";
require_once "../../vendor/autoload.php";

use App\Models\AgendaModel;
use App\Models\UsuarioModel;
use App\Models\RolOperacionModel;
use App\Services\AgendaService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	
	$objetoAgenda = new AgendaModel();
    $objetoServicio = new AgendaService();
    $objetoRolOperacion = new RolOperacionModel();
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

    if($operacion == 'registrar_agenda_carga_masiva'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroAgendaCargaMasiva();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoAgenda->registrarAgendaCargaMasiva($respuesta['datos_agenda']));

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