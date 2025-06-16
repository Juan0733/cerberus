<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";


use app\models\NovedadVehiculoModel;
use app\services\NovedadVehiculoService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
    $objetoNovedad= new NovedadVehiculoModel();
    $objetoServicio = new NovedadVehiculoService();

    $operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
    unset($_POST['operacion']);
    
    if($operacion == 'registrar_novedad_vehiculo') {
        $respuesta = $objetoServicio->sanitizarDatosNovedadVehiculo();
        if ($respuesta['tipo'] == 'ERROR') {
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoNovedad->registrarNovedadVehiculo($respuesta['datos_novedad']));
        
    } else {
        $respuesta = [
            "tipo" => "ERROR",
            "titulo" => 'Operación no válida',
            "mensaje" => 'Lo sentimos, la operación solicitada no es válida.'
        ];
        echo json_encode($respuesta);
    }

}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){

}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}