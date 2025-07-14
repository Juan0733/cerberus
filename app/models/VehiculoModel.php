<?php

namespace app\models;

use DateTime;

class VehiculoModel extends MainModel {

    private $objetoUsuario;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
    }

    public function registrarVehiculo($datosVehiculo){
        $respuesta = $this->objetoUsuario->consultarUsuario($datosVehiculo['propietario']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->consultarVehiculo($datosVehiculo['numero_placa']);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'OK'){
            $datosVehiculo['ubicacion'] = $respuesta['datos_vehiculo']['ubicacion'];
            $datosVehiculo['tipo_vehiculo'] = $respuesta['datos_vehiculo']['tipo_vehiculo'];

            $respuesta = $this->validarDuplicidadPropietarios($datosVehiculo['numero_placa'], $datosVehiculo['propietario']);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }
        
        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        if(!isset($datosVehiculo['ubicacion'])){
            $datosVehiculo['ubicacion'] = 'FUERA';
        }
        $sentenciaInsertar = "
            INSERT INTO vehiculos (numero_placa, tipo_vehiculo, fk_usuario, fecha_registro, ubicacion, fk_usuario_sistema) 
            VALUES ('{$datosVehiculo['numero_placa']}', '{$datosVehiculo['tipo_vehiculo']}', '{$datosVehiculo['propietario']}', '$fechaRegistro', '{$datosVehiculo['ubicacion']}', '$usuarioSistema');";
        
        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if ($respuesta['tipo'] == 'ERROR') {
            return $respuesta;    
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Registro Exitoso',
            "mensaje"=> 'El vehículo fue registrado correctamente.'
        ];
        return $respuesta;
    }

    public function consultarVehiculos($parametros){
        $sentenciaBuscar = "
            SELECT numero_placa, tipo_vehiculo, ubicacion
            FROM vehiculos 
            WHERE 1=1";

        if(isset($parametros['numero_placa'])){
            $sentenciaBuscar .= " AND numero_placa LIKE '{$parametros['numero_placa']}%'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND fk_usuario LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['tipo_vehiculo'])){
            $sentenciaBuscar .= " AND tipo_vehiculo ='{$parametros['tipo_vehiculo']}'";
        }

        if(isset($parametros['ubicacion'])){
            $sentenciaBuscar .= " AND ubicacion = '{$parametros['ubicacion']}'";
        }

        $sentenciaBuscar .= " 
            GROUP BY numero_placa, tipo_vehiculo, ubicacion
            LIMIT 10;";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if ($respuesta['tipo'] == 'ERROR') {
            return $respuesta;    
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No Encontrados',
                "mensaje"=> 'No se encontraron resultados.'
            ];
            return $respuesta;
        }

        $vehiculos = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $respuesta = [
            "tipo"=>"OK",
            "vehiculos" => $vehiculos
        ];
        return $respuesta;
    }

    public function consultarVehiculo($placa){
        $sentenciaBuscar = "
            SELECT numero_placa, tipo_vehiculo, ubicacion
            FROM vehiculos 
            WHERE numero_placa = '$placa'
            GROUP BY numero_placa, tipo_vehiculo, ubicacion;";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if ($respuesta['tipo'] == 'ERROR') {
            return $respuesta;    
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Vehículo No Encontrado',
                "mensaje"=> 'Lo sentimos, parece que el vehículo de placas '.$placa.' no se encuentra registrado en el sistema.'
            ];
            return $respuesta;
        }

        $datosVehiculo = $respuestaSentencia->fetch_assoc();
        $respuesta = [
            "tipo" => "OK",
            "datos_vehiculo" => $datosVehiculo
        ];
        return $respuesta;
    }

    public function consultarPropietarioVehiculo($placa, $propietario){
        $sentenciaBuscar = "
            SELECT numero_placa, tipo_vehiculo, ubicacion
            FROM vehiculos 
            WHERE numero_placa = '$placa' AND fk_usuario = '$propietario';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if ($respuesta['tipo'] == 'ERROR') {
            return $respuesta;    
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No Encontrados',
                "mensaje"=> 'No se encontro datos relacionados con el vehículo de placas '.$placa.' y el usuario con número de  documento '.$propietario.'.'
            ];
            return $respuesta;
        }

        $vehiculo = $respuestaSentencia->fetch_assoc();
        $respuesta = [
            "tipo" => "OK",
            'titulo' => "Vehículo Encontrado",
            "mensaje" => "El vehículo se encuentra registrado en el sistema.",
            'datos_vehiculo' => $vehiculo
        ];
        return $respuesta;
    }

    public function consultarPropietarios($placa){
        $sentenciaBuscar = "
            SELECT 
                veh.tipo_vehiculo,
                COALESCE(fun.tipo_documento, vis.tipo_documento, vig.tipo_documento, apr.tipo_documento) AS tipo_documento,
                COALESCE(fun.numero_documento, vis.numero_documento, vig.numero_documento, apr.numero_documento) AS numero_documento,  
                COALESCE(fun.nombres, vis.nombres, vig.nombres, apr.nombres) AS nombres,
                COALESCE(fun.apellidos, vis.apellidos, vig.apellidos, apr.apellidos) AS apellidos,
                COALESCE(fun.telefono, vis.telefono, vig.telefono, apr.telefono) AS telefono,
                COALESCE(fun.ubicacion, vis.ubicacion, vig.ubicacion, apr.ubicacion) AS ubicacion
            FROM vehiculos veh
            LEFT JOIN funcionarios fun ON veh.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON veh.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON veh.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON veh.fk_usuario = apr.numero_documento
            WHERE veh.numero_placa = '$placa'";
        
        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if ($respuesta['tipo'] == 'ERROR') {
            return $respuesta;    
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No Encontrados',
                "mensaje"=> 'No se encontraron datos relacionados a la placa '.$placa
            ];
            return $respuesta;
        }

        $propietarios = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $respuesta = [
            "tipo"=>"OK",
            "propietarios" => $propietarios
        ];
        return $respuesta;
    }

    private function validarDuplicidadPropietarios($placa, $propietario){
        $respuesta = $this->consultarPropietarioVehiculo($placa, $propietario);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'OK'){
            $respuesta = [
                'tipo' => 'ERROR',
                "titulo" => 'Vehículo Existente',
                "mensaje" => 'No es posible registrar el vehículo de placas '.$placa.', porque ya se encuentra registrado y asociado al usuario con número de documento'.$propietario.'.'
            ];
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            "titulo" => 'Vehículo No Existente',
            "mensaje" => 'Es posible registrar el vehículo.'
        ];
        return $respuesta;
    }

    private function validarLimiteVehiculos($documento){
        $parametros = [
            'numero_documento' => $documento
        ];
        $respuesta = $this->consultarVehiculos($parametros);
        if($respuesta['tipo'] == 'ERROR'){
            if($respuesta['titulo'] == 'Datos No Encontrados'){
                $respuesta = [
                    "tipo"=>"OK",
                    "titulo" => 'Limite De Vehículos',
                    "mensaje"=> 'El usuario es apto para registrar un nuevo vehiculo.'
                ];
                return $respuesta;
            }elseif($respuesta['titulo'] == 'Error de Conexión'){
                return $respuesta;
            }
        }

        $vehiculos = $respuesta['vehiculos'];
        if(count($vehiculos) == 5){
            $vehiculoAleatorio = rand(0, 4);
            $respuesta = $this->eliminarPropiedadVehiculo($documento, $vehiculos[$vehiculoAleatorio]['numero_placa']);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Limite De Vehículos',
            "mensaje"=> 'El usuario es apto para registrar un nuevo vehiculo.'
        ];

        return $respuesta;
    }

    private function validarLimitePropietarios($placa){
        $respuesta = $this->consultarPropietarios($placa);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $propietarios = $respuesta['propietarios'];
        if(count($propietarios) < 2){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Propietarios Insuficientes',
                "mensaje"=> 'Para poder eliminar un propietario, el vehículo debe tener como minimo 2 propietarios.'
            ];
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Propietarios Suficientes',
            "mensaje"=> 'El vehículo tiene suficientes propietarios.'
        ];
        return $respuesta;
    }

    public function eliminarPropiedadVehiculo($propietario, $placa){
        $respuesta = $this->validarLimitePropietarios($placa);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $sentenciaEliminar = "
            DELETE 
            FROM vehiculos 
            WHERE fk_usuario = '$propietario' AND numero_placa = '$placa';";
        
        $respuesta = $this->ejecutarConsulta($sentenciaEliminar);
        if ($respuesta['tipo'] == 'ERROR') {
            return $respuesta;    
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Eliminación Exitosa',
            "mensaje"=> 'El propietario del vehículo fue eliminado correctamente.'
        ];
        return $respuesta;
    }

    public function conteoTipoVehiculo(){
        $tiposVehiculo = ["carros", "motos"];
        $vehiculos = [];
        $totalVehiculos = 0;

        foreach($tiposVehiculo as $tipo) {
            if($tipo == "carros"){
                $sentenciaBuscar = "
                    SELECT numero_placa
                    FROM vehiculos 
                    WHERE tipo_vehiculo <> 'Moto' AND ubicacion = 'DENTRO'
                    GROUP BY numero_placa;";
            }else{
                $sentenciaBuscar = "
                    SELECT numero_placa 
                    FROM vehiculos 
                    WHERE tipo_vehiculo = 'Moto' AND ubicacion = 'DENTRO'
                    GROUP BY numero_placa;";
            }

            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if ($respuesta['tipo'] == 'ERROR') {
                return $respuesta;    
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            $cantidad = $respuestaSentencia->num_rows;
            $vehiculos[] = [
                'tipo_vehiculo' => $tipo,
                'cantidad' => $cantidad
            ];
            $totalVehiculos += $cantidad;
        }

        foreach ($vehiculos as &$vehiculo) {
            if($vehiculo['cantidad'] < 1){
                $porcentaje = 0;
            }else{
                $porcentaje = $vehiculo['cantidad']*100/$totalVehiculos;
            }

            $vehiculo['porcentaje'] = $porcentaje;
        }

        $respuesta = [
            'tipo' => "OK",
            'titulo'=> "Conteo Exitoso",
            'mensaje' => "El conteo de vehículos fue realizado con éxito.",
            'vehiculos' => $vehiculos
        ];
        return $respuesta;
    }

    public function actualizarUbicacionVehiculo($placa, $ubicacion){
        $sentenciaActualizar = "
            UPDATE vehiculos
            SET ubicacion = '$ubicacion'
            WHERE numero_placa = '$placa';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;    
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Ubicación Actualizada',
            'mensaje' => 'La ubicación del vehículo fue actualizada correctamente.'
        ];
        return $respuesta;
    }

    public function consultarNotificacionesVehiculo(){
        $objetoFecha = new DateTime();
        $fechaActual = $objetoFecha->format('Y-m-d H:i:s');
        $fechaMenos15H = (clone $objetoFecha)->modify('-15 hours')->format('Y-m-d H:i:s');
        $fechaMenos1H = (clone $objetoFecha)->modify('-1 hours')->format('Y-m-d H:i:s');

        $notificaciones = [];

        $sentenciaBuscar = "
           SELECT 
                veh.numero_placa, 
                ppv.estado_permiso, 
                ppv.codigo_permiso, 
                mov.fecha_ultimo_movimiento AS fecha_ultima_entrada, 
                ppv.fecha_registro AS fecha_permiso
            FROM (
                SELECT numero_placa
                FROM vehiculos
                WHERE ubicacion = 'DENTRO'
                GROUP BY numero_placa
            ) veh
            INNER JOIN (
                SELECT fk_vehiculo, MAX(fecha_registro) AS fecha_ultimo_movimiento
                FROM movimientos
                GROUP BY fk_vehiculo
            ) mov ON veh.numero_placa = mov.fk_vehiculo
            LEFT JOIN (
                SELECT p1.*
                FROM permisos_vehiculos p1
                INNER JOIN (
                    SELECT fk_vehiculo, MAX(fecha_registro) AS fecha_ultimo_permiso
                    FROM permisos_vehiculos
                    WHERE tipo_permiso = 'PERMANENCIA'
                    GROUP BY fk_vehiculo
                ) ult ON p1.fk_vehiculo = ult.fk_vehiculo 
                    AND p1.fecha_registro = ult.fecha_ultimo_permiso
            ) ppv ON veh.numero_placa = ppv.fk_vehiculo
            WHERE 
                mov.fecha_ultimo_movimiento < '$fechaMenos15H'
                AND (
                    ppv.estado_permiso IS NULL 
                    OR ppv.estado_permiso = 'DESAPROBADO'
                    OR (ppv.estado_permiso = 'PENDIENTE' AND ppv.fecha_registro < '$fechaMenos1H') 
                    OR (ppv.estado_permiso = 'APROBADO' AND ppv.fecha_fin_permiso < '$fechaActual')
                );";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows > 0){
            $vehiculos = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
            foreach ($vehiculos as &$vehiculo) {
                $fechaUltimaEntrada = new DateTime($vehiculo['fecha_ultima_entrada']);
                $fechaPermiso = new DateTime($vehiculo['fecha_permiso']);

                $diferencia = $fechaUltimaEntrada->diff($objetoFecha);
                $horasPermanencia = ($diferencia->days * 24) + $diferencia->h;
                $vehiculo['horas_permanencia'] = $horasPermanencia;

                if(($vehiculo['estado_permiso'] == 'DESAPROBADO') && $fechaPermiso < $fechaUltimaEntrada){
                   $vehiculo['estado_permiso'] = NULL;
                }

                $notificaciones[] = $vehiculo;
            };
        }

        $respuesta = [
            'tipo' => 'OK',
            'notificaciones_vehiculo' => $notificaciones
        ];
        return $respuesta;
    }
}