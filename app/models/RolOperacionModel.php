<?php
namespace App\Models;

class RolOperacionModel extends MainModel{
    public function consultarOperacion($operacion){
        $sentenciaBuscar = "
            SELECT rol
            FROM roles_operaciones
            WHERE operacion = '$operacion';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $this->cerrarConexion();
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Operación No Encontrada',
                'mensaje' => 'Lo sentimos, no se encontro la operación solicitada.'
            ];
            return $respuesta;
        }

        $this->cerrarConexion();

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Operación Encontrada',
            'mensaje' => 'La operación si se encuentra registrada.'
        ];
        return $respuesta;
    }

    public function consultarRolOperacion($rol, $operacion){
        $sentenciaBuscar = "
            SELECT rol
            FROM roles_operaciones
            WHERE rol = '$rol' AND operacion = '$operacion';";

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
                'mensaje' => 'Lo sentimos, pero parece que este rol no tiene asociado la operación solicitada.'
            ];
            return $respuesta;
        }

        $this->cerrarConexion();

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Relación Encontrada',
            'mensaje' => 'El rol si esta asociado con la operación solicitada.'
        ];
        return $respuesta;
    }
}