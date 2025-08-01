<?php
namespace App\Models; 

class NovedadVehiculoModel extends MainModel{
    private $objetoVehiculo;
    private $objetoUsuario;

    public function __construct() {
        $this->objetoVehiculo = new VehiculoModel();
        $this->objetoUsuario = new UsuarioModel();
    }

    public function registrarNovedadVehiculo($datosNovedad){
        $respuesta = $this->objetoUsuario->consultarUsuario($datosNovedad['documento_involucrado']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoVehiculo->consultarVehiculo($datosNovedad['numero_placa']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $codigoNovedad = 'NV'.date('YmdHis');

        $sentenciaInsertar = "
            INSERT INTO novedades_vehiculos(codigo_novedad, tipo_novedad, fk_usuario_involucrado, fk_usuario_autoriza, fk_vehiculo, puerta_registro, descripcion, fecha_registro, fk_usuario_sistema) 
            VALUES('$codigoNovedad', '{$datosNovedad['tipo_novedad']}', '{$datosNovedad['documento_involucrado']}', '{$datosNovedad['propietario']}', '{$datosNovedad['numero_placa']}', '$puertaActual', '{$datosNovedad['descripcion']}', '$fechaRegistro', '$usuarioSistema');";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $datosVehiculo = [
            'propietario' => $datosNovedad['documento_involucrado'],
            'numero_placa' => $datosNovedad['numero_placa']
        ];

        $respuesta = $this->objetoVehiculo->registrarVehiculo($datosVehiculo);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Registro Exitoso',
            'mensaje' => 'La novedad fue registrada correctamente',
        ];
        return $respuesta;
    }

    public function consultarNovedadesVehiculo($parametros){
        $sentenciaBuscar = "
            SELECT 
                nv.codigo_novedad, 
                nv.tipo_novedad,
                nv.fecha_registro,
                nv.fk_usuario_involucrado,
                nv.fk_vehiculo,
                vh.tipo_vehiculo,
                COALESCE(fun.tipo_documento, apr.tipo_documento, vis.tipo_documento, vig.tipo_documento) AS tipo_documento,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos
            FROM novedades_vehiculos nv
            INNER JOIN (SELECT numero_placa, tipo_vehiculo FROM vehiculos GROUP BY numero_placa, tipo_vehiculo) vh ON nv.fk_vehiculo = vh.numero_placa
            LEFT JOIN funcionarios fun ON nv.fk_usuario_involucrado = fun.numero_documento
            LEFT JOIN visitantes vis ON nv.fk_usuario_involucrado = vis.numero_documento
            LEFT JOIN vigilantes vig ON nv.fk_usuario_involucrado = vig.numero_documento
            LEFT JOIN aprendices apr ON nv.fk_usuario_involucrado = apr.numero_documento
            WHERE 1 = 1";

        if(isset($parametros['fecha'])){
            $sentenciaBuscar .= " AND DATE(nv.fecha_registro) = '{$parametros['fecha']}'";
        }

        if(isset($parametros['numero_placa'])){
            $sentenciaBuscar .= " AND nv.fk_vehiculo LIKE '{$parametros['numero_placa']}%'";
        }

        if(isset($parametros['tipo_novedad'])){
            $sentenciaBuscar .= " AND nv.tipo_novedad = '{$parametros['tipo_novedad']}'";
        }

        $sentenciaBuscar .= " ORDER BY nv.fecha_registro DESC LIMIT 10;";

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

        $novedades = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'novedades' => $novedades
        ];
        return $respuesta;
    }

    public function consultarNovedadVehiculo($codigoNovedad){
        $sentenciaBuscar = "
            SELECT 
                nv.tipo_novedad, 
                nv.puerta_registro, 
                nv.fecha_registro,
                nv.descripcion,
                nv.fk_vehiculo,
                vig.nombres AS nombres_responsable,
                vig.apellidos AS apellidos_responsable,
                vh.tipo_vehiculo,
                COALESCE(fun1.nombres, apr1.nombres, vis1.nombres, vig1.nombres) AS nombres_involucrado,
                COALESCE(fun1.apellidos, apr1.apellidos, vis1.apellidos, vig1.apellidos) AS apellidos_involucrado,
                COALESCE(fun2.nombres, apr2.nombres, vis2.nombres, vig2.nombres) AS nombres_autorizador,
                COALESCE(fun2.apellidos, apr2.apellidos, vis2.apellidos, vig2.apellidos) AS apellidos_autorizador
            FROM novedades_vehiculos nv
            INNER JOIN vigilantes vig ON nv.fk_usuario_sistema = vig.numero_documento
            INNER JOIN (SELECT numero_placa, tipo_vehiculo FROM vehiculos GROUP BY numero_placa) vh ON nv.fk_vehiculo = vh.numero_placa
            LEFT JOIN funcionarios fun1 ON nv.fk_usuario_involucrado = fun1.numero_documento
            LEFT JOIN visitantes vis1 ON nv.fk_usuario_involucrado = vis1.numero_documento
            LEFT JOIN vigilantes vig1 ON nv.fk_usuario_involucrado = vig1.numero_documento
            LEFT JOIN aprendices apr1 ON nv.fk_usuario_involucrado = apr1.numero_documento
            LEFT JOIN funcionarios fun2 ON nv.fk_usuario_autoriza = fun2.numero_documento
            LEFT JOIN visitantes vis2 ON nv.fk_usuario_autoriza = vis2.numero_documento
            LEFT JOIN vigilantes vig2 ON nv.fk_usuario_autoriza = vig2.numero_documento
            LEFT JOIN aprendices apr2 ON nv.fk_usuario_autoriza = apr2.numero_documento
            WHERE nv.codigo_novedad = '$codigoNovedad'";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Novedad No Encontrada',
                "mensaje"=> 'No se encontraron resultados de la novedad'
            ];
            return $respuesta;
        }

        $novedad = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_novedad' => $novedad
        ];
        return $respuesta;
    }
}