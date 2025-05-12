<?php
namespace app\services;

class VehiculoService{

	 public function sanitizarParametros(){
        $parametros = [];

       if(isset($_GET['placa'])){
            $numeroPlaca= $this->limpiarDatos($_GET['documento']);
            unset($_GET['placa']);

            if(preg_match('/^[A-Za-z0-9]{6,15}$/', $numeroPlaca)){
                $parametros['numero_documento'] = $numeroPlaca;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
    }

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
