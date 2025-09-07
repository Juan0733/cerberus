<?php
namespace App\Services;

class MovimientoService{

    public function sanitizarDatosRegistroMovimientoPeatonal(){
        if (!isset($_POST['documento_peaton'], $_POST['observacion_peatonal']) || $_POST['documento_peaton'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
          return $respuesta;
        }

        $numeroDocumento = $this->limpiarDatos($_POST['documento_peaton']);
        $observacion = $this->limpiarDatos($_POST['observacion_peatonal']);
        unset($_POST['documento_peaton'], $_POST['observacion_peatonal']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{0,150}",
                'cadena' => $observacion
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

        $observacion = empty($observacion) ? 'NULL' : "'$observacion'";
        if($observacion != 'NULL'){
            $observacion = trim($observacion);
            $observacion = mb_strtoupper(mb_substr($observacion, 0, 2, "UTF-8"), "UTF-8").mb_strtolower(mb_substr($observacion, 2, null, "UTF-8"), "UTF-8");
        }

        $datosMovimiento = [
            'numero_documento' => $numeroDocumento,
            'observacion' => $observacion
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_movimiento" => $datosMovimiento
        ];
        return $respuesta;
    }

    public function sanitizarDatosRegistroMovimientoVehicular(){
        if (!isset($_POST['propietario'], $_POST['placa_vehiculo'], $_POST['tipo_vehiculo'], $_POST['pasajeros'], $_POST['observacion_vehicular']) || $_POST['propietario'] == '' || $_POST['placa_vehiculo'] == '' || $_POST['pasajeros'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $documentoPropietario = $this->limpiarDatos($_POST['propietario']);
        $placaVehiculo = $this->limpiarDatos($_POST['placa_vehiculo']);
        $tipoVehiculo = $this->limpiarDatos($_POST['tipo_vehiculo']);
        $pasajeros = json_decode($_POST['pasajeros'], true);
        $observacion = $this->limpiarDatos($_POST['observacion_vehicular']);
        unset($_POST['propietario'], $_POST['grupo_propietario'], $_POST['placa_vehiculo'], $_POST['pasajeros'], $_POST['observacion_vehicular']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $documentoPropietario
            ],
            [
                'filtro' => "[A-Za-z0-9 ]{5,6}",
                'cadena' => $placaVehiculo
            ],
            [
                'filtro' => "(AUTOMÓVIL|MOTO|CAMIÓN|BUS|)",
                'cadena' => $tipoVehiculo
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{0,150}",
                'cadena' => $observacion
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

        foreach ($pasajeros as &$pasajero) {
            if(!isset($pasajero['documento_pasajero']) || $pasajero['documento_pasajero'] == ''){
                $respuesta = [
                    "tipo" => "ERROR",
                    "titulo" => 'Campos Obligatorios',
                    "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
                ];
                return $respuesta;
            }
            $documentoPasajero = $this->limpiarDatos($pasajero['documento_pasajero']);

            $datos = [
                [
                    'filtro' => '[A-Za-z0-9]{6,15}',
                    'cadena' => $documentoPasajero
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

            $pasajero['documento_pasajero'] = $documentoPasajero;
        }

        $observacion = empty($observacion) ? 'NULL' : "'$observacion'";
        if($observacion != 'NULL'){
            $observacion = trim($observacion);
            $observacion = mb_strtoupper(mb_substr(trim($observacion), 0, 2, "UTF-8"), "UTF-8").mb_strtolower(mb_substr(trim($observacion), 2, null, "UTF-8"), "UTF-8");
        }

        $placaVehiculo = strtoupper($placaVehiculo);

        $datosMovimiento = [
            'propietario' => $documentoPropietario,
            'numero_placa' => $placaVehiculo,
            'tipo_vehiculo' => $tipoVehiculo,
            'pasajeros' => $pasajeros,
            'observacion' => $observacion
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_movimiento" => $datosMovimiento
        ];
        return $respuesta;
    }

    public function sanitizarParametros(){
        $parametros = [];

        if(isset($_GET['codigo_movimiento'])){
            $codigoMovimiento = $this->limpiarDatos($_GET['codigo_movimiento']);
            unset($_GET['codigo_movimiento']);

            if(preg_match('/^[A-Z0-9]{16}$/', $codigoMovimiento)){
                $parametros['codigo_movimiento'] = $codigoMovimiento;
            }
        }

        if(isset($_GET['puerta'])){
            $puerta = $this->limpiarDatos($_GET['puerta']);
            unset($_GET['puerta']);

            if(preg_match('/^(PEATONAL|PRINCIPAL|GANADERIA)$/', $puerta)){
                $parametros['puerta'] = $puerta;
            }
        }

        if(isset($_GET['fecha'])){
            $fecha = $this->limpiarDatos($_GET['fecha']);
            unset($_GET['fecha']);

            if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $fecha)){
                $parametros['fecha'] = $fecha;
            }
        }

        if(isset($_GET['jornada'])){
            $jornada = $this->limpiarDatos($_GET['jornada']);
            unset($_GET['jornada']);

            if(preg_match('/^(MAÑANA|TARDE|NOCHE)$/', $jornada)){
                $parametros['jornada'] = $jornada;
            }
        }

        if(isset($_GET['tipo_movimiento'])){
            $tipoMovimiento = $this->limpiarDatos($_GET['tipo_movimiento']);
            unset($_GET['tipo_movimiento']);

            if(preg_match('/^(ENTRADA|SALIDA)$/', $tipoMovimiento)){
                $parametros['tipo_movimiento'] = $tipoMovimiento;
            }
        }

        if(isset($_GET['fecha_inicio'])){
            $fechaInicio = $this->limpiarDatos($_GET['fecha_inicio']);
            unset($_GET['fecha_inicio']);

            if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $fechaInicio)){
                $parametros['fecha_inicio'] = $fechaInicio;
            }
        }

        if(isset($_GET['fecha_fin'])){
            $fechaFin = $this->limpiarDatos($_GET['fecha_fin']);
            unset($_GET['fecha_fin']);

            if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $fechaFin)){
                $parametros['fecha_fin'] = $fechaFin;
            }
        }

        if(isset($_GET['documento'])){
            $numeroDocumento = $this->limpiarDatos($_GET['documento']);
            unset($_GET['documento']);

            if(preg_match('/^[A-Za-z0-9]{6,15}$/', $numeroDocumento)){
                $parametros['numero_documento'] = $numeroDocumento;
            }
        }

        if(isset($_GET['placa'])){
            $placa = $this->limpiarDatos($_GET['placa']);
            unset($_GET['placa']);

            if(preg_match('/^[A-Za-z0-9]{3,6}$/', $placa)){
                $parametros['numero_placa'] = $placa;
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
    