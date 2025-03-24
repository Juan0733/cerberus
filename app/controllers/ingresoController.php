<?php

    namespace app\controllers;
    use app\models\mainModel;
    class IngresoController extends mainModel{
        
        function ingresoPeatonalControler($tipo,$fecha_suceso = "",$agenda_parametro=""){
            
            if ($tipo=="ENTRADA") {
                $estado="DENTRO";
                $contraestado="FUERA";
            } elseif ($tipo=="SALIDA") {
                $estado="FUERA";
                $contraestado="DENTRO";
            }
            if (!isset($_POST['num_identificacion']) ||
            $_POST['num_identificacion'] == "" ||
            $this->verificarDatos('[0-9 ]{6,15}',$_POST['num_identificacion'])
            ) {
                $mensaje=[
                    "titulo"=>"Error",
                    "mensaje"=>"Lo sentimos, a ocurrido un error con el numero de documento, intentalo de nuevo mas tarde.",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                return json_encode($mensaje);
            }
            else if ((isset($_POST['observaciones']) && $_POST['observaciones'] != "") &&
            (strlen($_POST['observaciones'])>255 ||
            strlen($_POST['observaciones'])<3) ) {
                $mensaje=[
                    "titulo"=>"Error",
                    "mensaje"=>"Lo sentimos, a ocurrido un error con la observacion, intentalo de nuevo mas tarde.",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                return json_encode($mensaje);
            }else{
                /* almacenamos el numero de docuemnto y obserrvacion en variables */
                
                $num_identificacion=trim($_POST['num_identificacion']);
                $observaciones = strtolower(trim($_POST['observaciones']));
                unset($_POST['num_identificacion'],$_POST['observaciones']);
                $permanencia=$this->consultarDatosUsuario($num_identificacion,["permanencia","id_ultimo_reporte"]);
                if ($permanencia[0]=="no_encontrado") {
                    $mensaje=[
                      "titulo"=>"Usuario No Registrado.<br> Lo sentimos",
                      "mensaje"=>"El usuario con número de documento $num_identificacion no se encuentra registrado en Cerberus.  ¿Deseas Registrarlo como VISITANTE?",
                      "icono"=> "info",
                      "tituloModal"=>"Registro Visitante",
                      "adaptar"=>"none",
                      "url"=> APP_URL_BASE."app/views/inc/modales/modal-registro-visitante.php",
                      "tipoMensaje"=>"normal_redireccion"
                    ];
                    unset($num_identificacion,$tipo,$estado,$permanencia);
                    return json_encode($mensaje);
                }else if ($permanencia[0]=="error_conexion") {
                    $mensaje=[
                        "titulo"=>"Error de Conexion",
                        "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                }else if ($permanencia[2]["permanencia"]==$estado) {
                    $mensaje=[
                        "titulo"=>"Error de Permanencia",
                        "mensaje"=>"El usuario con numero de documento $num_identificacion ya se encuentra $estado del SENA, ¿Desea registrar una NOVEDAD?",
                        "tituloModal"=>"Registro Novedad",
                        "icono"=> "error",
                        "adaptar"=> ["novedades",strtolower($tipo),$num_identificacion],
                        "url"=> APP_URL_BASE."app/views/inc/modales/modal-registro-novedad.php",
                        "tipoMensaje"=>"normal_redireccion"
                    ];
                    unset($num_identificacion,$tipo,$estado,$permanencia);
                    return json_encode($mensaje);
                }else if ($permanencia[2]["permanencia"]==$contraestado) {
                    $tabla=$permanencia[0];
                    $fecha_actual_time = time();
                    $fecha_actual = date('Y-m-d H:i:s',$fecha_actual_time);
                    if ($fecha_suceso != "") {
                        $fecha_actual = $fecha_suceso;
                    }
                    $id_reporte = "RP" . date('ymdHis', $fecha_actual_time);
                    $sentencia_update_permanencia="UPDATE $tabla SET permanencia='$estado',fecha_hora_ultimo_ingreso='$fecha_actual', id_ultimo_reporte='$id_reporte', forma_de_ingreso='PE' WHERE num_identificacion = '$num_identificacion'";
                    $permanencia_update = $this->ejecutarInsert($sentencia_update_permanencia);
                    unset($sentencia_update_permanencia,$fecha_actual_time,$tabla);
                    if ($permanencia_update != 1) {
                        $mensaje=[
                            "titulo"=>"Error de Conexion",
                            "mensaje"=>"Lo sentimos, parece que ha ocurrido un error al intentar cambiar la permanencia del usuario. Intentelo mas tarde",
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        return json_encode($mensaje);
                    } else {
                        unset($permanencia_update);
                        $rol_usuario=$permanencia[1];
                        $usuario_registro=$_SESSION['datos_usuario']['num_identificacion'];
                        if ($tipo=="ENTRADA") {
                            $sentencia_reporte ="INSERT INTO reporte_entrada_salida( tipo_reporte, num_identificacion_persona, fecha_hora_reporte, usuario_de_reporte, observacion,rol_usuario,id_reporte,id_reporte_relacion) VALUES ('$tipo','$num_identificacion','$fecha_actual','$usuario_registro','$observaciones','$rol_usuario','$id_reporte','')";
                        } else if ($tipo=="SALIDA") {
                            $id_reporte_relacion=$permanencia[2]["id_ultimo_reporte"];
                            $sentencia_reporte ="INSERT INTO reporte_entrada_salida( tipo_reporte, num_identificacion_persona, fecha_hora_reporte, usuario_de_reporte, observacion,rol_usuario,id_reporte,id_reporte_relacion) VALUES ('$tipo','$num_identificacion','$fecha_actual','$usuario_registro','$observaciones','$rol_usuario','$id_reporte','$id_reporte_relacion')";
                            if ($id_reporte_relacion[1]=="P") {
                                $tabla= "reporte_entrada_salida";
                            }else if($id_reporte_relacion[1]=="V") {
                                $tabla= "reporte_entrada_salida_vehicular";
                            }
                            $sentencia_update_reporte="UPDATE $tabla SET id_reporte_relacion='$id_reporte' WHERE id_reporte = '$id_reporte_relacion' AND num_identificacion_persona='$num_identificacion'";
                            $registro_update = $this->ejecutarInsert($sentencia_update_reporte);
                            unset($id_reporte_relacion,$sentencia_update_reporte,$tabla);
                        } 
                        $registro_insert = $this->ejecutarInsert($sentencia_reporte);
                        unset($usuario_registro,$sentencia_reporte,$rol_usuario,$fecha_actual,$observaciones,$permanencia,$id_reporte);
                        if ($registro_insert != 1 ||(isset($registro_update)&& $registro_update != 1)) {
                            
                            $mensaje=[
                                "titulo"=>"Error de Conexion",
                                "mensaje"=>"Lo sentimos, parece que ha ocurrido un error al intentar realizar el reporte de $estado. El usuario se encuentra $estado. ",
                                "icono"=> "error",
                                "tipoMensaje"=>"normal"
                            ];
                            unset($registro_insert,$registro_update);
                            return json_encode($mensaje);
                        } else {
                            unset($registro_insert,$registro_update);
                            if ($tipo == "ENTRADA" && $agenda_parametro!="no_agenda") {
                                $fecha_actual = new \DateTime();
                                $fecha_actual->modify('-2 hours');
                                $fecha_hora_dos_horas_atras = $fecha_actual->format('Y-m-d H:i:s');
                                $agendas_salida=$tipo == "SALIDA"? "INACTIVO": "ACTIVO" ;
                                $sentencia_agendas = "SELECT contador_agendas, titulo_agenda, descripcion_agenda, fecha_hora_agenda, placa_vehiculo, tipo_vehiculo, num_documento_persona FROM agendas WHERE DATE(fecha_hora_agenda) = CURDATE() AND fecha_hora_agenda >= '$fecha_hora_dos_horas_atras' AND estado_agenda = '$agendas_salida';";
                                $agendas = $this->ejecutarConsulta($sentencia_agendas);
                                unset($sentencia_agendas,$agendas_salida);
                            
                                if ($agendas === false) {
                                    
                                    $mensaje = [
                                        "titulo" => "Error de Conexion",
                                        "mensaje" => "Lo sentimos, parece que ha ocurrido un error al intentar revisar el registro de agendas. El usuario se encuentra $estado.",
                                        "icono" => "info",
                                        "tipoMensaje" => "normal"
                                    ];
                                    unset($agendas);
                                    return json_encode($mensaje);
                                } elseif ($agendas->num_rows!=0) {
                                    $registro_string = "";
                                    $registro_encontrado = false;
                                    while ($fila = $agendas->fetch_assoc()) {
                                        if ($fila['num_documento_persona'] == $num_identificacion) {
                                            $registro_encontrado = true;
                                            $registro_string .= "AGENDA - ".$fila['titulo_agenda'] . "\n"." HORA - ".date("h:i A", strtotime($fila['fecha_hora_agenda'])) . "\n"."observaciones - ".$fila['descripcion_agenda']." || ";
                                            $contador = $fila['contador_agendas'];
                                            $update_salida= $tipo == "SALIDA"? "CONCLUIDA":"INACTIVO";
                                            $sentencia_actualiza_agenda = "UPDATE agendas SET estado_agenda = '$update_salida' WHERE contador_agendas = '$contador';";
                                            $agenda_insert = $this->ejecutarInsert($sentencia_actualiza_agenda);
                                            unset($sentencia_actualiza_agenda, $contador,$update_salida);
                                
                                            if ($agenda_insert != 1) {
                                                $mensaje = [
                                                    "titulo" => "Error de Conexion",
                                                    "mensaje" => "Lo sentimos, parece que ha ocurrido un error al intentar realizar la actualización de la agenda. El usuario se encuentra $estado.",
                                                    "icono" => "error",
                                                    "tipoMensaje" => "normal"
                                                ];
                                                unset($agenda_insert);
                                                return json_encode($mensaje);
                                            }
                                        } else {
                                            $update_salida= $tipo == "SALIDA"? "CONCLUIDA":"INACTIVO";
                                            $sentencia_agendas_persona = "SELECT id_agenda_grupal, id_agenda FROM agenda_personas WHERE num_identificacion_persona = '$num_identificacion' AND estado_agenda = '$tipo'";
                                            $agendas_persona = $this->ejecutarConsulta($sentencia_agendas_persona);
                                            if ($agendas === false) {
                                                $mensaje = [
                                                    "titulo" => "Error de Conexion",
                                                    "mensaje" => "Lo sentimos, parece que ha ocurrido un error al intentar revisar el registro de agendas. El usuario se encuentra $estado. $agendas ",
                                                    "icono" => "info",
                                                    "tipoMensaje" => "normal"
                                                ];
                                                unset($agendas);
                                                return json_encode($mensaje);
                                            }elseif ($agendas_persona->num_rows!=0) {
                                                $registro_encontrado = true;
                                                while ($fila_persona = $agendas_persona->fetch_assoc()) {
                                                    $registro_string .= "AGENDA - ".$fila['titulo_agenda'] . "\n"." HORA - ".date("h:i A", strtotime($fila['fecha_hora_agenda'])) . "\n"."observaciones - ".$fila['descripcion_agenda']." || ";
                                                    $contador = $fila_persona['id_agenda'];
                                                    $update_salida= $tipo == "SALIDA"? "CONCLUIDA":"INACTIVO";
                                                    $sentencia_actualiza_agenda = "UPDATE agenda_personas SET estado_agenda= '$update_salida' WHERE id_agenda='$contador'";
                                                    $agenda_insert = $this->ejecutarInsert($sentencia_actualiza_agenda);
                                                    unset($sentencia_actualiza_agenda, $contador,$update_salida);
                                                    if ($agenda_insert != 1) {
                                                        $mensaje = [
                                                            "titulo" => "Error de Conexion",
                                                            "mensaje" => "Lo sentimos, parece que ha ocurrido un error al intentar realizar la actualización de la agenda. El usuario se encuentra $estado.",
                                                            "icono" => "error",
                                                            "tipoMensaje" => "normal"
                                                        ];
                                                        unset($agenda_insert);
                                                        return json_encode($mensaje);
                                                    }   
                                                }
                                            }
                                        }
                                    } if ($registro_encontrado===true) {
                                        $mensaje=[
                                            "titulo"=>"Excelente!",
                                            "mensaje"=>"Se ha registrado el ingreso de un usuario con exito. $registro_string ",
                                            "icono"=> "success",
                                            "tipo"=> "$tipo",
                                            "tipoMensaje"=>"normal"
                                        ];
                                        unset($registro_insert,$registro_update,$resultado,$tipo);
                                        return json_encode($mensaje);
                                    }
                                }
                                
                            }
                            
                            $resultado= $tipo == 'ENTRADA'?'el ingreso':'la salida';
                            $mensaje=[
                                "titulo"=>"Excelente!",
                                "mensaje"=>"Se ha registrado ".$resultado." de un usuario con exito. ",
                                "icono"=> "success",
                                "tipo"=> "$tipo",
                                "tipoMensaje"=>"normal_temporizada"
                            ];
                            unset($registro_insert,$registro_update,$resultado,$tipo);
                            return json_encode($mensaje);
                            
                            
                        }
                        
                    }
                    
                }
                
            }
        }
        

        function novedadesPersona($tipo){
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                $mensaje=[
                    "titulo"=>"Peticion Incorrecta",
                    "mensaje"=>"Lo sentimos, la accion que intentas realizar no es correcta",
                    "icono"=> "error",
                    "tipoMensaje"=>"redireccionar",
                    "url"=>"https://arcano.digital/cerberus_b/"
                ];
                return json_encode($mensaje);
            }else{
                
                if (!isset($_POST['num_documento_causante']) ||
                $_POST['num_documento_causante'] == "" ||
                $this->verificarDatos('[0-9 ]{6,15}',$_POST['num_documento_causante'])
                ) {
                    $mensaje=[
                        "titulo"=>"Error",
                        "mensaje"=>"Lo sentimos, a ocurrido un error con el numero de documento, intentalo de nuevo mas tarde.",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                } else if ((isset($_POST['observaciones']) && $_POST['observaciones'] != "") &&
                (strlen($_POST['observaciones'])>255 ||
                strlen($_POST['observaciones'])<3) ) {
                    $mensaje=[
                        "titulo"=>"Error",
                        "mensaje"=>"Lo sentimos, a ocurrido un error con la observacion, intentalo de nuevo mas tarde.",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                } else if ((isset($_POST['placa_vehiculo']) && $_POST['placa_vehiculo'] != "") &&
                ($this->verificarDatos('[A-Z0-9]{6}',$_POST['placa_vehiculo'])) ) {
                    $mensaje=[
                        "titulo"=>"Error",
                        "mensaje"=>"Lo sentimos, a ocurrido un error con la placa, intentalo de nuevo mas tarde.",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                }
                $now = new \DateTime();
                $fecha_minima = new \DateTime();
                $fecha_minima->modify('-3 weeks');

                $fecha_actual = $now->format('Y-m-d\TH:i');
                $fecha_minima_format = $fecha_minima->format('Y-m-d\TH:i');
                unset($fecha_minima,$now);
                if (!isset($_POST['fecha_suceso']) || trim($_POST['fecha_suceso']) === "") {
                    unset($fecha_actual,$fecha_minima_format);
                    $mensaje = [
                        "titulo" => "Error",
                        "mensaje" => "Lo sentimos, la fecha de suceso es obligatoria.",
                        "icono" => "error",
                        "tipoMensaje" => "normal"
                    ];
                    return json_encode($mensaje);
                }
                
                if ( $_POST['fecha_suceso'] < $fecha_minima_format ||  $_POST['fecha_suceso'] > $fecha_actual) {
                    $mensaje = [
                        "titulo" => "Error",
                        "mensaje" => "Lo sentimos, la fecha debe estar entre $fecha_minima_format y $fecha_actual.",
                        "icono" => "error",
                        "tipoMensaje" => "normal"
                    ];
                    unset($fecha_actual,$fecha_minima_format);
                    return json_encode($mensaje);
                }
                unset($fecha_minima_format);
                if (!isset($_POST['puerta_de_suceso']) ||
                $_POST['puerta_de_suceso'] == "" ||
                $this->verificarDatos('[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{2,64}',$_POST['puerta_de_suceso'])
                ) {
                    $mensaje=[
                        "titulo"=>"Error",
                        "mensaje"=>"Lo sentimos, a ocurrido un error con la puerta del suceso, intentalo de nuevo mas tarde.",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                }
                if ($tipo=="ENTRADA") {
                    $estado="DENTRO";
                    $contraestado="FUERA";
                    $contratipo="SALIDA";
                } elseif ($tipo=="SALIDA") {
                    $estado="FUERA";
                    $contraestado="DENTRO";
                    $contratipo="ENTRADA";
                }
                $num_identificacion = trim($_POST['num_documento_causante']);
                $puerta = strtolower(trim($_POST['puerta_de_suceso']));
                $fecha_suceso = (new \DateTime($_POST['fecha_suceso']))->format('Y-m-d H:i:s');
                $placa = $_POST['placa_vehiculo']!=""? strtoupper($_POST['placa_vehiculo']):"";
                $observaciones = $_POST['observaciones']!=""? strtolower(trim($_POST['observaciones'])):"";
                unset($_POST['num_documento_causante'],$_POST['puerta_de_suceso'],$_POST['fecha_suceso'],$_POST['placa_vehiculo'],$_POST['observaciones']);
                $fecha_actual_time = time();
                $fecha_actual = date('Y-m-d H:i:s',$fecha_actual_time);
                if ($placa != "") {
                    $puerta_ingreso="VEHICULAR";
                    $errores_pasajeros= $this->actualizarPermanenciaPasajero($num_identificacion,$placa,"PROPIETARIO",$observaciones,$contratipo,$fecha_suceso);
                    if ($errores_pasajeros[0]!="bien"){
                        $mensaje=[
                            "titulo"=>"Error al Registrar",
                            "mensaje"=>"Ha ocurrido un: ".$errores_pasajeros[0]." con el usuario: ".$errores_pasajeros[1],
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        unset($errores_pasajeros);
                        return json_encode($mensaje);
                    }
                    $sentencia_permanencia_vehiculo = "SELECT `permanencia`, `fecha_hora_ultimo_ingreso` FROM `vehiculos_personas` WHERE `num_identificacion_persona` = '$num_identificacion' AND `placa_vehiculo` = '$placa'";
                    $buscar_vehiculo = $this->ejecutarConsulta($sentencia_permanencia_vehiculo);
                    unset($sentencia_permanencia_vehiculo);

                    if ($buscar_vehiculo === false) {
                        $mensaje=[
                            "titulo"=>"Error al Buscar Vehiculo",
                            "mensaje"=>"Ha ocurrido un error al buscar el vehiculo del usuario",
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        unset($errores_pasajeros);
                        return json_encode($mensaje);
                    } elseif ($buscar_vehiculo->num_rows==0) {
                        $mensaje=[
                            "titulo"=>"Error de Propiedad de Vehiculo",
                            "mensaje"=>"No se ha encontrado el vehiculo $placa del usuario con numero de documento $num_identificacion",
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        unset($errores_pasajeros);
                        return json_encode($mensaje);
                    }else{
                        $datos=$buscar_vehiculo->fetch_assoc();
                        if ($datos['permanencia'] != $estado) {
                            $mensaje=[
                                "titulo"=>"Error de Permanencia de Vehiculo",
                                "mensaje"=>"el vehiculo $placa se encuentra ".$datos['permanencia'],
                                "icono"=> "error",
                                "tipoMensaje"=>"normal"
                            ];
                            unset($errores_pasajeros);
                            return json_encode($mensaje);
                        }elseif($datos['fecha_hora_ultimo_ingreso']< $fecha_suceso){
                            $sentencia_update_vehiculo = "UPDATE `vehiculos_personas` SET `fecha_hora_ultimo_ingreso`='$fecha_suceso',`permanencia`='$contraestado' WHERE `num_identificacion_persona` = $num_identificacion AND `placa_vehiculo` = $placa";
                            $insert_permanencia_vehiculo = $this->ejecutarInsert($sentencia_update_vehiculo);
                            unset($sentencia_update_vehiculo);
                            if ($insert_permanencia_vehiculo != 1) {
                                $mensaje=[
                                    "titulo"=>"Error",
                                    "mensaje"=>"Ha ocurrido un error al registrar la permanencia del vehiculo, intentalo mas tarde.",
                                    "icono"=> "error",
                                    "tipoMensaje"=>"normal"
                                ];
                                unset($errores_pasajeros);
                                return json_encode($mensaje);
                            }
                        }else{
                            $permanencia_vehiculo_no=$datos['fecha_hora_ultimo_ingreso'];
                        }
                    }
                }else{
                    $puerta_ingreso="PEATONAL";
                    $_POST['num_identificacion'] = $num_identificacion;
                    $_POST['observaciones'] = $observaciones;
                    $resultado=$this->ingresoPeatonalControler($contratipo,$fecha_suceso,"no_agenda");
                    $respuesta = json_decode($resultado, true);
                    if ($respuesta['titulo'] != "Excelente!") {
                        $mensaje=[
                            "titulo"=>"Error al Registrar Novedad",
                            "mensaje"=>"Ha ocurrido un error al registrar la novedad, intentalo mas tarde",
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        return json_encode($respuesta);
                    }

                } 
                $consultar_datos=$this->consultarDatosUsuario($num_identificacion,["id_ultimo_reporte"]);
                $consultar_datos=$consultar_datos[2]["id_ultimo_reporte"];
                
                $usuario_registro=$_SESSION['datos_usuario']['num_identificacion'];

                $sentencia_novedad = "INSERT INTO novedades_e_s(fecha_hora_novedad, descripcion_agenda, usuario_registro_novedad, puerta_de_novedad, tipo_novedad, num_identificacion_causante, id_reporte_ingreso_salida, puerta_registro_novedad, fecha_de_suceso) VALUES ('$fecha_actual','$observaciones','$usuario_registro','$puerta','$tipo','$num_identificacion','$consultar_datos','$puerta_ingreso','$fecha_suceso')";
                $novedades_insert = $this->ejecutarInsert($sentencia_novedad);
                unset($sentencia_novedad,$consultar_datos,$fecha_actual_time,$fecha_actual,$usuario_registro,$observaciones,$puerta,$num_identificacion,$consultar_datos,$puerta_ingreso,$fecha_suceso);
                if ($novedades_insert != 1) {
                    $mensaje = [
                        "titulo" => "Error de Conexion",
                        "mensaje" => "Lo sentimos, parece que ha ocurrido un error al intentar realizar el reporte de novedad. El usuario se encuentra $estado.",
                        "icono" => "error",
                        "tipoMensaje" => "normal"
                    ];
                    unset($agenda_insert);
                    return json_encode($mensaje);
                } else {
                    $resultado_mensaje= $tipo == 'ENTRADA'?'el ingreso':'la salida';
                    $mensaje_vehicular= $placa !=""? 'y del vehiculo' : '';
                    $mensaje_vehicular= isset($permanencia_vehiculo_no)? " en el vehiculo $placa, no se ha registrado un cambio de permanencia al vehiculo. ultima fecha de movimiento de vehiculo: $permanencia_vehiculo_no" : $mensaje_vehicular;
                    $mensaje=[
                        "titulo"=>"Excelente!",
                        "mensaje"=>"Se ha registrado la novedad de $contratipo del usuario $mensaje_vehicular con exito. AHORA DEBE DE RESGITRAR  ".strtoupper($resultado_mensaje)." DEL USUARIO",
                        "icono"=> "success",
                        "tipo"=> "$tipo",
                        "tipoMensaje"=>"normal"
                    ];
                    unset($registro_insert,$registro_update,$resultado,$tipo);
                    return json_encode($mensaje);
                }
                

            }
        }
        function listarReportes($tipo){
            header('Content-Type: application/json; charset=UTF-8');
            $output = [
				'listado' => '' // Valor por defecto para evitar errores de clave no definida
			];

            if (!isset($_POST['tipoListado']) || $_POST['tipoListado'] == "") {
				http_response_code(400); // Código de error HTTP 400: Bad Request
				echo json_encode(['error' => 'El campo tipoListado es obligatorio']);
				exit;
			} else {
				$tipo_listado = $this->limpiarDatos($_POST['tipoListado']);
				unset($_POST['tipoListado']);
                
                $select = isset($_POST['select']) ? $_POST['select'] : "5";
                $where="WHERE tipo_reporte='$tipo'"; 
                $sentencia="
                (
                    SELECT num_identificacion_persona, fecha_hora_reporte, rol_usuario, NULL AS placa_vehiculo
                    FROM reporte_entrada_salida
                    $where
                )
                UNION ALL
                (
                    SELECT num_identificacion_persona, fecha_hora_reporte, rol_usuario, placa_vehiculo
                    FROM reporte_entrada_salida_vehicular
                    $where
                )
                ORDER BY fecha_hora_reporte DESC LIMIT $select;";

                $buscar_reportes = $this->ejecutarConsulta($sentencia);
                unset($where,$sentencia);

                if ($buscar_reportes === false) {
                    $output['listado'] = $tipo_listado == 'tabla' 
						? '<tr><td colspan="8">Error al listar los reportes</td></tr>' 
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
                } else { 
                    if($buscar_reportes->num_rows < 1){
                        // No hay registros
						$output['listado'] = $tipo_listado == 'tabla' 
                        ? '<tr><td colspan="8">No se encontraron registros</td></tr>' 
                        : '
                        <div class="document-card">
                            <div class="card-header">
                                <div>
                                    <p class="document-title">Sin registros</p>
                                    <p class="document-meta">No se encontraron registros</p>
                                </div>
                            
                            </div>
                        </div>';
                    }else{
                        // Construcción de datos
                        /* var_dump($tipo_listado); */
						if ($tipo_listado === 'tabla') {
							$output['listado']= '
								<table class="table">
									<thead class="head-table">
										<tr>
											<th>Fecha y Hora</th>
											<th class="td-tipo-doc">Tipo</th>
											<th>Identificacion</th>
											<th>Nombres</th>
											<th>Apellidos</th>
											<th>Tipo Persona</th>
											<th>Vehiculo</th>
										</tr>
									</thead>
									<tbody class="body-table">';
                                    while ($reporte = $buscar_reportes->fetch_object()) {
                                        // var_dump($reporte);
                                        $consultar_datos=$this->consultarDatosUsuario($reporte->num_identificacion_persona,["nombres","apellidos","tipo_documento"]);
                                        $output['listado'] .= '
                                        <tr>
                                            <td>'.$reporte->fecha_hora_reporte.'</td>
                                            <td class="td-tipo-doc">'.$consultar_datos[2]["tipo_documento"].'</td>
                                            <td>'.$reporte->num_identificacion_persona.'</td>
                                            <td>'.$consultar_datos[2]['nombres'].'</td>
                                            <td>'.$consultar_datos[2]['apellidos'].'</td>
                                            <td>'.$reporte->rol_usuario.'</td>
                                            <td>'.$reporte->placa_vehiculo.'</td>
                                        </tr>';
                                    }
                                    unset($consultar_datos);
                                    $output['listado'] .= '</tbody></table>';
                        }elseif($tipo_listado === 'card'){
                            /* var_dump($tipo_listado); */
                            while ($reporte = $buscar_reportes->fetch_object()) {
                                $consultar_datos=$this->consultarDatosUsuario($reporte->num_identificacion_persona,["nombres","apellidos","tipo_documento"]);
                                $tipo_ = $reporte->rol_usuario;
                                $output['listado'] .= '
                                <div class="document-card" onclick="toggleCard(this)">
                                    <div class="card-header">
                                        <div>
                                            <p class="document-title">'.$consultar_datos[2]["nombres"]." ".$consultar_datos[2]["apellidos"].'</p>
                                            <p class="document-meta">'.$consultar_datos[2]["tipo_documento"].': '.$reporte->num_identificacion_persona.'</p>
                                        </div>
                                        <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                                    </div>
                                    <div class="card-details">
                                        <p><strong>Fecha y Hora: </strong>'.$reporte->fecha_hora_reporte.'</p>
                                        <p><strong>Tipo Persona:</strong>'.TIPOS_ROL_USUARIO["$tipo_"].'</p>
                                        <p><strong>Vehículo:</strong>'.$reporte->placa_vehiculo.'</p>
                                    </div>
                                </div>';
                                unset($consultar_datos);
                            }
                        }
                    }
                }

                ini_set('display_errors', 0); // Oculta errores en producción
                ini_set('log_errors', 1); // Activa el registro de errores
                ini_set('error_log', APP_URL_BASE . 'config/manejo-error.log'); // Archivo donde se guardarán los errores
        
                echo json_encode($output, JSON_UNESCAPED_UNICODE);
            }
        }
        // public function listarReportes($tipo){

        //     header('Content-Type: application/json'); 

        //     $columnas = [
        //         'tipo_documento',
        //         'num_identificacion',
        //         'nombres',
        //         'apellidos',
        //         'correo',
        //         'telefono',
        //         'estado',
        //         'fecha_hora_ultimo_ingreso',
        //         'permanencia'];

        //     $tabla = "visitantes";
        //     $id = 'tipo_documento';
            
        //     $tipo_listado = $this->limpiarDatos($_POST['tipoListado']);
        //     unset($_POST['tipoListado']);
            
        //     $filtro = '';
        //     if (isset($_POST['filtro']) && $_POST['filtro'] !== '') {
        //         $filtro = $this->limpiarDatos($_POST['filtro']);
        //     }

        //     /* Filtro Like */
        //     $sentenciaCondicionada = '';

        //     if ($filtro != '' ) {
        //         $sentenciaCondicionada = "WHERE (";
        //         $contadorColumas = count($columnas);
        //         for ($i=0; $i < $contadorColumas; $i++) { 
        //             $sentenciaCondicionada .= $columnas[$i] . " LIKE '%".$filtro."%' OR ";
        //         }

        //         $sentenciaCondicionada = substr_replace($sentenciaCondicionada, "", -3);
        //         $sentenciaCondicionada .= ")";
        //     }
        //     /* Filtro Limit */
        //     $limit = 3;
        //     if (isset($_POST['registros']) && $_POST['registros'] !== '') {
        //         $limit = $this->limpiarDatos($_POST['registros']);
        //     }
        //     $pagina = 0;
        //     if (isset($_POST['pagina']) && $_POST['pagina'] !== '') {
        //         $pagina = $this->limpiarDatos($_POST['pagina']);
        //     }

        //     if (!$pagina) {
        //         $inicio = 0;
        //         $pagina = 1;
        //     }else {
        //         $inicio = ($pagina - 1) * $limit;
        //     }


        //     $sLimit = "LIMIT $inicio , $limit";

        //     $sentencia = "SELECT  SQL_CALC_FOUND_ROWS ". implode(', ', $columnas). " 
        //     FROM $tabla 
        //     $sentenciaCondicionada 
        //     $sLimit";
        //     $buscar_visitantes = $this->ejecutarConsulta($sentencia);
        //     $numero_registros = $buscar_visitantes->num_rows;

            
        //     /*  Consulta total registros*/

        //     $sentencia_filtro = "SELECT FOUND_ROWS()";
        //     $busqueda_filtro = $this->ejecutarConsulta($sentencia_filtro);
        //     $registros_filtro = $busqueda_filtro->fetch_array();
        //     $total_filtro = $registros_filtro[0];

        //     /*  Consulta total registros*/

        //     $sentencia_total = "SELECT count($id) FROM $tabla";
        //     $busqueda_total = $this->ejecutarConsulta($sentencia_total);
        //     $registros_total = $busqueda_total->fetch_array();
        //     $total_registros = $registros_total[0];




        //     $output = [];
        //     $output['total_registros'] = $total_registros;
        //     $output['total_filtro'] = $total_filtro;
        //     $output['data'] = '';
        //     $output['paginacion'] = '';
        //     if (!$buscar_visitantes){
		// 			$output['data'] = $tipo_listado == 'tabla' 
        //             ? '
        //                             <table class="table">
        //                                 <thead class="head-table">
        //                                     <tr>
        //                                         <th>Tipo de Documento</th>
        //                                         <th>Número de Identificación</th>
        //                                         <th>Nombres</th>
        //                                         <th>Apellidos</th>
        //                                         <th>Correo</th>
        //                                         <th>Teléfono</th>
        //                                         <th>Fecha y Hora Último Ingreso</th>
        //                                         <th>Permanencia</th>
        //                                     </tr>
        //                                 </thead>
        //                                 <tbody class="body-table" id="listado_visitantes">
        //                                 <tr><td colspan="9">Error al cargar los visitantes</td></tr>
        //                                 </tbody>
        //                                 </table>' 
        //             : '
        //             <div class="document-card">
        //                 <div class="card-header">
        //                     <div>
        //                         <p class="document-title">Error en el listado</p>
        //                         <p class="document-meta">Error al listar los reportes</p>
        //                     </div>
        //                     <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
        //                 </div>
        //             </div>';
        //     } else{
        //         if ($buscar_visitantes->num_rows < 1) {
        //             $output['data'] = $tipo_listado == 'tabla' 
        //             ? '
        //                             <table class="table">
        //                                 <thead class="head-table">
        //                                     <tr>
        //                                         <th>Tipo de Documento</th>
        //                                         <th>Número de Identificación</th>
        //                                         <th>Nombres</th>
        //                                         <th>Apellidos</th>
        //                                         <th>Correo</th>
        //                                         <th>Teléfono</th>
        //                                         <th>Fecha y Hora Último Ingreso</th>
        //                                         <th>Permanencia</th>
        //                                     </tr>
        //                                 </thead>
        //                                 <tbody class="body-table" id="listado_visitantes">
        //                                 <tr><td colspan="9">No se encontraron Visitantes</td></tr>
        //                                 </tbody>
        //                                 </table>'
        //             :'
        //             <div class="document-card">
        //                 <div class="card-header">
        //                     <div>
        //                         <p class="document-meta">No se encontro Visitantes</p>
        //                     </div>
        //                 </div>
        //             </div>';
        //         } else{
        //             if ($tipo_listado == 'tabla') {
        //                 $output['data'] = '
        //                             <table class="table">
        //                                 <thead class="head-table">
        //                                     <tr>
        //                                         <th>Tipo de Documento</th>
        //                                         <th>Número de Identificación</th>
        //                                         <th>Nombres</th>
        //                                         <th>Apellidos</th>
        //                                         <th>Correo</th>
        //                                         <th>Teléfono</th>
        //                                         <th>Fecha y Hora Último Ingreso</th>
        //                                         <th>Permanencia</th>
        //                                         <th>Acciones</th>
        //                                     </tr>
        //                                 </thead>
        //                                 <tbody class="body-table" id="listado_visitantes">
        //                             ';
    
        //                 while ($datos = $buscar_visitantes->fetch_object()) {
        //                     $output['data'].='
        //                         <tr >
        //                             <td>'.$datos->tipo_documento.'</td>
        //                             <td>'.$datos->num_identificacion.'</td>
        //                             <td>'.$datos->nombres.'</td>
        //                             <td>'.$datos->apellidos.'</td>
        //                             <td>'.$datos->correo.'</td>
        //                             <td>'.$datos->telefono.'</td>
        //                             <td>'.$datos->fecha_hora_ultimo_ingreso.'</td>
        //                             <td>'.$datos->permanencia.'</td>
        //                             <td class="contenedor-colum-accion">
        //                                 <a href="'.APP_URL_BASE.'editar-visitante/'.$datos->num_identificacion.'/" class="button is-info is-rounded is-small">
        //                                     Editar
        //                                 </a>
        //                             </td>
        //                         </tr>
        //                     ';
        //                 }
        //                 $output['data'] .= '</tbody></table>';
        //             }elseif ($tipo_listado == 'card') {
                        
        //                 while ($datos = $buscar_visitantes->fetch_object()) {
        //                     $output['data'].= '
		// 						<div class="document-card" onclick="toggleCard(this)">
		// 							<div class="card-header">
		// 								<div>
		// 									<p class="document-title">'.$datos->nombres.' '.$datos->apellidos.'</p>
		// 									<p class="document-meta">'.$datos->tipo_documento.': '.$datos->num_identificacion. ' | ' .$datos->permanencia.'</p>
		// 								</div>
		// 								<span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
		// 							</div>
		// 							<div class="card-details">
		// 								<p><strong>Fecha y Hora: </strong>'.$datos->fecha_hora_ultimo_ingreso.'</p>
		// 								<p><strong>Correo:</strong>'.$datos->correo.'</p>
		// 								<p><strong>Telefono:</strong>'.$datos->telefono.'</p>
		// 							</div>
                                    
        //                             <div class="contenedor-acciones">
                                        
        //                                 <a href="'.APP_URL_BASE.'editar-visitante/'.$datos->num_identificacion.'/" class="button is-info is-rounded is-small">
        //                                     <p>
        //                                         Editar
        //                                     </p>
        //                                 </a>
        //                             </div>
		// 						</div>';
        //                 }
        //             }


        //         }
        //         if ($output['total_registros'] > 0) {
        //             $total_paginas = ceil($output['total_registros'] / $limit);
        //             $output['paginacion'] .= '<nav>';
        //             $output['paginacion'] .= '<ul>';

        //             for ($i=1; $i <= $total_paginas ; $i++) { 
        //                 $output['paginacion'] .= '<li>
        //                                             <a href="#" onclick="getData('.$i.')">'.$i.'</a>
        //                                         </li>';
        //             }
                    
        //             $output['paginacion'] .= '</ul>';
        //             $output['paginacion'] .= '</nav>';
        //         }
        //     } 
        //     return json_encode($output, JSON_UNESCAPED_UNICODE);
        // }
        

        function buscarPasajero($tipo){
            if ($tipo=="ENTRADA") {
                $estado="DENTRO";
                $contraestado="FUERA";
            } elseif ($tipo=="SALIDA") {
                $estado="FUERA";
                $contraestado="DENTRO";
            }
            $datos=$this->consultarDatosUsuario($_POST['num_identificacion_pasajero'],["nombres","apellidos","tipo_documento","num_identificacion","permanencia"]);
            $num_identificacion=$_POST['num_identificacion_pasajero'];
            unset($_POST['num_identificacion_pasajero']);
            if ($datos[0]=="no_encontrado") {
                $mensaje=[
                    "titulo"=>"Usuario No Registrado.<br> Lo sentimos",
                    "mensaje"=>"El usuario con número de documento $num_identificacion no se encuentra registrado en Cerberus.  ¿Deseas Registrarlo como VISITANTE?",
                    "adaptar"=>"none",
                    "icono"=> "info",
                    "url"=> APP_URL_BASE."app/views/inc/modales/modal-registro-visitante.php",
                    "tipoMensaje"=>"normal_redireccion"
                ];
                return json_encode($mensaje);
            }else if ($datos[0]=="error_conexion") {
                $mensaje=[
                    "titulo"=>"Error de Conexion",
                    "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                return json_encode($mensaje);
            }else if ($datos[2]["permanencia"]=="$estado") {
                $mensaje=[
                    "titulo"=>"Error de Permanencia",
                    "mensaje"=>"El usuario con numero de documento $num_identificacion ya se encuentra $estado del SENA, ¿Desea registrar una NOVEDAD?",
                    "icono"=> "error",
                    "adaptar"=> ["novedades",strtolower($tipo),$num_identificacion],
                    "url"=> APP_URL_BASE."app/views/inc/modales/modal-registro-novedad.php",
                    "tipoMensaje"=>"normal_redireccion"
                ];
                return json_encode($mensaje);
            }else if ($datos[2]["permanencia"]=="$contraestado") {
                $html='<tr  id="'.$datos[2]['num_identificacion'].'">';
                $html.='<td class="colum-oculta" >'.$datos[2]['tipo_documento'].'</td>';
                $html.='<td>'.$datos[2]['num_identificacion'].'</td>';
                $html.='<td>'.$datos[2]['nombres'].'</td>';
                $html.='<td>'.$datos[2]['apellidos'].'</td>';
                $html.='<td>';
                $html .= '<button type="button" id="' . $datos[2]['num_identificacion'] . '" class ="eliminar" onclick="eliminarPasajero(\'' . $datos[2]['num_identificacion'] . '\')">Eliminar</button>';
                $html.='</td>';
                $html.='</tr>';
                return json_encode($html, JSON_UNESCAPED_UNICODE);
            
            }
            
        }

        
        function placaConductor ($tipo){
            $num_identificacion=trim($_POST['num_identificacion']);
            $html="";
            $sentencia = "SELECT placa_vehiculo FROM vehiculos_personas WHERE num_identificacion_persona = '$num_identificacion' AND permanencia = '$tipo'";
            if ($tipo=="DENTRO") {
                $estado="SALIDA";
            }else{
                $estado="ENTRADA";
            }
           
            $buscar_vehiculo = $this->ejecutarConsulta($sentencia);
            unset($sentencia);
            if ($buscar_vehiculo === false) {
                return json_encode($html, JSON_UNESCAPED_UNICODE);
            } elseif ($buscar_vehiculo->num_rows!=0) {
                $datos=$buscar_vehiculo->fetch_all();
                foreach ($datos as $key => $reporte) {
                    $html.='<option value="'.$reporte[0].'">';
                }
            }
            $consulta_salida="";
            if ($estado=="SALIDA") {
                $consulta_salida="OR estado_agenda = 'INACTIVO'";
            }
            $buscar_agendas="SELECT contador_agendas, id_agendas, titulo_agenda, descripcion_agenda, placa_vehiculo FROM agendas WHERE (estado_agenda = 'ACTIVO' $consulta_salida) AND num_documento_persona = '$num_identificacion' AND DATE(fecha_hora_agenda) = CURDATE() AND (placa_vehiculo!=''  || placa_vehiculo!=null) ORDER BY fecha_hora_agenda ASC LIMIT 1;";
            $agendas = $this->ejecutarConsulta($buscar_agendas);
            unset($buscar_agendas,$consulta_salida);
        
            if ($agendas != false && $agendas->num_rows!=0) {
                $dato=$agendas->fetch_assoc();
                $id_grupal=$dato['id_agendas'];
                $update_salida= $estado == "SALIDA"? "INACTIVO":"ACTIVO";
                $sentencia_pasajeros_agenda="SELECT num_identificacion_persona FROM agenda_personas WHERE id_agenda_grupal = '$id_grupal' AND estado_agenda = '$update_salida'";
                $agendas_persona = $this->ejecutarConsulta($sentencia_pasajeros_agenda);
                if ($agendas_persona != false && $agendas_persona->num_rows!=0) {
                    $respuesta_consolidada = "";
                    $error ="";
                    
                    while ($fila = $agendas_persona->fetch_assoc()) {
                        $_POST['num_identificacion_pasajero'] = $fila['num_identificacion_persona']; // Simula envío de dato por POST
                        $respuesta_individual = $this->buscarPasajero($estado);
                        unset($_POST['num_identificacion_pasajero']);
                        $respuesta_decodificada = json_decode($respuesta_individual, true);
                        if (is_string($respuesta_decodificada)) {
                            $respuesta_consolidada .= $respuesta_decodificada;
                        }else{
                            $error .=$fila['num_identificacion_persona'].", ";
                        }
                    }
                    if ($error!="") {
                        $mensaje=[
                            "titulo"=>"Error Ingresando Pasajeros",
                            "mensaje"=>"Ha ocurrido un error al intentar ingresar al pasajero(s) con numero de cedula: $error",
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        $html=[$dato["placa_vehiculo"],$html,$respuesta_consolidada,$mensaje];
                    }else{
                        $html=[$dato["placa_vehiculo"],$html,$respuesta_consolidada];
                    }
                    
                }else{
                    $html=[$dato["placa_vehiculo"],$html];
                }
                
            }
            
            
            if ($tipo=="DENTRO") { //se compara con dentro ya que tipo es el valor que debe de tener la permanencia que debe de tener el vehiculo para que pueda salir, por ende si queremos que esto se realice en la salida se pone ese valor
                $permanencia = $this->consultarDatosUsuario($num_identificacion, ["forma_de_ingreso"]);
                if ($permanencia[0] == "no_encontrado") {
                    unset($permanencia);
                    return json_encode($html, JSON_UNESCAPED_UNICODE);
                } else if ($permanencia[0] == "error_conexion") {
                    unset($permanencia);
                    return json_encode($html, JSON_UNESCAPED_UNICODE);
                } else if (isset($permanencia[2]["forma_de_ingreso"])) {
                    if ($permanencia[2]["forma_de_ingreso"]!="PE") {
                        $html=[$permanencia[2]["forma_de_ingreso"],$html];
                    }
                }
                unset($permanencia);
                
            }
            unset($num_identificacion);
            return json_encode($html, JSON_UNESCAPED_UNICODE);

        }
        function actualizarPermanenciaPasajero($num_identificacion,$placa_vehiculo,$rol_en_vehiculo,$observaciones,$tipo,$fecha_suceso = "",$agendas=null) {
            if ($tipo=="ENTRADA") {
                $estado="DENTRO";
            } elseif ($tipo=="SALIDA") {
                $estado="FUERA";
            }
            /* CONSULTAMOS EN QUE TABLA ESTA Y QUE TENGA LA PERMANENCIA ADECUADA */
            $permanencia = $this->consultarDatosUsuario($num_identificacion, ["permanencia","id_ultimo_reporte"]);

            if ($permanencia[0] == "no_encontrado") {
                return ["Usuario no entontrado",$num_identificacion];
            } else if ($permanencia[0] == "error_conexion") {
                return ["Error en la base de datos",$num_identificacion];
            } else if ($permanencia[2]["permanencia"] == "$estado") {
                return ["Error en la permanencia",$num_identificacion];
            }else {
                $tabla=$permanencia[0];

            /* ACTUALIZAMOS LA PERMANENCIA DEL USUARIO EN SU RESPECTIVA TABLA */

                $fecha_actual_time = time();
                $fecha_actual = date('Y-m-d H:i:s',$fecha_actual_time);
                if ($fecha_suceso != "") {
                    $fecha_actual = $fecha_suceso;
                }
                $id_reporte = "RV" . date('ymdHis', $fecha_actual_time);
                $sentencia_update_permanencia="UPDATE $tabla SET permanencia='$estado',fecha_hora_ultimo_ingreso='$fecha_actual', id_ultimo_reporte='$id_reporte', forma_de_ingreso='$placa_vehiculo' WHERE num_identificacion = '$num_identificacion'";
                $permanencia_update = $this->ejecutarInsert($sentencia_update_permanencia);
                unset($sentencia_update_permanencia,$fecha_actual_time,$tabla);
                if ($permanencia_update != 1) {
                    return ["Error en la base de datos",$num_identificacion];
                } else {
                    
            /* CREAMOS EL REGISTRO DE REPORTE DE INGRESO VEHICULAR*/
                    unset($permanencia_update);
                    $rol_usuario=$permanencia[1];
                    $usuario_registro=$_SESSION['datos_usuario']['num_identificacion'];
                    if ($tipo=="ENTRADA") {
                        $sentencia_reporte ="INSERT INTO reporte_entrada_salida_vehicular( tipo_reporte, num_identificacion_persona, fecha_hora_reporte, usuario_de_reporte,rol_en_el_vehiculo, placa_vehiculo, observacion,rol_usuario,id_reporte,id_reporte_relacion) VALUES ('$tipo','$num_identificacion','$fecha_actual','$usuario_registro', '$rol_en_vehiculo','$placa_vehiculo', '$observaciones','$rol_usuario','$id_reporte','')";
                    } else if ($tipo=="SALIDA") {
                        $id_reporte_relacion=$permanencia[2]["id_ultimo_reporte"];
                        $sentencia_reporte ="INSERT INTO reporte_entrada_salida_vehicular( tipo_reporte, num_identificacion_persona, fecha_hora_reporte, usuario_de_reporte,rol_en_el_vehiculo, placa_vehiculo, observacion,rol_usuario,id_reporte,id_reporte_relacion) VALUES ('$tipo','$num_identificacion','$fecha_actual','$usuario_registro', '$rol_en_vehiculo','$placa_vehiculo', '$observaciones','$rol_usuario','$id_reporte','$id_reporte_relacion')";
                        if ($id_reporte_relacion[1]=="P") {
                            $tabla= "reporte_entrada_salida";
                        }else if($id_reporte_relacion[1]=="V") {
                            $tabla= "reporte_entrada_salida_vehicular";
                        }
                        $sentencia_update_reporte="UPDATE $tabla SET id_reporte_relacion='$id_reporte' WHERE id_reporte = '$id_reporte_relacion' AND num_identificacion_persona='$num_identificacion'";
                        $registro_update = $this->ejecutarInsert($sentencia_update_reporte);    
                        unset($id_reporte_relacion,$sentencia_update_reporte,$tabla);
                    }
                    $registro_insert = $this->ejecutarInsert($sentencia_reporte);
                    unset($usuario_registro,$rol_usuario,$sentencia_reporte,$fecha_actual,$observaciones,$permanencia,$id_reporte);
                    if ($registro_insert != 1 ||(isset($registro_update)&& $registro_update != 1)) {
                        unset($registro_insert,$registro_update);
                        return ["Error en la base de datos ",$num_identificacion];
                    } else{
                        unset($registro_insert,$registro_update);
                        
                        /* REVISAMOS QUE NO ESTE EN ALGUNA DE LAS AGENDAS DEL DIA*/
                        if ($agendas != null && is_array($agendas)) {
                            $registro_string = [];
                            $registro_encontrado = false;
                            $i=0;
                            while ($i < count($agendas)) {
                                $fila = $agendas[$i];
                                if ($fila['num_documento_persona'] == $num_identificacion) {
                                    $registro_encontrado = true;
                                    array_push($registro_string,[$fila['titulo_agenda'],date("h:i A", strtotime($fila['fecha_hora_agenda'])),$fila['descripcion_agenda']]);
                                    $contador = $fila['contador_agendas'];
                                    $update_salida= $tipo == "SALIDA"? "CONCLUIDA":"INACTIVO";
                                    $sentencia_actualiza_agenda = "UPDATE agendas SET estado_agenda = '$update_salida' WHERE contador_agendas = '$contador';";
                                    $agenda_insert = $this->ejecutarInsert($sentencia_actualiza_agenda,$update_salida);
                                    unset($sentencia_actualiza_agenda, $contador);
                        
                                    if ($agenda_insert != 1) {
                                        return ["Error agendas",$num_identificacion];
                                    }
                                } else {
                                    $update_salida= $tipo == "SALIDA"? "INACTIVO":"ACTIVO";
                                    $sentencia_agendas_persona = "SELECT id_agenda_grupal, id_agenda FROM agenda_personas WHERE num_identificacion_persona = '$num_identificacion' AND estado_agenda = '$update_salida'";
                                    $agendas_persona = $this->ejecutarConsulta($sentencia_agendas_persona);
                                    if ($agendas === false) {
                                        return ["Error agendas",$num_identificacion];
                                    }elseif ($agendas_persona->num_rows!=0) {
                                        $registro_encontrado = true;
                                        while ($fila_persona = $agendas_persona->fetch_assoc()) {
                                            array_push($registro_string,[$fila['titulo_agenda'],date("h:i A", strtotime($fila['fecha_hora_agenda'])),$fila['descripcion_agenda']]);
                                            $contador = $fila_persona['id_agenda'];
                                            $update_salida= $tipo == "SALIDA"? "CONCLUIDA":"INACTIVO";
                                            $sentencia_actualiza_agenda = "UPDATE agenda_personas SET estado_agenda= '$update_salida' WHERE id_agenda='$contador'";
                                            $agenda_insert = $this->ejecutarInsert($sentencia_actualiza_agenda);
                                            unset($sentencia_actualiza_agenda, $contador);
                                            if ($agenda_insert != 1) {
                                                return ["Error agendas",$num_identificacion];
                                            }   
                                        }
                                    }
                                }
                                $i++;
                            } if ($registro_encontrado===true) {
                                return ["bien agendas",$registro_string];
                            }
                            return ["bien"];
                        }
                        return ["bien"];
                    }
                }
            }
        }
    
        function ingresoVehicularControler($tipo){
            if ($tipo=="ENTRADA") {
                $estado="DENTRO";
                $contraestado="FUERA";
            } elseif ($tipo=="SALIDA") {
                $estado="FUERA";
                $contraestado="DENTRO";
            }
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                $mensaje=[
                    "titulo"=>"Peticion Incorrecta",
                    "mensaje"=>"Lo sentimos, la accion que intentas realizar no es correcta",
                    "icono"=> "error",
                    "tipoMensaje"=>"redireccionar",
                    "url"=>"https://arcano.digital/cerberus_b/"
                ];
                return json_encode($mensaje);
            }else{
                
                if (!isset($_POST['num_identificacion_vehiculo']) ||
                $_POST['num_identificacion_vehiculo'] == "" ||
                $this->verificarDatos('[0-9]{6,15}',$_POST['num_identificacion_vehiculo'])
                ) {
                    $mensaje=[
                        "titulo"=>"Error",
                        "mensaje"=>"Lo sentimos, a ocurrido un error con el numero de documento, intentalo de nuevo mas tarde.",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                }
                else if (!isset($_POST['placa_vehiculo']) ||
                $_POST['placa_vehiculo'] == "" ||
                strlen($_POST['placa_vehiculo'])>6) {
                    $mensaje=[
                        "titulo"=>"Error",
                        "mensaje"=>"Lo sentimos, a ocurrido un error con la placa del vehiculo, intentalo de nuevo mas tarde.",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                }else if ((isset($_POST['observaciones_vehiculo']) && $_POST['observaciones_vehiculo'] != "") &&
                (strlen($_POST['observaciones_vehiculo'])>255 ||
                strlen($_POST['observaciones_vehiculo'])<3) ) {
                    $mensaje=[
                        "titulo"=>"Error",
                        "mensaje"=>"Lo sentimos, a ocurrido un error con la observacion, intentalo de nuevo mas tarde.",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                }else{

                    $num_identificacion=trim($_POST['num_identificacion_vehiculo']);
                    unset($_POST['num_identificacion_vehiculo']);

                    $permanencia=$this->consultarDatosUsuario($num_identificacion,["permanencia"]);
                    if ($permanencia[0]=="no_encontrado") {
                        $mensaje=[
                            "titulo"=>"Usuario no Registrado.<br> Lo sentimos",
                            "mensaje"=>"El usuario con número de documento $num_identificacion no se encuentra registrado en Cerberus.  ¿Deseas Registrarlo como VISITANTE?",
                            "icono"=> "info",
                            "url"=> APP_URL_BASE."app/views/content/nuevo-visitante-vs-view.php",
                            "tipoMensaje"=>"normal_redireccion"
                        ];
                        unset($num_identificacion,$permanencia);
                        return json_encode($mensaje);
                    }else if ($permanencia[0]=="error_conexion") {
                        $mensaje=[
                            "titulo"=>"Error de Conexion",
                            "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        unset($num_identificacion,$permanencia);
                        return json_encode($mensaje);
                    }else if ($permanencia[2]["permanencia"]=="$estado") {
                        $mensaje=[
                            "titulo"=>"Error de Permanencia",
                            "mensaje"=>"El usuario con numero dee documento $num_identificacion ya se encuentra $estado del SENA, ¿Desea registrar una NOVEDAD?",
                            "tituloModal"=>"Registro Novedad",
                            "icono"=> "error",
                            "adaptar"=> ["novedades",strtolower($tipo),$num_identificacion],
                            "url"=> APP_URL_BASE."app/views/inc/modales/modal-registro-novedad.php",
                            "tipoMensaje"=>"normal_redireccion"
                        ];
                        unset($num_identificacion,$permanencia);
                        return json_encode($mensaje);
                    } else if ($permanencia[2]["permanencia"]=="$contraestado") {

                        $observaciones = strtolower(trim($_POST['observaciones_vehiculo']));
                        $placa_vehiculo = strtoupper(trim($_POST['placa_vehiculo']));
                        $buscar_vehiculo_sentencia = "SELECT permanencia FROM vehiculos_personas WHERE num_identificacion_persona = '$num_identificacion' AND placa_vehiculo = '$placa_vehiculo';";
                        $buscar_vehiculo = $this->ejecutarConsulta($buscar_vehiculo_sentencia);
                        unset($buscar_vehiculo_sentencia,$_POST['placa_vehiculo'],$_POST['observaciones_vehiculo']);
                        if (!$buscar_vehiculo) {
                            $mensaje=[
                                "titulo"=>"Error de Conexion",
                                "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                                "icono"=> "error",
                                "tipoMensaje"=>"normal"
                            ];
                            unset($num_identificacion,$permanencia);
                            return json_encode($mensaje);
                        }else {
                            if ($buscar_vehiculo->num_rows < 1) {
                                $mensaje=[
                                      "titulo"=>"Vehiculo no Registrado.<br> Lo sentimos",
                                      "mensaje"=>"El usuario con número de documento $num_identificacion no tiene registrado el vehiculo placa $placa_vehiculo.  ¿Deseas Registrar el vehiculo?",
                                      "icono"=> "info",
                                      "adaptar"=>"adaptar",
                                      "tituloModal"=>"Registro Vehiculo",
                                      "url"=> APP_URL_BASE."app/views/inc/modales/modal-registro-vehiculo.php",
                                      "tipoMensaje"=>"normal_redireccion"
                                ];
                                unset($num_identificacion,$permanencia,$buscar_vehiculo);
                                return json_encode($mensaje);
                            } else {
                                $permanencia_vehiculo = $buscar_vehiculo->fetch_assoc();
                                unset($buscar_vehiculo);
                                if ($permanencia_vehiculo["permanencia"]!=$contraestado) {
                                    $mensaje=[
                                        "titulo"=>"Vehiculo con Estado Incorrecto",
                                        "mensaje"=>"El vehiculo con $placa_vehiculo se encuentra ".$permanencia_vehiculo["permanencia"]."  ¿Deseas Registrar una novedad?",
                                        "tituloModal"=>"Registro Novedad",
                                        "icono"=> "error",
                                        "adaptar"=> ["novedades",strtolower($tipo),$num_identificacion],
                                        "url"=> APP_URL_BASE."app/views/inc/modales/modal-registro-novedad.php",
                                        "tipoMensaje"=>"normal_redireccion"
                                    ];
                                    unset($num_identificacion,$permanencia,$permanencia_vehiculo);
                                    return json_encode($mensaje);
                                } else {
                                    unset($permanencia_vehiculo);
                                    $fecha_actual_time = time();
                                    $fecha_actual = date('Y-m-d H:i:s',$fecha_actual_time);
                                    $sentencia_update_permanencia="UPDATE vehiculos_personas SET permanencia='$estado',fecha_hora_ultimo_ingreso='$fecha_actual' WHERE placa_vehiculo='$placa_vehiculo'";
                                    $permanencia_update = $this->ejecutarInsert($sentencia_update_permanencia);
                                    unset($sentencia_update_permanencia,$fecha_actual_time,$fecha_actual);
                                    if ($permanencia_update != 1) {
                                        unset($permanencia_update);
                                        $mensaje=[
                                            "titulo"=>"Error de Conexion",
                                            "mensaje"=>"Lo sentimos, parece que ha ocurrido un error al intentar realizar la $tipo el vehiculo. El vehiculo se encuentra $contraestado",
                                            "icono"=> "error",
                                            "tipoMensaje"=>"normal"
                                        ];
                                        return json_encode($mensaje);
                                    } else {

                                        /* BUSCAMOS LAS AGENDAS QUE HAYAN PARA ESE DIA :> */
                                        $fecha_actual = new \DateTime();
                                        $fecha_actual->modify('-2 hours');
                                        $fecha_hora_dos_horas_atras = $fecha_actual->format('Y-m-d H:i:s');
                                        $agendas_salida=$tipo == "SALIDA"? "INACTIVO": "ACTIVO" ;
                                        $sentencia_agendas = "SELECT contador_agendas, titulo_agenda, descripcion_agenda, fecha_hora_agenda, placa_vehiculo, tipo_vehiculo, num_documento_persona FROM agendas WHERE DATE(fecha_hora_agenda) = CURDATE() AND fecha_hora_agenda >= '$fecha_hora_dos_horas_atras' AND estado_agenda = '$agendas_salida';";
                                        $agendas = $this->ejecutarConsulta($sentencia_agendas);
                                        unset($sentencia_agendas);
                                    
                                        if ($agendas === false) {
                                            $error_agedas=true;
                                        } elseif ($agendas->num_rows!=0) {
                                            $agendas = isset($error_agedas)? null: $agendas;
                                        }else{
                                            $agendas = null;
                                        }

                                        if (isset($_POST['ids_pasajeros'])) {
                                            $num_identificacion_pasajeros = json_decode($_POST['ids_pasajeros'], true);
                                            unset($_POST['ids_pasajeros']);
                                        }
                    
                                        if (isset($num_identificacion_pasajeros)&& count($num_identificacion_pasajeros)>0) {
                                            $index = array_search($num_identificacion, $num_identificacion_pasajeros);
    
                                            if ($index === false) {
                                                array_unshift($num_identificacion_pasajeros, $num_identificacion);
                                            } else {
                                                unset($num_identificacion_pasajeros[$index]);
                                                array_unshift($num_identificacion_pasajeros, $num_identificacion);
                                            }
    
                                            unset($index);
                                            $errores_ingreso_bdd=[];
                                            $pasajeros_agendas_bdd=[];
                                            $resultado_agendas = [];
                                            if ($agendas!= null) {
                                                while ($fila = $agendas->fetch_assoc()) {
                                                    $resultado_agendas[] = $fila;
                                                }
                                            }
                                            unset($agendas);
                                            foreach ($num_identificacion_pasajeros as $i => $identificacion) {
                                                $rol_en_vehiculo=$identificacion==$num_identificacion_pasajeros[0]? "PROPIETARIO": "PASAJERO";

                                                $errores_pasajeros=$this->actualizarPermanenciaPasajero($identificacion,$placa_vehiculo,$rol_en_vehiculo,$observaciones,$tipo,"",$resultado_agendas);
                                                
                                                if ($errores_pasajeros[0]!="bien" && $errores_pasajeros[0]!="bien agendas"){
                                                    array_push($errores_ingreso_bdd,$errores_pasajeros[1]);
                                                }else if ($errores_pasajeros[0]=="bien agendas") {
                                                    array_push($pasajeros_agendas_bdd,$errores_pasajeros);
                                                }
                                                unset($errores_pasajeros,$rol_en_vehiculo);
                                            }
                                            unset($placa_vehiculo,$observaciones,$num_identificacion,$resultado_agendas);
                                            $texto="";
                                            
                                            
                                            if (count($pasajeros_agendas_bdd[0][1])>0 && count($pasajeros_agendas_bdd)>0 && isset($pasajeros_agendas_bdd[0][1])) {
                                                $resultado_agendas = [];
                                                var_dump($pasajeros_agendas_bdd);
                                                for ($i = 0; $i < count($pasajeros_agendas_bdd); $i++) {
                                                    $clave = $pasajeros_agendas_bdd[$i][1][0][0];
                                                    if (array_key_exists($clave, $resultado_agendas)) {
                                                        $resultado_agendas[$clave]++;
                                                    } else {
                                                        $resultado_agendas[$clave] = 1;
                                                    }
                                                }
                                                $mensaje_agendas = "";
                                                foreach ($resultado_agendas as $llave => $valor) {
                                                    $mensaje_agendas .= $llave . ": " . $valor . ", \n"; 
                                                }
                                                $texto.= "Y las siguientes agendas || $mensaje_agendas";

                                            }
                                            if (count($errores_ingreso_bdd)>0) {
                                                
                                                foreach ($errores_ingreso_bdd as $i => $error){
                                                    $texto.=" Ha ocurrido un: ".$error[0].", con el usuario: ".$error[1]." ";
                                                    
                                                }
                                                $mensaje=[
                                                    "titulo"=>"Error al Registrar",
                                                    "mensaje"=>$texto,
                                                    "icono"=> "error",
                                                    "tipoMensaje"=>"normal"
                                                ];
                                                unset($texto,$errores_ingreso_bdd);
                                                return json_encode($mensaje);
                                            } else {
                                                $mensaje=[
                                                    "titulo"=>"Excelente!",
                                                    "mensaje"=>"Se ha registrado la $tipo de los usuarios y vehiculo con exito. $texto",
                                                    "icono"=> "success",
                                                    "tipoMensaje"=>$texto != ""? "normal":"normal_temporizada"
                                                ];
                                                unset($errores_ingreso_bdd);
                                                return json_encode($mensaje);
                                            }
                                        } else {
                                            $errores_pasajeros=$this->actualizarPermanenciaPasajero($num_identificacion,$placa_vehiculo,"PROPIETARIO",$observaciones,$tipo,"",$agendas);
                                            unset($placa_vehiculo,$observaciones,$num_identificacion);
                                            /* var_dump($errores_pasajeros); */
                                            if ($errores_pasajeros[0]!="bien" && $errores_pasajeros[0]!="bien agendas"){
                                                $mensaje=[
                                                    "titulo"=>"Error al Registrar",
                                                    "mensaje"=>"Ha ocurrido un: ".$errores_pasajeros[0]." con el usuario: ".$errores_pasajeros[1],
                                                    "icono"=> "error",
                                                    "tipoMensaje"=>"normal"
                                                ];
                                                unset($errores_pasajeros);
                                                return json_encode($mensaje);
                                            } 
                                            $texto = "";
                                            if ($errores_pasajeros[0]=="bien agendas") {
                                                $texto = "Con la agenda " . $errores_pasajeros[1][0][0] . 
                                                " a la hora " . $errores_pasajeros[1][0][1] . 
                                                " con la descripcion " . $errores_pasajeros[1][0][2];
                                            }
                                            $mensaje=[
                                                "titulo"=>"Excelente!",
                                                "mensaje"=>"Se ha registrado la $tipo del usuario y el vehiculo con exito. $texto",
                                                "icono"=> "success",
                                                "tipoMensaje"=>$texto != ""? "normal":"normal_temporizada"
                                            ];
                                            unset($errores_pasajeros);
                                            return json_encode($mensaje);
                                            
                                        } 
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    