<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\VisitanteModel;
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion']) && $_POST['operacion'] != "") {
	
	$objetoVisitante = new VisitanteModel();
	$operacion = $objetoVisitante->limpiarDatos($_POST['operacion']);

	if($operacion == 'registrar_visitante'){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['documento_visitante'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['motivo_ingreso']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['tipo_documento'] == '' || $_POST['documento_visitante'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['motivo_ingreso'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];

            echo json_encode($respuesta);
            exit();
        }

        $tipoDocumento = $objetoVisitante->limpiarDatos($_POST['tipo_documento']);
        $numeroDocumento = $objetoVisitante->limpiarDatos($_POST['documento_visitante']);
        $nombres = $objetoVisitante->limpiarDatos($_POST['nombres']);
        $apellidos = $objetoVisitante->limpiarDatos($_POST['apellidos']);
        $telefono = $objetoVisitante->limpiarDatos($_POST['telefono']);
        $correoElectronico = $objetoVisitante->limpiarDatos($_POST['correo_electronico']);
        $motivoIngreso = $objetoVisitante->limpiarDatos($_POST['motivo_ingreso']);
		
		$datos = [
			[
				'filtro' => "[A-Z]{2,3}",
				'cadena' => $tipoDocumento
            ],
            [
				'filtro' => "[A-Za-z0-9]{6,15}",
				'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-z ]{2,50}",
                'cadena' => $nombres
            ],
            [
                'filtro' => "[A-Za-z ]{2,50}",
                'cadena' => $apellidos
            ],
            [
                'filtro' => "[0-9]{10}",
                'cadena' => $telefono
            ],
            [
                'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{11,64}",
                'cadena' => $correoElectronico
            ],
            [
                'filtro' => "[A-Za-z0-9 ]{5,100}",
                'cadena' => $motivoIngreso
            ]
		];

		if(!$objetoVisitante->verificarDatos($datos)){
			$respuesta = [
				"tipo" => "ERROR",
				'titulo' => "Formato Inválido",
				'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida."
			];

			echo json_encode($respuesta);
			exit();
		}

        $datosVisitante = [
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'motivo_ingreso' => $motivoIngreso
        ];

		echo json_encode($objetoVisitante->registrarVisitante($datosVisitante));
        
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion']) && $_GET['operacion'] != '' ){
	
	
}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}