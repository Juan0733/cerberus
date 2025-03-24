<?php

namespace app\controllers;
use app\models\mainModel;



class vigilanteController extends mainModel{

	
    public function registrarVigilanteControlador(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $mensaje=[
                "titulo"=>"Peticion incorrecta",
                "mensaje"=>"Lo sentimos, la accion que intentas realizar no es correcta",
                "icono"=> "error",
                "tipoMensaje"=>"redireccionar",
                "url"=>"http://localhost/Adso04/PROYECTOS/cerberus/panel-principal/"
            ];
            return json_encode($mensaje);
            exit();
    }else {/* Validacion de la no existencia de variables post y que vengan vacias a excepcion de los campos de vehiculos que no son obligatorios para el registro para eviar una alerta de error con los campos. */

        
		if(!isset(  $_POST['tipo_documento'],
        $_POST['num_identificacion'],
        $_POST['nombres'],
        $_POST['apellidos'],
        $_POST['telefono'],
        $_POST['correo'],
        $_POST['rol_usuario'],
		$_POST['tipo_vehiculo_vigilante'],
        $_POST['placa_vehiculo_vigilante'])
        // Validación de la existencia de variables POST y que vengan vacías
		||
		$_POST['tipo_documento'] == "" ||
        $_POST['num_identificacion'] == "" ||
        $_POST['nombres'] == "" ||
        $_POST['apellidos'] == "" ||
        $_POST['telefono'] == "" ||
        $_POST['correo'] == "" ||
        $_POST['rol_usuario'] == "" ){
            $mensaje=[
                "titulo"=>"Error",
                "mensaje"=>"Lo sentimos, a ocurrido un error con alguno de los datos, intentalo de nuevo mas tarde.",
                "icono"=> "error",
                "tipoMensaje"=>"normal"
            ];
            return json_encode($mensaje);
            exit();
			
		}else{
            // Limpieza y validación de datos
			$tipodocumento = $this->limpiarDatos( $_POST['tipo_documento']);
        	$numero_documento = $this->limpiarDatos( $_POST['num_identificacion']);
        	$nombre = $this->limpiarDatos( $_POST['nombres']);
        	$apellido = $this->limpiarDatos( $_POST['apellidos']);
        	$telefono = $this->limpiarDatos( $_POST['telefono']);
        	$email = $this->limpiarDatos( $_POST['correo']);
        	$rol = $this->limpiarDatos( $_POST['rol_usuario']);
			$tipo_vehiculo = $this->limpiarDatos($_POST['tipo_vehiculo_vigilante']);
			$placa_vehiculo = $this->limpiarDatos($_POST['placa_vehiculo_vigilante']); 
            $credenciales = $this->limpiarDatos($_POST['credencial']); 
            $usuario=$_SESSION['datos_usuario']['num_identificacion'];


            unset($_POST['nombres'],$_POST['tipo_documento'],$_POST['correo'],$_POST['apellidos'],$_POST['num_identificacion'], $_POST['telefono'], $_POST['tipo_vehiculo_vigilante'],$_POST['placa_vehiculo_vigilante']);

              // Validación de campos
            $campos_invalidos = [];
            if ($this->verificarDatos('[A-Za-z ]{2,64}', $nombre)) {
                array_push($campos_invalidos, 'NOMBRE(S)');
            }else {
                $nombre_vg = $nombre;
            }
            if ($this->verificarDatos('[A-Z]{2}', $tipodocumento)) {
                array_push($campos_invalidos, 'TIPO DE DOCUMENTO');
            }else {
                $tipodocumento_vg = $tipodocumento;
            }
            if ($this->verificarDatos('[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}', $email)) {
                array_push($campos_invalidos, 'CORREO ELECTRONICO');
            }else {
                $correo_vg = $email;
            }
            if ($this->verificarDatos('[A-Za-z ]{2,64}', $apellido)) {
                array_push($campos_invalidos, 'APELLIDO(S)');
            }else {
                $apellidos_vg = $apellido;
            }
            if ($this->verificarDatos('[0-9]{6,15}',$numero_documento)) {
                array_push($campos_invalidos, 'NUMERO DE DOCUMENTO');
                
            }else {
                $numero_documento_vg = $numero_documento; 
            }
            if ($this->verificarDatos('[0-9]{10}', $telefono)) {
                array_push($campos_invalidos, 'TELEFONO');
            }else {
                $telefono_vg = $telefono;
            }

            unset($nombre, $tipodocumento, $correo, $apellido, $numero_documento, $telefono);

			// Manejo de vehículo (opcional)
            if ($tipo_vehiculo != "" && $placa_vehiculo != "") {

                if ($this->verificarDatos('[A-Z]{2,}',$tipo_vehiculo)) {
                    array_push($campos_invalidos, 'TIPO DE VEHICULO');
                }else{
                    $tipo_vehiculo_vg = $tipo_vehiculo;
                }
                if ($this->verificarDatos('[A-Z0-9]{6,7}',$placa_vehiculo)) {
                    array_push($campos_invalidos, 'PLACA DE VEHICULO');
                }else {
                    $placa_vehiculo_vg = $placa_vehiculo;
                }

				unset($placa_vehiculo, $tipo_vehiculo);

			}elseif ($tipo_vehiculo != "" && $placa_vehiculo == "") {
				$mensaje=[
					"titulo"=>"Campo incompleto",
					"mensaje"=>"Lo sentimos, el campo de PLACA DE VEHICULO esta incompleto.",
					"icono"=> "error",
					"tipoMensaje"=>"normal"
				];
				return json_encode($mensaje);
				exit();
			}elseif($tipo_vehiculo == "" && $placa_vehiculo != "") {
				$mensaje=[
					"titulo"=>"Campo incompleto",
					"mensaje"=>"Lo sentimos, el campo de TIPO DE VEHICULO esta incompleto.",
					"icono"=> "error",
					"tipoMensaje"=>"normal"
				];
				return json_encode($mensaje);
				exit();
			}
             // Verificación de campos inválidos
			if (count($campos_invalidos) > 0) {
				$invalidos = "";
				foreach ($campos_invalidos as $campos) {
					if ($invalidos == "") {
						$invalidos = $campos;
					}else {
						$invalidos = $invalidos.", ".$campos;
					}
				}
				$mensaje=[
					"titulo"=>"Campos incompletos",
					"mensaje"=>"Lo sentimos, los campos ".$invalidos." no cumplen con el formato solicitado.",
					"icono"=> "error",
					"tipoMensaje"=>"normal"
				];
				return json_encode($mensaje);
				exit();
			}else {
                        // Buscar si existe un vigilante con el mismo número de identificación
						$buscar_vigilante_query = "
                            SELECT 'aprendices' AS tabla, a.num_identificacion, a.estado 
                            FROM aprendices a 
                            WHERE num_identificacion = '$numero_documento_vg' AND a.estado = 'ACTIVO'
                        UNION ALL
                            SELECT 'funcionarios' AS tabla, fn.num_identificacion, fn.estado 
                            FROM funcionarios fn
                            WHERE num_identificacion = '$numero_documento_vg' AND fn.estado = 'ACTIVO'
                        UNION ALL
                            SELECT 'visitantes' AS tabla, vs.num_identificacion, vs.estado 
                            FROM visitantes vs 
                            WHERE num_identificacion = '$numero_documento_vg'
                            AND vs.estado = 'ACTIVO'
                        UNION ALL
                            SELECT 'vigilantes' AS tabla, vi.num_identificacion, vi.estado 
                            FROM vigilantes vi 
                            WHERE num_identificacion = '$numero_documento_vg';
                        ";
						$buscar_vigilante = $this->ejecutarConsulta($buscar_vigilante_query);
						if ($buscar_vigilante== 'conexion-fallida') {
                            $mensaje=[
                                "titulo"=>"Error de Conexion",
                                "mensaje"=>"Lo sentimos, algo salio mal con la conexion por favor intentalo de nuevo mas tarde.",
                                "icono"=> "error",
                                "tipoMensaje"=>"normal"
                            ];
                            return json_encode($mensaje);
                            exit();
                        }else {
                            if ($buscar_vigilante->num_rows < 1) {
                                if (!isset($tipodocumento_vg,$numero_documento_vg,$nombre_vg,$apellidos_vg,$correo_vg,$telefono_vg)) {
                                    $mensaje=[
                                        "titulo"=>"Error al registrar",
                                        "mensaje"=>"Lo sentimos, algo salio mal con el registro por favor intentalo de nuevo mas tarde, si el error persiste comunicate con un asesor.",
                                        "icono"=> "error",
                                        "tipoMensaje"=>"normal"
                                    ];
                                    return json_encode($mensaje);
                                    exit();

                                      // Manejo del caso en que el vigilante no existe en la base de datos                                  
                                }else{
									$fecha_hora_actual = date('Y-m-d H:i:s');
                                    $registrar_vigilantes_query = "INSERT INTO `vigilantes`( `tipo_documento`, `num_identificacion`, `nombres`, `apellidos`, `correo`, `telefono`, `estado`,`rol_usuario`,`permanencia`, `fecha_hora_registro`) VALUES ('$tipodocumento_vg','$numero_documento_vg','$nombre_vg','$apellidos_vg','$correo_vg','$telefono_vg','ACTIVO','$rol','FUERA','$fecha_hora_actual')";

                                    unset($tipodocumento_vg,$correo_vg,$telefono_vg);
                                    $registrar_vigilantes = $this->ejecutarConsulta($registrar_vigilantes_query);
									  // Manejo del caso de error en la inserción
                                    if (!$registrar_vigilantes) {
                                        $mensaje=[
                                            "titulo"=>"Error al registrar",
                                            "mensaje"=>"Lo sentimos, algo salio mal con el registro por favor intentalo de nuevo mas tarde, si el error persiste comunicate con un asesor.",
                                            "icono"=> "error",
                                            "tipoMensaje"=>"normal"
                                        ];
                                        return json_encode($mensaje);
                                        exit();
                                    }else {
                                        // información de vehículo
										if (!isset($tipo_vehiculo_vg,$placa_vehiculo_vg)) {
                                            $mensaje=[
                                                "titulo"=>"Visitante registrado",
                                                "mensaje"=>"Genial, el visitante ".$nombre_vg." ".$apellidos_vg." fue registrado con existo en nuetra base de datos.",
                                                "icono"=> "success",
                                                "tipoMensaje"=>"normal"
                                            ];
                
                                            return json_encode($mensaje);
                                            exit();
                                        }else {
                                            // registra el vehículo asociado al vigilante
                                            $vehiculo_persona = $this->registrarNuevoVehiculo($placa_vehiculo_vg,$tipo_vehiculo_vg,$numero_documento_vg, $_SESSION['datos_usuario']['num_identificacion']);
                                            if (!$vehiculo_persona) {// manejar las respuestas que nos da el metrodo de registrar el vehiculo
                                                $mensaje=[
                                                    "titulo"=>"Informacion",
                                                    "mensaje"=>"Genial, el visitante a sido registra pero el registro de el vehiculo no ha sido exitoso.",
                                                    "icono"=> "info",
                                                    "tipoMensaje"=>"normal"
                                                ];
                                                return json_encode($mensaje);
                                                exit();
                                            }else{
                                                $mensaje=[
                                                    "titulo"=>"Vigilante registrado",
                                                    "mensaje"=>"Genial, el visitante ".$nombre_vg." ".$apellidos_vg." fue registrado con existo en nuetra base de datos y esta autorizado para entrar con el vehiculo con placa ".$placa_vehiculo_vg.".",
                                                    "icono"=> "success",
                                                    "tipoMensaje"=>"normal"
                                                ];
                                                return json_encode($mensaje);
                                                exit();
											}
										}	
									}
								}
                                // Manejo del caso en que ya existe un vigilante con el mismo número de identificación
							}else {
                                $datos_repetidos = $buscar_vigilante->fetch_all();
                                 // Verifica si no esta en la tabla de 'vigilantes'
                                foreach ($datos_repetidos as $datos) {
                                    if ($datos[0] != 'vigilantes') {
                                        if ($datos[2] == 'ACTIVO' || $datos[2] == 'PERMANECE' ) {

                                            $userSinS = rtrim($datos[0], 's');

                                            $mensaje=[
                                                "titulo"=>"Informacion",
                                                "mensaje"=> $nombre_vg." con numero de documento ".$numero_documento_vg." ya se encuentra en nuestra base de datos como ".$userSinS.".",
                                                "icono"=> "info",
                                                "tipoMensaje"=>"normal"
                                            ];
                                            return json_encode($mensaje);
                                            exit();
                                        }else {
                                            $mensaje=[
                                                "titulo"=>"Pendiente",
                                                "mensaje"=> "Pendiente por programar",
                                                "icono"=> "info",
                                                "tipoMensaje"=>"normal"
                                            ];
                                            return json_encode($mensaje);
                                            exit();
                                        }
                                    }else {
                                        if ($datos[2] == 'ACTIVO' || $datos[2] == 'PERMANECE' ) {
                                            $mensaje=[
                                                "titulo"=>"Informacion",
                                                "mensaje"=>"El vigilante ".$nombre_vg."  ya se encuentra en nuestra base de datos como vigilante.",
                                                "icono"=> "info",
                                                "tipoMensaje"=>"normal"
                                            ];
                                            return json_encode($mensaje);
                                            exit();
                                        }elseif ($datos[2] == 'INACTIVO'){
                                            $mensaje=[
                                                "titulo"=>"Informacion",
                                                "mensaje"=>$nombre_vg." con numero de documento ".$numero_documento_vg." ya se encuentra en nuestra base de datos inactivo por algun motivo, si deseas cambiar su estado a activo debera hacerlo una persona autoriazada desde el apartado de vigilantes INACTIVOS.",
                                                "icono"=> "info",
                                                "tipoMensaje"=>"normal"
                                            ];
                                            return json_encode($mensaje);
                                            exit();
										}
									}
			
								}

							}
						}
                    }

		}
		
    }
	
		
	}
    public function cargo($cargo){
        switch ($cargo) {
            case 'JV':
                return "Vigilante jefe";
                break;
            
            case 'VR':
                return "Vigilante rico";
                break;

            case 'VN':
                return
                 "Vigilante normal";
                break;

            default:
                return "error";
                break;

        }
    }


    public function vehiculosVigilante($num_id){
            
        $num_identificacion = $this->limpiarDatos($num_id);

        $consultar_vehiculo_query = "SELECT * FROM `vehiculos_personas` WHERE num_identificacion_persona = '$num_identificacion';";
        $consultar_vehiculo = $this->ejecutarConsulta($consultar_vehiculo_query);
        unset($num_id,$num_identificacion,$consultar_vehiculo_query);
        if (!$consultar_vehiculo) {
            
            $titulo = 'Error de conexion';
            $descripcion = 'Lo sentimos, parece que ocurrio un error con la base de datos, al intentar listar los vehiculos asociados.';
            echo "<script>
                Swal.fire({
                    title: '$titulo',
                    text: '$descripcion',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if(result.isConfirmed){
                            window.location.href='http://localhost/Adso04/PROYECTOS/cerberus/lista-vigilantes/';
                    }
                });
            </script>";
            exit();
        }else {
            $tabla = '';
            if ($consultar_vehiculo->num_rows < 1) {
                $tabla.='
                    <tr>
                        <td colspan="5">Sin Vehiculos registrados</td>
                    </tr>
                ';
                
            }else {
                
                while ($datos = $consultar_vehiculo->fetch_object()) {
                    $tabla.='
                        <tr >
                            <td>'.$datos->num_identificacion_persona.'</td>
                            <td>'.TIPOS_VEHICULOS["$datos->tipo_vehiculo"].'</td>
                            <td>'.$datos->placa_vehiculo.'</td>
                            <td>'.$datos->permanencia.'</td>
                            <td>
                                <form class="FormularioAjax" action="'.APP_URL_BASE.'app/ajax/vehiculoAjax.php" method="POST" autocomplete="off" >

                                    <input type="hidden" name="modulo_cliente" value="eliminar">
                                    <input type="hidden" name="cliente_id" value="'.$datos->placa_vehiculo.'">

                                    <button color="red" type="submit" class="button is-danger is-rounded is-small">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    ';
                }
                $consultar_vehiculo->free();
                unset($consultar_vehiculo);
            }
            
            return $tabla;
        }
    }

    public function listarVigilanteControler(){
        header('Content-Type: application/json'); 

        $columnas = [
            'tipo_documento',
            'num_identificacion',
            'nombres',
            'apellidos',
            'correo',
            'telefono',
            'estado',
            'fecha_ultima_sesion',
            'permanencia'];

        $tabla = "vigilantes";
        $id = 'tipo_documento';
        
        $tipo_listado = $this->limpiarDatos($_POST['tipoListado']);
        unset($_POST['tipoListado']);
        
        $filtro = '';
        if (isset($_POST['filtro']) && $_POST['filtro'] !== '') {
            $filtro = $this->limpiarDatos($_POST['filtro']);
        }

        /* Filtro Like */
        $sentenciaCondicionada = '';

        if ($filtro != '' ) {
            $sentenciaCondicionada = "WHERE (";
            $contadorColumas = count($columnas);
            for ($i=0; $i < $contadorColumas; $i++) { 
                $sentenciaCondicionada .= $columnas[$i] . " LIKE '%".$filtro."%' OR ";
            }

            $sentenciaCondicionada = substr_replace($sentenciaCondicionada, "", -3);
            $sentenciaCondicionada .= ")";
        }
        /* Filtro Limit */
        $limit = 3;
        if (isset($_POST['registros']) && $_POST['registros'] !== '') {
            $limit = $this->limpiarDatos($_POST['registros']);
        }
        $pagina = 0;
        if (isset($_POST['pagina']) && $_POST['pagina'] !== '') {
            $pagina = $this->limpiarDatos($_POST['pagina']);
        }

        if (!$pagina) {
            $inicio = 0;
            $pagina = 1;
        }else {
            $inicio = ($pagina - 1) * $limit;
        }


        $sLimit = "LIMIT $inicio , $limit";

        $sentencia = "SELECT  SQL_CALC_FOUND_ROWS ". implode(', ', $columnas). " 
        FROM $tabla 
        $sentenciaCondicionada 
        $sLimit";
        $buscar_vigilantes = $this->ejecutarConsulta($sentencia);
        $numero_registros = $buscar_vigilantes->num_rows;

        /*  Consulta total registros*/

        $sentencia_filtro = "SELECT FOUND_ROWS()";
        $busqueda_filtro = $this->ejecutarConsulta($sentencia_filtro);
        $registros_filtro = $busqueda_filtro->fetch_array();
        $total_filtro = $registros_filtro[0];

        /*  Consulta total registros*/

        $sentencia_total = "SELECT count($id) FROM $tabla";
        $busqueda_total = $this->ejecutarConsulta($sentencia_total);
        $registros_total = $busqueda_total->fetch_array();
        $total_registros = $registros_total[0];




        $output = [];
        $output['total_registros'] = $total_registros;
        $output['total_filtro'] = $total_filtro;
        $output['data'] = '';
        $output['paginacion'] = '';
        if (!$buscar_vigilantes){
            $output['data'] = $tipo_listado == 'tabla' 
            ? '
                            <table class="table">
                                <thead class="head-table">
                                    <tr>
                                        <th>Tipo de Documento</th>
                                        <th>Número de Identificación</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                        <th>Fecha y Hora Última sesion</th>
                                        <th>Permanencia</th>
                                    </tr>
                                </thead>
                                <tbody class="body-table" id="listado_vigilantes">
                                <tr><td colspan="9">Error al cargar los Vigilantes</td></tr>
                                </tbody>
                                </table>' 
            : '
            <div class="document-card">
                <div class="card-header">
                    <div>
                        <p class="document-title">Error en el listado</p>
                        <p class="document-meta">Error al listar los reportes</p>
                    </div>
                    <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                </div>
            </div>';
        } else{
            if ($buscar_vigilantes->num_rows < 1) {
                $output['data'] = $tipo_listado == 'tabla' 
                ? '
                                <table class="table">
                                    <thead class="head-table">
                                        <tr>
                                            <th>Tipo de Documento</th>
                                            <th>Número de Identificación</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Fecha y Hora Última sesion</th>
                                            <th>Permanencia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-table" id="listado_vigilantes">
                                    <tr><td colspan="9">No se encontraron Vigilantes</td></tr>
                                    </tbody>
                                    </table>'
                :'
                <div class="document-card">
                    <div class="card-header">
                        <div>
                            <p class="document-meta">No se encontro Vigilantes</p>
                        </div>
                    </div>
                </div>';
            } else{
                if ($tipo_listado == 'tabla') {
                    $output['data'] = '
                                <table class="table">
                                    <thead class="head-table">
                                        <tr>
                                            <th>Tipo de Documento</th>
                                            <th>Número de Identificación</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Fecha y Hora Última sesion</th>
                                            <th>Permanencia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-table" id="listado_vigilantes">
                                ';

                    while ($datos = $buscar_vigilantes->fetch_object()) {
                        $output['data'].='
                            <tr >
                                <td>'.$datos->tipo_documento.'</td>
                                <td>'.$datos->num_identificacion.'</td>
                                <td>'.$datos->nombres.'</td>
                                <td>'.$datos->apellidos.'</td>
                                <td>'.$datos->correo.'</td>
                                <td>'.$datos->telefono.'</td>
                                <td>'.$datos->fecha_ultima_sesion.'</td>
                                <td>'.$datos->permanencia.'</td>
                            </tr>
                        ';
                    }
                    $output['data'] .= '</tbody></table>';
                }elseif ($tipo_listado == 'card') {
                    
                    while ($datos = $buscar_vigilantes->fetch_object()) {
                        $output['data'].= '
                            <div class="document-card" onclick="toggleCard(this)">
                                <div class="card-header">
                                    <div>
                                        <p class="document-title">'.$datos->nombres.' '.$datos->apellidos.'</p>
                                        <p class="document-meta">'.$datos->tipo_documento.': '.$datos->num_identificacion. ' | ' .$datos->permanencia.'</p>
                                    </div>
                                    <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                                </div>
                                <div class="card-details">
                                    <p><strong>Fecha y Hora Ultima sesion: </strong>'.$datos->fecha_ultima_sesion.'</p>
                                    <p><strong>Correo:</strong>'.$datos->correo.'</p>
                                    <p><strong>Telefono:</strong>'.$datos->telefono.'</p>
                                </div>
                            </div>';
                    }
                }
            }
            if ($output['total_registros'] > 0) {
                $total_paginas = ceil($output['total_registros'] / $limit);
                $output['paginacion'] .= '<nav>';
                $output['paginacion'] .= '<ul>';

                for ($i=1; $i <= $total_paginas ; $i++) { 
                    $output['paginacion'] .= '<li>
                                                <a href="#" onclick="getData('.$i.')">'.$i.'</a>
                                            </li>';
                }
                
                $output['paginacion'] .= '</ul>';
                $output['paginacion'] .= '</nav>';
            }
        }
        return json_encode($output, JSON_UNESCAPED_UNICODE);
    }

            // public function listarVigilanteControler(){

            //     $filtro = isset($_POST['filtro']) ? trim($_POST['filtro']) : null;
            //     $select = isset($_POST['select']) ? $_POST['select'] : "num_identificacion";
            //     $filtro_permanencia = isset($_POST['filtro_permanencia']) ?$_POST['filtro_permanencia'] :null;
            //     $where="";
            //     $html="";

            //     if ($filtro != null) {
            //         if ($select=="nombres") {
            //             $where = "WHERE (  nombres LIKE '%".$filtro."%' OR apellidos LIKE '%".$filtro."%')";
            //         }else{
            //             $where = "WHERE ( ".$select." LIKE '%".$filtro."%')";
            //         }
                    
            //     }

            //     if ($filtro_permanencia !=null ) {
            //         if ($where=="") {
            //             $where = "WHERE permanencia = '".$filtro_permanencia."'";
            //         } else {
            //             $where .= "AND (permanencia = '".$filtro_permanencia."')";
            //         }
            //     }

            //     $sentencia="SELECT `num_identificacion`, `tipo_documento`, `nombres`, `apellidos`, `correo`, `telefono`, `rol_usuario`, `permanencia` , `fecha_hora_ultimo_ingreso`  FROM `vigilantes` ".$where;
                


            //     $buscar_vigilantes = $this->ejecutarConsulta($sentencia);


            //     if ($buscar_vigilantes === false) {
            //         $html.='<tr>';
            //         $html.='<td colspan="9">Conexion fallida. Intentelo mas tarde</td>';
            //         $html.='</tr>';
            //         return json_encode($html, JSON_UNESCAPED_UNICODE);
        
            //     } elseif ($buscar_vigilantes->num_rows!=0) {
            //         while ($row = $buscar_vigilantes->fetch_assoc()) {
            //             $html.='<tr>';
            //             $html.='<td class="tipo_documento">'.$row['tipo_documento'].'</td>';
            //             $html.='<td class="num_identificacion">'.$row['num_identificacion'].'</td>';
            //             $html.='<td class="nombres">'.$row['nombres'].'</td>';
            //             $html.='<td class="apellidos">'.$row['apellidos'].'</td>';
            //             $html.='<td class="correo">'.$row['correo'].'</td>';
            //             $html.='<td class="telefono">'.$row['telefono'].'</td>';                       
            //             $html.='<td class="rol_usuario">'.$this->cargo($row['rol_usuario']).'</td>';
            //             $html.='<td class="permanencia">'.$row['permanencia'].'</td>';
            //             $html.='<td class="fecha_hora_ultimo_ingreso">'.$row['fecha_hora_ultimo_ingreso'].'</td>';
            //             $html.='</tr>';
            //             if (($_SESSION['datos_usuario']['rol_usuario']!='SB' || ['rol_usuario']!='CO') && ($row['rol_usuario']=='JV')) {

            //             } else{
            //                 $html.="<td><form method='POST' class='formulario-fetch' action='" . APP_URL_BASE . "app/ajax/vigilanteAjax.php'>";
            //                 $html.="<input type='hidden' name='modulo_vigilante' value='editar'>";
            //                 $html.="<input type='hidden' name='id_vigilante' value='" . htmlspecialchars($row['num_identificacion']) . "'>";
            //                 $html.="<button type='submit'>Editar</button>";
            //                 $html.='</form></td>';
            //                 $html.='</tr>';
            //             }

            //         }
                    
            //     }else{
            //         $html.='<tr>';
            //         $html.='<td colspan="9">No se encontraron resultados</td>';
            //         $html.='</tr>';
            //     }
            //     return json_encode($html, JSON_UNESCAPED_UNICODE);



            // }
            public function obtenerVigilanteController($numero_documento_vg) {

                $num_identificacion = $this->limpiarDatos($numero_documento_vg);
    
                $consulta_vigilante_sql = "SELECT * FROM vigilantes WHERE num_identificacion = '$num_identificacion';";
                $consulta_vigilante = $this->ejecutarConsulta($consulta_vigilante_sql);
                unset($numero_documento_vg, $num_identificacion, $consulta_vigilante_sql);
    
                if (!$consulta_vigilante) {
                    
                    $mensaje=[
                        "titulo"=>"Error de la conexion",
                        "mensaje"=>"Lo sentimos, ocurrio un error con la base de datos, Intentalo de nuevo mas tarde",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                    exit();
    
                } else {
    
                    if ($consulta_vigilante->num_rows < 1) {
                        
                        $mensaje=[
                            "titulo"=>"Error de la conexion",
                            "mensaje"=>"Lo sentimos, el funcionaro que intentaste editar no existe en la base de datos",
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        return json_encode($mensaje);
                        exit();
    
                    } else {
    
                        $vigilante = $consulta_vigilante->fetch_assoc();
                        $consulta_vigilante->free();
                        unset($consulta_vigilante);
                        return $vigilante;
                    }
                }
            }

            public function editarVigilanteController() {

                if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                    $mensaje = [
                        "titulo" => "Error",
                        "mensaje" => "Solicitud denegada, Intente de nuevo mas tarde.",
                        "icono" => "error",
                        "tipoMensaje" => "normal"
                    ];
                    return json_encode($mensaje);
    
                } else {
    
                    if(!isset( $_POST['num_identificacion'],
                        $_POST['nombres'],
                        $_POST['apellidos'],
                        $_POST['telefono'],
                        $_POST['correo'],
                        $_POST['rol_usuario'],
                        $_POST['credencial'])
                        ||
                        $_POST['num_identificacion'] == "" ||
                        $_POST['nombres'] == "" ||
                        $_POST['apellidos'] == "" ||
                        $_POST['telefono'] == "" ||
                        $_POST['correo'] == "" ||
                        $_POST['credencial'] == "" ||
                        $_POST['rol_usuario'] == "" ){
                          
                            $mensaje=[
                                "titulo"=>"Error",
                                "mensaje"=>"Lo sentimos, a ocurrido un error con alguno de los datos, intentalo de nuevo mas tarde.",
                                "icono"=> "error",
                                "tipoMensaje"=>"normal"
                            ];
                            return json_encode($mensaje);
                            exit();
                            
                     }else{

                            $numero_documento = $this->limpiarDatos( $_POST['num_identificacion']);
                            $nombre = $this->limpiarDatos( $_POST['nombres']);
                            $apellido = $this->limpiarDatos( $_POST['apellidos']);
                            $telefono = $this->limpiarDatos( $_POST['telefono']);
                            $email = $this->limpiarDatos( $_POST['correo']);                          
                            $rol = $this->limpiarDatos( $_POST['rol_usuario']);
                            $credencial = $this->limpiarDatos( $_POST['credencial']);
                            if ($_POST['credencial']!="") {
                                $credencial = $this->limpiarDatos($_POST['credencial']);  
                                if ($this->verificarDatos('[0-9a-zA-Z]{6,16}', $credencial)) {
                                    $mensaje = [
                                        "titulo" => "Error",
                                        "mensaje" => "Credenciales ingresadas No Validas",
                                        "icono" => "error",
                                        "tipoMensaje" => "normal"
                                    ];
                                    return json_encode($mensaje);
                                }
                            }


                        // verificamos los datos del formulario sea lo que se esta solicitando
                        if ($this->verificarDatos('[A-Za-z ]{2,64}', $nombre)) {
                            $mensaje = [
                                "titulo" => "Error",
                                "mensaje" => "Datos Ingresados No Validos",
                                "icono" => "error",
                                "tipoMensaje" => "normal5"
                            ];
                            return json_encode($mensaje);
                        }
                        if ($this->verificarDatos('[a-zA-Z\ s]{2,64}', $apellido)) {
                            $mensaje = [
                                "titulo" => "Error",
                                "mensaje" => "Datos Ingresados No Validos",
                                "icono" => "error",
                                "tipoMensaje" => "normal4"
                            ];
                            return json_encode($mensaje);
                        }
                        if ($this->verificarDatos('[0-9]{6,13}',$numero_documento)) {
                            $mensaje = [
                                "titulo" => "Error",
                                "mensaje" => "Numero de documento No Valido",
                                "icono" => "error",
                                "tipoMensaje" => "normal"
                            ];
                            return json_encode($mensaje);
                        } 
                      
                        if ($this->verificarDatos('[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}',$email)) {
                            $mensaje = [
                                "titulo" => "Error",
                                "mensaje" => "Datos Ingresados No Validos",
                                "icono" => "error",
                                "tipoMensaje" => "normal2"
                            ];
                            return json_encode($mensaje);
                            
                        }
                        if ($this->verificarDatos('\+?[0-9]{10,14}', $telefono)) {
                            $mensaje = [
                                "titulo" => "Error",
                                "mensaje" => "Datos Ingresados No Validos",
                                "icono" => "error",
                                "tipoMensaje" => "normal1"
                            ];
                            return json_encode($mensaje);
                        }
    
                        // aqui llevamos a cabo la actualizacion de lo datos del vigilante seleccionado
                        if (isset($credencial)) {
                            $consulta_actualizar_sql = "UPDATE vigilantes SET nombres = '".$nombre."', apellidos = '".$apellido."', credencial = MD5('".$credencial."'), correo = '".$email."', telefono = '".$telefono."', rol_usuario = '".$rol."' WHERE num_identificacion = '".$numero_documento."'";
                        }
                        else{
                            $consulta_actualizar_sql = "UPDATE vigilantes SET nombres = '".$nombre."', apellidos = '".$apellido."', correo = '".$email."', telefono = '".$telefono."', rol_usuario = '".$rol."' WHERE num_identificacion = '".$numero_documento."'";
                        }
                      
                        $consulta_actualizar_vigilante = $this->ejecutarInsert($consulta_actualizar_sql);
                        if ($consulta_actualizar_vigilante != 1) {
                            $mensaje = [
                                "titulo" => "error",
                                "mensaje" => "Ha ocurrido un error a la hora de actualizar el vigilante",
                                "icono" => "error",
                                "tipoMensaje" => "normal"
                            ];
                            return json_encode($mensaje);
                        }else {
                            $mensaje = [
                                "titulo" => "vigilante Actualizado",
                                "mensaje" => "El vigilante se actualizo correctamente en la base de datos.",
                                "icono" => "success",
                                "tipoMensaje" => "normal"
                            ];
                            return json_encode($mensaje);
                        }
    
                    }
                }
            }
    











   		 
}

    