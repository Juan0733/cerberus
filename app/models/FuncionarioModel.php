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
            $sentenciaBuscar .= " AND brigadista = '".$parametros['brigadista']."'";
        }

        if(isset($parametros['ubicacion'])){
            $sentenciaBuscar .= " AND ubicacion = '".$parametros['ubicacion']."'";
        }

        if(isset($parametros['numero_documento'])){
            $sentenciaBuscar .= " AND numero_documento LIKE '".$parametros['numero_documento']."%'";
        }

        $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
        if(!$respuestaSentencia){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Error de Conexión',
                "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
            ];
            return $respuesta;
        }

        if($respuestaSentencia->num_rows < 1){
            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" => 'Datos No encontrados',
                "mensaje"=> 'No se encontraron datos relacionados a los criterios de busqueda.'
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

}