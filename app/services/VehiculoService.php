<?php
namespace app\services;

class VehiculoService{


    public function sanitizarDatosRegistroVehiculo(){
        if (!isset($_POST['propietario'], $_POST['numero_placa'], $_POST['tipo_vehiculo']) || $_POST['propietario'] == '' || $_POST['numero_placa'] == '' || $_POST['tipo_vehiculo'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
          return $respuesta;
        }

        $propietario = $this->limpiarDatos($_POST['propietario']);
        $numeroPlaca = $this->limpiarDatos($_POST['numero_placa']);
        $tipoVehiculo = $this->limpiarDatos($_POST['tipo_vehiculo']);
        unset($_POST['propietario'], $_POST['numero_placa'], $_POST['tipo_vehiculo']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $propietario
            ],
            [
                'filtro' => "[A-Za-z0-9]{5,6}",
                'cadena' => $numeroPlaca
            ],
            [
                'filtro' => "(Automóvil|Moto|Camión|Bus)",
                'cadena' => $tipoVehiculo
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

        $numeroPlaca = strtoupper($numeroPlaca);

        $datosVehiculo = [
            'propietario' => $propietario,
            'numero_placa' => $numeroPlaca,
            'tipo_vehiculo' => $tipoVehiculo
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_vehiculo" => $datosVehiculo
        ];
        return $respuesta;
    }
	
    public function sanitizarParametros(){
        $parametros = [];

        if(isset($_GET['placa'])){
            $numeroPlaca= $this->limpiarDatos($_GET['placa']);
            unset($_GET['placa']);

            if(preg_match('/^[A-Za-z0-9]{1,6}$/', $numeroPlaca)){
                $parametros['numero_placa'] = strtoupper($numeroPlaca);
            }
        }

        if(isset($_GET['documento'])){
            $numeroPlaca= $this->limpiarDatos($_GET['documento']);
            unset($_GET['documento']);

            if(preg_match('/^[A-Za-z0-9]{1,15}$/', $numeroPlaca)){
                $parametros['numero_documento'] = strtoupper($numeroPlaca);
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
