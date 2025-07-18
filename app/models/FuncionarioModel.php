<?php
namespace app\models;
use app\models\MainModel;
use DateTime;

class FuncionarioModel extends MainModel{
    private $objetoUsuario;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }
    
    public function registrarFuncionario($datosFuncionario){
        $respuesta = $this->validarDuplicidadFuncionario($datosFuncionario['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $sentenciaInsertar = "
            INSERT INTO funcionarios(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, tipo_contrato, brigadista, rol, fecha_fin_contrato, contrasena, fecha_registro, estado_usuario)
            VALUES('{$datosFuncionario['tipo_documento']}', '{$datosFuncionario['numero_documento']}', '{$datosFuncionario['nombres']}', '{$datosFuncionario['apellidos']}', '{$datosFuncionario['telefono']}', '{$datosFuncionario['correo_electronico']}', '{$datosFuncionario['tipo_contrato']}', '{$datosFuncionario['brigadista']}', '{$datosFuncionario['rol']}', {$datosFuncionario['fecha_fin_contrato']}, {$datosFuncionario['contrasena']}, '$fechaRegistro', {$datosFuncionario['estado_usuario']});";
        
        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo" => "OK",
            "titulo" => 'Registro Exitoso',
            "mensaje"=> 'El funcionario fue registrado correctamente.'
        ];
        return $respuesta;
    }

    public function actualizarFuncionario($datosFuncionario){
        $respuesta = $this->consultarFuncionario($datosFuncionario['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        $rolActual = $respuesta['datos_funcionario']['rol'];
        $estadoUsuarioActual = $respuesta['datos_funcionario']['estado_usuario'];

        if($rolActual != 'COORDINADOR' && $datosFuncionario['rol'] == 'COORDINADOR' && !isset($datosFuncionario['contrasena'])){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Contraseña Requerida',
                'mensaje' => 'Lo sentimos, pero es necesario que proporciones una contraseña para este usuario.'
            ];
            return $respuesta;
        }

        if($datosFuncionario['rol'] == 'COORDINADOR' && $estadoUsuarioActual == NULL){
            $datosFuncionario['estado_usuario'] = 'ACTIVO';
        }

        $sentenciaActualizar = "
            UPDATE funcionarios
            SET nombres = '{$datosFuncionario['nombres']}', apellidos = '{$datosFuncionario['apellidos']}', telefono = '{$datosFuncionario['telefono']}', correo_electronico = '{$datosFuncionario['correo_electronico']}', tipo_contrato = '{$datosFuncionario['tipo_contrato']}', rol = '{$datosFuncionario['rol']}', fecha_fin_contrato = {$datosFuncionario['fecha_fin_contrato']}";

        if(isset($datosFuncionario['contrasena'])){
            $sentenciaActualizar .= ", contrasena = {$datosFuncionario['contrasena']}";
        }

        if(isset($datosFuncionario['estado_usuario'])){
            $sentenciaActualizar .= ", estado_usuario = '{$datosFuncionario['estado_usuario']}'";
        }

        $sentenciaActualizar .= " WHERE numero_documento = '{$datosFuncionario['numero_documento']}'";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Actualización Exitosa',
            'mensaje' => 'El funcionario fue actualizado correctamente.'
        ];
        return $respuesta;
    }

    private function validarDuplicidadFuncionario($funcionario){
        $respuesta = $this->objetoUsuario->consultarUsuario($funcionario);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'OK'){
            $tipoUsuario = $respuesta['usuario']['tipo_usuario'];
            if($tipoUsuario == 'FUNCIONARIO'){
                $respuesta = [
                    'tipo' => "ERROR",
                    'titulo' => 'Usuario Existente',
                    'mensaje' => 'No fue posible realizar el registro, el usuario ya se encuentra registrado en el sistema como funcionario.'
                ];
                return $respuesta;
            }

            $tablaUsuario = $respuesta['usuario']['tabla_usuario'];
            $respuesta = $this->objetoUsuario->eliminarUsuario($funcionario, $tablaUsuario);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Usuario No Existente',
            "mensaje"=> 'El funcionario no se encuentra registrado en el sistema'
        ];
        return $respuesta;
    }

    public function habilitarFuncionario($datosFuncionario){
        $respuesta = $this->consultarFuncionario($datosFuncionario['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $estadoUsuario = $respuesta['datos_funcionario']['estado_usuario'];
        if($estadoUsuario == 'ACTIVO'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Usuario Activo',
                'mensaje' => 'No se pudo realiza la habilitacion, porque el funcionario ya se encuentra activo'
            ];
            return $respuesta;
        }

        $sentenciaActualizar = "
            UPDATE funcionarios SET contrasena = '{$datosFuncionario['contrasena']}', estado_usuario = 'ACTIVO' WHERE numero_documento = '{$datosFuncionario['numero_documento']}';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Usuario Activo',
            'mensaje' => 'El funcionario fue habilitado correctamente.'
        ];
        return $respuesta;
    }

    public function inhabilitarFuncionario($funcionario){
        $respuesta = $this->consultarFuncionario($funcionario);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $estadoUsuario = $respuesta['datos_funcionario']['estado_usuario'];
        if($estadoUsuario == 'INACTIVO'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Usuario Inactivo',
                'mensaje' => 'No se pudo realiza la inhabilitacion, porque el funcionario ya se encuentra inactivo'
            ];
            return $respuesta;
        }

        $sentenciaActualizar = "
            UPDATE funcionarios SET estado_usuario = 'INACTIVO' WHERE numero_documento = '$funcionario';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Usuario Inactivo',
            'mensaje' => 'El funcionario fue inhabilitado correctamente.'
        ];
        return $respuesta;
    }

    public function consultarFuncionarios($parametros){
        $sentenciaBuscar = "
            SELECT tipo_documento, numero_documento, nombres, apellidos, rol, telefono, correo_electronico, ubicacion, estado_usuario 
            FROM funcionarios 
            WHERE 1=1";
        
        if(isset($parametros['ubicacion'])){
            $sentenciaBuscar .= " AND ubicacion = '{$parametros['ubicacion']}'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND numero_documento LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['rol'])){
            $sentenciaBuscar .= " AND rol = '{$parametros['rol']}'";
        }

        if(isset($parametros['brigadista'])){
            $sentenciaBuscar .= " AND brigadista = '{$parametros['brigadista']}' ORDER BY fecha_registro DESC LIMIT 8;";

        }else{
            $sentenciaBuscar .= " ORDER BY fecha_registro DESC LIMIT 10;";
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

        $funcionarios = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'funcionarios' => $funcionarios
        ];
        return $respuesta;
    }

    public function consultarFuncionario($documento){
        $sentenciaBuscar = "
            SELECT 
                tipo_documento, 
                numero_documento, 
                nombres, apellidos, 
                telefono, 
                correo_electronico, 
                tipo_contrato, 
                brigadista, 
                rol,
                estado_usuario,
                COALESCE(fecha_fin_contrato, 'N/A') AS fecha_fin_contrato
            FROM funcionarios
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
                "titulo" => 'Funcionario No Encontrado',
                "mensaje"=> 'No se encontraron resultados del funcionario.'
            ];
            return $respuesta;
        }

        $funcionario = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_funcionario' => $funcionario
        ];
        return $respuesta;
    }


    public function conteoTotalBrigadistas(){
        $sentenciaBuscar = "
            SELECT numero_documento 
            FROM funcionarios 
            WHERE ubicacion = 'DENTRO' AND brigadista = 'SI';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if ($respuesta['tipo'] == 'ERROR') {
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        $totalBrigadistas= $respuestaSentencia->num_rows;
        $this->cerrarConexion();

        $respuesta = [
            'tipo' => "OK",
            'total_brigadistas' => $totalBrigadistas
        ];
        return $respuesta;
    }
}