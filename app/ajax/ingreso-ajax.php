<?php

namespace app\ajax;
use app\controllers\IngresoController as IngresoController;
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";
require '../controllers/ingresoController.php';

$insIngreso = new IngresoController();
// Verificar si se ha enviado una solicitud POST
if (isset($_POST['modulo_ingreso'])) {
        if ($_POST['modulo_ingreso'] == "ingreso_peatonal") {
            header("Location: ".APP_URL_BASE."ingreso-peatonal/");
        } elseif ($_POST['modulo_ingreso'] == "ingreso_vehicular") {
            header("Location: ".APP_URL_BASE."ingreso-vehicular/");
        } elseif ($_POST['modulo_ingreso'] == "ingreso_peatonal_registro") {
            echo $insIngreso->ingresoPeatonalControler("ENTRADA");
        }elseif ($_POST['modulo_ingreso'] == "salida_peatonal_registro") {
            echo $insIngreso->ingresoPeatonalControler("SALIDA");
        }elseif ($_POST['modulo_ingreso'] == "ingreso_vehicular_registro") {
            echo $insIngreso->ingresoVehicularControler("ENTRADA");
        }elseif ($_POST['modulo_ingreso'] == "salida_vehicular_registro") {
            echo $insIngreso->ingresoVehicularControler("SALIDA");
        }elseif ($_POST['modulo_ingreso'] == "novedades_entrada_salida") {
            if ($_POST['modulo_ingreso_tipo']=="entrada") {
                echo $insIngreso->novedadesPersona("ENTRADA");
            } else if ($_POST['modulo_ingreso_tipo']=="salida") {
                echo $insIngreso->novedadesPersona("SALIDA");
            }
        }else{
            session_destroy();
            header("Location: " . APP_URL_BASE . "login/");
        }
}
if (isset($_POST['modulo_ingreso_extra'])) {
    if ($_POST['modulo_ingreso_extra'] == "ingreso_pasajero_registro") {
        echo $insIngreso->buscarPasajero("ENTRADA");
    }elseif ($_POST['modulo_ingreso_extra'] == "salida_pasajero_registro") {
        echo $insIngreso->buscarPasajero("SALIDA");
    }elseif ($_POST['modulo_ingreso_extra'] == "placa_conductor") {
    if (isset($_POST['tipo'])) {
        echo $insIngreso->placaConductor($_POST['tipo']);
    }
    }
}
if (isset($_POST['lista_reportes'])) {
    if ($_POST['lista_reportes'] == "ENTRADA") {
        echo $insIngreso->listarReportes("ENTRADA");
    }elseif ($_POST['lista_reportes'] == "SALIDA") {
        echo $insIngreso->listarReportes("SALIDA");
    }
}
if (!isset($_POST['modulo_ingreso'])&&!isset($_POST['lista_reportes'])&&!isset($_POST['modulo_ingreso_extra'])) {
    session_destroy();
    header("Location: " . APP_URL_BASE . "login/");
}

?>