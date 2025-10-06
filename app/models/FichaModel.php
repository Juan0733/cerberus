<?php
namespace App\Models;

class FichaModel extends MainModel{

    public function registrarFicha($datosFicha){
        $respuesta = $this->validarDuplicidadFicha($datosFicha);
        if($respuesta['tipo'] == 'ERROR' && ($respuesta['titulo'] == 'Error de Conexión' || $respuesta['titulo'] == 'Ficha Existente')){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Ficha Desactualizada'){
            $respuesta = $this->actualizarFicha($datosFicha);
            return $respuesta;
        }

        $fechaRegistro = date('Y-m-d H:i:s');
        $usuarioSistema = $_SESSION['datos_usuario']['numero_documento'];
        $rolSistema = $_SESSION['datos_usuario']['rol'];

        $sentenciaInsertar = "
            INSERT INTO fichas(numero_ficha, nombre_programa, fecha_fin_ficha, fecha_registro, rol_usuario_sistema, fk_usuario_sistema)
            VALUES('{$datosFicha['numero_ficha']}', '{$datosFicha['nombre_programa']}', '{$datosFicha['fecha_fin_ficha']}', '$fechaRegistro', '$rolSistema', '$usuarioSistema');";

        $respuesta = $this->ejecutarConsulta($sentenciaInsertar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Registro Exitoso',
            'mensaje' => 'La ficha fue registrada correctamente.'
        ];
        return $respuesta;
    }

    private function actualizarFicha($datosFicha){
        $sentenciaActualizar = "
            UPDATE fichas 
            SET nombre_programa = '{$datosFicha['nombre_programa']}', fecha_fin_ficha = '{$datosFicha['fecha_fin_ficha']}' 
            WHERE numero_ficha = '{$datosFicha['numero_ficha']}';";

        $respuesta = $this->ejecutarConsulta($sentenciaActualizar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Actualización Exitosa',
            'mensaje' => 'La ficha fue actualizada correctamente.'
        ];
        return $respuesta;
    }

    private function validarDuplicidadFicha($datosFicha){
        $respuesta = $this->consultarFicha($datosFicha['numero_ficha']);
        if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
            return $respuesta;

        }elseif($respuesta['tipo'] == 'OK'){
            $fichaActual = $respuesta['datos_ficha'];
            if($fichaActual['nombre_programa'] == $datosFicha['nombre_programa'] && $fichaActual['fecha_fin_ficha'] == $datosFicha['fecha_fin_ficha']){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Ficha Existente',
                    'mensaje' => 'No es posible registrar la ficha, porque ya se encuentra registrada en el sistema.'
                ];
                return $respuesta; 
            }

            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Ficha Desactualizada',
                'mensaje' => 'La ficha ya se encuentra registrada, pero el resto de su informacion no coincide con la proporcionada.'
            ];
            return $respuesta; 
        }

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Ficha No Existente',
            'mensaje' => 'La ficha no se encuentra registrada en el sistema.'
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
            $this->cerrarConexion();
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Datos No Encontrados',
                'mensaje' => 'No se encontraron resultados.'
            ];
            return $respuesta;
        }

        $fichas = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);
        $this->cerrarConexion();
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
            $this->cerrarConexion();
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Ficha No Encontrada',
                'mensaje' => 'No se encontraron resultados'
            ];
            return $respuesta;
        }

        $ficha = $respuestaSentencia->fetch_assoc();
        $this->cerrarConexion();
        $respuesta = [
            'tipo' => 'OK',
            'datos_ficha' => $ficha
        ];
        return $respuesta;
    }
}