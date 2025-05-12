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

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaInsertar = "
            INSERT INTO vehiculos(numero_placa, tipo_vehiculo, fk_usuario, fecha_registro, fk_usuario_sistema) 
            VALUES ('".$datosVehiculo['numero_placa']."', '".$datosVehiculo['tipo_vehiculo']."', '".$datosVehiculo['propietario']."', '$fechaRegistro', '$usuarioSistema')";
        
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

    public function consultarVehiculo($placa){
        $sentenciaBuscar = "
            SELECT numero_placa, tipo, ubicacion
            FROM vehiculos 
            WHERE numero_placa = '$placa'
            GROUP BY numero_placa, tipo, ubicacion;";

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
                "titulo" => 'Vehiculo No encontrado',
                "mensaje"=> 'Lo sentimos, parece que el vehiculo de placas '.$placa.' no se encuentra registrado en el sistema.'
            ];
        }

        $datosVehiculo = $respuestaSentencia->fetch_assoc();
        $respuesta = [
            "tipo"=>"OK",
            "vehiculo" => $datosVehiculo
        ];
    }

    public function consultarPropietariosVehiculo($placa){
        $sentenciaBuscar = "
            SELECT 
                veh.tipo_vehiculo,
                COALESCE(fun.documento, vis.documento, vig.documento, apr.documento) AS numero_documento,  
                COALESCE(fun.nombres, vis.nombres, vig.nombres, apr.nombres) AS nombres,
                COALESCE(fun.apellidos, vis.apellidos, vig.apellidos, apr.apellidos) AS apellidos,
                COALESCE(fun.cargo, vis.telefono, vig.telefono, apr.telefono) AS telefono,
                COALESCE(fun.correo_electronico, vis.correo_electronico, vig.correo_electronico, apr.correo_electronio) AS correo_electronico
            FROM vehiculos veh
            LEFT JOIN funcionarios fun ON veh.documento = fun.documento
            LEFT JOIN visitantes vis ON veh.documento = vis.documento
            LEFT JOIN vigilantes vig ON veh.documento = vig.documento
            LEFT JOIN aprendices apr ON veh.documento = apr.documento
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
    }

    public function conteoTipoVehiculo(){
        $tiposVehiculo = ["carros", "motos"];
        $vehiculos = [];
        $totalVehiculos = 0;

        foreach($tiposVehiculo as $tipo) {
            if($tipo == "carros"){
                $sentenciaBuscar = "
                    SELECT contador 
                    FROM vehiculos 
                    WHERE tipo_vehiculo <> 'MT' AND ubicacion = 'DENTRO';";
            }else{
                $sentenciaBuscar = "
                    SELECT contador 
                    FROM vehiculos 
                    WHERE tipo_vehiculo = 'MT' AND ubicacion = 'DENTRO';";
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

    
}