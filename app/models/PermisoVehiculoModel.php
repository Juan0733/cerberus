<?php

namespace app\models;

class PermisoVehiculoModel extends MainModel{
    private $objetoUsuario;
    private $objetoVehiculo;
    private $objetoMovimiento;
    

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
        $this->objetoVehiculo = new VehiculoModel();
        $this->objetoMovimiento = new MovimientoModel();
    }

    public function registrarPermisoVehiculo($datosPermiso){
        $respuesta = $this->validarVehiculoAptoPermiso($datosPermiso['numero_documento'], $datosPermiso['numero_placa'],$datosPermiso['tipo_permiso']);
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
    
    private function validarVehiculoAptoPermiso($documento, $placa, $tipoPermiso){
        $respuesta = $this->objetoUsuario->consultarUsuario($documento);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoVehiculo->consultarPropietarioVehiculo($placa, $documento);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $vehiculo = $respuesta['datos_vehiculo'];
        if($vehiculo['ubicacion'] == 'FUERA'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Ubicación Incorrecta',
                'mensaje' => 'Lo sentimos, pero no es posible registrar el permiso, el vehículo no se encuentra dentro del CAB.'
            ];
            return $respuesta;
        }

        if($tipoPermiso == 'PERMANENCIA'){
            $respuesta = $this->consultarUltimoPermisoVehiculo($placa);
            if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
                return $respuesta;

            }else if($respuesta['tipo'] == 'OK'){
                $permiso = $respuesta['datos_permiso'];
                if($permiso['estado_permiso'] == 'PENDIENTE'){
                    $respuesta = [
                        'tipo' => 'ERROR',
                        'titulo'=> 'Permiso Pendiente',
                        'mensaje' => 'Lo sentimos, pero este vehículo tiene una solicitud de permanencia que se encuentra en estado pendiente.'
                    ];
                    return $respuesta;

                }elseif($permiso['estado_permiso'] == 'DESAPROBADO'){
                    $respuesta = $this->objetoMovimiento->consultarUltimoMovimientoVehiculo($placa);
                    if($respuesta['tipo'] == 'ERROR'){
                        return $respuesta;
                    }

                    $moviento = $respuesta['datos_movimiento'];
                    if($permiso['fecha_registro'] > $moviento['fecha_registro']){
                        $respuesta = [
                            'tipo' => 'ERROR',
                            'titulo'=> 'Permiso Desaprobado',
                            'mensaje' => 'Lo sentimos, pero la última solictud de permanencia de este vehículo, ha sido desaprobada.'
                        ];
                        return $respuesta;
                    }
                }
            }
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo'=> 'Vehículo Apto',
            'mensaje' => 'El vehículo es apto para registrarle un permiso.'
        ];
        return $respuesta;
    }

    public function aprobarPermisoVehiculo($codigoPermiso){
        $respuesta = $this->consultarPermisoVehiculo($codigoPermiso);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $estadoPermiso = $respuesta['datos_permiso']['estado_permiso'];
        if($estadoPermiso != 'PENDIENTE'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Permiso',
                'mensaje' => 'No se pudo realizar la aprobación del permiso, porque su estado ya ha sido modificado.'
            ];
            return $respuesta;
        }

        $fechaActual = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaActualizar = "
            UPDATE permisos_vehiculos 
            SET estado_permiso = 'APROBADO', fecha_atencion = '$fechaActual', fk_usuario_atencion = '$usuarioSistema' 
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
        $respuesta = $this->consultarPermisoVehiculo($codigoPermiso);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $permiso = $respuesta['datos_permiso'];
        if($permiso['estado_permiso'] != 'PENDIENTE'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Permiso',
                'mensaje' => 'No se pudo realizar la aprobación del permiso, porque su estado ya ha sido modificado.'
            ];
            return $respuesta;
        }

        $fechaActual = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaActualizar = "
            UPDATE permisos_vehiculos 
            SET estado_permiso = 'DESAPROBADO', fecha_atencion = '$fechaActual', fk_usuario_atencion = '$usuarioSistema'
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

    private function consultarUltimoPermisoVehiculo($vehiculo){
        $sentenciaBuscar = "
            SELECT estado_permiso, fecha_registro
            FROM permisos_vehiculos
            WHERE fk_vehiculo = '$vehiculo'
            ORDER BY fecha_registro DESC LIMIT 1;";

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
                COALESCE(fun.apellidos, apr.nombres, vis.apellidos, vig.apellidos) AS apellidos
            FROM permisos_vehiculos pv
            INNER JOIN (SELECT numero_placa, tipo_vehiculo FROM vehiculos GROUP BY numero_placa, tipo_vehiculo) veh ON pv.fk_vehiculo = veh.numero_placa
            LEFT JOIN funcionarios fun ON pv.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON pv.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON pv.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON pv.fk_usuario = apr.numero_documento
            WHERE 1= 1";

        if(isset($parametros['fecha'])){
            $sentenciaBuscar .= " AND DATE(pv.fecha_registro) = '{$parametros['fecha']}'";
        }

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
                pv.fk_vehiculo,
                veh.tipo_vehiculo,
                COALESCE(pv.fecha_fin_permiso, 'N/A') AS fecha_fin_permiso,
                COALESCE(pv.fecha_atencion, 'N/A') AS fecha_atencion,
                COALESCE(fun1.nombres, apr1.nombres, vis1.nombres, vig1.nombres) AS nombres_propietario,
                COALESCE(fun1.apellidos, apr1.apellidos, vis1.apellidos, vig1.apellidos) AS apellidos_propietario,
                COALESCE(fun2.nombres, vig2.nombres) AS nombres_solicitante,
                COALESCE(fun2.apellidos, vig2.apellidos) AS apellidos_solicitante,
                COALESCE(fun3.nombres, 'N/A') AS nombres_responsable,
                COALESCE(fun3.apellidos, 'N/A') AS apellidos_responsable
            FROM permisos_vehiculos pv
            INNER JOIN (SELECT numero_placa, tipo_vehiculo FROM vehiculos GROUP BY numero_placa, tipo_vehiculo) veh ON pv.fk_vehiculo = veh.numero_placa
            LEFT JOIN funcionarios fun1 ON pv.fk_usuario = fun1.numero_documento
            LEFT JOIN visitantes vis1 ON pv.fk_usuario = vis1.numero_documento
            LEFT JOIN vigilantes vig1 ON pv.fk_usuario = vig1.numero_documento
            LEFT JOIN aprendices apr1 ON pv.fk_usuario = apr1.numero_documento
            LEFT JOIN funcionarios fun2 ON pv.fk_usuario_sistema = fun2.numero_documento
            LEFT JOIN vigilantes vig2 ON pv.fk_usuario_sistema = vig2.numero_documento
            LEFT JOIN funcionarios fun3 ON pv.fk_usuario_atencion = fun3.numero_documento
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