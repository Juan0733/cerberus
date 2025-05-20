<?php

namespace app\models; 
use app\models\MainModel;

class NovedadUsuarioModel extends MainModel{
    private $objetoUsuario;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

   
    public function registrarNovedadUsuario($datosNovedad){
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaInsertar = "
            INSERT INTO novedades_usuarios(tipo_novedad, fk_usuario, fecha_suceso, puerta_suceso, puerta_registro, descripcion, fecha_registro, fk_usuario_sistema) 
            VALUES('".$datosNovedad['tipo_novedad']."', '".$datosNovedad['numero_documento']."', '".$datosNovedad['fecha_suceso']."', '".$datosNovedad['puerta_suceso']."', '$puertaActual', '".$datosNovedad['descripcion']."', '$fechaRegistro', '$usuarioSistema')";

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
            ];
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->consultarUsuario($datosNovedad['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $tablaUsuario = $respuesta['usuario']['grupo'];

        if($datosNovedad['tipo_novedad'] == 'SALIDA NO REGISTRADA'){
            $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosNovedad['numero_documento'], $tablaUsuario, 'FUERA');
        }elseif($datosNovedad['tipo_novedad'] == 'ENTRADA NO REGISTRADA'){
            $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosNovedad['numero_documento'], $tablaUsuario, 'DENTRO');
        }

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