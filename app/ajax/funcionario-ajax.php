<?php

namespace app\ajax;
use app\controllers\FuncionarioController as FuncionarioController;
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";
require '../controllers/funcionarioController.php';

// Verificar si se ha enviado una solicitud POST
if (isset($_POST['modulo_funcionario'])) {
    $insFuncionario = new FuncionarioController();
    
        // Manejar el registro de funcionarios
        if ($_POST['modulo_funcionario'] == "registro") {
            echo $insFuncionario->registrarFuncionarioControler();
        } elseif ($_POST['modulo_funcionario'] == "inhabilitar") {
            $id_funcionario = $_POST['id_funcionario'];
            echo $insFuncionario->llamarMetodo($id_funcionario, "FN");
        } elseif ($_POST['modulo_funcionario'] == "habilitar") {
            $id_funcionario = $_POST['id_funcionario'];
            echo $insFuncionario->habilitarFuncionarioController($id_funcionario);
        } elseif  ($_POST['modulo_funcionario'] == "actualizar") {
            echo $insFuncionario->editarFuncionarioController();
        } elseif($_POST['modulo_funcionario'] == "editar") {
            $id_funcionario = $_POST['id_funcionario'];
			if (empty($id_funcionario)) {
                echo "Error al obtener los datos del funcionario";
            } else {
                header("Location: ".APP_URL_BASE."editar-funcionario/".$id_funcionario."/");
            }
        }
}
if (isset($_POST['filtro'])) {
    $insFuncionario = new FuncionarioController();
        echo $insFuncionario->listarFuncionarioControler();
} 
if (!isset($_POST['modulo_funcionario']) && !isset($_POST['filtro'])) {
    session_destroy();
    header("Location: " . APP_URL_BASE . "login/");
}
?>