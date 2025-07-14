<?php
	
namespace app\models;
use \mysqli;

class MainModel{
	private $conexion;

	private function conectar(){
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		try {
			$this->conexion = new mysqli("localhost", "root", "", "cerberus");
			$respuesta = [
				"tipo"=>"OK",
				"titulo" => 'Conexión Exitosa',
				"mensaje"=> 'La conexion se realizo correctamente'
			];
			return $respuesta;

		} catch (\mysqli_sql_exception $e) {
			$respuesta = [
				"tipo"=>"ERROR",
				"titulo" => 'Error de Conexión',
				"mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.'
			];
			return $respuesta;
		}
	}
	
	protected function ejecutarConsulta($consulta){
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		$respuesta = $this->conectar();
		if($respuesta['tipo'] == 'ERROR'){
			return $respuesta;
		}
		
		try {
			$sql = $this->conexion->query($consulta);

			$tipoConsulta = strtoupper(substr(trim($consulta), 0, 6));
			if ($tipoConsulta == 'INSERT' || $tipoConsulta == 'DELETE') {
				if($this->conexion->affected_rows < 1){
					$respuesta = [
						"tipo"=>"ERROR",
						"titulo" => 'Error de Conexión',
						"mensaje"=> 'Lo sentimos, parece que la operación no tuvo los resultados esperados, intentalo más tarde.'
					];
					return $respuesta;
				}
			}

			$this->conexion->close();

			$respuesta = [
				"tipo"=>"EXITO",
				"titulo" => 'Operación Exitosa',
				"mensaje"=> 'La operación se realizó correctamente.',
				"respuesta_sentencia" => $sql
			];
			return $respuesta;

		} catch (\mysqli_sql_exception $e) {
			$this->conexion->close();
			$respuesta = [
				"tipo"=>"ERROR",
				"titulo" => 'Error de Conexión',
				"mensaje"=> 'Lo sentimos, parece que ocurrio un error al ejecutar la operación, intentalo más tarde.'
			];
			return $respuesta;
		}
	}
}


