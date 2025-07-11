<?php
namespace app\models;

use DateTime;

class UsuarioModel extends MainModel{
    private $objetoPermisoRol;

    public function __construct() {
        $this->objetoPermisoRol = new PermisoRolModel();
    }

    public function consultarUsuario($usuario){
        $tablas = ['vigilantes', 'visitantes', 'funcionarios', 'aprendices'];
        foreach($tablas as $tabla){
            if($tabla == 'aprendices'){
                $sentenciaBuscar = "
                    SELECT 
                        tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, 
                        fecha_fin_ficha, ubicacion 
                    FROM $tabla 
                    INNER JOIN fichas ON fk_ficha = numero_ficha 
                    WHERE numero_documento = '$usuario';";
            }else{
                $sentenciaBuscar = "
                    SELECT * 
                    FROM $tabla 
                    WHERE numero_documento = '$usuario';";
            }
            
            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if ($respuesta['tipo'] == 'ERROR') {
                return $respuesta;
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            if ($respuestaSentencia->num_rows > 0) {
                $datosUsuario = $respuestaSentencia->fetch_assoc();
                $datosUsuario['grupo'] = $tabla;
                $respuesta = [
                    'tipo' => 'OK',
                    'usuario' => $datosUsuario
                ];
                return $respuesta;
            }
        }
        
        $respuesta = [
            'tipo' => 'ERROR',
            'titulo' => 'Usuario No Encontrado',
            'mensaje' => 'Lo sentimos, parece que el usuario con numero de documento '.$usuario.', no se encuentra registrado en el sistema.'
        ];
        return $respuesta;
    }

    public function actualizarUbicacionUsuario($usuario, $tablaOrigen, $ubicacion){
        $sentenciaActualizar = "
            UPDATE $tablaOrigen 
            SET ubicacion = '$ubicacion' 
            WHERE numero_documento = '$usuario';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Ubicación Actualizada',
            "mensaje"=> 'La ubicación del usuario fue actualizada correctamente.'
        ];
        return $respuesta;
    }

    public function eliminarUsuario($usuario, $tablaOrigen){
        $sentenciaEliminar = "
            DELETE 
            FROM $tablaOrigen 
            WHERE numero_documento = '$usuario' ;";
        
        $respuesta= $this->ejecutarConsulta($sentenciaEliminar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Cambio Exitoso',
            "mensaje"=> 'El usuario fue eliminado correctamente.'
        ];
        return $respuesta;
    }

