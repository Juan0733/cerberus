<?php
namespace app\models;
use app\models\MainModel;

class AprendizModel extends MainModel{
    private $objetoUsuario;
    private $objetoVisitante;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

   
    public function eliminarAprendiz($aprendiz){
        $sentenciaEliminar = "DELETE FROM aprendices WHERE numero_identificacion = '$aprendiz'";

        $respuesta = $this->ejecutarConsulta($sentenciaEliminar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Eliminación Éxitosa',
            'mensaje' => 'El aprendiz fue eliminado correctamente',
            'icon' => ''
        ];
        return $respuesta;
    }
}