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

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaEliminar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                "icono" => "warning",
            ];
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