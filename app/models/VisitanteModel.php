<?php
namespace App\Models;

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

        $ubicacion = 'FUERA';
        if(isset($respuesta['ubicacion'])){
            $ubicacion = $respuesta['ubicacion'];
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $sentenciaInsertar = "
            INSERT INTO visitantes(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, motivo_ingreso, ubicacion, fecha_registro) 
            VALUES('{$datosVisitante['tipo_documento']}', '{$datosVisitante['numero_documento']}', '{$datosVisitante['nombres']}', '{$datosVisitante['apellidos']}', '{$datosVisitante['telefono']}', '{$datosVisitante['correo_electronico']}', '{$datosVisitante['motivo_ingreso']}', '$ubicacion', '$fechaRegistro')";

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
            $tipoUsuario = $respuesta['usuario']['tipo_usuario'];
            if($tipoUsuario == 'VISITANTE'){
                $respuesta = [
                    'tipo' => "ERROR",
                    'titulo' => 'Usuario Existente',
                    'mensaje' => 'No fue posible realizar el registro, el usuario con número de documento '.$visitante.' ya se encuentra registrado en el sistema como visitante.'
                ];
                return $respuesta;
            }

            $tablaUsuario = $respuesta['usuario']['tabla_usuario'];
            $ubicacionActual = $respuesta['usuario']['ubicacion'];
            $respuesta = $this->objetoUsuario->eliminarUsuario($visitante, $tablaUsuario);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

            $respuesta['ubicacion'] = $ubicacionActual;
            return $respuesta;
        }

         $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Usuario No Existente',
            "mensaje"=> 'El usuario no se encuentra registrado en el sistema'
        ];
        return $respuesta;
    }

    public function consultarVisitantes($parametros){
        $sentenciaBuscar = "
            SELECT tipo_documento, numero_documento, nombres, apellidos, telefono, ubicacion
            FROM visitantes
            WHERE 1=1";

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND numero_documento LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['ubicacion'])){
            $sentenciaBuscar .= " AND ubicacion = '{$parametros['ubicacion']}'";
        }

        $sentenciaBuscar .= " ORDER BY fecha_registro DESC";

        if(!isset($parametros['ubicacion']) || $parametros['ubicacion'] != 'DENTRO'){
            $sentenciaBuscar .= " LIMIT 10;";
        }

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No Encontrados',
                "mensaje"=> 'No se encontraron resultados.'
            ];
            return $respuesta;
        }

        $visitantes = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
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
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Visitante No Encontrado',
                "mensaje"=> 'No se encontraron resultados del visitante'
            ];
            return $respuesta;
        }

        $visitante = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_visitante' => $visitante
        ];
        return $respuesta;
    }
}