<?php
namespace app\services;

class MovimientoService{

    public function sanitizarDatosMovimientoPeatonal(){
        if (!isset($_POST['documento_peaton'], $_POST['observacion']) || $_POST['documento_peaton'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
          return $respuesta;
        }

        $numeroDocumento = $this->limpiarDatos($_POST['documento_peaton']);
        $observacion = $this->limpiarDatos($_POST['observacion_peatonal']);
        unset($_POST['documento_peaton'], $_POST['observacion_peatonal']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-zÑñ0-9 ]{0,100}",
                'cadena' => $observacion
            ]
        ];

        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
                ];
                return $respuesta;
			}
        }

        $observacion = empty($observacion) ? 'NULL' : "'$observacion'";

        $datosEntrada = [
            'numero_documento' => $numeroDocumento,
            'observacion' => $observacion
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_entrada" => $datosEntrada
        ];
        return $respuesta;
    }

    public function sanitizarParametros(){
        $parametros = [];

       if(isset($_GET['documento'])){
            $numeroDocumento= $this->limpiarDatos($_GET['documento']);
            unset($_GET['documento']);

            if(preg_match('/^[A-Za-z0-9]{6,15}$/', $numeroDocumento)){
                $parametros['numero_documento'] = $numeroDocumento;
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
    