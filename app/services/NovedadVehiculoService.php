<?php
namespace app\services;

class NovedadVehiculoService{
    public function sanitizarDatosRegistroNovedadVehiculo(){
        if (!isset($_POST['documento_involucrado'], $_POST['propietario'], $_POST['tipo_novedad'], $_POST['numero_placa'],  $_POST['descripcion']) || $_POST['documento_involucrado'] == '' || $_POST['propietario'] == '' || $_POST['tipo_novedad'] == '' || $_POST['numero_placa'] == '' || $_POST['descripcion'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $documentoInvolucrado = $this->limpiarDatos($_POST['documento_involucrado']);
        $propietario = $this->limpiarDatos($_POST['propietario']);
        $numeroPlaca = $this->limpiarDatos($_POST['numero_placa']);
        $tipoNovedad = strtoupper($this->limpiarDatos($_POST['tipo_novedad']));
        $descripcion = $this->limpiarDatos($_POST['descripcion']);
        unset($_POST['documento_involucrado'], $_POST['propietario'], $_POST['numero_placa'], $_POST['tipo_novedad'], $_POST['descripcion']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $documentoInvolucrado
            ],
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $propietario
            ],
            [
                'filtro' => "(VEHICULO PRESTADO)",
                'cadena' => $tipoNovedad
            ],
            [
                'filtro' => "[A-Za-z0-9]{5,6}",
                'cadena' => $numeroPlaca
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

        $numeroPlaca = strtoupper($numeroPlaca);
        $descripcion = trim(ucfirst(strtolower($descripcion)));

        $datosNovedad = [
            'documento_involucrado' => $documentoInvolucrado,
            'propietario' => $propietario,
            'numero_placa' => $numeroPlaca,
            'tipo_novedad' => $tipoNovedad,
            'descripcion' => $descripcion
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_novedad" => $datosNovedad
        ];
        return $respuesta;
    }

     public function sanitizarParametros(){
        $parametros = [];

        if(isset($_GET['codigo_novedad'])){
            $codigoNovedad = $this->limpiarDatos($_GET['codigo_novedad']);
            unset($_GET['codigo_novedad']);

            if(preg_match('/^[A-Z0-9]{16}$/', $codigoNovedad)){
                $parametros['codigo_novedad'] = $codigoNovedad;
            }
        }

        if(isset($_GET['placa'])){
            $numeroPlaca = $this->limpiarDatos($_GET['placa']);
            unset($_GET['placa']);

            if(preg_match('/^[A-Za-z0-9]{1,}$/', $numeroPlaca)){
                $parametros['numero_placa'] = $numeroPlaca;
            }
        }

        if(isset($_GET['tipo_novedad'])){
            $tipoNovedad = $this->limpiarDatos($_GET['tipo_novedad']);
            unset($_GET['tipo_novedad']);

            if(preg_match('/^(VEHICULO PRESTADO)$/', $tipoNovedad)){
                $parametros['tipo_novedad'] = $tipoNovedad;
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
    