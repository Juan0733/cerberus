<?php
namespace App\Models;

class AprendizModel extends MainModel{
    private $objetoUsuario;
    private $objetoFicha;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
        $this->objetoFicha = new FichaModel();
    }

    public function registrarAprendizIndividual($datosAprendiz){
        $respuesta = $this->validarDuplicidadAprendiz($datosAprendiz['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $datosAprendiz['ubicacion'] = 'FUERA';
        if(isset($respuesta['ubicacion'])){
            $datosAprendiz['ubicacion'] = $respuesta['ubicacion'];
        }

        $datosFicha = [
            'numero_ficha' => $datosAprendiz['numero_ficha'],
            'nombre_programa' => $datosAprendiz['nombre_programa'],
            'fecha_fin_ficha' => $datosAprendiz['fecha_fin_ficha']
        ];
        $respuesta = $this->objetoFicha->registrarFicha($datosFicha);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $rolSistema = $_SESSION['datos_usuario']['rol'];
        $sentenciaInsertar = "
            INSERT INTO aprendices(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, fk_ficha, ubicacion, fecha_registro, rol_usuario_sistema, fk_usuario_sistema)
            VALUES('{$datosAprendiz['tipo_documento']}', '{$datosAprendiz['numero_documento']}', '{$datosAprendiz['nombres']}', '{$datosAprendiz['apellidos']}', '{$datosAprendiz['telefono']}', '{$datosAprendiz['correo_electronico']}', '{$datosAprendiz['numero_ficha']}', '{$datosAprendiz['ubicacion']}', '$fechaRegistro', '$rolSistema', '$usuarioSistema');";
        
        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo" => "OK",
            "titulo" => 'Registro Exitoso',
            "mensaje"=> 'El aprendiz fue registrado correctamente.'
        ];
        return $respuesta;
    }

    public function registrarAprendizCargaMasiva($datosAprendices){
        foreach($datosAprendices as &$aprendiz){
            $respuesta = $this->validarDuplicidadAprendiz($aprendiz['numero_documento']);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

            $aprendiz['ubicacion'] = 'FUERA';
            if(isset($respuesta['ubicacion'])){
                $aprendiz['ubicacion'] = $respuesta['ubicacion'];
            }

            $datosFicha = [
                'numero_ficha' => $aprendiz['numero_ficha'],
                'nombre_programa' => $aprendiz['nombre_programa'],
                'fecha_fin_ficha' => $aprendiz['fecha_fin_ficha']
            ];

            $respuesta = $this->objetoFicha->registrarFicha($datosFicha);
            if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
                return $respuesta;
            }
        }
        unset($aprendiz);
        
        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $rolSistema = $_SESSION['datos_usuario']['rol'];

        foreach ($datosAprendices as $aprendiz) {
            $sentenciaInsertar = "
                INSERT INTO aprendices(tipo_documento, numero_documento, nombres, apellidos, telefono, correo_electronico, fk_ficha, ubicacion, fecha_registro, rol_usuario_sistema, fk_usuario_sistema)
                VALUES('{$aprendiz['tipo_documento']}', '{$aprendiz['numero_documento']}', '{$aprendiz['nombres']}', '{$aprendiz['apellidos']}', '{$aprendiz['telefono']}', '{$aprendiz['correo_electronico']}', '{$aprendiz['numero_ficha']}', '{$aprendiz['ubicacion']}', '$fechaRegistro', '$rolSistema', '$usuarioSistema');";
            
            $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }

        $respuesta = [
            "tipo" => "OK",
            "titulo" => 'Registro Exitoso',
            "mensaje"=> 'Fueron registrados '.count($datosAprendices).' aprendices correctamente.'
        ];
        return $respuesta;
    }

    public function actualizarAprendiz($datosAprendiz){
        $respuesta = $this->consultarAprendiz($datosAprendiz['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $datosFicha = [
            'numero_ficha' => $datosAprendiz['numero_ficha'],
            'nombre_programa' => $datosAprendiz['nombre_programa'],
            'fecha_fin_ficha' => $datosAprendiz['fecha_fin_ficha']
        ];
        $respuesta = $this->objetoFicha->registrarFicha($datosFicha);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;
        }

        $sentenciaActualizar = "
            UPDATE aprendices 
            SET nombres = '{$datosAprendiz['nombres']}', apellidos = '{$datosAprendiz['apellidos']}', telefono = '{$datosAprendiz['telefono']}', correo_electronico = '{$datosAprendiz['correo_electronico']}', fk_ficha = '{$datosAprendiz['numero_ficha']}'
            WHERE numero_documento = '{$datosAprendiz['numero_documento']}'";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Actualización Exitosa',
            'mensaje' => 'El aprendiz fue actualizado correctamente.'
        ];
        return $respuesta;
    }

    private function validarDuplicidadAprendiz($aprendiz){
        $respuesta = $this->objetoUsuario->consultarUsuario($aprendiz);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'OK'){
            $tipoUsuario = $respuesta['usuario']['tipo_usuario'];
            if($tipoUsuario == 'APRENDIZ'){
                $respuesta = [
                    'tipo' => "ERROR",
                    'titulo' => 'Usuario Existente',
                    'mensaje' => 'No fue posible realizar el registro, el usuario con número de documento '.$aprendiz.' ya se encuentra registrado en el sistema como aprendiz.'
                ];
                return $respuesta;
            }

            $tablaUsuario = $respuesta['usuario']['tabla_usuario'];
            $ubicacionActual = $respuesta['usuario']['ubicacion'];
            $respuesta = $this->objetoUsuario->eliminarUsuario($aprendiz, $tablaUsuario);
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

    public function consultarAprendices($parametros){
        $sentenciaBuscar = "
            SELECT tipo_documento, numero_documento, nombres, apellidos, telefono, ubicacion
            FROM aprendices
            WHERE 1=1";

        $rolSistema = $_SESSION['datos_usuario']['rol'];
        if(!isset($parametros['numero_ficha'], $parametros['numero_documento'], $parametros['ubicacion']) && ($rolSistema == 'SUBDIRECTOR' || $rolSistema == 'COORDINADOR' || $rolSistema == 'INSTRUCTOR')){
            $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
            $sentenciaBuscar .= " AND fk_usuario_sistema = '$usuarioSistema'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND numero_documento LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['numero_ficha'])){
            $sentenciaBuscar .= " AND fk_ficha LIKE '{$parametros['numero_ficha']}%'";
        }

        if(isset($parametros['ubicacion'])){
            $sentenciaBuscar .= " AND ubicacion = '{$parametros['ubicacion']}'";
        }

        $sentenciaBuscar .= " ORDER BY fecha_registro DESC";

        if(isset($parametros['cantidad_registros'])){
            $sentenciaBuscar .= " LIMIT {$parametros['cantidad_registros']};";
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

        $aprendices = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'aprendices' => $aprendices
        ];
        return $respuesta;
    }

    public function consultarAprendiz($documento){
        $sentenciaBuscar = "
            SELECT 
                apr.tipo_documento, 
                apr.numero_documento, 
                apr.nombres, 
                apr.apellidos, 
                apr.telefono, 
                apr.correo_electronico, 
                fich.numero_ficha, 
                fich.nombre_programa, 
                fich.fecha_fin_ficha,
                COALESCE(fun.nombres, apr2.nombres, vis.nombres, vig.nombres) AS nombres_responsable,
                COALESCE(fun.apellidos, apr2.apellidos, vis.apellidos, vig.apellidos) AS apellidos_responsable,
                apr.rol_usuario_sistema AS rol_responsable
            FROM aprendices apr
            INNER JOIN fichas fich ON apr.fk_ficha = fich.numero_ficha
            LEFT JOIN funcionarios fun ON apr.fk_usuario_sistema = fun.numero_documento
            LEFT JOIN aprendices apr2 ON apr.fk_usuario_sistema = apr2.numero_documento
            LEFT JOIN vigilantes vig ON apr.fk_usuario_sistema = vig.numero_documento
            LEFT JOIN visitantes vis ON apr.fk_usuario_sistema = vis.numero_documento
            WHERE apr.numero_documento = '$documento';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Aprendiz No Encontrado',
                "mensaje"=> 'No se encontraron resultados del aprendiz.'
            ];
            return $respuesta;
        }

        $aprendiz = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_aprendiz' => $aprendiz
        ];
        return $respuesta;
    }
}