<?php

namespace app\models; 
use app\models\MainModel;
use DateTime;

class NovedadUsuarioModel extends MainModel{
    private $objetoUsuario;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

    public function registrarNovedadUsuario($datosNovedad){
        $respuesta = $this->objetoUsuario->consultarUsuario($datosNovedad['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $tablaUsuario = $respuesta['usuario']['grupo'];
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $codigoNovedad = 'NU'.date('YmdHis');

        $sentenciaInsertar = "
            INSERT INTO novedades_usuarios(codigo_novedad, tipo_novedad, fk_usuario, fecha_suceso, puerta_suceso, puerta_registro, descripcion, fecha_registro, fk_usuario_sistema) 
            VALUES('$codigoNovedad', '{$datosNovedad['tipo_novedad']}', '{$datosNovedad['numero_documento']}', '{$datosNovedad['fecha_suceso']}', '{$datosNovedad['puerta_suceso']}', '$puertaActual', '{$datosNovedad['descripcion']}', '$fechaRegistro', '$usuarioSistema')";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

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
            WHERE DATE(nu.fecha_registro) = '{$parametros['fecha']}'";

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND nu.fk_usuario LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['tipo_novedad'])){
            $sentenciaBuscar .= " AND nu.tipo_novedad = '{$parametros['tipo_novedad']}'";
        }

        $sentenciaBuscar .= " ORDER BY nu.fecha_registro DESC LIMIT 10;";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No Encontrados',
                "mensaje"=> 'No se encontraron resultados.'
            ];
            return $respuesta;
        }

        $novedades = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
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
                vig1.nombres AS nombres_responsable,
                vig1.apellidos AS apellidos_responsable,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres_involucrado,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos_involucrado
            FROM novedades_usuarios nu
            INNER JOIN vigilantes vig1 ON nu.fk_usuario_sistema = vig1.numero_documento
            LEFT JOIN funcionarios fun ON nu.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON nu.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON nu.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON nu.fk_usuario = apr.numero_documento
            WHERE nu.codigo_novedad = '$codigoNovedad'";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Novedad No Encontrada',
                "mensaje"=> 'No se encontraron resultados de la novedad'
            ];
            return $respuesta;
        }

        $novedad = $respuestaSentencia->fetch_assoc();
        $respuesta = [
            'tipo' => 'OK',
            'datos_novedad' => $novedad
        ];
        return $respuesta;
    }
}