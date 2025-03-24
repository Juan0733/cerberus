<?php
namespace app\ajax;

use app\controllers\AgendaController as AgendaController;

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";
require '../controllers/agendaController.php';


if (isset($_POST['modulo_agenda'])) {
    $insAgenda = new agendaController();

    if ($_POST['modulo_agenda'] == "registrar") {
        echo $insAgenda->registrarAgendaControlador();
    } elseif ($_POST['modulo_agenda'] == "buscar_persona") {
        $documento = $_POST['documento'] ?? '';
        echo $insAgenda->buscarPersonaDocumento();
    } elseif ($_POST['modulo_agenda'] == "listar") {
        /* echo $insAgenda->listarAgendaControlador(); */
    } elseif ($_POST['modulo_agenda'] == "editar") {
        $id_vigilante = $_POST['id_vigilante'];
        if (empty($id_vigilante)) {
            echo "Error al obtener los datos del vigilante";
        } else {
            header("Location: " . APP_URL_BASE . "editar-vigilante/" . $id_vigilante . "/");
        }
    }

   

}

