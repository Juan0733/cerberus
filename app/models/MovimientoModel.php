<?php
namespace App\Models;

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

        $codigoMovimiento = 'EP'.date('YmdHis');
        $tipoMovimiento = 'ENTRADA';
        $tipoUsuario = $respuesta['usuario']['tipo_usuario'];
        $tablaUsuario = $respuesta['usuario']['tabla_usuario'];
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        
        $sentenciaInsertar = "
            INSERT INTO movimientos(codigo_movimiento, tipo_movimiento, fk_usuario, puerta_registro, fecha_registro, fk_usuario_sistema, tipo_usuario, observacion) 
            VALUES ('$codigoMovimiento', '$tipoMovimiento', '{$datosEntrada['numero_documento']}', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '$tipoUsuario', {$datosEntrada['observacion']})";
        
        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo']  == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosEntrada['numero_documento'], $tablaUsuario, 'DENTRO');
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
        $respuesta = $this->validarUsuarioAptoEntrada($datosEntrada['propietario']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        $datosEntrada['tipo_propietario'] = $respuesta['usuario']['tipo_usuario'];
        $datosEntrada['tabla_propietario'] = $respuesta['usuario']['tabla_usuario'];

        foreach($datosEntrada['pasajeros'] as &$pasajero){
            $respuesta = $this->validarUsuarioAptoEntrada($pasajero['documento_pasajero']);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
            $pasajero['tipo_pasajero'] = $respuesta['usuario']['tipo_usuario'];
            $pasajero['tabla_pasajero'] = $respuesta['usuario']['tabla_usuario'];
        }
        unset($pasajero);

        $respuesta = $this->validarPropiedadVehiculo($datosEntrada['numero_placa'], $datosEntrada['propietario']);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Propietario Incorrecto'){
            $datosVehiculo = [
                'numero_placa' => $datosEntrada['numero_placa'],
                'tipo_vehiculo' => $datosEntrada['tipo_vehiculo'],
                'propietario' => $datosEntrada['propietario']
            ];

            $respuesta = $this->objetoVehiculo->registrarVehiculo($datosVehiculo);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }
        
        $codigoMovimiento = 'EV'.date('YmdHis');
        $tipoMovimiento = 'ENTRADA';
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaInsertar = "
            INSERT INTO movimientos(codigo_movimiento, tipo_movimiento, fk_usuario, fk_vehiculo, relacion_vehiculo, puerta_registro, fecha_registro, fk_usuario_sistema, tipo_usuario, observacion) 
            VALUES ('$codigoMovimiento', '$tipoMovimiento', '{$datosEntrada['propietario']}', '{$datosEntrada['numero_placa']}', 'PROPIETARIO', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '{$datosEntrada['tipo_propietario']}', {$datosEntrada['observacion']});";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosEntrada['propietario'], $datosEntrada['tabla_propietario'], 'DENTRO');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoVehiculo->actualizarUbicacionVehiculo($datosEntrada['numero_placa'], 'DENTRO');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        foreach($datosEntrada['pasajeros'] as $pasajero){
            $sentenciaInsertar = "
                INSERT INTO movimientos(codigo_movimiento, tipo_movimiento, fk_usuario, fk_vehiculo, relacion_vehiculo, puerta_registro, fecha_registro, fk_usuario_sistema, tipo_usuario, observacion) 
                VALUES ('$codigoMovimiento', '$tipoMovimiento', '{$pasajero['documento_pasajero']}', '{$datosEntrada['numero_placa']}', 'PASAJERO', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '{$pasajero['tipo_pasajero']}', {$datosEntrada['observacion']})";
            
            $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

            $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($pasajero['documento_pasajero'], $pasajero['tabla_pasajero'], 'DENTRO');
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

    public function registrarSalidaPeatonal($datosSalida){
        $respuesta = $this->validarUsuarioAptoSalida($datosSalida['numero_documento']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $codigoMovimiento = 'SP'.date('YmdHis');
        $tipoMovimiento = 'SALIDA';
        $tipoUsuario = $respuesta['usuario']['tipo_usuario'];
        $tablaUsuario = $respuesta['usuario']['tabla_usuario'];
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        
        $sentenciaInsertar = "
            INSERT INTO movimientos(codigo_movimiento, tipo_movimiento, fk_usuario, puerta_registro, fecha_registro, fk_usuario_sistema, tipo_usuario, observacion) 
            VALUES ('$codigoMovimiento', '$tipoMovimiento', '{$datosSalida['numero_documento']}', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '$tipoUsuario', {$datosSalida['observacion']})";
        
        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosSalida['numero_documento'], $tablaUsuario, 'FUERA');
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

    public function registrarSalidaVehicular($datosSalida){
        $respuesta = $this->validarUsuarioAptoSalida($datosSalida['propietario']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        $datosSalida['tipo_propietario'] = $respuesta['usuario']['tipo_usuario'];
        $datosSalida['tabla_propietario']= $respuesta['usuario']['tabla_usuario'];

        foreach($datosSalida['pasajeros'] as &$pasajero){
            $respuesta = $this->validarUsuarioAptoSalida($pasajero['documento_pasajero']);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
            $pasajero['tipo_pasajero'] = $respuesta['usuario']['tipo_usuario'];
            $pasajero['tabla_pasajero'] = $respuesta['usuario']['tabla_usuario'];
        }
        unset($pasajero);

        $respuesta = $this->objetoVehiculo->consultarVehiculo($datosSalida['numero_placa']);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Vehículo No Encontrado'){
            $datosVehiculo = [
                'numero_placa' => $datosSalida['numero_placa'],
                'tipo_vehiculo' => $datosSalida['tipo_vehiculo'],
                'propietario' => $datosSalida['propietario']
            ];
            
            $respuesta = $this->objetoVehiculo->registrarVehiculo($datosVehiculo);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

        }elseif($respuesta['tipo'] == 'OK'){
            $respuesta = $this->objetoVehiculo->consultarPropietarios($datosSalida['numero_placa']);
            if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
                return $respuesta;

            }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Datos No Encontrados'){
                $datosVehiculo = [
                    'numero_placa' => $datosSalida['numero_placa'],
                    'propietario' => $datosSalida['propietario']
                ];
                
                $respuesta = $this->objetoVehiculo->registrarVehiculo($datosVehiculo);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }

            }elseif($respuesta['tipo'] == 'OK'){
                $respuesta = $this->validarPropiedadVehiculo($datosSalida['numero_placa'], $datosSalida['propietario']);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }
            }
        }

        $codigoMovimiento = 'SV'.date('YmdHis');
        $tipoMovimiento = 'SALIDA';
        $fechaRegistro = date('Y-m-d H:i:s');
        $puertaActual = $_SESSION['datos_usuario']['puerta'];
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];

        $sentenciaInsertar = "
            INSERT INTO movimientos(codigo_movimiento, tipo_movimiento, fk_usuario, fk_vehiculo, relacion_vehiculo, puerta_registro, fecha_registro, fk_usuario_sistema, tipo_usuario, observacion) 
            VALUES ('$codigoMovimiento', '$tipoMovimiento', '{$datosSalida['propietario']}', '{$datosSalida['numero_placa']}', 'PROPIETARIO', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '{$datosSalida['tipo_propietario']}', {$datosSalida['observacion']});";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($datosSalida['propietario'], $datosSalida['tabla_propietario'], 'FUERA');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->objetoVehiculo->actualizarUbicacionVehiculo($datosSalida['numero_placa'], 'FUERA');
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        foreach($datosSalida['pasajeros'] as $pasajero){
            $sentenciaInsertar = "
                INSERT INTO movimientos(codigo_movimiento, tipo_movimiento, fk_usuario, fk_vehiculo, relacion_vehiculo, puerta_registro, fecha_registro, fk_usuario_sistema, tipo_usuario, observacion) 
                VALUES ('$codigoMovimiento', '$tipoMovimiento', '{$pasajero['documento_pasajero']}', '{$datosSalida['numero_placa']}', 'PASAJERO', '$puertaActual', '$fechaRegistro', '$usuarioSistema', '{$pasajero['tipo_pasajero']}', {$datosSalida['observacion']})";
            
            $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

            $respuesta = $this->objetoUsuario->actualizarUbicacionUsuario($pasajero['documento_pasajero'], $pasajero['tabla_pasajero'], 'FUERA');
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
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        if($usuarioSistema == $usuario){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Registro No Permitido',
                'mensaje' => 'Los integrantes del personal de seguridad no pueden registrar su propia entrada. Solicite a un compañero que realice el registro por usted.'
            ];
            return $respuesta;
        }

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
        
        if($datosUsuario['tipo_usuario'] == 'APRENDIZ'){
            $fechaActual = new DateTime(date('Y-m-d'));
            $fechaFinFicha = new DateTime($datosUsuario['fecha_fin_ficha']);
            if($fechaFinFicha < $fechaActual){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Ficha Caducada',
                    'mensaje' => 'La ficha del aprendiz ya ha finalizado, por lo tanto se requiere que indique cuál es el motivo de su ingreso.',
                    'datos_usuario' => $datosUsuario
                ];
                return $respuesta;
            }

        }elseif($datosUsuario['tipo_usuario'] == 'FUNCIONARIO' && $datosUsuario['tipo_contrato'] == 'CONTRATISTA'){
            $fechaActual = new DateTime(date('Y-m-d'));
            $fechaFinContrato = new DateTime($datosUsuario['fecha_fin_contrato']);
            if($fechaFinContrato < $fechaActual){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Contrato Caducado',
                    'mensaje' => 'El contrato del funcionario ya ha finalizado, por lo tanto se requiere que indique cuál es el motivo de su ingreso.',
                    'datos_usuario' => $datosUsuario
                ];
                return $respuesta;
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
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        if($usuarioSistema == $usuario){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Registro No Permitido',
                'mensaje' => 'Los integrantes del personal de seguridad no pueden registrar su propia salida. Solicite a un compañero que realice el registro por usted.'
            ];
            return $respuesta;
        }

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
        $respuesta = $this->objetoVehiculo->consultarPropietarioVehiculo($placa, $usuario);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }else if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Datos No Encontrados'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Propietario Incorrecto',
                'mensaje' => 'El usuario con número de documento '.$usuario.', no le pertenece el vehículo de placas '.$placa.', ¿Es un vehículo prestado?'
            ];
            return $respuesta;

        }else if($respuesta['tipo'] == 'OK'){
            $vehiculo = $respuesta['datos_vehiculo'];
            if($vehiculo['estado_propiedad'] == 'INACTIVA'){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Propietario Incorrecto',
                    'mensaje' => 'El usuario con número de documento '.$usuario.', no le pertenece el vehículo de placas '.$placa.', ¿Es un vehículo prestado?'
                ];
                return $respuesta;
            }

            $respuesta = [
                'tipo' => 'OK',
                'titulo' => 'Propietario Correcto',
                'mensaje' => 'El propietario del vehículo coincide con el usuario que intenta realizar el movimiento.'
            ];
            return $respuesta;
        }
    }

    public function consultarUltimoMovimientoUsuario($usuario){
        $sentenciaBuscar = "
            SELECT fecha_registro
            FROM movimientos
            WHERE fk_usuario = '$usuario'
            ORDER BY fecha_registro DESC LIMIT 1;";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Movimiento No Encontrado',
                "mensaje"=> 'No se encontraron resultados del movimiento solicitado.'
            ];
            return $respuesta;
        }

        $movimiento = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_movimiento' => $movimiento
        ];
        return $respuesta;
    }

    public function consultarUltimoMovimientoVehiculo($vehiculo){
        $sentenciaBuscar = "
            SELECT fecha_registro
            FROM movimientos
            WHERE fk_vehiculo = '$vehiculo'
            ORDER BY fecha_registro DESC LIMIT 1;";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Movimiento No Encontrado',
                "mensaje"=> 'No se encontraron resultados del movimiento solicitado.'
            ];
            return $respuesta;
        }

        $movimiento = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_movimiento' => $movimiento
        ];
        return $respuesta;
    }

    public function consultarMovimientos($parametros){
        $sentenciaBuscar = "
            SELECT 
                DATE_FORMAT(mov.fecha_registro, '%d-%m-%Y %H:%i:%s') AS fecha_registro,
                mov.codigo_movimiento,
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
            $sentenciaBuscar .= " AND mov.fk_usuario LIKE '{$parametros['numero_documento']}%'";
        }

        if(isset($parametros['numero_placa'])){
            $sentenciaBuscar .= " AND mov.fk_vehiculo LIKE '{$parametros['numero_placa']}%'";
        }

        $sentenciaBuscar .= " ORDER BY mov.fecha_registro DESC;";
        
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
                "mensaje"=> 'No se encontraron resultados'
            ];
            return $respuesta;
        }

        $movimientos = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'movimientos' => $movimientos
        ];
        return $respuesta;
    }

    public function consultarMovimiento($codigoMovimiento){
        $sentenciaBuscar = "
            SELECT 
                mov.fecha_registro,
                mov.tipo_movimiento, 
                mov.puerta_registro,
                mov.fk_usuario,
                mov.tipo_usuario,
                vig2.nombres AS nombres_responsable,
                vig2.apellidos AS apellidos_responsable,
                vig2.rol AS rol_responsable,
                COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres,
                COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos,
                COALESCE(veh.tipo_vehiculo, 'N/A') AS tipo_vehiculo,
                COALESCE(mov.fk_vehiculo, 'N/A') AS fk_vehiculo,
                COALESCE(mov.relacion_vehiculo, 'N/A') AS relacion_vehiculo,
                COALESCE(mov.observacion, 'N/A') AS observacion
            FROM movimientos mov
            INNER JOIN vigilantes vig2 ON mov.fk_usuario_sistema = vig2.numero_documento
            LEFT JOIN (SELECT numero_placa, tipo_vehiculo FROM vehiculos GROUP BY numero_placa, tipo_vehiculo) veh ON mov.fk_vehiculo = veh.numero_placa
            LEFT JOIN funcionarios fun ON mov.fk_usuario = fun.numero_documento
            LEFT JOIN visitantes vis ON mov.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON mov.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON mov.fk_usuario = apr.numero_documento
            WHERE mov.codigo_movimiento = '$codigoMovimiento';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Movimiento No Encontrado',
                "mensaje"=> 'No se encontraron resultados del movimiento.'
            ];
            return $respuesta;
        }

        $movimiento = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_movimiento' => $movimiento
        ];
        return $respuesta;
    }

    public function consultarMovimientosUsuarios($parametros){
        $jornadas = [
            'MAÑANA' => ['07:00:00', '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00'],
            'TARDE' => ['12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00'],
            'NOCHE' => ['18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00', '23:00:00']
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

                $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }

                $respuestaSentencia = $respuesta['respuesta_sentencia'];
                $cantidadMovimientos = $respuestaSentencia->num_rows;
                $this->cerrarConexion();

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
