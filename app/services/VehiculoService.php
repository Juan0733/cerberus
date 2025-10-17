<?php
namespace App\Services;

class VehiculoService extends MainService{

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
                'filtro' => "(AUTOMÓVIL|MOTO|CAMIÓN|BUS)",
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

            if(preg_match('/^[A-Za-z0-9]{3,6}$/', $numeroPlaca)){
                $parametros['numero_placa'] = $numeroPlaca;
            }
        }

        if(isset($_GET['documento'])){
            $numeroPlaca= $this->limpiarDatos($_GET['documento']);
            unset($_GET['documento']);

            if(preg_match('/^[A-Za-z0-9]{6,15}$/', $numeroPlaca)){
                $parametros['numero_documento'] = $numeroPlaca;
            }
        }

        if(isset($_GET['tipo'])){
            $tipoVehiculo= $this->limpiarDatos($_GET['tipo']);
            unset($_GET['tipo']);

            if(preg_match('/^(AUTOMÓVIL|CAMIÓN|BUSETA|MOTO)$/', $tipoVehiculo)){
                $parametros['tipo_vehiculo'] = $tipoVehiculo;
            }
        }

        if(isset($_GET['ubicacion'])){
            $ubicacion = $this->limpiarDatos($_GET['ubicacion']);
            unset($_GET['ubicacion']);

            if(preg_match('/^(DENTRO|FUERA)$/', $ubicacion)){
                $parametros['ubicacion'] = $ubicacion;
            }
        }

        if(isset($_GET['cantidad'])){
            $cantidadRegistros = $this->limpiarDatos($_GET['cantidad']);
            unset($_GET['cantidad']);

            if(preg_match('/^(5|10)$/', $cantidadRegistros)){
                $parametros['cantidad_registros'] = $cantidadRegistros;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
    }
}
