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
        $usuarioSistema = 'NULL';
        $rolSistema = 'NULL';

        if(isset($_SESSION['datos_usuario'])){
            $usuarioSistema = "'{$_SESSION['datos_usuario']['numero_documento']}'";
            $rolSistema = "'{$_SESSION['datos_usuario']['rol']}'";
        }

        $sentenciaInsertar = "
            INSERT INTO visitantes(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, motivo_ingreso, ubicacion, fecha_registro, rol_usuario_sistema, fk_usuario_sistema) 
            VALUES('{$datosVisitante['tipo_documento']}', '{$datosVisitante['numero_documento']}', '{$datosVisitante['nombres']}', '{$datosVisitante['apellidos']}', '{$datosVisitante['telefono']}', '{$datosVisitante['correo_electronico']}', '{$datosVisitante['motivo_ingreso']}', '$ubicacion', '$fechaRegistro', $rolSistema, $usuarioSistema)";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoMotivo->registrarMotivoIngreso($datosVisitante['motivo_ingreso']);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;
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

        if(!isset($parametros['numero_documento'], $parametros['ubicacion'])){
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
            SELECT 
                vis.tipo_documento, 
                vis.numero_documento, 
                vis.nombres, 
                vis.apellidos, 
                vis.telefono, 
                vis.correo_electronico,
                vis.motivo_ingreso,
                COALESCE(fun.nombres, apr.nombres, vis2.nombres, vig.nombres, 'N/A') AS nombres_responsable,
                COALESCE(fun.apellidos, apr.apellidos, vis2.apellidos, vig.apellidos, 'N/A') AS apellidos_responsable,
                COALESCE(vis.rol_usuario_sistema, 'N/A') AS rol_responsable
            FROM visitantes vis
            LEFT JOIN funcionarios fun ON vis.fk_usuario_sistema = fun.numero_documento
            LEFT JOIN aprendices apr ON vis.fk_usuario_sistema = apr.numero_documento
            LEFT JOIN vigilantes vig ON vis.fk_usuario_sistema = vig.numero_documento
            LEFT JOIN visitantes vis2 ON vis.fk_usuario_sistema = vis2.numero_documento
            WHERE vis.numero_documento = '$documento';";

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