<?php
namespace App\Models;

use DateTime;

class UsuarioModel extends MainModel{

    public function consultarUsuario($usuario){
        $tablas = ['vigilantes', 'visitantes', 'funcionarios', 'aprendices'];
        foreach($tablas as $tabla){
            $sentenciaBuscar = "
                SELECT tipo_usuario, tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, ubicacion
                FROM $tabla 
                WHERE numero_documento = '$usuario';";
            
            if($tabla == 'aprendices'){
                $sentenciaBuscar = "
                    SELECT tipo_usuario, tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, ubicacion, fecha_fin_ficha
                    FROM $tabla 
                    INNER JOIN fichas ON fk_ficha = numero_ficha 
                    WHERE numero_documento = '$usuario';";

            }else if($tabla == 'funcionarios'){
                $sentenciaBuscar = "
                    SELECT tipo_usuario, tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, ubicacion, tipo_contrato, fecha_fin_contrato
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
                $this->cerrarConexion();
                $datosUsuario['tabla_usuario'] = $tabla;
                $respuesta = [
                    'tipo' => 'OK',
                    'usuario' => $datosUsuario
                ];
                return $respuesta;
            }
            $this->cerrarConexion();
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

    public function actualizarContrasenaUsuario($contrasena){
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $tablaUsuarioSistema = $_SESSION['datos_usuario']['tabla'];

        $sentenciaActualizar = "
            UPDATE $tablaUsuarioSistema SET contrasena = '$contrasena' 
            WHERE numero_documento = '$usuarioSistema';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $_SESSION['datos_usuario']['contrasena_actualizada'] = 'SI';

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Contraseña Actualizada',
            'mensaje' => 'La contraseña fue actualizada correctamente.'
        ];
        return $respuesta;
    }

    public function eliminarUsuario($usuario, $tablaOrigen){
        $sentenciaEliminar = "
            DELETE 
            FROM $tablaOrigen 
            WHERE numero_documento = '$usuario';";
        
        $respuesta= $this->ejecutarConsulta($sentenciaEliminar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Eliminación Exitosa',
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
            $columnas = "numero_documento, tipo_usuario";
            $condicion = "numero_documento = '$usuario' AND estado_usuario = 'ACTIVO'";

            if($tabla == 'funcionarios'){
                $columnas .= ", tipo_contrato, fecha_fin_contrato";
                $condicion .= " AND (rol = 'COORDINADOR' OR rol = 'SUBDIRECTOR' OR rol = 'INSTRUCTOR')";
            }

            $sentenciaBuscar = "
                SELECT $columnas
                FROM `$tabla` 
                WHERE  $condicion;";
            
            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if ($respuesta['tipo'] == 'ERROR') {
                return $respuesta;
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            if ($respuestaSentencia->num_rows > 0) {
                $datosUsuario = $respuestaSentencia->fetch_assoc();
                $this->cerrarConexion();

                if($datosUsuario['tipo_usuario'] == 'FUNCIONARIO' && $datosUsuario['tipo_contrato'] == 'CONTRATISTA'){
                    $fechaActual = new DateTime(date('Y-m-d'));
                    $fechaFinContrato = new DateTime($datosUsuario['fecha_fin_contrato']);
                    if($fechaFinContrato < $fechaActual){
                        $respuesta = [
                            "tipo"=>"ERROR",
                            "titulo" =>'Acceso Denegado',
                            "mensaje"=> 'Lo sentimos, parece que no tienes acceso a Cerberus o tu número de identificación es incorrecto.',
                        ];
                        return $respuesta;
                    } 
                }

                $respuesta = [
                    'tipo' => 'OK',
                    'titulo' => 'Usuario Encontrado',
                    'mensaje' => 'Se encontro una coincidencia con el usuario proporcionado.'
                ];
                return $respuesta; 
            }
            $this->cerrarConexion();
        }

        $respuesta = [
            "tipo"=>"ERROR",
            "titulo" =>'Acceso Denegado',
            "mensaje"=> 'Lo sentimos, parece que no tienes acceso a Cerberus o tu número de identificación es incorrecto.',
        ];
        return $respuesta;
    }

    public function validarContrasenaLogin($datosLogin){
        $tablas = ['vigilantes', 'funcionarios'];
        foreach ($tablas as $tabla) {
            $condicion = "numero_documento = '{$datosLogin['usuario']}' AND contrasena = MD5('{$datosLogin['contrasena']}') AND estado_usuario = 'ACTIVO'";

            if($tabla == 'funcionarios'){
                $condicion .= "  AND (rol = 'COORDINADOR' OR rol = 'SUBDIRECTOR' OR rol = 'INSTRUCTOR')";
            }

            $sentenciaBuscar = "
                SELECT * 
                FROM `$tabla` 
                WHERE $condicion;";

            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if ($respuesta['tipo'] == 'ERROR') {
                return $respuesta;
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            if ($respuestaSentencia->num_rows > 0) {
                $datosUsuario = $respuestaSentencia->fetch_assoc();
                $this->cerrarConexion();

                $datosUsuario['tabla'] = $tabla;

                $datosUsuario['panel_acceso'] = 'inicio';
                if($datosUsuario['rol'] == 'VIGILANTE'){
                    $datosUsuario['panel_acceso'] = 'entradas';
                }

                $datosUsuario['contrasena_actualizada'] = 'SI';
                if($datosUsuario['fecha_ultima_sesion'] == NULL){
                    $datosUsuario['contrasena_actualizada'] = 'NO';
                }

                $respuesta = $this->actualizarFechaSesion($datosUsuario['numero_documento'], $tabla);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }

                $datosUsuario['hora_sesion'] = time();
                $this->iniciarSesion($datosUsuario);

                $respuesta = [
                    'tipo' => 'OK',
                    'titulo' => 'Login Exitoso',
                    'mensaje' => 'Usuario autorizado para acceder a cerberus',
                    'ruta' => $datosUsuario['panel_acceso']
                ];
                return $respuesta;
            }
            $this->cerrarConexion();
        }

        $respuesta = [
            "tipo" => "ERROR",
            "titulo" => 'Acceso Denegado',
            "mensaje"=> 'Lo sentimos, parece que tu contraseña es incorrecta.'
        ];
        return $respuesta;
    }

    private function iniciarSesion($datosUsuario){
        session_regenerate_id(true);

        $duracion = 30 * 24 * 60 * 60;
        $expira = $datosUsuario['hora_sesion'] + $duracion;

        setcookie(session_name(), session_id(), $expira, "/");

        $_SESSION['datos_usuario'] = $datosUsuario;
    }

    public function cerrarSesion(){
        if(ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }

        session_unset();
        session_destroy();

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Sesión Cerrada',
            'mensaje' => 'La sesión ha sido cerrada correctamente'
        ];
        return $respuesta;
    }

    public function validarTiempoSesion(){
        if(isset($_SESSION['datos_usuario'])){
            $tiempoLimite = 8 * 60 * 60;

            if($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE'){
                $tiempoLimite = 12 * 60 * 60;
            }

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
            $this->cerrarConexion();
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
            $this->cerrarConexion();
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
        unset($usuario);

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
        $fechaMenos15H = (clone $objetoFecha)->modify('-15 hours')->format('Y-m-d H:i:s');
        $fechaMenos1H = (clone $objetoFecha)->modify('-1 hours')->format('Y-m-d H:i:s');

        $notificaciones = [];

        foreach ($tablas as $tabla) {
            $sentenciaBuscar = "
                SELECT 
                    usu.numero_documento, 
                    usu.tipo_usuario,
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
                    AND mov.fecha_registro < '$fechaMenos15H'
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
                    $diferencia = $fechaUltimaEntrada->diff($objetoFecha);
                    $horasPermanencia = ($diferencia->days * 24) + $diferencia->h;
                    $usuario['horas_permanencia'] = $horasPermanencia;

                    if($usuario['fecha_permiso'] !== NULL){
                        $fechaUltimoPermiso = new DateTime($usuario['fecha_permiso']);
                        if(($usuario['estado_permiso'] == 'DESAPROBADO') && $fechaUltimoPermiso < $fechaUltimaEntrada){
                            $usuario['estado_permiso'] = NULL;
                        }
                    }

                    $notificaciones[] = $usuario;
                };
                unset($usuario);
            }

            $this->cerrarConexion();
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
