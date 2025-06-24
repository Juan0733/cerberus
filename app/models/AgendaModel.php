<?php
namespace app\models;

use DateTime;

class AgendaModel extends MainModel{
    private $objetoUsuario;
    private $objetoVisitante;

    public function __construct() {
        $this->objetoUsuario = new UsuarioModel();
        $this->objetoVisitante = new VisitanteModel();
    }

    public function registrarAgendaIndividual($datosAgenda){
        $agendados = [
            [
                'numero_documento' => $datosAgenda['numero_documento'],
                'tipo_documento' => $datosAgenda['tipo_documento'],
                'numero_documento' => $datosAgenda['numero_documento'],
                'nombres' => $datosAgenda['nombres'],
                'apellidos' => $datosAgenda['apellidos'],
                'telefono' => $datosAgenda['telefono'],
                'correo_electronico' => $datosAgenda['correo_electronico']
            ]
        ];

        $respuesta = $this->validarDuplicidadAgenda($agendados, $datosAgenda['fecha_agenda']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->validarExistenciaAgendados($agendados, $datosAgenda['motivo']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $codigoAgenda = 'AI'.date('YmdHis');

        $sentenciaInsertar = "
            INSERT INTO agendas(codigo_agenda, titulo, motivo, fk_usuario, fecha_agenda, fecha_registro, fk_usuario_sistema)
            VALUES ('$codigoAgenda', '{$datosAgenda['titulo']}', '{$datosAgenda['motivo']}', '{$datosAgenda['numero_documento']}', '{$datosAgenda['fecha_agenda']}', '$fechaRegistro', '$usuarioSistema');";

        $respuesta= $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        
        $respuesta = [
            'tipo' => 'OK',
            'titulo' =>'Registro Exitoso',
            'mensaje' => 'La agenda fue registrada correctamente.'
        ];
        return $respuesta;
    }

    public function registrarAgendaGrupal($datosAgenda){
        $respuesta = $this->validarDuplicidadAgenda($datosAgenda['agendados'], $datosAgenda['fecha_agenda']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = $this->validarExistenciaAgendados($datosAgenda['agendados'], $datosAgenda['motivo']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        
        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $codigoAgenda = 'AG'.date('YmdHis');

        foreach ($datosAgenda['agendados'] as $agendado) {
            $sentenciaInsertar = "
                INSERT INTO agendas(codigo_agenda, titulo, motivo, fk_usuario, fecha_agenda, fecha_registro, fk_usuario_sistema)
                VALUES ('$codigoAgenda', '{$datosAgenda['titulo']}', '{$datosAgenda['motivo']}', '{$agendado['numero_documento']}', '{$datosAgenda['fecha_agenda']}', '$fechaRegistro', '$usuarioSistema');";

            $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }
        
        $respuesta = [
            'tipo' => 'OK',
            'titulo' =>'Registro Exitoso',
            'mensaje' => 'Fueron agendados correctamente '.count($datosAgenda['agendados']).' usuarios.'
        ];
        return $respuesta;
    }

    public function actualizarAgenda($datosAgenda){
        $respuesta = $this->consultarAgenda($datosAgenda['codigo_agenda']);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $agendados = $respuesta['datos_agenda']['agendados'];
        $fechaActualAgenda = new DateTime($respuesta['datos_agenda']['fecha_agenda']);
        $fechaNuevaAgenda = new DateTime($datosAgenda['fecha_agenda']);

        if($fechaActualAgenda != $fechaNuevaAgenda){
            $respuesta = $this->validarDuplicidadAgenda($agendados, $datosAgenda['fecha_agenda']);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }
        
        $sentenciaActualizar = "
            UPDATE agendas
            SET titulo = '{$datosAgenda['titulo']}', motivo = '{$datosAgenda['motivo']}', fecha_agenda = '{$datosAgenda['fecha_agenda']}'
            WHERE codigo_agenda = '{$datosAgenda['codigo_agenda']}';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' =>'Actualización Exitosa',
            'mensaje' => 'La agenda fue actualizada correctamente.'
        ];
        return $respuesta;
    }

    private function validarDuplicidadAgenda($agendados, $fechaAgenda){
        foreach ($agendados as $agendado) {
            $sentenciaBuscar = "
                SELECT codigo_agenda
                FROM agendas
                WHERE fk_usuario = '{$agendado['numero_documento']}' AND fecha_agenda = '$fechaAgenda';
            ";
            
            $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }

            $respuestaSentencia = $respuesta['respuesta_sentencia'];
            if($respuestaSentencia->num_rows > 0){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Agenda Duplicada',
                    'mensaje' => 'El usuario con número de documento '.$agendado['numero_documento'].' ya tiene una agenda programada para la fecha proporcionada.'
                ];
                return $respuesta;
            }
        }
        
        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Sin Duplicados',
            'mensaje' => 'No se encontraron agendas duplicadas.'
        ];
        return $respuesta;
    }

