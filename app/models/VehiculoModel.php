<?php

namespace app\models; 

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

        $respuesta = $this->validarLimiteVehiculos($datosVehiculo['propietario']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaInsertar = "
            INSERT INTO vehiculos (numero_placa, tipo_vehiculo, fk_usuario, fecha_registro, fk_usuario_sistema) 
            VALUES ('{$datosVehiculo['numero_placa']}', '{$datosVehiculo['tipo_vehiculo']}', '{$datosVehiculo['propietario']}', '$fechaRegistro', '$usuarioSistema');";
        
        $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
        if (!$respuestaSentencia) {
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;    
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Registro Éxitoso',
            "mensaje"=> 'El vehiculo fue registrado correctamente.'
        ];
        return $respuesta;
    }

    public function consultarVehiculos($parametros){
        $sentenciaBuscar = "
            SELECT numero_placa, tipo_vehiculo, ubicacion
            FROM vehiculos 
            WHERE 1=1";

        if(isset($parametros['numero_placa'])){
            $sentenciaBuscar .= " AND numero_placa = '{$parametros['numero_placa']}'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND fk_usuario = '{$parametros['numero_documento']}'";
        }

        $sentenciaBuscar .= " GROUP BY numero_placa, tipo_vehiculo, ubicacion;";

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
        if (!$respuestaSentencia) {
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;    
        }

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

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
        if (!$respuestaSentencia) {
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;    
        }

        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Vehículo No Encontrado',
                "mensaje"=> 'Lo sentimos, parece que el vehiculo de placas '.$placa.' no se encuentra registrado en el sistema.'
            ];
            return $respuesta;
        }

        $datosVehiculo = $respuestaSentencia->fetch_assoc();
        $respuesta = [
            "tipo"=>"OK",
            "vehiculo" => $datosVehiculo
        ];
        return $respuesta;
    }

    public function consultarPropietariosVehiculo($placa){
        $sentenciaBuscar = "
            SELECT 
                veh.tipo_vehiculo,
                COALESCE(fun.numero_documento, vis.numero_documento, vig.numero_documento, apr.numero_documento) AS numero_documento,  
                COALESCE(fun.nombres, vis.nombres, vig.nombres, apr.nombres) AS nombres,
                COALESCE(fun.apellidos, vis.apellidos, vig.apellidos, apr.apellidos) AS apellidos,
                COALESCE(fun.telefono, vis.telefono, vig.telefono, apr.telefono) AS telefono,
                COALESCE(fun.correo_electronico, vis.correo_electronico, vig.correo_electronico, apr.correo_electronico) AS correo_electronico
            FROM vehiculos veh
            LEFT JOIN funcionarios fun ON veh.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON veh.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON veh.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON veh.fk_usuario = apr.numero_documento
            WHERE veh.numero_placa = '$placa'";
        
        $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
        if (!$respuestaSentencia) {
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;    
        }

        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No encontrados',
                "mensaje"=> 'No se encontraron datos relacionados a la placa '.$placa
            ];
        }

        $propietarios = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $respuesta = [
            "tipo"=>"OK",
            "propietarios" => $propietarios
        ];
        return $respuesta;
    }

    public function validarLimiteVehiculos($documento){
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

    public function eliminarPropiedadVehiculo($propietario, $placa){
        $sentenciaEliminar = "
            DELETE 
            FROM vehiculos 
            WHERE fk_usuario = '$propietario' AND numero_placa = '$placa';";
        
        $respuestaSentencia = $this->ejecutarConsulta($sentenciaEliminar);
        if (!$respuestaSentencia) {
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;    
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Eliminación Éxitosa',
            "mensaje"=> 'La propiedad del vehiculo fue eliminada correctamente.'
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

            $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
            if (!$respuestaSentencia) {
                $respuesta = [
                    "tipo"=>"ERROR",
                    "titulo" => 'Error de Conexión',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
                ];
                return $respuesta;    
            }

            $cantidad = $respuestaSentencia->num_rows;
            $vehiculos[] = [
                'tipo_vehiculo' => $tipo,
                'cantidad' => $cantidad
            ];
            $totalVehiculos += $cantidad;
        }

        foreach ($vehiculos as &$vehiculo) {
            // Se calcula el porcentaje de cada tipo de vehiculo que se encuentran dentro del sena sobre el total general de vehiculos.
            if($vehiculo['cantidad'] < 1){
                $porcentaje = 0;
            }else{
                $porcentaje = $vehiculo['cantidad']*100/$totalVehiculos;
            }

            $vehiculo['porcentaje'] = $porcentaje;
        }

        $respuesta = [
            'tipo' => "OK",
            'titulo'=> "Conteo Éxitoso",
            'mensaje' => "El conteo de vehiculos fue realizado con éxito.",
            'vehiculos' => $vehiculos
        ];
        return $respuesta;
    }

    public function actualizarUbicacionVehiculo($placa, $ubicacion){
        $sentenciaActualizar = "
            UPDATE vehiculos
            SET ubicacion = '$ubicacion'
            WHERE numero_placa = '$placa';";

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaActualizar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;    
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Ubicacion Actualizada',
            'mensaje' => 'La ubicacion del vehiculo fue actualizada correctamente.'
        ];
        return $respuesta;
    }
    
}