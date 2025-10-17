<?php
namespace App\Models;

use DateTime;

class NovedadUsuarioModel extends MainModel{
    private $objetoUsuario;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

    public function registrarNovedadUsuario($datosNovedad){
        $respuesta = $this->validarUsuarioAptoNovedad($datosNovedad['numero_documento'], $datosNovedad['tipo_novedad']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        
        $tablaUsuario = $respuesta['tabla_usuario'];

        if(!isset($_SESSION['datos_usuario']['puerta'])){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Puerta Actual',
                'mensaje' => 'Lo sentimos, pero es necesario que selecciones la puerta en la que estás actualmente. ¿Deseas seleccionar la puerta actual?'
            ];
            return $respuesta;
        }

        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $rolSistema = $_SESSION['datos_usuario']['rol'];
        $codigoNovedad = 'NU'.date('YmdHis');

        $sentenciaInsertar = "
            INSERT INTO novedades_usuarios(codigo_novedad, tipo_novedad, fk_usuario, fecha_suceso, puerta_suceso, puerta_registro, descripcion, fecha_registro, rol_usuario_sistema, fk_usuario_sistema) 
            VALUES('$codigoNovedad', '{$datosNovedad['tipo_novedad']}', '{$datosNovedad['numero_documento']}', '{$datosNovedad['fecha_suceso']}', '{$datosNovedad['puerta_suceso']}', '$puertaActual', '{$datosNovedad['descripcion']}', '$fechaRegistro', '$rolSistema', '$usuarioSistema')";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        if($datosNovedad['tipo_novedad'] == 'SALIDA NO REGISTRADA'){
            $ubicacion = 'FUERA';

        }elseif($datosNovedad['tipo_novedad'] == 'ENTRADA NO REGISTRADA'){
            $ubicacion = 'DENTRO';
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosNovedad['numero_documento'], $tablaUsuario, $ubicacion);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Registro Exitoso',
            'mensaje' => 'La novedad fue registrada correctamente.',
        ];
        return $respuesta;
    }

    private function validarUsuarioAptoNovedad($usuario, $tipoNovedad){
        $respuesta = $this->objetoUsuario->consultarUsuario($usuario);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $usuario = $respuesta['usuario'];

        if($tipoNovedad == 'ENTRADA NO REGISTRADA'){
            if($usuario['ubicacion'] == 'DENTRO'){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Ubicación Incorrecta',
                    'mensaje' => 'Lo sentimos, pero no es posible registrar la novedad, el usuario se encuentra dentro del CAB.'
                ];
                return $respuesta;
            }

        }elseif($tipoNovedad == 'SALIDA NO REGISTRADA'){
            if($usuario['ubicacion'] == 'FUERA'){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Ubicación Incorrecta',
                    'mensaje' => 'Lo sentimos, pero no es posible registrar la novedad, el usuario no se encuentra dentro del CAB.'
                ];
                return $respuesta;
            }
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Usuario Apto',
            'mensaje' => 'El usuario es apto para registrarle una novedad.',
            'tabla_usuario' => $usuario['tabla_usuario']
        ];
        return $respuesta;
    }

    public function consultarNovedadesUsuario($parametros){
        $sentenciaBuscar = "
            SELECT 
                nu.codigo_novedad, 
                nu.tipo_novedad, puerta_suceso, 
                nu.fecha_registro, 
                nu.fk_usuario,
                nu.fk_usuario_sistema,
                COALESCE(fun.tipo_documento, apr.tipo_documento, vis.tipo_documento, vig.tipo_documento) AS tipo_documento,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos
            FROM novedades_usuarios nu
            LEFT JOIN funcionarios fun ON nu.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON nu.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON nu.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON nu.fk_usuario = apr.numero_documento
            WHERE 1 = 1";

        if(isset($parametros['fecha'])){
            $sentenciaBuscar .= " AND DATE(nu.fecha_registro) = '{$parametros['fecha']}'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND nu.fk_usuario LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['tipo_novedad'])){
            $sentenciaBuscar .= " AND nu.tipo_novedad = '{$parametros['tipo_novedad']}'";
        }

        $sentenciaBuscar .= " ORDER BY nu.fecha_registro DESC";

        if(isset($parametros['cantidad_registros'])){
            $sentenciaBuscar .= " LIMIT {$parametros['cantidad_registros']};";
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

        $novedades = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'novedades' => $novedades
        ];
        return $respuesta;
    }

    public function consultarNovedadUsuario($codigoNovedad){
        $sentenciaBuscar = "
            SELECT 
                nu.tipo_novedad, 
                nu.puerta_registro, 
                nu.puerta_suceso, 
                nu.fecha_suceso, 
                nu.fecha_registro,
                nu.descripcion,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres_involucrado,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos_involucrado,
                COALESCE(fun2.nombres, apr2.nombres, vis2.nombres, vig2.nombres) AS nombres_responsable,
                COALESCE(fun2.apellidos, apr2.apellidos, vis2.apellidos, vig2.apellidos) AS apellidos_responsable,
                nu.rol_usuario_sistema AS rol_responsable
            FROM novedades_usuarios nu
            LEFT JOIN funcionarios fun ON nu.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON nu.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON nu.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON nu.fk_usuario = apr.numero_documento
            LEFT JOIN funcionarios fun2 ON nu.fk_usuario_sistema = fun2.numero_documento
            LEFT JOIN visitantes vis2 ON nu.fk_usuario_sistema = vis2.numero_documento
            LEFT JOIN vigilantes vig2 ON nu.fk_usuario_sistema = vig2.numero_documento
            LEFT JOIN aprendices apr2 ON nu.fk_usuario_sistema = apr2.numero_documento
            WHERE nu.codigo_novedad = '$codigoNovedad'";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Novedad No Encontrada',
                "mensaje"=> 'No se encontraron resultados de la novedad'
            ];
            return $respuesta;
        }

        $novedad = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_novedad' => $novedad
        ];
        return $respuesta;
    }
}