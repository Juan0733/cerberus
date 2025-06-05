<?php
namespace app\models; 

class NovedadVehiculoModel extends MainModel{
    private $objetoVehiculo;

    public function __construct() {
        $this->objetoVehiculo = new VehiculoModel();
    }

    public function registrarNovedadVehiculo($datosNovedad){
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaInsertar = "
            INSERT INTO novedades_vehiculos(tipo_novedad, fk_usuario_involucrado, fk_usuario_autoriza, fk_vehiculo, puerta_registro, descripcion, fecha_registro, fk_usuario_sistema) 
            VALUES('{$datosNovedad['tipo_novedad']}', '{$datosNovedad['documento_involucrado']}', '{$datosNovedad['propietario']}', '{$datosNovedad['numero_placa']}', '$puertaActual', '{$datosNovedad['descripcion']}', '$fechaRegistro', '$usuarioSistema');";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoVehiculo->consultarVehiculo($datosNovedad['numero_placa']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $datosVehiculo = $respuesta['vehiculo'];
        $datosVehiculo['propietario'] = $datosNovedad['documento_involucrado'];

        $respuesta = $this->objetoVehiculo->registrarVehiculo($datosVehiculo);
         if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Registro Éxitoso',
            'mensaje' => 'La novedad fue registrada correctamente',
        ];
        return $respuesta;
    }
}