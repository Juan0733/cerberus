<?php
namespace app\services;

class FichaService{

    public function sanitizarParametros(){
        $parametros = [];

        if(isset($_GET['ficha'])){
            $numeroFicha = $this->limpiarDatos($_GET['ficha']);
            unset($_GET['ficha']);

            if(preg_match('/^[0-9]{7}$/', $numeroFicha)){
                $parametros['numero_ficha'] = $numeroFicha;
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
    