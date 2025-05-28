<?php
namespace app\models;
use DateTime;

class MovimientoModel extends MainModel{
    private $objetoUsuario;
    private $objetoVehiculo;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
        $this->objetoVehiculo = new VehiculoModel();

    }

    public function registrarEntradaPeatonal($datosEntrada){
        $respuesta = $this->validarUsuarioAptoEntrada($datosEntrada['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $tipoMovimiento = 'ENTRADA';
        $grupoUsuario = $respuesta['usuario']['grupo'];
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        
        $sentenciaInsertar = "
            INSERT INTO movimientos(tipo_movimiento, fk_usuario, puerta_registro, fecha_registro, fk_usuario_sistema, grupo_usuario) 
            VALUES ('$tipoMovimiento', '{$datosEntrada['numero_documento']}', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '$grupoUsuario')";
        
        $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR", 
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosEntrada['numero_documento'], $grupoUsuario, 'DENTRO');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Registro Éxitoso',
            "mensaje"=> 'La entrada peatonal fue registrada correctamente.'
        ];
        return $respuesta;
    }

    public function registrarEntradaVehicular($datosEntrada){
        $respuesta = $this->validarPropiedadVehiculo($datosEntrada['numero_placa'], $datosEntrada['propietario']);
        if($respuesta['tipo'] == 'ERROR'){
            if($respuesta['titulo'] == 'Error de Conexión' || $respuesta['titulo'] == 'Datos No encontrados'){
                return $respuesta;
            }elseif($respuesta['titulo'] == 'Propietario Incorrecto'){
                $tipoVehiculo = $respuesta['tipo_vehiculo'];
                $datosVehiculo = [
                    'tipo_vehiculo' => $tipoVehiculo,
                    'numero_placa' => $datosEntrada['numero_placa'],
                    'propietario' => $datosEntrada['propietario']
                ];

                $respuesta = $this->objetoVehiculo->registrarVehiculo($datosVehiculo);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }
            }
        }

        $tipoMovimiento = 'ENTRADA';
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaInsertar = "
            INSERT INTO movimientos(tipo_movimiento, fk_usuario, fk_vehiculo, relacion_vehiculo, puerta_registro, fecha_registro, fk_usuario_sistema, grupo_usuario, observacion) 
            VALUES ('$tipoMovimiento', '{$datosEntrada['propietario']}', '{$datosEntrada['numero_placa']}', 'Propietario', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '{$datosEntrada['grupo_propietario']}', '{$datosEntrada['observacion']}');";

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR", 
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosEntrada['propietario'], $datosEntrada['grupo_propietario'], 'DENTRO');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoVehiculo->actualizarUbicacionVehiculo($datosEntrada['numero_placa'], 'DENTRO');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        foreach($datosEntrada['pasajeros'] as $pasajero){
            $sentenciaInsertar = "
                INSERT INTO movimientos(tipo_movimiento, fk_usuario, fk_vehiculo, relacion_vehiculo, puerta_registro, fecha_registro, fk_usuario_sistema, grupo_usuario, observacion) 
                VALUES ('$tipoMovimiento', '{$pasajero['documento_pasajero']}', '{$datosEntrada['numero_placa']}', 'Pasajero', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '{$pasajero['grupo_pasajero']}', '{$datosEntrada['observacion']}')";
            
            $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
            if(!$respuestaSentencia){
                $respuesta = [
                    "tipo"=>"ERROR", 
                    "titulo" => 'Error de Conexión',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
                ];
                return $respuesta;
            }

            $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($pasajero['documento_pasajero'], $pasajero['grupo_pasajero'], 'DENTRO');
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Registro Éxitoso',
            "mensaje"=> 'La entrada vehicular fue registrada correctamente.'
        ];
        return $respuesta;
    }

    public function registrarSalidaPeatonal($datosEntrada){
        $respuesta = $this->validarUsuarioAptoSalida($datosEntrada['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $tipoMovimiento = 'SALIDA';
        $grupoUsuario = $respuesta['usuario']['grupo'];
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        
        $sentenciaInsertar = "
            INSERT INTO movimientos(tipo_movimiento, fk_usuario, puerta_registro, fecha_registro, fk_usuario_sistema, grupo_usuario) 
            VALUES ('$tipoMovimiento', '{$datosEntrada['numero_documento']}', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '$grupoUsuario')";
        
        $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR", 
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosEntrada['numero_documento'], $grupoUsuario, 'FUERA');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Registro Éxitoso',
            "mensaje"=> 'La salida peatonal fue registrada correctamente.'
        ];
        return $respuesta;
    }

    public function registrarSalidaVehicular($datosEntrada){
        $respuesta = $this->validarPropiedadVehiculo($datosEntrada['numero_placa'], $datosEntrada['propietario']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $tipoMovimiento = 'SALIDA';
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaInsertar = "
            INSERT INTO movimientos(tipo_movimiento, fk_usuario, fk_vehiculo, relacion_vehiculo, puerta_registro, fecha_registro, fk_usuario_sistema, grupo_usuario, observacion) 
            VALUES ('$tipoMovimiento', '{$datosEntrada['propietario']}', '{$datosEntrada['numero_placa']}', 'Propietario', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '{$datosEntrada['grupo_propietario']}', {$datosEntrada['observacion']});";

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR", 
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
            ];
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosEntrada['propietario'], $datosEntrada['grupo_propietario'], 'FUERA');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoVehiculo->actualizarUbicacionVehiculo($datosEntrada['numero_placa'], 'FUERA');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        foreach($datosEntrada['pasajeros'] as $pasajero){
            $sentenciaInsertar = "
                INSERT INTO movimientos(tipo_movimiento, fk_usuario, fk_vehiculo, relacion_vehiculo, puerta_registro, fecha_registro, fk_usuario_sistema, grupo_usuario, observacion) 
                VALUES ('$tipoMovimiento', '{$pasajero['documento_pasajero']}', '{$datosEntrada['numero_placa']}', 'Pasajero', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '{$pasajero['grupo_pasajero']}', {$datosEntrada['observacion']})";
            
            $respuestaSentencia = $this->ejecutarConsulta($sentenciaInsertar);
            if(!$respuestaSentencia){
                $respuesta = [
                    "tipo"=>"ERROR", 
                    "titulo" => 'Error de Conexión',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
                ];
                return $respuesta;
            }

            $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($pasajero['documento_pasajero'], $pasajero['grupo_pasajero'], 'FUERA');
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }

        $respuesta = [
            "tipo"=>"OK",
            "titulo" => 'Registro Éxitoso',
            "mensaje"=> 'La salida vehicular fue registrada correctamente.'
        ];
        return $respuesta;
    }

    public function validarUsuarioAptoEntrada($usuario){
        $respuesta = $this->objetoUsuario->consultarUsuario($usuario);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $datosUsuario = $respuesta['usuario'];
        if($datosUsuario['ubicacion'] == 'DENTRO'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Salida No Registrada',
                'mensaje' => 'Parece que el usuario con número de documento '.$usuario.', no se le registro una salida, porque el sistema indica que aún se encuentra dentro del CAB.'
            ];
            return $respuesta;
        }
        
        if($datosUsuario['grupo'] == 'aprendices'){
            $fechaActual = new DateTime();
            $fechaFinFicha = new DateTime($datosUsuario['fecha_fin_ficha']);
            if($fechaFinFicha < $fechaActual){
                $datosUsuario['motivo_ingreso'] = 'La ficha del aprendiz ha finalizado';
                $respuesta = $this->objetoUsuario->cambiarGrupoUsuario('aprendices', 'visitantes', $datosUsuario);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }

                $datosUsuario['grupo'] = 'visitantes';
            }

        }elseif($datosUsuario['grupo'] == 'funcionarios' && $datosUsuario['tipo_contrato'] == 'contratista'){
            $fechaActual = new DateTime();
            $fechaFinContrato = new DateTime($datosUsuario['fecha_fin_contrato']);
            if($fechaFinContrato < $fechaActual){
                $datosUsuario['motivo_ingreso'] = 'El contrato del funcionario ha finalizado';
                $this->objetoUsuario->cambiarGrupoUsuario('funcionarios', 'visitantes', $datosUsuario);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }

                $datosUsuario['grupo'] = 'visitantes';
            }
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Usuario Apto',
            'mensaje' => 'El usuario es apto, para registrar su ingreso al CAB.',
            'usuario' => $datosUsuario,
        ];
        return $respuesta;
    }

     public function validarUsuarioAptoSalida($usuario){
        $respuesta = $this->objetoUsuario->consultarUsuario($usuario);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $datosUsuario = $respuesta['usuario'];
        if($datosUsuario['ubicacion'] == 'FUERA'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Entrada No Registrada',
                'mensaje' => 'Parece que el usuario con número de documento '.$usuario.', no se le registro una entrada, porque el sistema indica que se encuentra fuera del CAB.'
            ];
            return $respuesta;
        }
        
        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Usuario Apto',
            'mensaje' => 'El usuario es apto, para registrar su salida del CAB.',
            'usuario' => $datosUsuario,
        ];
        return $respuesta;
    }

    public function validarPropiedadVehiculo($placa, $usuario){
        $respuesta = $this->objetoVehiculo->consultarPropietariosVehiculo($placa);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        
        $propietarios = $respuesta['propietarios'];
        foreach($propietarios as $propietario){
            if($propietario['numero_documento'] == $usuario){
                $respuesta = [
                    'tipo' => 'OK',
                    'titulo' => 'Propietario Correcto',
                    'mensaje' => 'El propietario del vehiculo coincide con el usuario que intenta realizar el movimiento.'
                ];
                return $respuesta;
            }
        }

        //Se anexa el tipo de vehiculo a la respuesta para complementar los datos del vehiculo y hacer su registro en caso de tratarse de una entrada vehicular
        $tipoVehiculo = $propietarios[0]['tipo_vehiculo'];

        $respuesta = [
            'tipo' => 'ERROR',
            'titulo' => 'Propietario Incorrecto',
            'mensaje' => 'El usuario con numero de documento '.$usuario.', no le pertenece el vehículo de placas '.$placa.', ¿Es un vehículo prestado?',
            'tipo_vehiculo' => $tipoVehiculo
        ];
        return $respuesta;
    }

    public function consultarMovimientos($parametros){
        $sentenciaBuscar = "
            SELECT 
                DATE_FORMAT(mov.fecha_registro, '%d-%m-%Y %H:%i:%s') AS fecha_registro,
                mov.tipo_movimiento, 
                mov.puerta_registro,
                mov.fk_usuario,
                mov.fk_usuario_sistema,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos,
                COALESCE(fun.tipo_documento, apr.tipo_documento, vis.tipo_documento, vig.tipo_documento) AS tipo_documento,
                COALESCE(fk_vehiculo, 'N/A') AS fk_vehiculo,
                COALESCE(relacion_vehiculo, 'N/A') AS relacion_vehiculo
            FROM movimientos mov
            LEFT JOIN funcionarios fun ON mov.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON mov.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON mov.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON mov.fk_usuario = apr.numero_documento
            WHERE DATE(mov.fecha_registro) BETWEEN DATE('{$parametros['fecha_inicio']}') AND DATE('{$parametros['fecha_fin']}')";

        if(isset($parametros['puerta'])){
            $sentenciaBuscar .= " AND mov.puerta_registro = '{$parametros['puerta']}'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND mov.fk_usuario = '{$parametros['numero_documento']}'";
        }

        if(isset($parametros['numero_placa'])){
            $sentenciaBuscar .= " AND mov.fk_vehiculo = '{$parametros['numero_placa']}'";
        }

        $sentenciaBuscar .= " ORDER BY mov.fecha_registro DESC;";

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
        if(!$respuestaSentencia){
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
                "mensaje"=> 'No se encontraron resultados'
            ];
            return $respuesta;
        }

        $movimientos = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);

        $respuesta = [
            'tipo' => 'OK',
            'movimientos' => $movimientos
        ];

        return $respuesta;
    }

    public function consultarMovimientosUsuarios($parametros){
        $jornadas = [
            'mañana' => ['07:00:00', '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00'],
            'tarde' => ['12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00'],
            'noche' => ['18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00', '23:00:00']
        ];

        $jornada = $parametros['jornada'];
        $tablas = ['visitantes', 'aprendices', 'funcionarios', 'vigilantes'];
        $movimientos = [];
        foreach ($tablas as $tabla) {
            $datos = [
                'tipo_usuario' => $tabla
            ];

            for ($i=0; $i < count($jornadas[$jornada]) - 1; $i++) { 
                $horaInicio = $jornadas[$jornada][$i];
                $horaFin = $jornadas[$jornada][$i+1];
                $sentenciaBuscar = "
                    SELECT mov.fecha_registro 
                    FROM movimientos mov 
                    INNER JOIN $tabla ON mov.fk_usuario = numero_documento
                    WHERE mov.tipo_movimiento = '{$parametros['tipo_movimiento']}'
                    AND DATE(mov.fecha_registro) = '{$parametros['fecha']}' 
                    AND TIME(mov.fecha_registro) BETWEEN '$horaInicio' AND '$horaFin'";

                if(isset($parametros['puerta'])){
                    $sentenciaBuscar .= " AND puerta_registro = '{$parametros['puerta']}'";
                }

                $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
                if(!$respuestaSentencia){
                    $respuesta = [
                        "tipo"=>"ERROR", 
                        "titulo" => 'Error de Conexión',
                        "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
                    ];
                    return $respuesta;
                }

                $cantidadMovimientos = $respuestaSentencia->num_rows;

                $datos['rangos'][] = date('H:i', strtotime($horaInicio)).'-'.date('H:i', strtotime($horaFin));
                $datos['cantidades'][] = $cantidadMovimientos;
            }

            $movimientos[] = $datos;    
        }

        $respuesta = [
            'tipo' => 'OK',
            'movimientos' => $movimientos
        ];

        return $respuesta;
    }
}
