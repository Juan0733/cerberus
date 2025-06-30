<?php

namespace app\models;

class PermisoVehiculoModel extends MainModel{
    private $objetoUsuario;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

    public function registrarPermisoVehiculo($datosPermiso){
        $respuesta = $this->objetoUsuario->consultarUsuario($datosPermiso['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $codigoPermiso = 'PV'.date('YmdHis');

        $sentenciaInsertar = "
            INSERT INTO permisos_vehiculos(codigo_permiso, tipo_permiso, fk_vehiculo, fk_usuario, descripcion, fecha_fin_permiso, fecha_registro, fk_usuario_sistema) 
            VALUES('$codigoPermiso', '{$datosPermiso['tipo_permiso']}', '{$datosPermiso['numero_placa']}', '{$datosPermiso['numero_documento']}', '{$datosPermiso['descripcion']}', '{$datosPermiso['fecha_fin_permiso']}', '$fechaRegistro', '$usuarioSistema')";

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

    public function aprobarPermisoVehiculo($codigoPermiso){
        $fechaActual = date('Y-m-d H:i:s');

        $sentenciaActualizar = "
            UPDATE permisos_vehiculos 
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

    public function desaprobarPermisoVehiculo($codigoPermiso){
        $fechaActual = date('Y-m-d H:i:s');

        $sentenciaActualizar = "
            UPDATE permisos_vehiculos 
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

    public function consultarPermisosVehiculos($parametros){
        $sentenciaBuscar = "
            SELECT 
                pv.codigo_permiso,
                pv.tipo_permiso, 
                pv.estado_permiso,
                pv.fecha_registro,
                pv.fk_usuario,
                pv.fk_vehiculo,
                veh.tipo_vehiculo,
                COALESCE(fun.tipo_documento, apr.tipo_documento, vis.tipo_documento, vig.tipo_documento) AS tipo_documento,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres,
            FROM permisos_vehiculos pv
            INNER JOIN (SELECT numero_placa, tipo_vehiculo FROM vehiculos GROUP BY numero_placa, tipo_vehiculo) veh ON pv.fk_vehiculo = veh.numero_placa
            LEFT JOIN funcionarios fun ON pv.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON pv.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON pv.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON pv.fk_usuario = apr.numero_documento
            WHERE DATE(pv.fecha_registro) = '{$parametros['fecha']}'";

        if(isset($parametros['tipo_permiso'])){
            $sentenciaBuscar .= " AND pv.tipo_permiso = '{$parametros['tipo_permiso']}'";
        }

        if(isset($parametros['codigo_permiso'])){
            $sentenciaBuscar .= " AND pv.codigo_permiso = '{$parametros['codigo_permiso']}'";
        }

        if(isset($parametros['numero_placa'])){
            $sentenciaBuscar .= " AND pv.fk_vehiculo LIKE '{$parametros['numero_placa']}%'";
        }

        if(isset($parametros['estado_permiso'])){
            $sentenciaBuscar .= " AND pv.estado_permiso = '{$parametros['estado_permiso']}'";
        }

        $sentenciaBuscar .= " ORDER BY pv.fecha_registro DESC LIMIT 10;";

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
            'permisos_vehiculos' => $permisos
        ];
        return $respuesta;
    }

    public function consultarPermisoVehiculo($codigoPermiso){
        $sentenciaBuscar = "
            SELECT 
                pv.codigo_permiso, 
                pv.tipo_permiso,
                pv.estado_permiso,  
                pv.fecha_registro,
                pv.descripcion,
                vig1.nombres AS nombres_responsable,
                vig1.apellidos AS apellidos_responsable,
                COALESCE(ppu.fecha_fin_permiso, 'N/A') AS fecha_fin_permiso,
                COALESCE(ppu.fecha_aprobacion, 'N/A') AS fecha_aprobacion,
                COALESCE(ppu.fecha_desaprobacion, 'N/A') AS fecha_desaprobacion,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres_propietario,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos_propietario
            FROM permisos_vehiculos pv
            INNER JOIN (SELECT numero_placa, tipo_vehiculo FROM vehiculos GROUP BY numero_placa, tipo_vehiculo) veh ON pv.fk_vehiculo = veh.numero_placa
            INNER JOIN vigilantes vig1 ON pv.fk_usuario_sistema = vig1.numero_documento
            LEFT JOIN funcionarios fun ON pv.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON pv.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON pv.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON pv.fk_usuario = apr.numero_documento
            WHERE pv.codigo_permiso = '$codigoPermiso'";

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

    public function consultarNotificacionesPermisosVehiculo(){
        $sentenciaBuscar = "
            SELECT codigo_permiso, tipo_permiso, fk_vehiculo
            FROM permisos_vehiculos
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
            'notificaciones_permisos_vehiculo' => $notificaciones
        ];
        return $respuesta;
    }
}