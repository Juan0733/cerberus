<?php
namespace app\models;

class VisitanteModel extends MainModel{
    private $objetoUsuario;
    private $objetoMotivo;
    
    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
        $this->objetoMotivo = new MotivoIngresoModel();
    }

    public function registrarVisitante($datosVisitante){
        $respuesta = $this->validarDuplicidadVisitante($datosVisitante['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $sentenciaInsertar = "
            INSERT INTO visitantes(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, motivo_ingreso, fecha_registro) 
            VALUES('{$datosVisitante['tipo_documento']}', '{$datosVisitante['numero_documento']}', '{$datosVisitante['nombres']}', '{$datosVisitante['apellidos']}', '{$datosVisitante['telefono']}', '{$datosVisitante['correo_electronico']}', '{$datosVisitante['motivo_ingreso']}', '$fechaRegistro')";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        if($datosVisitante['motivo_ingreso'] != 'La ficha del aprendiz ha finalizado' && $datosVisitante['motivo_ingreso'] != 'El contrato del funcionario ha finalizado'){
            $respuesta = $this->objetoMotivo->registrarMotivoIngreso($datosVisitante['motivo_ingreso']);
            if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
                return $respuesta;
            }
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Registro Exitoso',
            "mensaje"=> 'El visitante fue registrado correctamente.'
        ];
        return $respuesta;
    }

    private function validarDuplicidadVisitante($visitante){
        $respuesta = $this->objetoUsuario->consultarUsuario($visitante);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'OK'){
            $grupoUsuario = $respuesta['usuario']['grupo'];
            if($grupoUsuario == 'visitantes'){
                $respuesta = [
                    'tipo' => "ERROR",
                    'titulo' => 'Usuario Existente',
                    'mensaje' => 'No fue posible realizar el registro, el usuario ya se encuentra registrado en el sistema como visitante.'
                ];
                return $respuesta;
            }

            $respuesta = $this->objetoUsuario->eliminarUsuario($visitante, $grupoUsuario);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }

         $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Usuario No Existente',
            "mensaje"=> 'El visitante no se encuentra registrado en el sistema'
        ];
        return $respuesta;
    }

    public function consultarVisitantes($parametros){
        $sentenciaBuscar = "
            SELECT tipo_documento, numero_documento, nombres, apellidos, telefono, ubicacion
            FROM visitantes
            WHERE 1=1";

        if(isset($parametros['ubicacion'])){
            $sentenciaBuscar .= " AND ubicacion = '{$parametros['ubicacion']}'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND numero_documento = '{$parametros['numero_documento']}'";
        }

        $sentenciaBuscar .= " ORDER BY fecha_registro DESC LIMIT 10";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No encontrados',
                "mensaje"=> 'No se encontraron resultados.'
            ];
            return $respuesta;
        }

        $visitantes = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $respuesta = [
            'tipo' => 'OK',
            'visitantes' => $visitantes
        ];
        return $respuesta;
    }

    public function consultarVisitante($documento){
        $sentenciaBuscar = "
            SELECT tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, motivo_ingreso
            FROM visitantes
            WHERE numero_documento = '$documento';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No encontrados',
                "mensaje"=> 'No se encontraron resultados.'
            ];
            return $respuesta;
        }

        $visitante = $respuestaSentencia->fetch_assoc();
        $respuesta = [
            'tipo' => 'OK',
            'datos_visitante' => $visitante
        ];
        return $respuesta;
    }
}