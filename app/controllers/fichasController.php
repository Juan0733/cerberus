<?php

    namespace app\controllers;
    use app\models\mainModel;
    class FichasController extends mainModel{

public function registrarFichaControlador(){
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $mensaje=[
            "titulo"=>"Peticion incorrecta",
            "mensaje"=>"Lo sentimos, la accion que intentas realizar no es correcta",
            "icono"=> "error",
            "tipoMensaje"=>"redireccionar",
            "url"=>"http://localhost/Adso04/PROYECTOS/cerberus/"
        ];
        return json_encode($mensaje);
    }else {
        if ($_POST['nombre_programa_s'] == "otro"){
            $nombre_programa = trim($_POST['nombre_programa']);
            } else {
            $nombre_programa = trim($_POST['nombre_programa_s']);
            }

        if ($_POST['numero_ficha'] != "") {
            $numero_ficha = $_POST['numero_ficha'];
        }

        if ($_POST['fecha_inicio'] != "" && $_POST['fecha_fin'] != "") {
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
        }

        unset($_POST['nombre_programa'],$_POST['nombre_programa_s'],$_POST['numero_ficha']);

        $sentencia = "INSERT INTO `fichas`(`num_ficha`, `fecha_inicio_ficha`, `fecha_fin_ficha`, `estado_ficha`, `fecha_registro_ficha`, `nombre_programa`) 
        VALUES ('$numero_ficha', '$fecha_inicio', '$fecha_fin', 'ACTIVO', NOW(), '$nombre_programa')";

        $insertar_ficha = $this->ejecutarInsert($sentencia);
        unset($sentencia);

        if ($insertar_ficha != 1) {
            $mensaje=[
                "titulo"=>"Error de Conexion",
                "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                "icono"=> "error",
                "tipoMensaje"=>"normal"
            ];
            return json_encode($mensaje);
        } else {         

            $mensaje=[
                "titulo"=>"Bien!",
                "mensaje"=>"Ha registrado una ficha con exito",
                "icono"=> "success",
                "tipoMensaje"=>"normal"
            ];
            echo json_encode($mensaje);
            exit();
        }
        
    }
        
}



public function obtenerProgramasController() {
        $sentencia = "SELECT DISTINCT nombre_programa FROM fichas;";

        $filtro_nombre = $this->ejecutarConsulta($sentencia);

        if ($filtro_nombre == 'conexion-fallida'){
            $mensaje=[
                "titulo"=>"Errord de conexión",
                "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentalo mas tarde",
                "icono"=> "error",
                "tipoMensaje"=> "normal"
            ];
            return json_encode($mensaje);
        } else {
            if($filtro_nombre->num_rows < 1) {
                $mensaje=[
                    "titulo"=>"Error en las ficha",
                    "mensaje"=>"Lo sentimos, parece que la ficha no existe. Intentelo mas tarde",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                return json_encode($mensaje);
            } else {
                $tabla = '';
                while ($datos = $filtro_nombre->fetch_object()) {
                    $tabla.='
                        "<option value="'. $datos->nombre_programa . '">' . $datos->nombre_programa . '</option>"
                    ';
                }
                $filtro_nombre->free();
                unset($filtro_nombre);
                return $tabla;
            }
        }     
    }
}