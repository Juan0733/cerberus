<?php
namespace App\Models;

class VigilanteModel extends MainModel{
    private $objetoUsuario;
    
    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

    public function registrarVigilanteIndividual($datosVigilante){
        $rolSistema = $_SESSION['datos_usuario']['rol'];
        if($rolSistema == 'SUPERVISOR' && $datosVigilante['rol'] != 'VIGILANTE'){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Rol No Autorizado',
                "mensaje"=> 'No tienes autorización para registrar vigilantes con este rol.'
            ];
            return $respuesta;
        }

        $respuesta = $this->validarDuplicidadVigilante($datosVigilante['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $datosVigilante['ubicacion'] = 'FUERA';
        if(isset($respuesta['ubicacion'])){
            $datosVigilante['ubicacion'] = $respuesta['ubicacion'];
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $sentenciaInsertar = "
            INSERT INTO vigilantes(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, rol, contrasena, ubicacion, fecha_registro, estado_usuario, fk_usuario_sistema) 
            VALUES('{$datosVigilante['tipo_documento']}', '{$datosVigilante['numero_documento']}', '{$datosVigilante['nombres']}', '{$datosVigilante['apellidos']}', '{$datosVigilante['telefono']}', '{$datosVigilante['correo_electronico']}', '{$datosVigilante['rol']}', '{$datosVigilante['contrasena']}', '{$datosVigilante['ubicacion']}', '$fechaRegistro', '{$datosVigilante['estado_usuario']}', '$usuarioSistema')";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo" => "OK",
            "titulo" => 'Registro Exitoso',
            "mensaje"=> 'El vigilante fue registrado correctamente.'
        ];
        return $respuesta;
    }

    public function registrarVigilanteCargaMasiva($datosVigilantes){
        $rolSistema = $_SESSION['datos_usuario']['rol'];

        foreach ($datosVigilantes as &$vigilante) {
            if($rolSistema == 'SUPERVISOR' && $vigilante['rol'] != 'VIGILANTE'){
                $respuesta = [
                    "tipo" => "ERROR",
                    "titulo" => 'Rol No Autorizado',
                    "mensaje"=> 'No tienes autorización para registrar vigilantes con este rol.'
                ];
                return $respuesta;
            }

            $respuesta = $this->validarDuplicidadvigilante($vigilante['numero_documento']);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

            $vigilante['ubicacion'] = 'FUERA';
            if(isset($respuesta['ubicacion'])){
                $vigilante['ubicacion'] = $respuesta['ubicacion'];
            }
        }
        unset($vigilante);

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        foreach ($datosVigilantes as $vigilante) {
            $sentenciaInsertar = "
                INSERT INTO vigilantes(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, rol, contrasena, ubicacion, fecha_registro, estado_usuario, fk_usuario_sistema)
                VALUES('{$vigilante['tipo_documento']}', '{$vigilante['numero_documento']}', '{$vigilante['nombres']}', '{$vigilante['apellidos']}', '{$vigilante['telefono']}', '{$vigilante['correo_electronico']}', '{$vigilante['rol']}', '{$vigilante['contrasena']}', '{$vigilante['ubicacion']}', '$fechaRegistro', '{$vigilante['estado_usuario']}', '$usuarioSistema');";
            
            $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }

        $respuesta = [
            "tipo" => "OK",
            "titulo" => 'Registro Exitoso',
            "mensaje"=> 'El vigilante fue registrado correctamente.'
        ];
        return $respuesta;
    }

    public function actualizarVigilante($datosVigilante){
        $respuesta = $this->consultarVigilante($datosVigilante['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $sentenciaActualizar = "
            UPDATE vigilantes SET nombres = '{$datosVigilante['nombres']}', apellidos = '{$datosVigilante['apellidos']}', telefono = '{$datosVigilante['telefono']}', correo_electronico = '{$datosVigilante['correo_electronico']}', rol = '{$datosVigilante['rol']}'";
        
        if(isset($datosVigilante['contrasena'])){
            $sentenciaActualizar .= ", contrasena = '{$datosVigilante['contrasena']}'";
        }

        $sentenciaActualizar .= " WHERE numero_documento = '{$datosVigilante['numero_documento']}'";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Actualización Exitosa',
            'mensaje' => 'El vigilante fue actualizado correctamente.'
        ];
        return $respuesta;
    }

    public function habilitarVigilante($datosVigilante){
        $respuesta = $this->consultarVigilante($datosVigilante['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $estadoUsuario = $respuesta['datos_vigilante']['estado_usuario'];
        if($estadoUsuario == 'ACTIVO'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Vigilante Activo',
                'mensaje' => 'No se pudo realiza la habilitación, porque el vigilante ya se encuentra activo'
            ];
            return $respuesta;
        }

        $sentenciaActualizar = "
            UPDATE vigilantes SET contrasena = '{$datosVigilante['contrasena']}', estado_usuario = 'ACTIVO' WHERE numero_documento = '{$datosVigilante['numero_documento']}';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Habilitación Exitosa',
            'mensaje' => 'El vigilante fue habilitado correctamente.'
        ];
        return $respuesta;
    }

    public function inhabilitarVigilante($vigilante){
        $respuesta = $this->consultarVigilante($vigilante);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $estadoUsuario = $respuesta['datos_vigilante']['estado_usuario'];
        if($estadoUsuario == 'INACTIVO'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Usuario Inactivo',
                'mensaje' => 'No se pudo realiza la inhabilitación, porque el vigilante ya se encuentra inactivo'
            ];
            return $respuesta;
        }

        $sentenciaActualizar = "
            UPDATE vigilantes SET estado_usuario = 'INACTIVO' WHERE numero_documento = '$vigilante';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Inhabilitación Exitosa',
            'mensaje' => 'El vigilante fue inhabilitado correctamente.'
        ];
        return $respuesta;
    }

