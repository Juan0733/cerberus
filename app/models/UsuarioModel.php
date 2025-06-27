<?php
namespace app\models;

class UsuarioModel extends MainModel{

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

    private function actualizarFechaSesion($usuario, $tabla){
        $fechaUltimaSesion = date('Y-m-d H:i:s');

        $sentenciaActualizar = "
            UPDATE $tabla 
            SET fecha_ultima_sesion = '$fechaUltimaSesion';";

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
                setcookie(session_name(), session_id(), $datosUsuario['hora_sesion'] + 44000, "/");

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
        $rolesPermisos = [
            'JEFE VIGILANTES' => ['consultar_agendas', 'consultar_agenda', 'consultar_aprendices', 'consultar_aprendiz', 
            'consultar_funcionarios', 'consultar_funcionario', 'conteo_total_brigadistas', 'registrar_entrada_peatonal', 
            'registrar_salida_peatonal', 'registrar_entrada_vehicular', 'registrar_salida_vehicular', 'validar_usuario_apto_entrada', 
            'validar_usuario_apto_salida', 'consultar_movimientos', 'generar_informe_pdf', 'registrar_novedad_usuario', 'consultar_novedades_usuario', 
            'consultar_novedad_usuario', 'registrar_novedad_vehiculo', 'consultar_novedades_vehiculo', 'consultar_novedad_vehiculo', 
            'validar_usuario', 'validar_contrasena', 'conteo_total_usuarios', 'conteo_tipo_usuario', 'cerrar_sesion', 
            'registrar_vehiculo', 'consultar_vehiculos', 'consultar_vehiculo', 'consultar_propietarios', 'eliminar_propietario_vehiculo', 
            'conteo_tipo_vehiculo', 'registrar_vigilante', 'actualizar_vigilante', 'guardar_puerta', 'habilitar_vigilante', 
            'inhabilitar_vigilante', 'consultar_vigilantes', 'consultar_vigilante', 'consultar_puerta', 'registrar_visitante', 
            'consultar_visitantes', 'consultar_visitante'],
            
            'VIGILANTE RASO' => ['consultar_agendas', 'consultar_agenda', 'consultar_aprendices', 'consultar_aprendiz', 
            'consultar_funcionarios', 'consultar_funcionario', 'conteo_total_brigadistas', 'registrar_entrada_peatonal', 
            'registrar_salida_peatonal', 'registrar_entrada_vehicular', 'registrar_salida_vehicular', 'validar_usuario_apto_entrada', 
            'validar_usuario_apto_salida', 'registrar_novedad_usuario', 'registrar_novedad_vehiculo', 'validar_usuario', 
            'validar_contrasena', 'conteo_total_usuarios', 'conteo_tipo_usuario', 'cerrar_sesion', 'registrar_vehiculo', 
            'consultar_vehiculos', 'consultar_vehiculo', 'consultar_propietarios', 'conteo_tipo_vehiculo', 'guardar_puerta', 
            'consultar_vigilantes', 'consultar_vigilante', 'consultar_puerta', 'registrar_visitante', 'consultar_visitantes', 
            'consultar_visitante'],
            
            'COORDINADOR' => ['registrar_agenda', 'actualizar_agenda', 'eliminar_agenda', 'consultar_agendas', 'consultar_agenda', 
            'registrar_aprendiz', 'actualizar_aprendiz', 'consultar_aprendices', 'consultar_aprendiz', 'consultar_fichas', 
            'consultar_ficha', 'consultar_funcionarios', 'consultar_funcionario', 'conteo_total_brigadistas',  'validar_usuario', 
            'validar_contrasena', 'conteo_total_usuarios', 'conteo_tipo_usuario', 'cerrar_sesion', 'registrar_vehiculo', 
            'conteo_tipo_vehiculo', 'guardar_puerta', 'consultar_vigilantes', 'consultar_vigilante', 'registrar_visitante', 
            'consultar_visitantes', 'consultar_visitante'],
            
            'SUBDIRECTOR'=>['registrar_agenda', 'actualizar_agenda', 'eliminar_agenda', 'consultar_agendas', 'consultar_agenda', 
            'registrar_aprendiz', 'actualizar_aprendiz', 'consultar_aprendices', 'consultar_aprendiz', 'consultar_fichas', 
            'consultar_ficha', 'registrar_funcionario', 'actualizar_funcionario', 'consultar_funcionarios', 'consultar_funcionario', 
            'conteo_total_brigadistas',  'consultar_movimientos', 'consultar_movimientos_usuarios', 'generar_informe_pdf', 'consultar_novedades_usuario', 
            'consultar_novedad_usuario', 'consultar_novedades_vehiculo', 'consultar_novedad_vehiculo', 'validar_usuario', 
            'validar_contrasena', 'conteo_total_usuarios', 'conteo_tipo_usuario', 'cerrar_sesion', 'registrar_vehiculo', 
            'consultar_vehiculos', 'consultar_vehiculo', 'consultar_propietarios', 'eliminar_propietario_vehiculo', 
            'conteo_tipo_vehiculo', 'registrar_vigilante', 'actualizar_vigilante', 'habilitar_vigilante', 'inhabilitar_vigilante', 
            'consultar_vigilantes', 'consultar_vigilante', 'registrar_visitante', 'consultar_visitantes', 'consultar_visitante'],
            
            'INVITADO' => ['registrar_aprendiz', 'consultar_fichas', 'consultar_ficha', 'auto_registrar_funcionario',  
            'auto_registrar_vigilante', 'registrar_visitante', 'consultar_motivos_ingreso']
        ];

        if(isset($_SESSION['datos_usuario'])){
            $rol = $_SESSION['datos_usuario']['rol'];
            if(!in_array($permiso, $rolesPermisos[$rol])){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Acceso Denegado',
                    'mensaje'  => 'Lo sentimimos, no tienes acceso a este recurso'
                ];
                return $respuesta;
            }

        }else{
            if(!in_array($permiso, $rolesPermisos['INVITADO'])){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Acceso Denegado',
                    'mensaje'  => 'Lo sentimimos, no tienes acceso a este recurso'
                ];
                return $respuesta;
            }
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
}
