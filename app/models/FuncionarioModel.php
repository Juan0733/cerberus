<?php
namespace app\models;
use app\models\MainModel;

class FuncionarioModel extends MainModel{

    public function consultarFuncionarios($parametros){
        $sentenciaBuscar = "
            SELECT numero_documento, nombres, apellidos, rol, telefono, correo_electronico, ubicacion 
            FROM funcionarios 
            WHERE 1=1";
        
        if(isset($parametros['brigadista'])){
            $sentenciaBuscar .= " AND brigadista = '{$parametros['brigadista']}'";
        }

        if(isset($parametros['ubicacion'])){
            $sentenciaBuscar .= " AND ubicacion = '{$parametros['ubicacion']}'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND numero_documento = '{$parametros['numero_documento']}'";
        }

        $sentenciaBuscar .= " ORDER BY fecha_registro DESC LIMIT 10;";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No encontrados',
                "mensaje"=> 'No se encontraron resultados.'
            ];
            return $respuesta;
        }

        $funcionarios = $respuestaSentencia->fetch_all(MYSQLI_ASSOC);

        $respuesta = [
            'tipo' => 'OK',
            'funcionarios' => $funcionarios
        ];

        return $respuesta;
    }

    public function conteoTotalBrigadistas(){
        $sentenciaBuscar = "
            SELECT numero_documento 
            FROM funcionarios 
            WHERE ubicacion = 'DENTRO' AND brigadista = 'SI';";

        $respuesta = $this->ejecutarConsulta($sentenciaBuscar);
        if ($respuesta['tipo'] == 'ERROR') {
            return $respuesta;
        }

        $respuestaSentencia = $respuesta['respuesta_sentencia'];
        $totalBrigadistas= $respuestaSentencia->num_rows;

        $respuesta = [
            'tipo' => "OK",
            'total_brigadistas' => $totalBrigadistas
        ];
        return $respuesta;
    }

}