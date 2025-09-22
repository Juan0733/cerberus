<?php
namespace App\Services;

class PermisoUsuarioService extends MainService{
    public function sanitizarDatosRegistroPermisoUsuario(){
        if (!isset($_POST['documento_beneficiario'], $_POST['tipo_permiso'], $_POST['descripcion'], $_POST['fecha_fin_permiso']) || $_POST['documento_beneficiario'] == '' || $_POST['tipo_permiso'] == '' || $_POST['descripcion'] == '' || $_POST['fecha_fin_permiso'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $numeroDocumento = $this->limpiarDatos($_POST['documento_beneficiario']);
        $tipoPermiso = $this->limpiarDatos($_POST['tipo_permiso']);
        $descripcion = $this->limpiarDatos($_POST['descripcion']);
        $fechaFinPermiso = $this->limpiarDatos($_POST['fecha_fin_permiso']);
        $estadoPermiso = 'PENDIENTE';
        unset($_POST['documento_beneficiario'], $_POST['descripcion'], $_POST['fecha_fin_permiso']);

        $datos = [
            [
                'filtro' => "[A-Za-z0-9]{6,15}",
                'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "(PERMANENCIA|SALIDA)",
                'cadena' => $tipoPermiso
            ],
            [
                'filtro' => "[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])",
                'cadena' => $fechaFinPermiso
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}",
                'cadena' => $descripcion	
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

        if($tipoPermiso == 'SALIDA'){
            $estadoPermiso = 'APROBADO';
        }

        $descripcion = mb_strtoupper(mb_substr(trim($descripcion), 0, 1, "UTF-8"), "UTF-8").mb_strtolower(mb_substr(trim($descripcion), 1, null, "UTF-8"), "UTF-8");

        $datosPermiso = [
            'numero_documento' => $numeroDocumento,
            'tipo_permiso' => $tipoPermiso,
            'descripcion' => $descripcion,
            'fecha_fin_permiso' => $fechaFinPermiso,
            'estado_permiso' => $estadoPermiso
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_permiso" => $datosPermiso
        ];
        return $respuesta;
    }

    public function sanitizarParametros(){
        $parametros = [];

        if(isset($_GET['codigo_permiso'])){
            $codigoPermiso = $this->limpiarDatos($_GET['codigo_permiso']);
            unset($_GET['codigo_permiso']);

            if(preg_match('/^[A-Z0-9]{16}$/', $codigoPermiso)){
                $parametros['codigo_permiso'] = $codigoPermiso;
            }
        }

        if(isset($_GET['tipo_permiso'])){
            $tipoPermiso = $this->limpiarDatos($_GET['tipo_permiso']);
            unset($_GET['tipo_permiso']);

            if(preg_match('/^(PERMANENCIA|SALIDA)$/', $tipoPermiso)){
                $parametros['tipo_permiso'] = $tipoPermiso;
            }
        }

        if(isset($_GET['documento'])){
            $numeroDocumento = $this->limpiarDatos($_GET['documento']);
            unset($_GET['documento']);

            if(preg_match('/^[A-Za-z0-9]{6,15}$/', $numeroDocumento)){
                $parametros['numero_documento'] = $numeroDocumento;
            }
        }

        if(isset($_GET['estado'])){
            $estadoPermiso = $this->limpiarDatos($_GET['estado']);
            unset($_GET['estado']);

            if(preg_match('/^(APROBADO|DESAPROBADO|PENDIENTE)$/', $estadoPermiso)){
                $parametros['estado_permiso'] = $estadoPermiso;
            }
        }

        if(isset($_GET['fecha'])){
            $fecha = $this->limpiarDatos($_GET['fecha']);
            unset($_GET['ficha']);

            if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $fecha)){
                $parametros['fecha'] = $fecha;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
    }
}
    