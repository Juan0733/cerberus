<?php
namespace app\models;

class PermisoRolModel extends MainModel{
    public function consultarPermiso($permiso){
        $sentenciaBuscar = "
            SELECT rol
            FROM roles_permisos
            WHERE permiso = '$permiso';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Permiso No Encontrado',
                'mensaje' => 'Lo sentimos, no se encontro el permiso solicitado.'
            ];
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Permiso Encontrado',
            'mensaje' => 'El permiso si se encuentra registrado.'
        ];
        return $respuesta;
    }

    public function consultarPermisoRol($permiso, $rol){
        $sentenciaBuscar = "
            SELECT rol
            FROM roles_permisos
            WHERE permiso = '$permiso' AND rol = '$rol';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Permiso No Encontrado',
                'mensaje' => 'Lo sentimos, no se encontro una relación entre el permiso y rol proporcionado.'
            ];
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Permiso Encontrado',
            'mensaje' => 'El permiso si tiene relacion con el rol proporcionado.'
        ];
        return $respuesta;
    }
}