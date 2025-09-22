<?php
namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class MainService{
    public function sanitizarDatosActualizacionContrasenaUsuario(){
        if(!isset($_POST['contrasena']) || $_POST['contrasena'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $contrasena = $this->limpiarDatos($_POST['contrasena']);
        unset($_POST['contrasena']); 
		    
        if(!preg_match("/^[A-Za-z0-9*_@\-]{8,}$/", $contrasena)){
            $respuesta = [
                "tipo" => "ERROR",
                'titulo' => "Formato Inválido",
                'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
            ];
            return $respuesta;
        }

        $contrasena = md5($contrasena);
        $respuesta = [
            "tipo" => "OK",
            "contrasena" => $contrasena
        ];
        return $respuesta;
    }

    public function sanitizarDatosHabilitacionUsuario(){
        if(!isset($_POST['numero_documento'], $_POST['contrasena']) || $_POST['numero_documento'] == '' || $_POST['contrasena'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $numeroDocumento = $this->limpiarDatos($_POST['numero_documento']);
        $contrasena = $this->limpiarDatos($_POST['contrasena']);
        unset($_POST['numero_documento'], $_POST['contrasena']); 
		
		$datos = [
            [
				'filtro' => "[A-Za-z0-9]{6,15}",
				'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-z0-9*_@\-]{8,}",
                'cadena' => $contrasena
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

        $contrasena = md5($contrasena);

        $datosUsuario = [
            'numero_documento' => $numeroDocumento,
            'contrasena' => $contrasena
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_usuario" => $datosUsuario
        ];
        return $respuesta;
    }

    protected function guardarArhivoExcel($archivo){
        $carpetaPlantilla = "../excel/";

        if(!file_exists($carpetaPlantilla)){
            mkdir($carpetaPlantilla);
        }

        $nombrePlantilla = time() . "_" . $archivo['name'];
        $rutaTemporal = $archivo['tmp_name'];
        $rutaPlantilla = $carpetaPlantilla . $nombrePlantilla;
            
        move_uploaded_file($rutaTemporal, $rutaPlantilla);

        if(!file_exists($rutaPlantilla)){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Archivo No Subido',
                'mensaje' => 'Se produjo un erro al subir el archivo.'
            ];
            return $respuesta;
        }

        $respuesta = [
            'tipo' => 'OK',
            'ruta_archivo' => $rutaPlantilla
        ];
        return $respuesta;
    }

    protected function leerArchivoExcel($rutaArchivo, $encabezados, $columnaLimite){
        try {
            $archivo = IOFactory::load($rutaArchivo);
            $hojaActual = $archivo->getActiveSheet(0);

            $datosExcel = [];
            $ultimaFila = $hojaActual->getHighestRow();

            for ($i = 2; $i <= $ultimaFila; $i++) {
                $valoresCeldas = [];
                $celdasVacias = 0;

                foreach ($hojaActual->getColumnIterator('A', $columnaLimite) as $columna) {
                    $indiceColumna = $columna->getColumnIndex();
                    $celda = $hojaActual->getCell($indiceColumna . $i);
                    $valorCelda = $this->limpiarDatos($celda->getValue());
                    $valoresCeldas[] = $valorCelda;

                    if (trim($valorCelda) == '') {
                        $celdasVacias += 1;
                    }
                }

                if ($celdasVacias > 2) {
                    continue;
                }

                if (count($encabezados) === count($valoresCeldas)) {
                    $datosFila = array_combine($encabezados, $valoresCeldas);
                    $datosExcel[] = $datosFila;
                }
            }
            unlink($rutaArchivo);

            $respuesta = [
                'tipo' => 'OK',
                'datos_excel' => $datosExcel
            ]; 
            return $respuesta;

        } catch (\Throwable $th) {
            unlink($rutaArchivo);

            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Excel',
                'mensaje' => 'Se produjo un error al tratar de leer el archivo excel.'.$th
            ];
            return $respuesta;
        }
    }

    protected function validarDuplicidadDatosArray($array2D, $clave) {
        $valores = array_column($array2D, $clave);
        if(count($valores) !== count(array_unique($valores))){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Datos Duplicados',
                'mensaje' => 'Se encontraron datos duplicados dentro del array proporcionado.'
            ];
            return $respuesta;
        };

        $respuesta = [
            'tipo' => 'OK',
            'titulo' => 'Datos Sin Duplicados',
            'mensaje' => 'No se encontro duplicidad en los datos del array proporcionado.'
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