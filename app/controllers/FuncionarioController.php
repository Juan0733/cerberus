<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\FuncionarioModel;
use app\services\FuncionarioService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	
	$objetoFuncionario = new FuncionarioModel();
    $objetoServicio = new FuncionarioService();

    $operacion = $objetoServicio->limpiarDatos($_POST['operacion']);

}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoFuncionario = new FuncionarioModel();
    $objetoServicio = new FuncionarioService();

    $operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
    if($operacion == 'consultar_funcionarios'){
        $respuesta = $objetoServicio->sanitizarParametros();
        
        echo json_encode($objetoFuncionario->consultarFuncionarios($respuesta['parametros']));
    }
}