<?php
namespace app\services;
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class AgendaService{

    public function sanitizarDatosActualizacionAgenda(){
        if (!isset($_POST['codigo_agenda'], $_POST['motivo'], $_POST['titulo'], $_POST['fecha_agenda']) || $_POST['codigo_agenda'] == '' || $_POST['titulo'] == '' || $_POST['motivo'] == '' || $_POST['fecha_agenda'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

       
        $codigoAgenda = $this->limpiarDatos($_POST['codigo_agenda']);
        $titulo = $this->limpiarDatos($_POST['titulo']);
        $motivo = $this->limpiarDatos($_POST['motivo']);
        $fechaAgenda = $this->limpiarDatos($_POST['fecha_agenda']);
        unset($_POST['codigo_agenda'], $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']);

        $datos = [
            [
                'filtro' => "[A-Z0-9]{16}",
                'cadena' => $codigoAgenda
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,50}",
                'cadena' => $titulo
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}",
                'cadena' => $motivo
            ],
            [
                'filtro' => "[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])",
                'cadena' => $fechaAgenda
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

        $titulo = ucwords(strtolower($titulo));
        $motivo = trim(ucfirst(strtolower($motivo)));

        $datosAgenda = [
            'codigo_agenda' => $codigoAgenda,
            'titulo' => $titulo,
            'motivo' => $motivo,
            'fecha_agenda' => $fechaAgenda
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_agenda" => $datosAgenda
        ];
        return $respuesta;
    }

    public function sanitizarDatosRegistroAgendaIndividual(){
        if (!isset($_POST['tipo_documento'], $_POST['numero_documento'], $_POST['nombres'], $_POST['apellidos'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']) || $_POST['tipo_documento'] == '' || $_POST['numero_documento'] == '' || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['titulo'] == '' || $_POST['motivo'] == '' || $_POST['fecha_agenda'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
          return $respuesta;
        }

        $tipoDocumento = $this->limpiarDatos($_POST['tipo_documento']);
        $numeroDocumento = $this->limpiarDatos($_POST['numero_documento']);
        $nombres = $this->limpiarDatos($_POST['nombres']);
        $apellidos = $this->limpiarDatos($_POST['apellidos']);
        $telefono = $this->limpiarDatos($_POST['telefono']);
        $correoElectronico = $this->limpiarDatos($_POST['correo_electronico']);
        $titulo = $this->limpiarDatos($_POST['titulo']);
        $motivo = $this->limpiarDatos($_POST['motivo']);
        $fechaAgenda = $this->limpiarDatos($_POST['fecha_agenda']);
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']); 
		
		$datos = [
			[
				'filtro' => "(CC|CE|TI|PP|PEP)",
				'cadena' => $tipoDocumento
            ],
            [
				'filtro' => "[A-Za-z0-9]{6,15}",
				'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}",
                'cadena' => $nombres
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}",
                'cadena' => $apellidos
            ],
            [
                'filtro' => "[0-9]{10}",
                'cadena' => $telefono
            ],
            [
                'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}",
                'cadena' => $correoElectronico
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,50}",
                'cadena' => $titulo
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}",
                'cadena' => $motivo
            ],
            [
                'filtro' => "[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])",
                'cadena' => $fechaAgenda
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

        $titulo = ucwords(strtolower($titulo));
        $motivo = trim(ucfirst(strtolower($motivo)));

        $datosAgenda = [
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'titulo' => $titulo,
            'motivo' => $motivo,
            'fecha_agenda' => $fechaAgenda
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_agenda" => $datosAgenda
        ];
        return $respuesta;
    }

    public function sanitizarDatosRegistroAgendaGrupal(){
        if (!isset($_FILES['plantilla_excel'],  $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']) || $_FILES['plantilla_excel'] == '' ||  $_POST['titulo'] == '' || $_POST['motivo'] == '' || $_POST['fecha_agenda'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
          return $respuesta;
        }

        $archivo = $_FILES['plantilla_excel'];
        $titulo = $this->limpiarDatos($_POST['titulo']);
        $motivo = $this->limpiarDatos($_POST['motivo']);
        $fechaAgenda = $this->limpiarDatos($_POST['fecha_agenda']);
        unset($_FILES['plantilla_excel'], $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']); 

        $datos = [
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,50}",
                'cadena' => $titulo
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}",
                'cadena' => $motivo
            ],
            [
                'filtro' => "[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])",
                'cadena' => $fechaAgenda
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

        $respuesta = $this->guardarArhivoExcel($archivo);
        if($respuesta == 'ERROR'){
            return $respuesta;
        }

        $rutaArchivo = $respuesta['ruta_archivo'];

        $respuesta = $this->leerArchivoExcel($rutaArchivo);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }

        $agendados = $respuesta['agendados'];
        foreach ($agendados as $agendado) {
            
            $datos = [
                [
                    'filtro' => "[A-Z]{2,3}",
                    'cadena' => $agendado['tipo_documento']
                ],
                [
                    'filtro' => "[A-Za-z0-9]{6,15}",
                    'cadena' => $agendado['numero_documento']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $agendado['nombres']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $agendado['apellidos']
                ],
                [
                    'filtro' => "[0-9]{10}",
                    'cadena' => $agendado['telefono']
                ],
                [
                    'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}",
                    'cadena' => $agendado['correo_electronico']
                ],
            
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
        }

        $titulo = ucwords(strtolower($titulo));
        $motivo = trim(ucfirst(strtolower($motivo)));

        $datosAgenda = [
            'agendados' => $agendados,
            'titulo' => $titulo,
            'motivo' => $motivo,
            'fecha_agenda' => $fechaAgenda
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_agenda" => $datosAgenda
        ];
        return $respuesta; 
    }

    public function sanitizarParametros(){
        $parametros = [];

        if(isset($_GET['codigo_agenda'])){
            $codigoAgenda = $this->limpiarDatos($_GET['codigo_agenda']);
            unset($_GET['codigo_agenda']);

            if(preg_match('/^[A-Z0-9]{16}$/', $codigoAgenda)){
                $parametros['codigo_agenda'] = $codigoAgenda;
            }
        }

        if(isset($_GET['fecha'])){
            $fecha = $this->limpiarDatos($_GET['fecha']);
            unset($_GET['fecha']);

            if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $fecha)){
                $parametros['fecha'] = $fecha;
            }
        }

        if(isset($_GET['documento'])){
            $numeroDocumento = $this->limpiarDatos($_GET['documento']);
            unset($_GET['documento']);

            if(preg_match('/^[A-Za-z0-9]{1,15}$/', $numeroDocumento)){
                $parametros['numero_documento'] = $numeroDocumento;
            }
        }

        if(isset($_GET['titulo'])){
            $titulo = $this->limpiarDatos($_GET['titulo']);
            unset($_GET['titulo']);

            if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{1,15}$/', $titulo)){
                $parametros['titulo'] = $titulo;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
    }

    private function guardarArhivoExcel($archivo){
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



    private function leerArchivoExcel($rutaArchivo){
        try {
            $archivo = IOFactory::load($rutaArchivo);
                    
            $agendados = [];
            $encabezados = ['tipo_documento', 'numero_documento', 'nombres', 'apellidos', 'telefono', 'correo_electronico'];
            
            $hojaActual = $archivo->getActiveSheet(0);
            $filas = $hojaActual->getRowIterator();
            foreach($filas as $fila){
                $valoresCeldas = [];
                if($fila->getRowIndex() == 1){
                    continue;
                }

                $celdas = $fila->getCellIterator();
                $celdas->setIterateOnlyExistingCells(true);
                foreach($celdas as $celda){
                    $valorCelda = $this->limpiarDatos($celda->getValue());
                    if(!empty($valorCelda)){
                        $valoresCeldas[] = $valorCelda;
                    }
                }

                if(count($valoresCeldas) == 6){
                    $agendado = array_combine($encabezados, $valoresCeldas);
                    $agendados[] = $agendado;
                }
            }

            unlink($rutaArchivo);

            $respuesta = [
                'tipo' => 'OK',
                'agendados' => $agendados
            ]; 
            return $respuesta;

        } catch (\Throwable $th) {
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Excel',
                'mensaje' => 'Se produjo un error al tratar de leer el archivo excel.'
            ];
            return $respuesta;
        }
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
    