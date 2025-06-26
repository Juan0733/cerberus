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
                $datosUsuario['puerta'] = 'peatonal';
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