    private function validarDuplicidadVigilante($vigilante){
        $respuesta = $this->objetoUsuario->consultarUsuario($vigilante);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'OK'){
            $tipoUsuario = $respuesta['usuario']['tipo_usuario'];
            if($tipoUsuario == 'VIGILANTE'){
                $respuesta = [
                    'tipo' => "ERROR",
                    'titulo' => 'Usuario Existente',
                    'mensaje' => 'No fue posible realizar el registro, el usuario con número de documento '.$vigilante.' ya se encuentra registrado en el sistema como vigilante.'
                ];
                return $respuesta;
            }

            $tablaUsuario = $respuesta['usuario']['tabla_usuario'];
            $ubicacionActual = $respuesta['usuario']['ubicacion'];
            $respuesta = $this->objetoUsuario->eliminarUsuario($vigilante, $tablaUsuario);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

            $respuesta['ubicacion'] = $ubicacionActual;
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Usuario No Existente',
            "mensaje"=> 'El usuario no se encuentra registrado en el sistema'
        ];
        return $respuesta;
    }

    public function consultarVigilantes($parametros){
        $sentenciaBuscar = "
            SELECT tipo_documento, numero_documento, nombres, apellidos, telefono, ubicacion, estado_usuario, rol
            FROM vigilantes
            WHERE 1=1";

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND numero_documento LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['rol'])){
            $sentenciaBuscar .= " AND rol = '{$parametros['rol']}'";
        }

        if(isset($parametros['ubicacion'])){
            $sentenciaBuscar .= " AND ubicacion = '{$parametros['ubicacion']}'";
        }

        $sentenciaBuscar .= " ORDER BY fecha_registro DESC";

        if(!isset($parametros['ubicacion']) || $parametros['ubicacion'] != 'DENTRO'){
            $sentenciaBuscar .= " LIMIT 10;";
        }

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

        $vigilantes = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'vigilantes' => $vigilantes
        ];
        return $respuesta;
    }

    public function consultarVigilante($documento){
        $sentenciaBuscar = "
            SELECT tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, rol, estado_usuario
            FROM vigilantes
            WHERE numero_documento = '$documento';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Vigilante No Encontrado',
                "mensaje"=> 'No se encontraron resultados del vigilante'
            ];
            return $respuesta;
        }

        $vigilante = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_vigilante' => $vigilante
        ];
        return $respuesta;
    }

    public function guardarPuerta($puerta){
        $_SESSION['datos_usuario']['puerta'] = $puerta;

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Cambio de Puerta',
            'mensaje' => 'La puerta se guardó correctamente.'
        ];
        return $respuesta;
    }

    public function consultarPuertaActual(){
        if(!isset($_SESSION['datos_usuario']['puerta'])){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Puerta No Encontrada',
                'mensaje' => 'No se encontro una puerta seleccionada actualmente.'
            ];
            return $respuesta;
        }
        
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $respuesta = [
            'tipo' => 'OK',
            'puerta_actual' => $puertaActual
        ];
        return $respuesta;
    }
}