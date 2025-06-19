<?php
namespace app\models;

class FichaModel extends MainModel{

    public function registrarFicha($datosFicha){
        $respuesta = $this->validarDuplicidadFicha($datosFicha);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $sentenciaInsertar = "
            INSERT INTO fichas(numero_ficha, nombre_programa, fecha_fin_ficha, fecha_registro)
            VALUES('{$datosFicha['numero_ficha']}', '{$datosFicha['nombre_programa']}', '{$datosFicha['fecha_fin_ficha']}', '$fechaRegistro');";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Registro Exitoso',
            'mensaje' => 'La ficha fue registrada correctamente'
        ];
        return $respuesta;
    }

    public function validarDuplicidadFicha($datosFicha){
        $respuesta = $this->consultarFicha($datosFicha['numero_ficha']);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'OK'){
            $fichaActual = $respuesta['datos_ficha'];
            if($fichaActual['nombre_programa'] == $datosFicha['nombre_programa'] && $fichaActual['fecha_fin_ficha'] == $datosFicha['fecha_fin_ficha']){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Ficha Existente',
                    'mensaje' => 'No es posible registrar la ficha, porque ya se encuentra registrada en el sistema'
                ];
                return $respuesta; 
            }

            $respuesta = $this->eliminarFicha($datosFicha['numero_ficha']);
            if($respuesta['tipo'] == 'ERROR'){
                return $respuesta;
            }
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Ficha No Existente',
            'mensaje' => 'La ficha no se encuentra registrada en el sistema'
        ];
        return $respuesta;
    }

    public function consultarFichas(){
        $fechaActual = date('Y-m-d H:i:s');
        $sentenciaBuscar = "
            SELECT numero_ficha
            FROM fichas
            WHERE fecha_fin_ficha > '$fechaActual';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
             $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Datos No Encontrados',
                'mensaje' => 'No se encontraron resultados'
            ];
            return $respuesta;
        }

        $fichas = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $respuesta = [
            'tipo' => 'OK',
            'fichas' => $fichas
        ];
        return $respuesta;
    }

    public function consultarFicha($ficha){
        $sentenciaBuscar = "
            SELECT numero_ficha, nombre_programa, fecha_fin_ficha
            FROM fichas
            WHERE numero_ficha = '$ficha';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Datos No Encontrados',
                'mensaje' => 'No se encontraron resultados'
            ];
            return $respuesta;
        }

        $ficha = $respuestaSentencia->fetch_assoc();
        $respuesta = [
            'tipo' => 'OK',
            'datos_ficha' => $ficha
        ];
        return $respuesta;
    }

    private function eliminarFicha($ficha){
        $sentenciaEliminar = "
            DELETE
            FROM fichas
            WHERE numero_ficha = '$ficha';";
        
        $respuesta = $this->ejecutarConsulta($sentenciaEliminar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Eliminación Exitosa',
            'mensaje' => 'La ficha fue eliminada correctamente'
        ];
        return $respuesta;
    }
}