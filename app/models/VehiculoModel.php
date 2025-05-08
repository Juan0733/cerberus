<?php

namespace app\models; 
use app\models\MainModel;

class VehiculoModel extends MainModel {

    public function conteoTipoVehiculo(){
        $tiposVehiculo = ["carros", "motos"];
        $vehiculos = [];
        $totalVehiculos = 0;

        foreach($tiposVehiculo as $tipo) {
            if($tipo == "carros"){
                $sentenciaBuscar = "SELECT contador FROM vehiculos WHERE tipo_vehiculo <> 'MT' AND ubicacion = 'DENTRO';";
            }else{
                $sentenciaBuscar = "SELECT contador FROM vehiculos WHERE tipo_vehiculo = 'MT' AND ubicacion = 'DENTRO';";
            }

            $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
            if (!$respuestaSentencia) {
                $respuesta = [
                    "tipo"=>"ERROR",
                    "titulo" => 'Error de Conexión',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
                ];
                return $respuesta;    
            }

            $cantidad = $respuestaSentencia->num_rows;
            $vehiculos[] = [
                'tipo_vehiculo' => $tipo,
                'cantidad' => $cantidad
            ];
            $totalVehiculos += $cantidad;
        }

        foreach ($vehiculos as &$vehiculo) {
            // Se calcula el porcentaje de cada tipo de vehiculo que se encuentran dentro del sena sobre el total general de vehiculos.
            if($vehiculo['cantidad'] < 1){
                $porcentaje = 0;
            }else{
                $porcentaje = $vehiculo['cantidad']*100/$totalVehiculos;
            }

            $vehiculo['porcentaje'] = $porcentaje;
        }

        $respuesta = [
            'tipo' => "OK",
            'titulo'=> "Conteo Éxitoso",
            'mensaje' => "El conteo de vehiculos fue realizado con éxito.",
            'vehiculos' => $vehiculos
        ];
        return $respuesta;
    }

    
}