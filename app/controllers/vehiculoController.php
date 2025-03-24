<?php

	namespace app\controllers; 
	use app\models\mainModel;
	
	class VehiculoController extends mainModel {
		public function registrarVehiculoControler(){
			if (!isset($_POST['placa_vehiculo_visitante'],$_POST['tipo_vehiculo_visitante'],$_POST['num_documento_visitante']) || $_POST['placa_vehiculo_visitante'] == "" || $_POST['num_documento_visitante'] == "" || $_POST['tipo_vehiculo_visitante'] == "" ) {
				$mensaje=[
					"titulo"=>"Error",
					"mensaje"=>"Lo sentimos, los datos necesarios para registrar el vehiculo son insuficientes.",
					"icono"=> "error",
					"tipoMensaje"=>"normal"
				];
				return json_encode($mensaje);
				exit();
			}else {
				

				$campos_invalidos = [];
				if ($this->verificarDatos('[0-9]{6,15}',$_POST['num_documento_visitante'])) {
					array_push($campos_invalidos, 'NUMERO DE DOCUMENTO');	
				}else {

					$num_documento_ps = $this->limpiarDatos($_POST['num_documento_visitante']); 
				}

				if ($this->verificarDatos('[A-Z]{2,}',$_POST['tipo_vehiculo_visitante'])) {
					array_push($campos_invalidos, 'TIPO DE VEHICULO');
				}else{
					$tipo_vehiculo_ps = $this->limpiarDatos($_POST['tipo_vehiculo_visitante']);
				}
				if ($this->verificarDatos('[A-Z0-9]{6,7}',$_POST['placa_vehiculo_visitante'])) {
					array_push($campos_invalidos, 'PLACA DE VEHICULO');
				}else {
					$placa_vehiculo_ps = $this->limpiarDatos($_POST['placa_vehiculo_visitante']);
				}


				
				if (count($campos_invalidos) > 0)  {
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

					for ($i=0; $i < 5; $i++) { 
						

						switch ($i) {
							case 0:
								$tipo_persona = 'Visitante';
								$consultar_persona ="SELECT num_identificacion FROM `visitantes` WHERE num_identificacion = '$num_documento_ps';";
								break;
							case 1:
								$tipo_persona = 'Visitante';
								$consultar_persona ="SELECT num_identificacion FROM `visitantes` WHERE num_identificacion = '$num_documento_ps';";
								break;
							case 2:
								$tipo_persona = 'Funcionario';
								$consultar_persona ="SELECT num_identificacion FROM `funcionarios` WHERE num_identificacion = '$num_documento_ps';";
								break;
								
							case 3:
								$tipo_persona = "Vigilante";
								$consultar_persona ="SELECT num_identificacion FROM `vigilantes` WHERE num_identificacion = '$num_documento_ps';";
								break;
							
							case 4:
								$tipo_persona =  "Aprendiz";
								$consultar_persona ="SELECT num_identificacion FROM `aprendices` WHERE num_identificacion = '$num_documento_ps';";
								break;
								
							default:
								$mensaje=[
									"titulo"=>"No lo encontramos!",
									"mensaje"=>"Lo sentimos, no locagramos encontralo.",
									"icono"=> "error",
									"tipoMensaje"=>"normal"
								];
								return json_encode($mensaje);
							
							}
						$buscar_persona = $this->ejecutarConsulta($consultar_persona);

						if (!$buscar_persona) {
							$mensaje=[
								"titulo"=>"Error de Conexion",
								"mensaje"=>"Lo sentimos, algo salio mal con la conexion por favor intentalo de nuevo mas tarde.",
								"icono"=> "error",
								"tipoMensaje"=>"normal"
							];
							return json_encode($mensaje);
							break;
						}else {
							if ($buscar_persona->num_rows > 0) {
								break;
							}
						}
						
					}

					if (!$buscar_persona) {
						$mensaje=[
							"titulo"=>"Error de Conexion",
							"mensaje"=>"Lo sentimos, algo salio mal con la conexion por favor intentalo de nuevo mas tarde.",
							"icono"=> "error",
							"tipoMensaje"=>"normal"
						];
						return json_encode($mensaje);
					}else {
						if ($buscar_persona->num_rows < 1) {
							$mensaje=[
								"titulo"=>"Usuario No Registrado.<br> Lo sentimos",
								"mensaje"=>"El usuario con número de documento $num_documento_ps se encuentra registrado en Cerberus.  ¿Deseas Registrarlo como VISITANTE?",
								"icono"=> "info",
								"tituloModal"=>"Registro Visitante",
								"adaptar"=>"none",
								"url"=> APP_URL_BASE."app/views/inc/modales/modal-registro-visitante.php",
								"tipoMensaje"=>"normal_redireccion"
							];
							return json_encode($mensaje);
							exit();	
						}else {
			
							$registrar_vehiculo = $this->registrarNuevoVehiculo($_POST['placa_vehiculo_visitante'],$_POST['tipo_vehiculo_visitante'],$_POST['num_documento_visitante'], $_SESSION['datos_usuario']['num_identificacion']);
							if (!$registrar_vehiculo) {
								$mensaje=[
									"titulo"=>"Error",
									"mensaje"=>"Lo sentimos, no nos pudimos conectar a la base de datos intentalo de nuevo mas tarde.",
									"icono"=> "error",
									"tipoMensaje"=>"normal"
								];
								return json_encode($registrar_vehiculo);
								exit();
							}else { 
								$mensaje=[
									"titulo"=>"Registro Exitoso",
									"mensaje"=>"Genial el registro a sido exitoso.",
									"icono"=> "success",
									"tipoMensaje"=>"normal"
								];
								return json_encode($registrar_vehiculo);
								exit();
							}
						}
					}

				}
				
			}
		}

		public function listarVehiculosControler(){
			
            $tipo_listado = $this->limpiarDatos($_POST['tipoListado']);
            unset($_POST['tipoListado']);
			$sentencia_vehiculos = "SELECT placa_vehiculo, tipo_vehiculo, fecha_hora_ultimo_ingreso, permanencia FROM vehiculos_personas GROUP BY placa_vehiculo;";

			$listado_vehiculos = $this->ejecutarConsulta($sentencia_vehiculos);
			unset($sentencia_vehiculos);

			$output['data'] = '';
			if (!$listado_vehiculos) {
				$output['data'] = $tipo_listado == 'tabla' 
                    ? '
                                    <table class="table">
                                        <thead class="head-table">
                                            <tr>
                                                <th>Placa Vehiculo</th>
                                                <th>Tipo Vehiculo</th>
                                                <th>Ultimo Reporte</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-table" id="listado_vehiculos">
                                        <tr><td colspan="4">Error al cargar los vehiculos</td></tr>
                                        </tbody>
                                        </table>' 
                    : '
                    <div class="document-card">
                        <div class="card-header">
                            <div>
                                <p class="document-title">Error al cargar los vehiculos</p>
                                <p class="document-meta">Error al cargar los vehiculos</p>
                            </div>
                        </div>
                    </div>';
			}else {
				if ($listado_vehiculos->num_rows < 1) {
					
                    $output['data'] = $tipo_listado == 'tabla' 
                    ? '
                                    <table class="table">
                                        <thead class="head-table">
                                            <tr>
                                                <th>Placa Vehiculo</th>
                                                <th>Tipo Vehiculo</th>
                                                <th>Ultimo Reporte</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-table" id="listado_vehiculos">
                                        <tr><td colspan="5">No se encontraron Vehiculos</td></tr>
                                        </tbody>
                                        </table>'
                    :'
                    <div class="document-card">
                        <div class="card-header">
                            <div>
                                <p class="document-meta">No se encontraron Vehiculos</p>
                            </div>
                        </div>
                    </div>';
				}else {
					if ($tipo_listado == 'tabla') {
						$output['data'] = '
                                    <table class="table">
                                        <thead class="head-table">
                                            <tr>
                                                <th>Placa Vehiculo</th>
                                                <th>Tipo Vehiculo</th>
                                                <th>Ultimo Reporte</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-table" id="listado_vehiculos">
						';
						while ($datos = $listado_vehiculos->fetch_object() ) {
							$output['data'] .= '
								<tr id="'.$datos->placa_vehiculo.'">
									<td>'.$datos->placa_vehiculo.'</td>
									<td>'.TIPOS_VEHICULOS["$datos->tipo_vehiculo"].'</td>
									<td>'.$datos->fecha_hora_ultimo_ingreso.'</td>
									<td>'.$datos->permanencia.'</td>
									<td class="contenedor-colum-acciones">
                                        <a class="btn-cards" onclick="mostrarModalVehiPropietarios(\''.$datos->placa_vehiculo.'\')" >
                                            <p>
                                                Ver Propietarios
                                            </p>
                                        </a>
									</td>
								</tr>
							';
						}
                        $output['data'] .= '</tbody></table>';

					}elseif($tipo_listado == 'card') {
                        
                        while ($datos = $listado_vehiculos->fetch_object()) {
                            $output['data'].= '
								<div id="'.$datos->placa_vehiculo.'" class="document-card" onclick="toggleCard(this)">
									<div class="card-header">
										<div>
											<p class="document-title">'.$datos->placa_vehiculo.' | Tipo:' .TIPOS_VEHICULOS["$datos->tipo_vehiculo"].'</p>
											<p class="document-meta">Ultimo reporte: '.$datos->fecha_hora_ultimo_ingreso. ' | ' .$datos->permanencia.'</p>
										</div>
										<span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
									</div>
                                    
                                    <div class="contenedor-acciones">
                                        
                                        <a class="btn-cards" onclick="mostrarModalVehiPropietarios(\''.$datos->placa_vehiculo.'\')" >
                                            <p>
                                                Ver Propietarios
                                            </p>
                                        </a>
                                    </div>
								</div>';
                        }

					}
				}
				$listado_vehiculos->free();
				unset($listado_vehiculos);
				return json_encode($output, JSON_UNESCAPED_UNICODE);
			}
			
		}

		public function eliminarVehiculoControler(){

			if (!isset($_POST["placa_vahiculo_anterior"],$_POST["num_identidad"]) || $_POST["placa_vahiculo_anterior"] == "" ||$_POST["num_identidad"] == "") {
				
				$mensaje=[
					"titulo"=>"Error",
					"mensaje"=>"Lo sentimos, los datos necesarios para editar el vehiculo son insuficientes.",
					"icono"=> "error",
					"tipoMensaje"=>"normal"
				];
				return json_encode($mensaje);
				exit();
			}else {
				$placa_vehiculo_anterior = $this->limpiarDatos($_POST["placa_vahiculo_anterior"]);
				$num_identidad = $this->limpiarDatos($_POST["num_identidad"]);
	
				$sentencia_vehiculos_edit = "DELETE FROM `vehiculos_personas` WHERE num_identificacion_persona = '$num_identidad' AND placa_vehiculo = '$placa_vehiculo_anterior';";

				
				$actualizar_vehiculo = $this->ejecutarConsulta($sentencia_vehiculos_edit);
				if (!$actualizar_vehiculo) {
					$mensaje = [
						"titulo" => "error",
						"mensaje" => "Ha ocurrido un error al intentar eliminarl el vehiculo $placa_vehiculo_anterior de el propietario $num_identidad",
						"icono" => "error",
						"tipoMensaje" => "normal"
					];
					echo json_encode($mensaje);
				}else {
					$mensaje = [
						"titulo" => "Eliminacion Completa",
						"mensaje" => "El Vehiculo se elimino correctamente en la base de datos.",
						"icono" => "success",
						"tipoMensaje" => "normal"
					];
					echo json_encode($mensaje);
				}
			}

		}
		
		public function editarVehiculoControler(){
			if (!isset($_POST["placa_vahiculo_anterior"],$_POST["num_identidad"],$_POST["placa_vahiculo_edit"],$_POST["tipo_vehiculo_edit"]) || $_POST["placa_vahiculo_anterior"] == "" ||$_POST["num_identidad"] == "" || $_POST["placa_vahiculo_edit"] == "" ||  $_POST["tipo_vehiculo_edit"] == "") {
					
				$mensaje=[
					"titulo"=>"Error",
					"mensaje"=>"Lo sentimos, los datos necesarios para editar el vehiculo son insuficientes.",
					"icono"=> "error",
					"tipoMensaje"=>"normal"
				];
				return json_encode($mensaje);
				exit();
			}else {
				$placa_vehiculo_anterior = $this->limpiarDatos($_POST["placa_vahiculo_anterior"]);
				$num_identidad = $this->limpiarDatos($_POST["num_identidad"]);
				$placa_vehiculo_edit = $this->limpiarDatos($_POST["placa_vahiculo_edit"]);
				$tipo_vehiculo_edit = $this->limpiarDatos($_POST["tipo_vehiculo_edit"]);

				$sentencia_vehiculos_edit = "UPDATE `vehiculos_personas` SET `placa_vehiculo`='$placa_vehiculo_edit', `tipo_vehiculo`='$tipo_vehiculo_edit' WHERE num_identificacion_persona = '$num_identidad' AND placa_vehiculo = '$placa_vehiculo_anterior';";

				
				$actualizar_vehiculo = $this->ejecutarInsert($sentencia_vehiculos_edit);
				if ($actualizar_vehiculo != 1) {
					$mensaje = [
						"titulo" => "error",
						"mensaje" => "Ha ocurrido un error a la hora de actualizar el vehiculo de el propietario $num_identidad",
						"icono" => "error",
						"tipoMensaje" => "normal"
					];
					echo json_encode($mensaje);
				}else {
					$mensaje = [
						"titulo" => "Eliminacion Completa",
						"mensaje" => "El Vehiculo se actualizo correctamente en la base de datos.",
						"icono" => "success",
						"tipoMensaje" => "normal"
					];
					echo json_encode($mensaje);
				}
			}
			
		}

		public function listarPropietariosVehiculosControler(){
			
            $tipo_listado = $this->limpiarDatos($_POST['tipoListado']);
            $placa_vehiculo = $this->limpiarDatos($_POST['placa_vehiculo']);
            unset($_POST['tipoListado']);
			$sentencia_vehiculos = "SELECT num_identificacion_persona, placa_vehiculo, tipo_vehiculo, fecha_hora_ultimo_ingreso, permanencia FROM vehiculos_personas WHERE placa_vehiculo = '$placa_vehiculo'";

			$listado_vehiculos = $this->ejecutarConsulta($sentencia_vehiculos);
			unset($sentencia_vehiculos);

			$output['data'] = '';
			if (!$listado_vehiculos) {
				$output['data'] = $tipo_listado == 'tabla' 
                    ? '
                                    <table class="table">
                                        <thead class="head-table">
                                            <tr>
                                                <th>Placa Vehiculo</th>
                                                <th>Tipo Vehiculo</th>
                                                <th>Ultimo Reporte</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-table" id="listado_vehiculos">
                                        <tr><td colspan="4">Error al cargar los vehiculos</td></tr>
                                        </tbody>
                                        </table>' 
                    : '
                    <div class="document-card">
                        <div class="card-header">
                            <div>
                                <p class="document-title">Error al cargar los vehiculos</p>
                                <p class="document-meta">Error al cargar los vehiculos</p>
                            </div>
                        </div>
                    </div>';
			}else {
				if ($listado_vehiculos->num_rows < 1) {
					
                    $output['data'] = $tipo_listado == 'tabla' 
                    ? '
                                    <table class="table">
                                        <thead class="head-table">
                                            <tr>
                                                <th>Placa Vehiculo</th>
                                                <th>Tipo Vehiculo</th>
                                                <th>Ultimo Reporte</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-table" id="listado_vehiculos">
                                        <tr><td colspan="5">No se encontraron Vehiculos</td></tr>
                                        </tbody>
                                        </table>'
                    :'
                    <div class="document-card">
                        <div class="card-header">
                            <div>
                                <p class="document-meta">No se encontraron Vehiculos</p>
                            </div>
                        </div>
                    </div>';
				}else {
					if ($tipo_listado == 'tabla') {
						$output['data'] = '
                                    <table class="table">
                                        <thead class="head-table">
                                            <tr>
                                                <th>Nombre y Apellidos</th>
                                                <th>No. Documento</th>
                                                <th>Telefono</th>
                                                <th>Estado Persona</th>
                                                <th>Estado Vehiculo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-table" id="listado_vehiculos">
						';
						while ($datos = $listado_vehiculos->fetch_object() ) {
							
							$consultar_datos=$this->consultarDatosUsuario($datos->num_identificacion_persona, ["nombres","apellidos","tipo_documento", "num_identificacion", "permanencia", "telefono"]);
							$output['data'] .= '
								<tr class="propietarios">
									<td>'.$consultar_datos[2]["nombres"].' '.$consultar_datos[2]["apellidos"].'</td>
									<td>'.$consultar_datos[2]["num_identificacion"].'</td>
									<td>'.$consultar_datos[2]["telefono"].'</td>
									<td>'.$consultar_datos[2]["permanencia"].'</td>
									<td>'.$datos->permanencia.'</td>
									<td class="contenedor-colum-acciones-ptr">
                                        <a class="btn-editar" onclick="mostrarModalVehiEditPropi(\''.$datos->placa_vehiculo.'\')" >
                                            <ion-icon name="create-outline"></ion-icon>
                                        </a>
                                        <a class="btn-cancelar-table" onclick="eliminarVehiculoPropietario(\''.$datos->placa_vehiculo.'\' , \''.$consultar_datos[2]["num_identificacion"].'\', \''.$consultar_datos[2]["nombres"].' '.$consultar_datos[2]["apellidos"].'\')" >
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </a>
									</td>
								</tr>
							';
						}
                        $output['data'] .= '</tbody></table>';

					}elseif($tipo_listado == 'card') {
                        
                        while ($datos = $listado_vehiculos->fetch_object()) {
							
							$consultar_datos=$this->consultarDatosUsuario($datos->num_identificacion_persona, ["nombres","apellidos","tipo_documento", "num_identificacion", "permanencia", "telefono",]);
                            $output['data'].= '
								<div class="document-card propietarios" onclick="toggleCard(this)">
									<div class="card-header">
										<div>
											<p class="document-title">'.$datos->placa_vehiculo.' | Tipo:' .TIPOS_VEHICULOS["$datos->tipo_vehiculo"].'</p>
											<p class="document-meta">Nombres: '.$consultar_datos[2]["nombres"].' '.$consultar_datos[2]["apellidos"].'</p>
										</div>
										<span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
									</div>
                                    
									<div class="card-details">
										<p><strong>'.$consultar_datos[2]["tipo_documento"].': </strong>'.$consultar_datos[2]["num_identificacion"].'</p>
										<p><strong>Telefono: </strong>'.$consultar_datos[2]["telefono"].'</p>
										<p><strong>Estado Persona:</strong>'.$consultar_datos[2]["permanencia"].'</p>
										<p><strong>Estado Vehiculo:</strong>'.$datos->permanencia.'</p>
									</div>

                                    <div class="contenedor-acciones">
                                        
                                        <a class="btn-editar" onclick="mostrarModalVehiEditPropi(\''.$datos->placa_vehiculo.'\')" >
                                            <ion-icon name="create-outline"></ion-icon>
                                        </a>
                                        <a class="btn-cancelar-table" onclick="eliminarVehiculoPropietario(\''.$datos->placa_vehiculo.'\' , \''.$consultar_datos[2]["num_identificacion"].'\', \''.$consultar_datos[2]["nombres"].' '.$consultar_datos[2]["apellidos"].'\')" >
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </a>
                                    </div>
								</div>';
                        }

					}
				}
				$listado_vehiculos->free();
				unset($listado_vehiculos);
				return json_encode($output, JSON_UNESCAPED_UNICODE);
			}
			
		}
	}