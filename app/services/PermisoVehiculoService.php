<?php
namespace app\services;

class PermisoVehiculoService{
    public function sanitizarDatosRegistroPermisoVehiculo(){
        if(!isset($_POST['propietario'], $_POST['numero_placa'], $_POST['tipo_permiso'], $_POST['descripcion'], $_POST['fecha_fin_permiso']) || $_POST['propietario'] == '' || $_POST['numero_placa'] == '' || $_POST['tipo_permiso'] == '' || $_POST['descripcion'] == '' || $_POST['fecha_fin_permiso'] == '' ) {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'.implode(' ',$_POST)
            ];
            return $respuesta;
        }

        $numeroDocumento = $this->limpiarDatos($_POST['propietario']);
        $numeroPlaca = $this->limpiarDatos($_POST['numero_placa']);
        $tipoPermiso = $this->limpiarDatos($_POST['tipo_permiso']);
        $descripcion = $this->limpiarDatos($_POST['descripcion']);
        $fechaFinPermiso = $this->limpiarDatos($_POST['fecha_fin_permiso']);
        unset($_POST['propietario'], $_POST['numero_placa'], $_POST['descripcion'], $_POST['fecha_fin_permiso']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-z0-9]{5,6}",
                'cadena' => $numeroPlaca
            ],
            [
                'filtro' => "(PERMANENCIA)",
                'cadena' => $tipoPermiso
            ],
            [
                'filtro' => "[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])",
                'cadena' => $fechaFinPermiso
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,150}",
                'cadena' => $descripcion	
            ]
        ];

        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.".$dato['cadena'],
                ];
                return $respuesta;
			}
        }

        $descripcion = trim(ucfirst(strtolower($descripcion)));

        $datosPermiso = [
            'numero_documento' => $numeroDocumento,
            'numero_placa' => $numeroPlaca,
            'tipo_permiso' => $tipoPermiso,
            'descripcion' => $descripcion,
            'fecha_fin_permiso' => $fechaFinPermiso,
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_permiso" => $datosPermiso
        ];
        return $respuesta;
    }

    public function sanitizarParametros(){
        $parametros = [];

        if(isset($_GET['codigo_permiso'])){
            $codigoPermiso = $this->limpiarDatos($_GET['codigo_permiso']);
            unset($_GET['codigo_permiso']);

            if(preg_match('/^[A-Z0-9]{16}$/', $codigoPermiso)){
                $parametros['codigo_permiso'] = $codigoPermiso;
            }
        }

        if(isset($_GET['tipo_permiso'])){
            $tipoPermiso = $this->limpiarDatos($_GET['tipo_permiso']);
            unset($_GET['tipo_permiso']);

            if(preg_match('/^(PERMANENCIA)$/', $tipoPermiso)){
                $parametros['tipo_permiso'] = $tipoPermiso;
            }
        }

        if(isset($_GET['placa'])){
            $numeroPlaca = $this->limpiarDatos($_GET['placa']);
            unset($_GET['placa']);

            if(preg_match('/^[A-Za-z0-9]{1,15}$/', $numeroPlaca)){
                $parametros['numero_placa'] = $numeroPlaca;
            }
        }

        if(isset($_GET['estado'])){
            $estadoPermiso = $this->limpiarDatos($_GET['estado']);
            unset($_GET['estado']);

            if(preg_match('/^(APROBADO|DESAPROBADO|PENDIENTE)$/', $estadoPermiso)){
                $parametros['estado_permiso'] = $estadoPermiso;
            }
        }

        if(isset($_GET['fecha'])){
            $fecha = $this->limpiarDatos($_GET['fecha']);
            unset($_GET['ficha']);

            if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $fecha)){
                $parametros['fecha'] = $fecha;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
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
    