<?php
namespace app\services;

class UsuarioService{
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
        if(!isset($_POST['usuario'], $_POST['contrasena'], $_POST['tabla']) || $_POST['usuario'] == '' || $_POST['contrasena'] == '' || $_POST['tabla'] == ''){
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
		$tabla = $this->limpiarDatos($_POST['tabla']);
        unset($_POST['usuario'], $_POST['contrasena'], $_POST['tabla']);

		$datos = [
			[
				'filtro' => "[a-zA-Z0-9]{6,15}",
				'cadena' => $usuario
			],
			[
				'filtro' => "[a-zA-Z0-9]{6,15}",
				'cadena' => $contrasena
			],
			[
				'filtro' => "(vigilantes|funcionarios)",
				'cadena' => $tabla
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
			'contrasena' => $contrasena,
			'tabla' => $tabla
		];

        $respuesta = [
            "tipo" => "OK",
            "datos_login" => $datosLogin
        ];
        return $respuesta;
    }

    public function limpiarDatos($dato){
		$palabras=["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==",";","::"];


		$dato=trim($dato);
		$dato=stripslashes($dato);

		foreach($palabras as $palabra){
			$dato=str_ireplace($palabra, "", $dato);
		}

		$dato=trim($dato);
		$dato=stripslashes($dato);

		return $dato;
	}
    
}
    