    private function validarExistenciaAgendados($agendados, $motivoIngreso){
        foreach($agendados as $agendado){
            $respuesta = $this->objetoUsuario->consultarUsuario($agendado['numero_documento']);
            if($respuesta['tipo'] == 'ERROR' && ['titulo'] == 'Error de Conexión'){
                return $respuesta;

            }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Usuario No Encontrado'){
                $agendado['motivo_ingreso'] = $motivoIngreso;

                $respuesta = $this->objetoVisitante->registrarVisitante($agendado);
                if($respuesta['tipo'] == 'ERROR'){
                    return $respuesta;
                }
            }
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Agendados Existente',
            'mensaje' => 'Las personas agendas ya se encuentran registradas en el sistema.'
        ];
        return $respuesta;
    }

    public function consultarAgendas($parametros){
        $sentenciaBuscar = "
                SELECT 
                    a.codigo_agenda, 
                    a.titulo,
                    a.fecha_agenda,
                    COALESCE(fun.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres_agendado,
                    COALESCE(fun.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos_agendado
                FROM agendas a
                LEFT JOIN funcionarios fun ON a.fk_usuario = fun.numero_documento
                LEFT JOIN aprendices apr ON a.fk_usuario = apr.numero_documento
                LEFT JOIN visitantes vis ON a.fk_usuario = vis.numero_documento
                LEFT JOIN vigilantes vig ON a.fk_usuario = vig.numero_documento
                WHERE DATE(a.fecha_agenda) = '{$parametros['fecha']}'";

        $rol = $_SESSION['datos_usuario']['rol'];
        if($rol != 'jefe vigilantes' && $rol != 'vigilante raso'){
            $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
            $sentenciaBuscar .= " AND fk_usuario_sistema = '$usuarioSistema'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND fk_usuario = '{$parametros['numero_documento']}'";
        }else{
            $sentenciaBuscar .= " AND a.fk_usuario = (
                SELECT MIN(a2.fk_usuario)
                FROM agendas a2
                WHERE a2.codigo_agenda = a.codigo_agenda
            )";
        }

        if(isset($parametros['titulo'])){
            $sentenciaBuscar .= " AND titulo = '{$parametros['titulo']}'";
        }

        $sentenciaBuscar .= " ORDER BY a.fecha_registro DESC LIMIT 10;";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
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

        $agendas = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        foreach($agendas as &$agenda){
            $fecha = new DateTime($agenda['fecha_agenda']);
            $mes = MESES[$fecha->format('F')];
            $fechaFormateada = $fecha->format('j').' de '.$mes;
            $horaFormateada = strtolower($fecha->format('g:iA')) ;

            $agenda['fecha'] = $fechaFormateada;
            $agenda['hora'] = $horaFormateada;
        }
        
        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Consulta Exitosa',
            'mensaje' => 'Consulta ejecutada correctamente.',
            'agendas' => $agendas
            
        ];
        return $respuesta;
    }

    public function consultarAgenda($codigoAgenda){
        $sentenciaBuscar = "
            SELECT 
                age.titulo, 
                age.motivo,
                age.fecha_agenda,
                fun1.nombres AS nombres_responsable,
                fun1.apellidos AS apellidos_responsable,
                COALESCE(fun2.numero_documento, apr.numero_documento, vis.numero_documento, vig.numero_documento) AS numero_documento,
                COALESCE(fun2.nombres, apr.nombres, vis.nombres, vig.nombres) AS nombres_agendado,
                COALESCE(fun2.apellidos, apr.apellidos, vis.apellidos, vig.apellidos) AS apellidos_agendado
            FROM agendas age
            INNER JOIN funcionarios fun1 ON age.fk_usuario_sistema = fun1.numero_documento
            LEFT JOIN funcionarios fun2 ON age.fk_usuario = fun2.numero_documento
            LEFT JOIN visitantes vis ON age.fk_usuario = vis.numero_documento
            LEFT JOIN vigilantes vig ON age.fk_usuario = vig.numero_documento
            LEFT JOIN aprendices apr ON age.fk_usuario = apr.numero_documento
            WHERE age.codigo_agenda = '$codigoAgenda';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Agenda No Encontrada',
                "mensaje"=> 'No se encontró la agenda solicitada.'
            ];
            return $respuesta;
        }

        $resultados = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $objetoFecha = new DateTime($resultados[0]['fecha_agenda']);
        $mes = MESES[$objetoFecha->format('F')];  
        $fechaFormateada = $objetoFecha->format('j') . ' de ' . $mes;

        $horaFormateada = strtolower($objetoFecha->format('g:iA')); 

        $datosAgenda = [
            'titulo' => $resultados[0]['titulo'],
            'motivo' => $resultados[0]['motivo'],
            'fecha_agenda' => $resultados[0]['fecha_agenda'],
            'fecha'=> $fechaFormateada,
            'hora'=> $horaFormateada,
            'nombres_responsable'=> $resultados[0]['nombres_responsable'],
            'apellidos_responsable'=> $resultados[0]['apellidos_responsable'],
            'agendados' => []
        ];
        
        foreach ($resultados as $resultado) {
            $datosAgenda['agendados'][] = [
                'numero_documento' => $resultado['numero_documento'],
                'nombres' => $resultado['nombres_agendado'],
                'apellidos' => $resultado['apellidos_agendado']
            ];
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Consulta Exitosa',
            'mensaje' => 'La agenda fue consultada correctamente.',
            'datos_agenda' => $datosAgenda
        ];
        return $respuesta;
    }

    public function eliminarAgenda($codigoAgenda){
        $sentenciaEliminar = "
            DELETE
            FROM agendas
            WHERE codigo_agenda = '$codigoAgenda';";

        $respuesta = $this->ejecutarConsulta($sentenciaEliminar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' =>'Eliminación Exitosa',
            'mensaje' => 'La agenda fue eliminada correctamente.'
        ];
        return $respuesta;
    }
}