    private function actualizarFechaSesion($usuario, $tablaOrigen){
        $fechaUltimaSesion = date('Y-m-d H:i:s');

        $sentenciaActualizar = "
            UPDATE $tablaOrigen 
            SET fecha_ultima_sesion = '$fechaUltimaSesion'
            WHERE numero_documento = '$usuario';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Actualización Exitosa',
            'mensaje' => 'La fecha de la ultima sesión fue actualizada correctamente.'
        ];
        return $respuesta;
    }
    
    public function validarUsuarioLogin($usuario){
        $tablas = ['vigilantes', 'funcionarios'];
        foreach ($tablas as $tabla) {
            if($tabla == 'vigilantes'){
                $sentenciaBuscar = "
                    SELECT `numero_documento` 
                    FROM `$tabla` 
                    WHERE  numero_documento = '$usuario' AND estado_usuario = 'ACTIVO';";

            }elseif($tabla == 'funcionarios'){
                $sentenciaBuscar = "
                    SELECT `numero_documento` 
                    FROM `$tabla` 
                    WHERE  numero_documento = '$usuario' AND estado_usuario = 'ACTIVO' AND (rol = 'COORDINADOR' OR rol = 'SUBDIRECTOR');";
            }
            
            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if ($respuesta['tipo'] == 'ERROR') {
                return $respuesta;
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            if ($respuestaSentencia->num_rows > 0) {
                $respuesta = [
                    'tipo' => 'OK',
                    'titulo' => 'Usuario Encontrado',
                    'mensaje' => 'Se encontro una coincidencia con el usuario proporcionado.'
                ];
                return $respuesta; 
            }
        }

        $respuesta = [
            "tipo"=>"ERROR",
            "titulo" =>'Acceso Denegado',
            "mensaje"=> 'Lo sentimos, parece que no tienes acceso a Cerberus o tu número de identificación es incorrecto.',
            "icono" => "warning",
            "cod_error"=> "350"
        ];
        return $respuesta;
    }

    public function validarContrasenaLogin($datosLogin){
        $tablas = ['vigilantes', 'funcionarios'];
        foreach ($tablas as $tabla) {
            if($tabla == 'vigilantes'){
                $sentenciaBuscar = "
                    SELECT * 
                    FROM `$tabla` 
                    WHERE numero_documento = '{$datosLogin['usuario']}' AND contrasena = MD5('{$datosLogin['contrasena']}') AND estado_usuario = 'ACTIVO';";

            }elseif($tabla == 'funcionarios'){
                $sentenciaBuscar = "
                    SELECT * 
                    FROM `$tabla` 
                    WHERE numero_documento = '{$datosLogin['usuario']}' AND contrasena = MD5('{$datosLogin['contrasena']}') AND estado_usuario = 'ACTIVO' AND (rol = 'COORDINADOR' OR rol = 'SUBDIRECTOR');";
            }

            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if ($respuesta['tipo'] == 'ERROR') {
                return $respuesta;
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            if ($respuestaSentencia->num_rows > 0) {
                $datosUsuario = $respuestaSentencia->fetch_assoc();
                $datosUsuario['hora_sesion'] = time();
                $datosUsuario['panel_acceso'] = 'inicio';

                session_regenerate_id(true);
                setcookie(session_name(), session_id(), $datosUsuario['hora_sesion'] + 315360000, "/");

                $respuesta = $this->actualizarFechaSesion($datosUsuario['numero_documento'], $tabla);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }

                $_SESSION['datos_usuario'] = $datosUsuario;

                $respuesta = [
                    'tipo' => 'OK',
                    'titulo' => 'Login Exitoso',
                    'mensaje' => 'Usuario autorizado para acceder a cerberus',
                    'ruta' => $datosUsuario['panel_acceso']
                ];
                return $respuesta;
            }
        }
       
        $respuesta = [
            "tipo" => "ERROR",
            "titulo" => 'Acceso Denegado',
            "mensaje"=> 'Lo sentimos, parece que tu contraseña es incorrecta.'
        ];
        return $respuesta;
    }

    public function validarPermisosUsuario($permiso){
        $respuesta = $this->objetoPermisoRol->consultarPermiso($permiso);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $rol = 'INVITADO';
        if(isset($_SESSION['datos_usuario'])){
            $rol = $_SESSION['datos_usuario']['rol'];
        }

        $respuesta = $this->objetoPermisoRol->consultarPermisoRol($permiso, $rol);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Permiso No Encontrado'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Acceso Denegado',
                'mensaje' => 'Lo sentimos, no tienes acceso a este recurso'
            ];
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Acceso Permitido',
            'mensaje'  => 'Tienes acceso a este recurso'
        ];
        return $respuesta;
    }

    public function validarTiempoSesion(){
        if(isset($_SESSION['datos_usuario'])){
            $tiempoLimite = 43200;
            $tiempoTranscurrido = time() -  $_SESSION['datos_usuario']['hora_sesion'];

            if($tiempoTranscurrido > $tiempoLimite){
                $this->cerrarSesion();
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Sesión Expirada',
                    'mensaje' => 'La sesión ha expirado, vuelve a ingresar al sistema.'
                ];
                return $respuesta;
            }
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Sesión Vigente',
            'mensaje' => 'La sesión no ha expirado'
        ];
        return $respuesta;
    }

    public function cerrarSesion(){
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Sesión Cerrada',
            'mensaje' => 'La sesion ha sido cerrada correctamente'
        ];
        return $respuesta;
    }

    public function conteoTotalUsuarios(){
        $tablas = ['vigilantes', 'visitantes', 'funcionarios', 'aprendices'];
        $totalUsuarios = 0;

        foreach($tablas as $tabla){
            $sentenciaBuscar = "
                SELECT numero_documento 
                FROM $tabla
                WHERE ubicacion = 'DENTRO';";

            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if ($respuesta['tipo'] == 'ERROR') {
                return $respuesta;
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            $totalUsuarios += $respuestaSentencia->num_rows;
        }

        $respuesta = [
            'tipo' => "OK",
            'titulo'=> "Conteo Exitoso",
            'mensaje' => "El conteo de usuarios fue realizado con éxito.",
            'total_usuarios' => $totalUsuarios
        ];
        return $respuesta;
    }

    public function conteoTipoUsuario(){
        $tablas = ['aprendices', 'funcionarios', 'visitantes', 'vigilantes'];
        $usuarios = [];
        $totalUsuarios = 0;

        foreach($tablas as $tabla){
            $sentenciaBuscar = "
                SELECT numero_documento 
                FROM $tabla 
                WHERE ubicacion = 'DENTRO';";

            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if ($respuesta['tipo'] == 'ERROR') {
                return $respuesta;
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            $cantidad = $respuestaSentencia->num_rows;
            $usuarios[] = [
                'tipo_usuario' => $tabla,
                'cantidad' => $cantidad
            ];

            $totalUsuarios += $cantidad;
        }

        foreach ($usuarios as &$usuario) {
            if($usuario['cantidad'] < 1){
                $porcentaje = 0;
            }else{
                $porcentaje = $usuario['cantidad']*100/$totalUsuarios;
                if(is_float($porcentaje)){
                    $porcentaje = number_format($porcentaje, 1, '.', '');
                }
            }

            $usuario['porcentaje'] = $porcentaje;
        }

        $respuesta = [
            'tipo' => "OK",
            'titulo'=> "Conteo Exitoso",
            'mensaje' => "El conteo de usuarios fue realizado con éxito.",
            'usuarios' => $usuarios
        ];
        return $respuesta;
    }

    public function consultarNotificacionesUsuario(){
        $tablas = ['vigilantes', 'visitantes', 'funcionarios', 'aprendices'];
        $objetoFecha = new DateTime();
        $fechaActual = $objetoFecha->format('Y-m-d H:i:s');
        $fechaMenos16H = (clone $objetoFecha)->modify('-16 hours')->format('Y-m-d H:i:s');
        $fechaMenos1H = (clone $objetoFecha)->modify('-1 hours')->format('Y-m-d H:i:s');

        $notificaciones = [];

        foreach ($tablas as $tabla) {
            $sentenciaBuscar = "
                SELECT 
                    usu.numero_documento, 
                    ppu.estado_permiso, 
                    ppu.codigo_permiso,
                    ppu.fecha_registro AS fecha_permiso, 
                    mov.fecha_registro AS fecha_ultima_entrada
                FROM 
                    $tabla usu
                INNER JOIN (
                    SELECT m1.*
                    FROM movimientos m1
                    INNER JOIN (
                        SELECT fk_usuario, MAX(fecha_registro) AS fecha_ultimo_movimiento
                        FROM movimientos
                        GROUP BY fk_usuario
                    ) ult ON m1.fk_usuario = ult.fk_usuario 
                        AND m1.fecha_registro = ult.fecha_ultimo_movimiento
                    WHERE m1.tipo_movimiento = 'ENTRADA'
                ) mov ON usu.numero_documento = mov.fk_usuario
                LEFT JOIN (
                    SELECT p1.*
                    FROM permisos_usuarios p1
                    INNER JOIN (
                        SELECT fk_usuario, MAX(fecha_registro) AS fecha_ultimo_permiso
                        FROM permisos_usuarios
                        WHERE tipo_permiso = 'PERMANENCIA'
                        GROUP BY fk_usuario
                    ) ult ON p1.fk_usuario = ult.fk_usuario 
                        AND p1.fecha_registro = ult.fecha_ultimo_permiso
                ) ppu ON usu.numero_documento = ppu.fk_usuario
                WHERE 
                    usu.ubicacion = 'DENTRO'
                    AND mov.fecha_registro < '$fechaMenos16H'
                    AND (
                        ppu.estado_permiso IS NULL 
                        OR ppu.estado_permiso = 'DESAPROBADO'
                        OR (ppu.estado_permiso = 'PENDIENTE' AND ppu.fecha_registro < '$fechaMenos1H') 
                        OR (ppu.estado_permiso = 'APROBADO' AND ppu.fecha_fin_permiso < '$fechaActual')
                    );";

            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            if($respuestaSentencia->num_rows > 0){
                $usuarios = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
                foreach ($usuarios as &$usuario) {
                    $fechaUltimaEntrada = new DateTime($usuario['fecha_ultima_entrada']);
                    $fechaPermiso = new DateTime($usuario['fecha_permiso']);

                    $diferencia = $fechaUltimaEntrada->diff($objetoFecha);
                    $horasPermanencia = ($diferencia->days * 24) + $diferencia->h;
                    $usuario['horas_permanencia'] = $horasPermanencia;

                    if(($usuario['estado_permiso'] == 'DESAPROBADO') && $fechaPermiso < $fechaUltimaEntrada){
                        $usuario['estado_permiso'] = NULL;
                    }

                    $notificaciones[] = $usuario;
                };
            }
        }

        $notificaciones = $this->ordenarNotificacionesUsuario($notificaciones);
        $respuesta = [
            'tipo' => 'OK',
            'notificaciones_usuario' => $notificaciones
        ];
        return $respuesta;
    }

    private function ordenarNotificacionesUsuario($array){
        if(count($array) <= 1){
            return $array;
        }

        $pivot = $array[intdiv(count($array), 2)]['horas_permanencia'];

        $izquierda = [];
        $mitad = [];
        $derecha = [];

        foreach ($array as $notificacion) {
            $horas = $notificacion['horas_permanencia'];

            if($horas > $pivot){
                $izquierda[] = $notificacion;

            }else if($horas == $pivot){
                $mitad[] = $notificacion;

            }elseif($horas < $pivot){
                $derecha[] = $notificacion;
            }
        } 

        return array_merge(
            $this->ordenarNotificacionesUsuario($izquierda), 
            $mitad, 
            $this->ordenarNotificacionesUsuario($derecha)
        );
        
    }
}
