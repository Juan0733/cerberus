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
                    FROM ".$tabla." 
                    INNER JOIN fichas ON fk_ficha = numero_ficha 
                    WHERE numero_documento = '".$usuario."';";
            }else{
                $sentenciaBuscar = "
                    SELECT * 
                    FROM ".$tabla." 
                    WHERE numero_documento = '".$usuario."';";
            }
            
            $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
            if (!$respuestaSentencia) {
                $respuesta = [
                    "tipo"=>"ERROR",
                    "titulo" => 'Error de Conexión',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                ];
                return $respuesta;
            }

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

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaActualizar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR", 
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                "icono" => "warning",
            ];
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Ubicación Actualizada',
            "mensaje"=> 'La ubicación del usuario fue actualizada correctamente.'
        ];
        return $respuesta;
    }

    public function cambiarGrupoUsuario($tablaOrigen, $tablaDestino, $datosUsuario){
        $sentenciaEliminar = "
            DELETE 
            FROM $tablaOrigen 
            WHERE numero_documento = '".$datosUsuario['numero_documento']."' ;";
        
        $respuestaSentencia = $this->ejecutarConsulta($sentenciaEliminar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                "icono" => "warning",
            ];
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:s:i');

        if($tablaDestino == 'aprendices'){
            $sentenciaInsertar = "
                INSERT INTO aprendices(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, fk_ficha, fecha_registro) 
                VALUES('".$datosUsuario['tipo_documento']."', '".$datosUsuario['numero_documento']."', '".$datosUsuario['nombres']."', '".$datosUsuario['apellidos']."', '".$datosUsuario['telefono']."', '".$datosUsuario['correo_electronico']."', '".$datosUsuario['numero_ficha']."', '$fechaRegistro')";

        }elseif($tablaDestino == 'funcionarios'){
            if($datosUsuario['rol'] == 'subdirector' || $datosUsuario['rol'] == 'coordinador' || $datosUsuario['rol'] == 'bienestar aprendiz'){
                $sentenciaInsertar = "
                    INSERT INTO funcionarios(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, rol, tipo_contrato, fecha_fin_contrato, contrasena, fecha_registro, estado) 
                    VALUES('".$datosUsuario['tipo_documento']."', '".$datosUsuario['numero_documento']."', '".$datosUsuario['nombres']."', '".$datosUsuario['apellidos']."', '".$datosUsuario['telefono']."', '".$datosUsuario['correo_electronico']."', '".$datosUsuario['rol']."', '".$datosUsuario['tipo_contrato']."', '".$datosUsuario['fecha_fin_contrato']."', MD5('".$datosUsuario['contrasena']."'), '$fechaRegistro', 'ACTIVO')";
            }else{  
                $sentenciaInsertar = "
                INSERT INTO funcionarios(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, rol, tipo_contrato, fecha_fin_contrato, fecha_registro) VALUES('".$datosUsuario['tipo_documento']."', '".$datosUsuario['numero_documento']."', '".$datosUsuario['nombres']."', '".$datosUsuario['apellidos']."', '".$datosUsuario['telefono']."', '".$datosUsuario['correo_electronico']."', '".$datosUsuario['rol']."', '".$datosUsuario['tipo_contrato']."', '".$datosUsuario['fecha_fin_contrato']."', '$fechaRegistro')";
            }
           
        }elseif($tablaDestino == 'visitantes'){
            $sentenciaInsertar = "
                INSERT INTO visitantes(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, motivo_ingreso, fecha_registro) 
                VALUES('".$datosUsuario['tipo_documento']."', '".$datosUsuario['numero_documento']."', '".$datosUsuario['nombres']."', '".$datosUsuario['apellidos']."', '".$datosUsuario['telefono']."', '".$datosUsuario['correo_electronico']."', '".$datosUsuario['motivo_ingreso']."', '$fechaRegistro')";

        }elseif($tablaDestino == 'vigilantes'){
            $sentenciaInsertar = "
                INSERT INTO visitantes(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, rol, fecha_registro) 
                VALUES('".$datosUsuario['tipo_documento']."', '".$datosUsuario['numero_documento']."', '".$datosUsuario['nombres']."', '".$datosUsuario['apellidos']."', '".$datosUsuario['telefono']."', '".$datosUsuario['correo_electronico']."', '".$datosUsuario['rol']."', MD5('".$datosUsuario['contrasena']."'), '$fechaRegistro')";
        }

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                "icono" => "warning",
            ];
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Cambio Éxitoso',
            "mensaje"=> 'El usuario fue cambiado de grupo exitosamente.',
            "icono" => "success",
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
                    WHERE  numero_documento = '$usuario' AND estado_usuario = 'ACTIVO' AND (rol = 'coordinador' OR rol = 'subdirector' OR rol = 'bienestar aprendiz');";
            }
            
            $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);

            if (!$respuestaSentencia) {
                $respuesta = [
                    "tipo"=> "ERROR",
                    "titulo" => 'Error de Conexión',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                    "icono" => "warning"
                    
                ];
                return $respuesta;
            }

            if ($respuestaSentencia->num_rows > 0) {
                $respuesta = [
                    'tipo' => 'OK',
                    'tabla' => $tabla
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
        $sentenciaBuscar = "
            SELECT * 
            FROM ".$datosLogin['tabla']."
            WHERE  numero_documento = '".$datosLogin['usuario']."' AND contrasena = MD5('".$datosLogin['contrasena']."') AND estado_usuario = 'ACTIVO';";
                    
        $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
        if (!$respuestaSentencia) {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                "icono" => "warning",
                "cod_error"=> "350"
            ];
            return $respuesta;
        }

        if ($respuestaSentencia->num_rows < 1) {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Acceso Denegado',
                "mensaje"=> 'Lo sentimos, parece que tu contraseña es incorrecta.',
                "icono" => "warning",
            ];
            return $respuesta;
        }

        $datosUsuario = $respuestaSentencia->fetch_assoc();
        $datosUsuario['puerta'] = 'peatonal';
        // Se valida nuevamente que el rol del usuario tenga acceso al sistema
        if($datosUsuario['rol'] == 'bienestar aprendiz'){
            $panelAcceso = 'estadias/';
        }else{
            $panelAcceso = 'inicio/';
        }

        $_SESSION['datos_usuario'] = $datosUsuario;
        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Login Éxitoso',
            'mensaje' => 'Usuario autorizado para acceder a cerberus',
            'ruta' => $panelAcceso
        ];
        return $respuesta;
    }


    public function cerrarSesion($urlBase){
        session_destroy();

        if(headers_sent()){
            echo "<script> window.location.href='".$urlBase."'; </script>";
        }else{
            header("Location: ".$urlBase);
        }
        
    }


    public function conteoTotalUsuarios(){
        $tablas = ['vigilantes', 'visitantes', 'funcionarios', 'aprendices'];
        $totalUsuarios = 0;

        foreach($tablas as $tabla){
            $sentenciaBuscar = "
                SELECT numero_documento 
                FROM ".$tabla." 
                WHERE ubicacion = 'DENTRO';";

            $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
            if (!$respuestaSentencia) {
                $respuesta = [
                    "tipo"=>"ERROR",
                    "titulo" => 'Error de Conexión',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                    "icono" => "warning"
                ];
                return $respuesta;
            }

            $totalUsuarios += $respuestaSentencia->num_rows;
        }

        $respuesta = [
            'tipo' => "OK",
            'titulo'=> "Conteo Éxitoso",
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
                FROM ".$tabla." 
                WHERE ubicacion = 'DENTRO';";

            $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
            if (!$respuestaSentencia) {
                $respuesta = [
                    "tipo"=>"ERROR",
                    "titulo" => 'Error de Conexión',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                    "icono" => "warning",
                ];
                return $respuesta;
            }

            $cantidad = $respuestaSentencia->num_rows;
            $usuarios[] = [
                'tipo_usuario' => $tabla,
                'cantidad' => $cantidad
            ];

            $totalUsuarios += $cantidad;
        }

        foreach ($usuarios as &$usuario) {
            // Se calcula el porcentaje de cada tipo de usuario que se encuentran dentro del sena sobre el total general de usuarios.
            if($usuario['cantidad'] < 1){
                $porcentaje = 0;
            }else{
                $porcentaje = number_format($usuario['cantidad']*100/$totalUsuarios, 1, '.', '');
            }

            $usuario['porcentaje'] = $porcentaje;
        }

        $respuesta = [
            'tipo' => "OK",
            'titulo'=> "Conteo Éxitoso",
            'mensaje' => "El conteo de usuarios fue realizado con éxito.",
            'usuarios' => $usuarios
        ];

        return $respuesta;
    }
}
