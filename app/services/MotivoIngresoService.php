<?php
namespace App\Services;

class MotivoIngresoService{

    public function limpiarDatos($dato){
		$palabras=["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==",";","::"];

		$dato=trim($dato);
		$dato=stripslashes($dato);

		foreach($palabras as $palabra){
			$dato=str_ireplace($palabra, "", $dato);
		}

		$dato=trim($dato);
		$dato=stripslashes($dato);

		return $dato;
	}
}
    