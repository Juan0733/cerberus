<?php
namespace App\Models;

use DateTime;

class PermisoUsuarioModel extends MainModel{
    private $objetoUsuario;
    private $objetoMovimiento;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
        $this->objetoMovimiento = new MovimientoModel();
    }

    public function registrarPermisoUsuario($datosPermiso){
        $respuesta = $this->validarUsuarioAptoPermiso($datosPermiso['numero_documento'], $datosPermiso['tipo_permiso']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $codigoPermiso = 'PU'.date('YmdHis');

        $sentenciaInsertar = "
            INSERT INTO permisos_usuarios(codigo_permiso, tipo_permiso, fk_usuario, descripcion, fecha_fin_permiso, fecha_registro, estado_permiso, fk_usuario_sistema) 
            VALUES('$codigoPermiso', '{$datosPermiso['tipo_permiso']}', '{$datosPermiso['numero_documento']}', '{$datosPermiso['descripcion']}', '{$datosPermiso['fecha_fin_permiso']}', '$fechaRegistro', '{$datosPermiso['estado_permiso']}', '$usuarioSistema')";

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

    private function validarUsuarioAptoPermiso($documento, $tipoPermiso){
        $respuesta = $this->objetoUsuario->consultarUsuario($documento);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        $usuario = $respuesta['usuario'];
        
        if($tipoPermiso == 'PERMANENCIA'){
            if($usuario['ubicacion'] == 'FUERA'){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Ubicación Incorrecta',
                    'mensaje' => 'Lo sentimos, pero no es posible registrar el permiso, el usuario no se encuentra dentro del CAB.'
                ];
                return $respuesta;
            }

            $respuesta = $this->consultarUltimoPermisoUsuario($documento, $tipoPermiso);
            if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
                return $respuesta;

            }elseif($respuesta['tipo'] == 'OK'){
                $permiso = $respuesta['datos_permiso'];
                if($permiso['estado_permiso'] == 'PENDIENTE'){
                    $respuesta = [
                        'tipo' => 'ERROR',
                        'titulo'=> 'Permiso Pendiente',
                        'mensaje' => 'Lo sentimos, pero este usuario tiene un permiso de permanencia que se encuentra en estado pendiente.'
                    ];
                    return $respuesta;

                }elseif($permiso['estado_permiso'] == 'DESAPROBADO'){
                    $respuesta = $this->objetoMovimiento->consultarUltimoMovimientoUsuario($documento);
                    if($respuesta['tipo'] == 'ERROR'){
                        return $respuesta;
                    }

                    $movimiento = $respuesta['datos_movimiento'];
                    if($permiso['fecha_registro'] > $movimiento['fecha_registro']){
                        $respuesta = [
                            'tipo' => 'ERROR',
                            'titulo'=> 'Permiso Desaprobado',
                            'mensaje' => 'Lo sentimos, pero el permiso de permanencia mas reciente de este usuario, ha sido desaprobado.'
                        ];
                        return $respuesta;
                    }
                }
            }

        }elseif($tipoPermiso == 'SALIDA'){
            $respuesta = $this->consultarUltimoPermisoUsuario($documento, $tipoPermiso);
            if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
                return $respuesta;

            }elseif($respuesta['tipo'] == 'OK'){
                $permiso = $respuesta['datos_permiso'];
                $fechaFinPermiso = strtotime($permiso['fecha_fin_permiso']);
                $fechaActual = strtotime('now');

                if($fechaFinPermiso >= $fechaActual){
                    $respuesta = [
                        'tipo' => 'ERROR',
                        'titulo'=> 'Permiso Vigente',
                        'mensaje' => 'Lo sentimos, pero este usuario ya tiene un permiso de salida vigente.'
                    ];
                    return $respuesta;
                }
            }
        }
       
        $respuesta = [
            'tipo' => 'OK',
            'titulo'=> 'Usuario Apto',
            'mensaje' => 'El usuario es apto para registrarle un permiso.'
        ];
        return $respuesta;
    }

    public function aprobarPermisoUsuario($codigoPermiso){
        $respuesta = $this->consultarPermisoUsuario($codigoPermiso);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $estadoPermiso = $respuesta['datos_permiso']['estado_permiso'];
        if($estadoPermiso != 'PENDIENTE'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Permiso',
                'mensaje' => 'No se pudo realizar la aprobación del permiso, porque ya no se encuentra en estado pendiente.'
            ];
            return $respuesta;
        }

        $fechaActual = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaActualizar = "
            UPDATE permisos_usuarios 
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

    public function desaprobarPermisoUsuario($codigoPermiso){
        $respuesta = $this->consultarPermisoUsuario($codigoPermiso);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $estadoPermiso = $respuesta['datos_permiso']['estado_permiso'];
        if($estadoPermiso != 'PENDIENTE'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Permiso',
                'mensaje' => 'No se pudo realizar la aprobación del permiso, porque ya no se encuentra en estado pendiente.'
            ];
            return $respuesta;
        }

        $fechaActual = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaActualizar = "
            UPDATE permisos_usuarios 
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

    private function consultarUltimoPermisoUsuario($usuario, $tipoPermiso){
        $sentenciaBuscar = "
            SELECT estado_permiso, fecha_registro, fecha_fin_permiso
            FROM permisos_usuarios
            WHERE fk_usuario = '$usuario' AND tipo_permiso = '$tipoPermiso'
            ORDER BY fecha_registro DESC LIMIT 1;";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Permiso No Encontrado',
                "mensaje"=> 'No se encontraron resultados del permiso solicitado.'
            ];
            return $respuesta;
        }

        $permiso = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_permiso' => $permiso
        ];
        return $respuesta;
    }

    public function consultarPermisosUsuarios($parametros){
        $sentenciaBuscar = "
            SELECT 
                pu.codigo_permiso,
                pu.tipo_permiso, 
                pu.estado_permiso,
                pu.fecha_registro,
                pu.fk_usuario,
                pu.fk_usuario_sistema,
                COALESCE(fun.tipo_documento, apr.tipo_documento, vis.tipo_documento, vig.tipo_documento) AS tipo_documento,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos
            FROM permisos_usuarios pu
            LEFT JOIN funcionarios fun ON pu.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON pu.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON pu.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON pu.fk_usuario = apr.numero_documento
            WHERE 1 = 1";

        $rol = $_SESSION['datos_usuario']['rol'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $fechaActual = date('Y-m-d H:i:s');

        if(isset($parametros['tipo_permiso'])){
            $sentenciaBuscar .= " AND pu.tipo_permiso = '{$parametros['tipo_permiso']}'";

            if(($parametros['tipo_permiso'] == 'PERMANENCIA' && $rol == 'SUPERVISOR') || ($parametros['tipo_permiso'] == 'SALIDA' && ($rol == 'COORDINADOR' || $rol == 'INSTRUCTOR'))){
                $sentenciaBuscar .= " AND pu.fk_usuario_sistema = '$usuarioSistema'";
                
            }elseif($parametros['tipo_permiso'] == 'SALIDA' && ($rol == 'SUPERVISOR' || $rol == 'VIGILANTE')){
                $sentenciaBuscar .= " AND pu.fecha_fin_permiso >= '$fechaActual'";
            }

        }elseif(!isset($parametros['tipo_permiso']) && $rol == 'SUPERVISOR'){
            $sentenciaBuscar .= " AND ((pu.tipo_permiso = 'PERMANENCIA' AND pu.fk_usuario_sistema = '$usuarioSistema') OR (pu.tipo_permiso = 'SALIDA' AND pu.fecha_fin_permiso >= '$fechaActual'))";
        }

        if(isset($parametros['fecha'])){
            $sentenciaBuscar .=  " AND DATE(pu.fecha_registro) = '{$parametros['fecha']}'";
        }

        if(isset($parametros['codigo_permiso'])){
            $sentenciaBuscar .= " AND pu.codigo_permiso = '{$parametros['codigo_permiso']}'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND pu.fk_usuario LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['estado_permiso'])){
            $sentenciaBuscar .= " AND pu.estado_permiso = '{$parametros['estado_permiso']}'";
        }

        $sentenciaBuscar .= " ORDER BY pu.fecha_registro DESC LIMIT 10;";

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

        $permisos = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'permisos_usuarios' => $permisos
        ];
        return $respuesta;
    }

    public function consultarPermisoUsuario($codigoPermiso){
        $sentenciaBuscar = "
            SELECT 
                pu.codigo_permiso, 
                pu.tipo_permiso,
                pu.estado_permiso,  
                pu.fecha_registro,
                pu.descripcion,
                COALESCE(pu.fecha_fin_permiso, 'N/A') AS fecha_fin_permiso,
                COALESCE(pu.fecha_atencion, 'N/A') AS fecha_atencion,
                COALESCE(fun1.nombres, apr1.nombres, vis1.nombres, vig1.nombres) AS nombres_beneficiario,
                COALESCE(fun1.apellidos, apr1.apellidos, vis1.apellidos, vig1.apellidos) AS apellidos_beneficiario,
                COALESCE(fun1.tipo_usuario, apr1.tipo_usuario, vis1.tipo_usuario, vig1.tipo_usuario) AS tipo_beneficiario,
                COALESCE(fun2.nombres, vig2.nombres) AS nombres_registro,
                COALESCE(fun2.apellidos, vig2.apellidos) AS apellidos_registro,
                COALESCE(fun2.rol, vig2.rol) AS rol_registro,
                COALESCE(fun3.nombres, 'N/A') AS nombres_atencion,
                COALESCE(fun3.apellidos, 'N/A') AS apellidos_atencion,
                COALESCE(fun3.rol, 'N/A') AS rol_atencion
            FROM permisos_usuarios pu
            LEFT JOIN funcionarios fun1 ON pu.fk_usuario = fun1.numero_documento
            LEFT JOIN visitantes vis1 ON pu.fk_usuario = vis1.numero_documento
            LEFT JOIN vigilantes vig1 ON pu.fk_usuario = vig1.numero_documento
            LEFT JOIN aprendices apr1 ON pu.fk_usuario = apr1.numero_documento
            LEFT JOIN funcionarios fun2 ON pu.fk_usuario_sistema = fun2.numero_documento
            LEFT JOIN vigilantes vig2 ON pu.fk_usuario_sistema = vig2.numero_documento
            LEFT JOIN funcionarios fun3 ON pu.fk_usuario_atencion = fun3.numero_documento
            WHERE pu.codigo_permiso = '$codigoPermiso'";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Permiso No Encontrado',
                "mensaje"=> 'No se encontraron resultados del permiso solicitado.'
            ];
            return $respuesta;
        }

        $permiso = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
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
        $this->cerrarConexion();

        $respuesta = [
            'tipo' => 'OK',
            'notificaciones_permisos_usuario' => $notificaciones
        ];
        return $respuesta;
    }
}