<?php
	
namespace app\models;
use \mysqli;

if(file_exists(__DIR__."/../../config/server.php")){
	require_once __DIR__."/../../config/server.php";
}

class MainModel{
	private $conexion;

	private function conectar(){
		// mysqli_report(MYSQLI_REPORT_OFF);
		
		try {
			$this->conexion = new mysqli("localhost", "root", "", "cerberus");
		} catch (\Exception $e) {
			$this->conexion = '';
		}
	}
	
	protected function ejecutarConsulta($consulta){
		$this->conectar();
		if (!$this->conexion) {
			$respuesta = [
				"tipo"=>"ERROR",
				"titulo" => 'Error de Conexión',
				"mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
			];
			return $respuesta;

		}else {
			$sql = $this->conexion->query($consulta);
			if (!$sql) {
				$respuesta = [
                    "tipo"=>"ERROR",
                    "titulo" => 'Error de Operación',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error al ejecutar la operación, intentalo más tarde.'
                ];
                return $respuesta;
			}

			$tipoConsulta = strtoupper(substr(trim($consulta), 0, 6));
			if ($tipoConsulta == 'INSERT' || $tipoConsulta == 'DELETE') {
				if($this->conexion->affected_rows < 1){
					$respuesta = [
						"tipo"=>"ERROR",
						"titulo" => 'Operación Fallida',
						"mensaje"=> 'Lo sentimos, parece que la operación no tuvo los resultados esperados, intentalo más tarde.'
					];
					return $respuesta;
				}
			}

			$this->conexion->close();
			$this->conexion = '';

			$respuesta = [
				"tipo"=>"EXITO",
				"titulo" => 'Operación Exitosa',
				"mensaje"=> 'La operación se realizó correctamente.',
				"respuesta_sentencia" => $sql
			];

			return $respuesta;
		}
	}
}


