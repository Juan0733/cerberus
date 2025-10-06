<?php
namespace App\Services;

class UsuarioService extends MainService{
    public function sanitizarUsuarioLogin(){
        if(!isset($_POST['usuario']) || $_POST['usuario'] == ''){
			$respuesta = [
				"tipo" => "ERROR",
				"titulo" => 'Campos Obligatorios',
				"mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
			];

			return $respuesta;
		}

		$usuario = $this->limpiarDatos($_POST['usuario']);
        unset($_POST['usuario']);

		$datos = [
			[
				'filtro' => "[A-Za-z0-9]{6,15}",
				'cadena' => $usuario
			]
		];

        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
                ];
                return $respuesta;
			}
        }

        $respuesta = [
            "tipo" => "OK",
            "usuario" => $usuario
        ];
        return $respuesta;
    }

    public function sanitizarDatosLogin(){
        if(!isset($_POST['usuario'], $_POST['contrasena']) || $_POST['usuario'] == '' || $_POST['contrasena'] == ''){
			$respuesta = [
				"tipo" => "ERROR",
				"titulo" => 'Campos Obligatorios',
				"mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.',
				"icono" => "warning",
				"cod_error"=> "350"
			];

			return $respuesta;
		}

		$usuario = $this->limpiarDatos($_POST['usuario']);
		$contrasena = $this->limpiarDatos($_POST['contrasena']);
        unset($_POST['usuario'], $_POST['contrasena']);

		$datos = [
			[
				'filtro' => "[a-zA-Z0-9]{6,15}",
				'cadena' => $usuario
			],
			[
				'filtro' => "[a-zA-Z0-9]{6,15}",
				'cadena' => $contrasena
			]
		];

        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
                ];
                return $respuesta;
			}
        }

        $datosLogin = [
			'usuario' => $usuario,
			'contrasena' => $contrasena
		];

        $respuesta = [
            "tipo" => "OK",
            "datos_login" => $datosLogin
        ];
        return $respuesta;
    }
}
    