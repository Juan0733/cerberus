<?php
namespace app\models;
use app\models\MainModel;
use app\models\UsuarioModel;


class VisitanteModel extends MainModel{
    private $objetoUsuario;
    
    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

    public function registrarVisitante($datosVisitante){
        $respuesta = $this->objetoUsuario->consultarUsuario($datosVisitante['numero_documento']);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;
        }elseif($respuesta['tipo'] == 'OK'){
            $datosUsuario = $respuesta['usuario'];
            if($datosUsuario['grupo'] == 'visitantes'){
                $respuesta = [
                    'tipo' => "ERROR",
                    'titulo' => 'Usuario Existente',
                    'mensaje' => 'No fue posible realizar el registro, el usuario ya se encuentra registrado en el grupo de visitantes.'
                ];
                return $respuesta;
            }

            $respuesta = [
                'tipo' => "ERROR",
                'titulo' => 'Cambiar Grupo Usuario',
                'mensaje' => 'El usuario ya se encuentra registrado en el grupo de '.$datosVisitante['grupo'].', ¿Desea cambiarlo al grupo de visitantes?'
            ];
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:s:i');
        $sentenciaInsertar = "
        INSERT INTO visitantes(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, motivo_ingreso, fecha_registro) 
        VALUES('{$datosVisitante['tipo_documento']}', '{$datosVisitante['numero_documento']}', '{$datosVisitante['nombres']}', '{$datosVisitante['apellidos']}', '{$datosVisitante['telefono']}', '{$datosVisitante['correo_electronico']}', '{$datosVisitante['motivo_ingreso']}', '$fechaRegistro')";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Registro Éxitoso',
            "mensaje"=> 'El visitante fue registrado correctamente.'
        ];
        return $respuesta;
    }
}