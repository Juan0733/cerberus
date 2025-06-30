<?php

namespace app\models; 

class PermisoUsuarioModel extends MainModel{
    private $objetoUsuario;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

    public function registrarPermisoUsuario($datosPermiso){
        $respuesta = $this->objetoUsuario->consultarUsuario($datosPermiso['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $codigoPermiso = 'PU'.date('YmdHis');

        $sentenciaInsertar = "
            INSERT INTO permisos_usuarios(codigo_permiso, tipo_permiso, fk_usuario, descripcion, fecha_fin_permiso, fecha_registro, fk_usuario_sistema) 
            VALUES('$codigoPermiso', '{$datosPermiso['tipo_permiso']}', '{$datosPermiso['numero_documento']}', '{$datosPermiso['descripcion']}', '{$datosPermiso['fecha_fin_permiso']}', '$fechaRegistro', '$usuarioSistema')";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Registro Exitoso',
            'mensaje' => 'El permiso se registro correctamente.',
        ];
        return $respuesta;
    }

    public function aprobarPermisoUsuario($codigoPermiso){
        $fechaActual = date('Y-m-d H:i:s');

        $sentenciaActualizar = "
            UPDATE permisos_usuarios 
            SET estado_permiso = 'APROBADO', fecha_aprobacion = '$fechaActual'
            WHERE codigo_permiso = '$codigoPermiso';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Aprobación Exitosa',
            'mensaje' => 'El permiso fue aprobado exitosamente.'
        ];
        return $respuesta;
    }

     public function desaprobarPermisoUsuario($codigoPermiso){
        $fechaActual = date('Y-m-d H:i:s');

        $sentenciaActualizar = "
            UPDATE permisos_usuarios 
            SET estado_permiso = 'DESAPROBADO', fecha_desaprobacion = '$fechaActual'
            WHERE codigo_permiso = '$codigoPermiso';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Desaprobación Exitosa',
            'mensaje' => 'El permiso fue desaprobado exitosamente.'
        ];
        return $respuesta;
    }


    public function consultarPermisosUsuarios($parametros){
        $sentenciaBuscar = "
            SELECT 
                ppu.codigo_permiso,
                ppu.tipo_permiso, 
                ppu.estado_permiso,
                ppu.fecha_registro,
                ppu.fk_usuario,
                ppu.fk_usuario_sistema,
                COALESCE(fun.tipo_documento, apr.tipo_documento, vis.tipo_documento, vig.tipo_documento) AS tipo_documento,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos
            FROM permisos_usuarios ppu
            LEFT JOIN funcionarios fun ON ppu.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON ppu.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON ppu.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON ppu.fk_usuario = apr.numero_documento
            WHERE DATE(ppu.fecha_registro) = '{$parametros['fecha']}'";

        if(isset($parametros['tipo_permiso'])){
            $sentenciaBuscar .= " AND ppu.tipo_permiso = '{$parametros['tipo_permiso']}'";
        }

        if(isset($parametros['codigo_permiso'])){
            $sentenciaBuscar .= " AND ppu.codigo_permiso = '{$parametros['codigo_permiso']}'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND ppu.fk_usuario LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['estado_permiso'])){
            $sentenciaBuscar .= " AND ppu.estado_permiso = '{$parametros['estado_permiso']}'";
        }

        $sentenciaBuscar .= " ORDER BY ppu.fecha_registro DESC LIMIT 10;";

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

        $permisos = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $respuesta = [
            'tipo' => 'OK',
            'permisos_usuarios' => $permisos
        ];
        return $respuesta;
    }

    public function consultarPermisoUsuario($codigoPermiso){
        $sentenciaBuscar = "
            SELECT 
                ppu.codigo_permiso, 
                ppu.tipo_permiso,
                ppu.estado_permiso,  
                ppu.fecha_registro,
                ppu.descripcion,
                vig1.nombres AS nombres_responsable,
                vig1.apellidos AS apellidos_responsable,
                COALESCE(ppu.fecha_fin_permiso, 'N/A') AS fecha_fin_permiso,
                COALESCE(ppu.fecha_aprobacion, 'N/A') AS fecha_aprobacion,
                COALESCE(ppu.fecha_desaprobacion, 'N/A') AS fecha_desaprobacion,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres_solicitante,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos_solicitante
            FROM permisos_usuarios ppu
            INNER JOIN vigilantes vig1 ON ppu.fk_usuario_sistema = vig1.numero_documento
            LEFT JOIN funcionarios fun ON ppu.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON ppu.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON ppu.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON ppu.fk_usuario = apr.numero_documento
            WHERE ppu.codigo_permiso = '$codigoPermiso'";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Permiso No Encontrado',
                "mensaje"=> 'No se encontraron resultados del permiso solicitado.'
            ];
            return $respuesta;
        }

        $permiso = $respuestaSentencia->fetch_assoc();
        $respuesta = [
            'tipo' => 'OK',
            'datos_permiso' => $permiso
        ];
        return $respuesta;
    }

    public function consultarNotificacionesPermisosUsuario(){
        $sentenciaBuscar = "
            SELECT codigo_permiso, tipo_permiso, fk_usuario
            FROM permisos_usuarios
            WHERE estado_permiso = 'PENDIENTE'
            ORDER BY fecha_registro;";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        $notificaciones = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);

        $respuesta = [
            'tipo' => 'OK',
            'notificaciones_permisos_usuario' => $notificaciones
        ];
        return $respuesta;
    }
}