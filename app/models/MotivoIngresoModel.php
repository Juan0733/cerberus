<?php
namespace app\models;

class MotivoIngresoModel extends MainModel{
    public function registrarMotivoIngreso($motivo){
        $respuesta = $this->validarDuplicidadMotivo($motivo);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $sentenciaInsertar = "
            INSERT INTO motivos_ingreso(motivo, fecha_registro)
            VALUES('$motivo', '$fechaRegistro');";
        
        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Registro Exitoso',
            'mensaje' => 'El motivo fue registrado correctamente'
        ];
        return $respuesta;
    }

    private function validarDuplicidadMotivo($motivo){
        $respuesta = $this->consultarMotivoIngreso($motivo);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'OK'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Motivo Existente',
                'mensaje' => 'No es posible registrar el motivo, porque ya se encuentra registrado en el sistema'
            ];
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Motivo No Existente',
            'mensaje' => 'El motivo no se encuentra registrado en el sistema'
        ];
        return $respuesta;
    }

    public function consultarMotivosIngreso(){
        $sentenciaBuscar = "
            SELECT motivo
            FROM motivos_ingreso";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Datos No Encontrados',
                'mensaje' => 'No se encontraron resultados'
            ];
            return $respuesta;
        }

        $motivos = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'motivos_ingreso' => $motivos
        ];
        return $respuesta;
    }

    private function consultarMotivoIngreso($motivo){
        $sentenciaBuscar = "
            SELECT motivo 
            FROM motivos_ingreso
            WHERE motivo = '$motivo';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Motivo No Encontrado',
                'mensaje' => 'No se encontraron resultados del motivo'
            ];
            return $respuesta;
        }

        $this->cerrarConexion();

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Datos Encontrados',
            'mensaje' => 'Se encontraron resultados'
        ];
        return $respuesta;
    }
}