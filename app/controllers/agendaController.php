<?php

namespace app\controllers;



use app\models\mainModel;

class agendaController extends mainModel
{
    public function registrarAgendaControlador(){
        
		header('Content-Type: application/json'); 
        // Verificar que el método sea POST
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $mensaje = [
                "titulo" => "Petición incorrecta",
                "mensaje" => "Lo sentimos, la acción que intentas realizar no es correcta",
                "icono" => "error",
                "tipoMensaje" => "redireccionar",
                "url" => "../panel-principal/"
            ];
            return json_encode($mensaje);
            exit();
        } else {
            // Validar que las variables POST necesarias estén presentes y no estén vacías
            if (
                !isset(
                    $_POST['titulo_agenda'],
                    $_POST['descripcion_agenda'],
                    $_POST['num_documento_persona'],
                    $_POST['num_identificacion_persona'],
                    $_POST['fecha_hora_agenda']
                ) ||
                $_POST['titulo_agenda'] == "" ||
                $_POST['descripcion_agenda'] == "" ||
                $_POST['num_documento_persona'] == "" ||
                $_POST['fecha_hora_agenda'] == ""
            ) {
                $mensaje = [
                    "titulo" => "Error",
                    "mensaje" => "Lo sentimos, ha ocurrido un error con alguno de los datos. Inténtalo de nuevo más tarde.",
                    "icono" => "error",
                    "tipoMensaje" => "normal"
                ];
                echo json_encode($mensaje);
                exit();
            } else {
                // Limpiar y validar datos
                $titulo_agenda = $this->limpiarDatos($_POST['titulo_agenda']);
                $descripcion_agenda = $this->limpiarDatos($_POST['descripcion_agenda']);
                $numero_documento = $this->limpiarDatos($_POST['num_documento_persona']);
                $numero_documento_c = $this->limpiarDatos($_POST['num_identificacion_persona']);
                $fecha_agenda = $this->limpiarDatos($_POST['fecha_hora_agenda']);
                $tipo_vehiculo = isset($_POST['tipo_vehiculo']) ? $this->limpiarDatos($_POST['tipo_vehiculo']) : null;
                $placa_vehiculo = isset($_POST['placa_vehiculo']) ? $this->limpiarDatos($_POST['placa_vehiculo']) : null;
            }

            $campos_invalidos = [];

            // Validar datos
            if ($this->verificarDatos('[A-Za-z]{2,64}', $titulo_agenda)) {
                array_push($campos_invalidos, 'TÍTULO AGENDA');
            }
            if ($this->verificarDatos('[A-Za-z ]{2,64}', $descripcion_agenda)) {
                array_push($campos_invalidos, 'DESCRIPCIÓN AGENDA');
            }
            if ($this->verificarDatos('[0-9]{6,15}', $numero_documento)) {
                array_push($campos_invalidos, 'NÚMERO DE DOCUMENTO');
            }
            if ($this->verificarDatos('^\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}$', $fecha_agenda)) {
                array_push($campos_invalidos, 'FECHA Y HORA DE LA AGENDA');
            }

            // Validar vehículo solo si ambos campos están presentes
            if (!empty($tipo_vehiculo) && !empty($placa_vehiculo)) {
                if ($this->verificarDatos('[A-Z]{2,}', $tipo_vehiculo)) {
                    array_push($campos_invalidos, 'TIPO DE VEHÍCULO');
                }
                if ($this->verificarDatos('[A-Z0-9]{6,7}', $placa_vehiculo)) {
                    array_push($campos_invalidos, 'PLACA DE VEHÍCULO');
                }
            } elseif (!empty($tipo_vehiculo) || !empty($placa_vehiculo)) {
                $mensaje = [
                    "titulo" => "Campo incompleto",
                    "mensaje" => "Ambos campos de vehículo deben estar completos.",
                    "icono" => "error",
                    "tipoMensaje" => "normal"
                ];
                echo json_encode($mensaje);
                exit();
            }
            // Verificar si hay campos inválidos
            if (count($campos_invalidos) > 0) {
                $invalidos = implode(', ', $campos_invalidos);
                $mensaje = [
                    "titulo" => "Campos incompletos",
                    "mensaje" => "Los campos " . $invalidos . " no cumplen con el formato solicitado.",
                    "icono" => "error",
                    "tipoMensaje" => "normal"
                ];
                echo json_encode($mensaje);
                exit();
            }
            
            // Registrar agenda
            $fecha_hora_actualid = (string)date('ymdHis');
            $id_agenda = "AG" . $fecha_hora_actualid;
            $fecha_hora_actual = date('Y-m-d H:i:s');
            $fecha_agenda_format = (new \DateTime($fecha_agenda))->format('Y-m-d H:i:s');
            
                

            if (isset($_POST['agenda_grupar_check'])) {
                if (isset($_POST['agenda_vehiculo_check'])) {
                    $mensaje = [
                        "titulo" => "Checkbox vehiculo y agenda grupal",
                        "mensaje" => "La agenda fue registrada con éxito.",
                        "icono" => "success",
                        "tipoMensaje" => "normal"
                    ];
                    return json_encode($mensaje);
                    exit();
                }else {
                    if (!isset($_POST['registroGrupal']) || empty($_POST['registroGrupal'])) {
                        $mensaje = [
                            "titulo" => "Error",
                            "mensaje" => "No se recibió el campo 'registroGrupal'.",
                            "icono" => "error",
                            "tipoMensaje" => "error"
                        ];
                        echo json_encode($mensaje);
                        exit();
                    }
                    $personasGrupal = json_decode($_POST['registroGrupal'], true);
                    
                    $registrar_agendas_query = "INSERT INTO `agendas`(`id_agendas`, `titulo_agenda`, `descripcion_agenda`, `num_documento_persona`, `fecha_hora_registro`, `fecha_hora_agenda`, `estado_agenda`, `placa_vehiculo`, `tipo_vehiculo`) 
                    VALUES ('$id_agenda', '$titulo_agenda', '$descripcion_agenda', '$numero_documento', '$fecha_hora_actual', '$fecha_agenda_format', 'ACTIVA', " . 
                    (!empty($placa_vehiculo) ? "'$placa_vehiculo'" : "NULL") . ", " . 
                    (!empty($tipo_vehiculo) ? "'$tipo_vehiculo'" : "NULL") . ")";

                    $registrar_agendas = $this->ejecutarConsulta($registrar_agendas_query);
                    
                    foreach ($personasGrupal as $persona) {
                        $sentencia_ag_persona = "INSERT INTO `agenda_personas`( `id_agenda`, `num_identificacion_persona`) VALUES ('$id_agenda','$persona')";
                        $registrar_ag_persona = $this->ejecutarConsulta($sentencia_ag_persona);
                    }

                    $mensaje = [
                        "titulo" => "Checkbox  agenda grupal " .$personasGrupal[1]."" ,
                        "mensaje" => "La agenda fue registrada con éxito.",
                        "icono" => "success",
                        "tipoMensaje" => "normal"
                    ];
                    echo json_encode($mensaje);
                    exit();
                }
            }else {
                $registrar_agendas_query = "INSERT INTO `agendas`(`id_agendas`, `titulo_agenda`, `descripcion_agenda`, `num_documento_persona`, `fecha_hora_registro`, `fecha_hora_agenda`, `estado_agenda`, `placa_vehiculo`, `tipo_vehiculo`) 
                VALUES ('$id_agenda', '$titulo_agenda', '$descripcion_agenda', '$numero_documento', '$fecha_hora_actual', '$fecha_agenda_format', 'ACTIVA', " . 
                (!empty($placa_vehiculo) ? "'$placa_vehiculo'" : "NULL") . ", " . 
                (!empty($tipo_vehiculo) ? "'$tipo_vehiculo'" : "NULL") . ")";

                $registrar_agendas = $this->ejecutarConsulta($registrar_agendas_query);

                if ($registrar_agendas) {
                    $mensaje = [
                        "titulo" => "Agenda registrada",
                        "mensaje" => "La agenda fue registrada con éxito.",
                        "icono" => "success",
                        "tipoMensaje" => "normal"
                    ];
                    return json_encode($mensaje);
                    exit();
                } else {
                    $mensaje = [
                        "titulo" => "Error al registrar",
                        "mensaje" => "Algo salió mal al registrar la agenda. Intenta de nuevo más tarde.",
                        "icono" => "error",
                        "tipoMensaje" => "normal"
                    ];
                    return json_encode($mensaje);
                    exit();
                }
            }

            
        }
    }
    public function buscarPersonaDocumento(){
        
            header('Content-Type: application/json');
                                
            
            if (!isset($_POST['documento']) || empty($_POST['documento'])) {
                $respuesta = [
                    "titulo" => "Campo vacío",
                    "mensaje" => "El documento es obligatorio para realizar la búsqueda.",
                    "icono" => "error",
                    "tipoMensaje" => "normal"
                ];
                echo json_encode($respuesta);
                exit();
            }
        
            
            $documento = $this->limpiarDatos($_POST['documento']);
            if ($this->verificarDatos('[0-9]{6,15}', $documento)) {
                $respuesta = [
                    "titulo" => "Formato inválido ",
                    "mensaje" => "El número de documento ingresado no cumple con el formato permitido.",
                    "icono" => "error",
                    "tipoMensaje" => "normal"
                ];
                echo json_encode($respuesta);
                exit();
            }
        
            $datos_persona = $this->consultarDatosUsuario($documento, ["nombres", "apellidos", "tipo_documento", "num_identificacion"]);
        
            if (!$datos_persona || $datos_persona[0] == "no_encontrado") {
                if (isset($_POST['masivo']) && $this->limpiarDatos($_POST['masivo']) == 'masivo' ) {
                    if (!isset(
                            $_POST['campo_0'],
                            $_POST['campo_1'],
                            $_POST['campo_2'],
                            $_POST['campo_3']
                        ) ||
                        $_POST['campo_0'] == "" ||
                        $_POST['campo_1'] == "" ||
                        $_POST['campo_2'] == "" ||
                        $_POST['campo_3'] == ""
                    ) {
                        $mensaje = [
                            "titulo" => "Error",
                            "mensaje" => "Lo sentimos, ha ocurrido un error con alguno de los datos. Inténtalo de nuevo más tarde.",
                            "icono" => "error",
                            "tipoMensaje" => "normal"
                        ];
                        echo json_encode($mensaje);
                        exit();
                    
                    }else {
                        
                        $tipo_documuneto = $this->limpiarDatos($_POST['campo_0']); // Tipo de Documento
                        $numero_identidad= $this->limpiarDatos($_POST['campo_1']); // Número de Identidad
                        $nombres = $this->limpiarDatos($_POST['campo_2']); // Nombres
                        $apellidos = $this->limpiarDatos($_POST['campo_3']); // Apellidos
                        if (isset($_POST['campo_4'],$_POST['campo_5'])) {
                            $correo = $this->limpiarDatos($_POST['campo_4']); // Correo
                            $telefono = $this->limpiarDatos($_POST['campo_5']); // Teléfono
                        }else{
                            
                            $correo = '0AG'; // Correo
                            $telefono = '0AG'; // Teléfono
                        }
                        $fecha_hora_actual = date('Y-m-d H:i:s');
                        $registra_ag_prs_sent = "INSERT INTO `visitantes`( `tipo_documento`, `num_identificacion`, `nombres`, `apellidos`, `correo`, `telefono`, `estado`,  `permanencia`, `fecha_hora_registro`) VALUES ('$tipo_documuneto','$numero_identidad','$nombres','$apellidos','$correo','$telefono','ACTIVO','FUERA','$fecha_hora_actual')";

                        $registro_prs = $this->ejecutarInsert($registra_ag_prs_sent);


						if ($registro_prs != 1) {
							$respuesta  = [
								"codigo" => "ERROR",
								"titulo" => "error",
								"mensaje" => "Ha ocurrido un error a la hora de registar " . $numero_identidad . " " . $nombres,
								"icono" => "error",
								"tipoMensaje" => "normal"
							];
						}else {
							$respuesta  = [
								"codigo" => "RVAEX",
								"titulo" => "Registro Exitoso",
								"mensaje" => "El Vehiculo se modifico correctamente en la base de datos.",
								"icono" => "success",
								"tipoMensaje" => "normal"
							];
						}

                    }
                } else {
                    $respuesta=[
                      "codigo" => "UNEBD",
                      "titulo"=>"Usuario No Registrado.<br> Lo sentimos",
                      "mensaje"=>"El usuario con número de documento $documento no se encuentra registrado en Cerberus.  ¿Deseas Registrarlo como VISITANTE?",
                      "icono"=> "info",
                      "tituloModal"=>"Registro Visitante",
                      "adaptar"=>"none",
                      "url"=> APP_URL_BASE."app/views/inc/modales/modal-registro-visitante.php",
                      "tipoMensaje"=>"normal_redireccion"
                    ];
                }
            }else{
                $respuesta = [
                    "codigo" => "RVAEX",
                    "nombre" => "".$datos_persona[2]['nombres']."",
                    "apellidos" => "".$datos_persona[2]['apellidos']."",
                    "tipo_documento" => "".$datos_persona[2]['tipo_documento']."",
                    "num_identificacion" => "".$datos_persona[2]['num_identificacion'].""
                ];
            }
            // Devolver la respuesta
            echo json_encode($respuesta);
            exit();
            }
    }

