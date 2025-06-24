<?php
namespace app\services;

class NovedadUsuarioService{
    public function sanitizarDatosRegistroNovedadUsuario(){
        if (!isset($_POST['documento_involucrado'], $_POST['tipo_novedad'], $_POST['fecha_suceso'], $_POST['puerta_suceso'], $_POST['descripcion']) || $_POST['documento_involucrado'] == '' || $_POST['tipo_novedad'] == '' || $_POST['fecha_suceso'] == '' || $_POST['puerta_suceso'] == '' || $_POST['descripcion'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $numeroDocumento = $this->limpiarDatos($_POST['documento_involucrado']);
        $tipoNovedad = $this->limpiarDatos($_POST['tipo_novedad']);
        $fechaSuceso = $this->limpiarDatos($_POST['fecha_suceso']);
        $puertaSuceso = $this->limpiarDatos($_POST['puerta_suceso']);
        $descripcion = $this->limpiarDatos($_POST['descripcion']);
        unset($_POST['documento_involucrado'], $_POST['tipo_novedad'], $_POST['fecha_suceso'], $_POST['puerta_suceso'], $_POST['descripcion']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-z ]{1,50}",
                'cadena' => $tipoNovedad
            ],
            [
                'filtro' => "[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])",
                'cadena' => $fechaSuceso
            ],
            [
                'filtro' => "(principal|ganaderia|peatonal)",
                'cadena' => $puertaSuceso
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}",
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

        $datosNovedad = [
            'numero_documento' => $numeroDocumento,
            'tipo_novedad' => $tipoNovedad,
            'fecha_suceso' => $fechaSuceso,
            'puerta_suceso' => $puertaSuceso,
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
    