<?php
	
namespace app\models;
use \mysqli;

if(file_exists(__DIR__."/../../config/server.php")){
	require_once __DIR__."/../../config/server.php";
}

class MainModel{
	protected function conectar(){
		// mysqli_report(MYSQLI_REPORT_OFF);
		
		try {
			$enlace_conexion = new mysqli("localhost", "root", "", "cerberus");
			//   $enlace_conexion = new mysqli("localhost", "arcanoposada_adsob", "CDqaQeehjt9y", "arcanoposada_cerbeb"); 
		
			if ($enlace_conexion->connect_error) {
				throw new \Exception("No se realizó la conexión: " . $enlace_conexion->connect_error);
			}else {
				return $enlace_conexion;
			} 
		} catch (\Exception $e) {
			unset($enlace_conexion);
			return false; 
		}
	}
	
	protected function ejecutarConsulta($consulta){
		$conexion = $this->conectar();
		if (!$conexion) {
			return false;
		}else {
			$sql=$conexion->query($consulta);
			$conexion->close();
			return $sql;
		}
	}
}


