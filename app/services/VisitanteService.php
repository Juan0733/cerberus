<?php
namespace app\services;

class VisitanteService{
    public function sanitizarDatosRegistroVisitante(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['documento_visitante'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['motivo_ingreso']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['tipo_documento'] == '' || $_POST['documento_visitante'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['motivo_ingreso'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];

            return $respuesta;
        }

        $tipoDocumento = $this->limpiarDatos($_POST['tipo_documento']);
        $numeroDocumento = $this->limpiarDatos($_POST['documento_visitante']);
        $nombres = $this->limpiarDatos($_POST['nombres']);
        $apellidos = $this->limpiarDatos($_POST['apellidos']);
        $telefono = $this->limpiarDatos($_POST['telefono']);
        $correoElectronico = $this->limpiarDatos($_POST['correo_electronico']);
        $motivoIngreso = $this->limpiarDatos($_POST['motivo_ingreso']);
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['documento_visitante'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['motivo_ingreso']); 
		
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
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}",
                'cadena' => $motivoIngreso
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

        $nombres = trim(ucwords(strtolower($nombres)));
        $apellidos = trim(ucwords((strtolower($apellidos))));
        $motivoIngreso = trim(ucfirst($motivoIngreso));

        $datosVisitante = [
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'motivo_ingreso' => $motivoIngreso
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_visitante" => $datosVisitante
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
    