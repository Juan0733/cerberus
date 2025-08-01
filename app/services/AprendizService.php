<?php
namespace App\Services;

class AprendizService{
    public function sanitizarDatosRegistroAprendiz(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['numero_ficha'], $_POST['nombre_programa'], $_POST['fecha_fin_ficha']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['tipo_documento'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['numero_ficha'] == '' || $_POST['nombre_programa'] == '' || $_POST['fecha_fin_ficha'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $tipoDocumento = $this->limpiarDatos($_POST['tipo_documento']);
        $numeroDocumento = $this->limpiarDatos($_POST['numero_documento']);
        $nombres = $this->limpiarDatos($_POST['nombres']);
        $apellidos = $this->limpiarDatos($_POST['apellidos']);
        $telefono = $this->limpiarDatos($_POST['telefono']);
        $correoElectronico = $this->limpiarDatos($_POST['correo_electronico']);
        $numeroFicha = $this->limpiarDatos($_POST['numero_ficha']);
        $nombrePrograma = $this->limpiarDatos($_POST['nombre_programa']);
        $fechaFinFicha = $this->limpiarDatos($_POST['fecha_fin_ficha']);
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['numero_ficha'], $_POST['nombre_programa'], $_POST['fecha_fin_ficha']); 
		
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
                'filtro' => "[0-9]{7}",
                'cadena' => $numeroFicha
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}",
                'cadena' => $nombrePrograma
            ],
            [
                'filtro' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])',
                'cadena' => $fechaFinFicha
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

        $nombres = mb_convert_case(mb_strtolower(trim($nombres), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower(trim($apellidos), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $nombrePrograma = mb_convert_case(mb_strtolower(trim($nombrePrograma), "UTF-8"), MB_CASE_TITLE, "UTF-8");

        $datosAprendiz = [
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'numero_ficha' => $numeroFicha,
            'nombre_programa' => $nombrePrograma,
            'fecha_fin_ficha' => $fechaFinFicha
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_aprendiz" => $datosAprendiz
        ];
        return $respuesta;
    }

    public function sanitizarDatosActualizacionAprendiz(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['numero_ficha'], $_POST['nombre_programa'], $_POST['fecha_fin_ficha']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['numero_ficha'] == '' || $_POST['nombre_programa'] == '' || $_POST['fecha_fin_ficha'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $numeroDocumento = $this->limpiarDatos($_POST['numero_documento']);
        $nombres = $this->limpiarDatos($_POST['nombres']);
        $apellidos = $this->limpiarDatos($_POST['apellidos']);
        $telefono = $this->limpiarDatos($_POST['telefono']);
        $correoElectronico = $this->limpiarDatos($_POST['correo_electronico']);
        $numeroFicha = $this->limpiarDatos($_POST['numero_ficha']);
        $nombrePrograma = $this->limpiarDatos($_POST['nombre_programa']);
        $fechaFinFicha = $this->limpiarDatos($_POST['fecha_fin_ficha']);
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['numero_ficha'], $_POST['nombre_programa'], $_POST['fecha_fin_ficha']); 
		
		$datos = [
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
                'filtro' => "[0-9]{7}",
                'cadena' => $numeroFicha
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}",
                'cadena' => $nombrePrograma
            ],
            [
                'filtro' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])',
                'cadena' => $fechaFinFicha
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

        $nombres = mb_convert_case(mb_strtolower(trim($nombres), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower(trim($apellidos), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $nombrePrograma = mb_convert_case(mb_strtolower(trim($nombrePrograma), "UTF-8"), MB_CASE_TITLE, "UTF-8");

        $datosAprendiz = [
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'numero_ficha' => $numeroFicha,
            'nombre_programa' => $nombrePrograma,
            'fecha_fin_ficha' => $fechaFinFicha
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_aprendiz" => $datosAprendiz
        ];
        return $respuesta;
    }

    public function sanitizarParametros()
    {
        $parametros = [];

        if(isset($_GET['ubicacion'])){
            $ubicacion = $this->limpiarDatos($_GET['ubicacion']);
            unset($_GET['ubicacion']);

            if(preg_match('/^(DENTRO|FUERA)$/', $ubicacion)){
                 $parametros['ubicacion'] = $ubicacion;
            }
        }

        if(isset($_GET['documento'])){
            $numeroDocumento= $this->limpiarDatos($_GET['documento']);
            unset($_GET['documento']);

            if(preg_match('/^[A-Za-z0-9]{1,15}$/', $numeroDocumento)){
                $parametros['numero_documento'] = $numeroDocumento;
            }
        }

        if(isset($_GET['ficha'])){
            $numeroFicha = $this->limpiarDatos($_GET['ficha']);
            unset($_GET['ficha']);

            if(preg_match('/^[0-9]+$/', $numeroFicha)){
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
    