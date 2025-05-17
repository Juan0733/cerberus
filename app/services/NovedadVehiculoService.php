<?php
namespace app\services;

class NovedadVehiculoService{
    public function sanitizarDatosNovedadVehiculo(){
        if (!isset($_POST['documento_involucrado'], $_POST['propietario'], $_POST['tipo_novedad'], $_POST['numero_placa'],  $_POST['descripcion']) || $_POST['documento_involucrado'] == '' || $_POST['propietario'] == '' || $_POST['tipo_novedad'] == '' || $_POST['numero_placa'] == '' || $_POST['descripcion'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $documentoInvolucrado = $this->limpiarDatos($_POST['documento_involucrado']);
        $propietario = $this->limpiarDatos($_POST['propietario']);
        $numeroPlaca = $this->limpiarDatos($_POST['numero_placa']);
        $tipoNovedad = $this->limpiarDatos($_POST['tipo_novedad']);
        $descripcion = $this->limpiarDatos($_POST['descripcion']);
        unset($_POST['documento_involucrado'], $_POST['propietario'], $_POST['numero_placa'], $_POST['tipo_novedad'], $_POST['descripcion']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $documentoInvolucrado
            ],
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $propietario
            ],
            [
                'filtro' => "[A-Za-z ]{1,50}",
                'cadena' => $tipoNovedad
            ],
            [
                'filtro' => "[A-Za-z0-9]{5,6}",
                'cadena' => $numeroPlaca
            ],
            [
                'filtro' => "[A-Za-zÑñ0-9 ]{5,100}",
                'cadena' => $descripcion	
            ]
        ];

        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.".$dato['cadena'],
                ];
                return $respuesta;
			}
        }

        $tipoNovedad = strtoupper($tipoNovedad);
        $numeroPlaca = strtoupper($numeroPlaca);

        $datosNovedad = [
            'documento_involucrado' => $documentoInvolucrado,
            'propietario' => $propietario,
            'numero_placa' => $numeroPlaca,
            'tipo_novedad' => $tipoNovedad,
            'descripcion' => $descripcion
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_novedad" => $datosNovedad
        ];
        return $respuesta;
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
    