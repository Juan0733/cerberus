<?php
namespace app\models;
use app\models\MainModel;
use app\models\UsuarioModel;
use DateTime;

class MovimientoModel extends MainModel{
    private $objetoUsuario;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

    public function registrarEntradaPeatonal($datosEntrada){
        $respuesta = $this->validarUsuarioAptoIngreso($datosEntrada['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $grupoUsuario = $respuesta['usuario']['grupo'];
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        if(!$datosEntrada['observacion']){
            $sentenciaInsertar = "INSERT INTO movimientos(tipo_movimiento, fk_usuario, puerta_registro, fecha_registro, fk_usuario_sistema, grupo_usuario) VALUES ('ENTRADA', '".$datosEntrada['numero_documento']."', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '$grupoUsuario')";
        }else{
            $sentenciaInsertar = "INSERT INTO movimientos(tipo_movimiento, fk_usuario, puerta_registro, observacion, fecha_registro, fk_usuario_sistema, grupo_usuario) VALUES ('ENTRADA', '".$datosEntrada['numero_documento']."', '$puertaActual', '".$datosEntrada['observacion']."', '$fechaRegistro', '$usuarioSistema', '$grupoUsuario')";
        }
       

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR", 
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosEntrada['numero_documento'], $grupoUsuario, 'DENTRO');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Registro Éxitoso',
            "mensaje"=> 'La entrada fue registrada correctamente.'
        ];
        return $respuesta;
    }

    public function validarUsuarioAptoIngreso($usuario){
        $respuesta = $this->objetoUsuario->consultarUsuario($usuario);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $datosUsuario = $respuesta['usuario'];
        if($datosUsuario['ubicacion'] == 'DENTRO'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Salida No Registrada',
                'mensaje' => 'Parece que a este usuario no se le registro una salida, porque el sistema indica que aún se encuentra dentro del CAB.'
            ];
            return $respuesta;
        }
        
        if($datosUsuario['grupo'] == 'aprendices'){
            $fechaActual = new DateTime();
            $fechaFinFicha = new DateTime($datosUsuario['fecha_fin_ficha']);
            if($fechaFinFicha < $fechaActual){
                $datosUsuario['motivo_ingreso'] = 'La ficha del aprendiz ha finalizado';
                $respuesta = $this->objetoUsuario->cambiarGrupoUsuario('aprendices', 'visitantes', $datosUsuario);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }

                $datosUsuario['grupo'] = 'visitantes';
            }

        }elseif($datosUsuario['grupo'] == 'funcionarios' && $datosUsuario['tipo_contrato'] == 'contratista'){
            $fechaActual = new DateTime();
            $fechaFinContrato = new DateTime($datosUsuario['fecha_fin_contrato']);
            if($fechaFinContrato < $fechaActual){
                $datosUsuario['motivo_ingreso'] = 'El contrato del funcionario ha finalizado';
                $this->objetoUsuario->cambiarGrupoUsuario('funcionarios', 'visitantes', $datosUsuario);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }

                $datosUsuario['grupo'] = 'visitantes';
            }
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Usuario Apto',
            'mensaje' => 'El usuario es apto, para registrar su ingreso al CAB.',
            'usuario' => $datosUsuario
        ];
        return $respuesta;
    }
}
