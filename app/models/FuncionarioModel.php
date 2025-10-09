<?php
namespace App\Models;

class FuncionarioModel extends MainModel{
    private $objetoUsuario;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }
    
    public function registrarFuncionarioIndividual($datosFuncionario){
        $rolSistema = $_SESSION['datos_usuario']['rol'];
        if($rolSistema == 'COORDINADOR' && $datosFuncionario['rol'] != 'INSTRUCTOR'){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Rol No Autorizado',
                "mensaje"=> 'No tienes autorización para registrar funcionarios con este rol.'
            ];
            return $respuesta;
        }

        $respuesta = $this->validarDuplicidadFuncionario($datosFuncionario['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $datosFuncionario['ubicacion'] = 'FUERA';
        if(isset($respuesta['ubicacion'])){
            $datosFuncionario['ubicacion'] = $respuesta['ubicacion'];
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $sentenciaInsertar = "
            INSERT INTO funcionarios(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, tipo_contrato, brigadista, rol, fecha_fin_contrato, contrasena, ubicacion, fecha_registro, estado_usuario, rol_usuario_sistema, fk_usuario_sistema)
            VALUES('{$datosFuncionario['tipo_documento']}', '{$datosFuncionario['numero_documento']}', '{$datosFuncionario['nombres']}', '{$datosFuncionario['apellidos']}', '{$datosFuncionario['telefono']}', '{$datosFuncionario['correo_electronico']}', '{$datosFuncionario['tipo_contrato']}', '{$datosFuncionario['brigadista']}', '{$datosFuncionario['rol']}', {$datosFuncionario['fecha_fin_contrato']}, {$datosFuncionario['contrasena']}, '{$datosFuncionario['ubicacion']}', '$fechaRegistro', {$datosFuncionario['estado_usuario']}, '$rolSistema', '$usuarioSistema');";
        
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

    public function registrarFuncionarioCargaMasiva($datosFuncionarios){
        $rolSistema = $_SESSION['datos_usuario']['rol'];
        foreach ($datosFuncionarios as &$funcionario) {
            if($rolSistema == 'COORDINADOR' && $funcionario['rol'] != 'INSTRUCTOR'){
                $respuesta = [
                    "tipo" => "ERROR",
                    "titulo" => 'Rol No Autorizado',
                    "mensaje"=> 'No tienes autorización para registrar funcionarios con este rol.'
                ];
                return $respuesta;
            }

            $respuesta = $this->validarDuplicidadFuncionario($funcionario['numero_documento']);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

            $funcionario['ubicacion'] = 'FUERA';
            if(isset($respuesta['ubicacion'])){
                $funcionario['ubicacion'] = $respuesta['ubicacion'];
            }
        }
        unset($funcionario);

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        foreach ($datosFuncionarios as $funcionario) {
            $sentenciaInsertar = "
                INSERT INTO funcionarios(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, tipo_contrato, brigadista, rol, fecha_fin_contrato, contrasena, ubicacion, fecha_registro, estado_usuario, rol_usuario_sistema, fk_usuario_sistema)
                VALUES('{$funcionario['tipo_documento']}', '{$funcionario['numero_documento']}', '{$funcionario['nombres']}', '{$funcionario['apellidos']}', '{$funcionario['telefono']}', '{$funcionario['correo_electronico']}', '{$funcionario['tipo_contrato']}', '{$funcionario['brigadista']}', '{$funcionario['rol']}', {$funcionario['fecha_fin_contrato']}, {$funcionario['contrasena']}, '{$funcionario['ubicacion']}', '$fechaRegistro', {$funcionario['estado_usuario']}, '$rolSistema', '$usuarioSistema');";
            
            $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }

        $respuesta = [
            "tipo" => "OK",
            "titulo" => 'Registro Exitoso',
            "mensaje"=> 'Fueron registrados '.count($datosFuncionarios).' funcionarios correctamente.'
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
                    'mensaje' => 'No fue posible realizar el registro, el usuario con número de documento '.$funcionario.' ya se encuentra registrado en el sistema como funcionario.'
                ];
                return $respuesta;
            }

            $tablaUsuario = $respuesta['usuario']['tabla_usuario'];
            $ubicacionActual = $respuesta['usuario']['ubicacion'];
            $respuesta = $this->objetoUsuario->eliminarUsuario($funcionario, $tablaUsuario);
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

    public function actualizarFuncionario($datosFuncionario){
        $respuesta = $this->consultarFuncionario($datosFuncionario['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        $rolActual = $respuesta['datos_funcionario']['rol'];
        $estadoUsuarioActual = $respuesta['datos_funcionario']['estado_usuario'];

        if($rolActual != 'COORDINADOR' && $rolActual != 'INSTRUCTOR' && ($datosFuncionario['rol'] == 'COORDINADOR' || $datosFuncionario['rol'] == 'INSTRUCTOR') && !isset($datosFuncionario['contrasena'])){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Contraseña Requerida',
                'mensaje' => 'Lo sentimos, pero es necesario que proporciones una contraseña para este usuario.'
            ];
            return $respuesta;
        }

        if(($datosFuncionario['rol'] == 'COORDINADOR' || $datosFuncionario['rol'] == 'INSTRUCTOR') && $estadoUsuarioActual == NULL){
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

    public function habilitarFuncionario($datosFuncionario){
        $respuesta = $this->consultarFuncionario($datosFuncionario['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $rol = $respuesta['datos_funcionario']['rol'];
        $estadoUsuario = $respuesta['datos_funcionario']['estado_usuario'];
        
        if($rol != 'COORDINADOR' && $rol != 'INSTRUCTOR'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Rol Incorrecto',
                'mensaje' => 'No se pudo realizar la habilitación, porque este funcionario no tiene un rol autorizado para acceder al sistema.'
            ];
            return $respuesta;
        }

        if($estadoUsuario == 'ACTIVO'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Funcionario Activo',
                'mensaje' => 'No se pudo realizar la habilitación, porque el funcionario ya se encuentra activo'
            ];
            return $respuesta;
        }

        $sentenciaActualizar = "
            UPDATE funcionarios SET contrasena = '{$datosFuncionario['contrasena']}', estado_usuario = 'ACTIVO' 
            WHERE numero_documento = '{$datosFuncionario['numero_documento']}';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Habilitación Exitosa',
            'mensaje' => 'El funcionario fue habilitado correctamente.'
        ];
        return $respuesta;
    }

    public function inhabilitarFuncionario($funcionario){
        $respuesta = $this->consultarFuncionario($funcionario);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $rol = $respuesta['datos_funcionario']['rol'];
        $estadoUsuario = $respuesta['datos_funcionario']['estado_usuario'];
        
        if($rol != 'COORDINADOR' && $rol != 'INSTRUCTOR'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Rol Incorrecto',
                'mensaje' => 'No se pudo realizar la inhabilitación, porque este funcionario no tiene un rol autorizado para acceder al sistema.'
            ];
            return $respuesta;
        }

        if($estadoUsuario == 'INACTIVO'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Funcionario Inactivo',
                'mensaje' => 'No se pudo realizar la inhabilitación, porque el funcionario ya se encuentra inactivo.'
            ];
            return $respuesta;
        }

        $sentenciaActualizar = "
            UPDATE funcionarios SET estado_usuario = 'INACTIVO' 
            WHERE numero_documento = '$funcionario';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Inhabilitación Exitosa',
            'mensaje' => 'El funcionario fue inhabilitado correctamente.'
        ];
        return $respuesta;
    }

    public function consultarFuncionarios($parametros){
        $sentenciaBuscar = "
            SELECT tipo_documento, numero_documento, nombres, apellidos, rol, telefono, correo_electronico, ubicacion, estado_usuario 
            FROM funcionarios 
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

        if(isset($parametros['brigadista'])){
            $sentenciaBuscar .= " AND brigadista = '{$parametros['brigadista']}' ORDER BY fecha_registro DESC LIMIT 8;";

        }else{
            $rolSistema = $_SESSION['datos_usuario']['rol'];
            if(!isset($parametros['numero_documento'], $parametros['rol'], $parametros['ubicacion']) && $rolSistema == 'COORDINADOR'){
                $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
                $sentenciaBuscar .= " AND fk_usuario_sistema = '$usuarioSistema'";
            }

            $sentenciaBuscar .= " ORDER BY fecha_registro DESC";

            if(!isset($parametros['numero_documento'], $parametros['rol'], $parametros['ubicacion'])){
                $sentenciaBuscar .= " LIMIT 10;";
            }
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
                fun.tipo_documento, 
                fun.numero_documento, 
                fun.nombres, 
                fun.apellidos, 
                fun.telefono, 
                fun.correo_electronico, 
                fun.tipo_contrato, 
                fun.brigadista, 
                fun.rol,
                fun.estado_usuario,
                COALESCE(fun.fecha_fin_contrato, 'N/A') AS fecha_fin_contrato,
                COALESCE(fun2.nombres, apr.nombres, vis.nombres, vig.nombres, 'N/A') AS nombres_responsable,
                COALESCE(fun2.apellidos, apr.apellidos, vis.apellidos, vig.apellidos, 'N/A') AS apellidos_responsable,
                COALESCE(fun.rol_usuario_sistema, 'N/A') AS rol_responsable
            FROM funcionarios fun
            LEFT JOIN funcionarios fun2 ON fun.fk_usuario_sistema = fun2.numero_documento
            LEFT JOIN aprendices apr ON fun.fk_usuario_sistema = apr.numero_documento
            LEFT JOIN vigilantes vig ON fun.fk_usuario_sistema = vig.numero_documento
            LEFT JOIN visitantes vis ON fun.fk_usuario_sistema = vis.numero_documento
            WHERE fun.numero_documento = '$documento';";

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