<?php


    namespace app\controllers; 
	use app\models\mainModel;
	
	class ContadorController extends mainModel {

        public function contador(){
			$totales = [
				'aprendices' => 0,
				'funcionarios' => 0,
				'vigilantes' => 0,
				'visitantes' => 0,
				'vehiculos_personas' => 0
			];
		
			$tablas = [
				'aprendices',
				'funcionarios',
				'vigilantes',
				'visitantes',
				'vehiculos_personas'
			];
		
			$total_general = 0;
			$total_personas = 0;
			for ($i = 0; $i < count($totales); $i++) { 
				if ($tablas[$i] == 'vehiculos_personas') {
					$sentencia = "SELECT COUNT(num_identificacion_persona) AS contador FROM vehiculos_personas WHERE permanencia = 'DENTRO'";
					$contador = $this->ejecutarConsulta($sentencia);
					$contador_resultado = $contador->fetch_assoc();
					$totales['vehiculos_personas'] = $contador_resultado['contador'];
		
				} else {
					$sentencia = "SELECT COUNT(num_identificacion) AS contador FROM $tablas[$i] WHERE permanencia = 'DENTRO'";
					$contador = $this->ejecutarConsulta($sentencia);
					$contador_resultado = $contador->fetch_assoc();
					$totales[$tablas[$i]] = $contador_resultado['contador'];
					$total_personas += $totales[$tablas[$i]];
				}
				
				$total_general += $totales[$tablas[$i]];
				
			}
		
			
			$porcentajes = [];
			foreach ($totales as $tipo => $cantidad) {
				if ($tipo == 'vehiculos_personas') {
					$porcentajes[$tipo] = $total_general > 0 ? ($totales[$tipo] / $total_personas) * 100 : 0;
				}else {
					$porcentajes[$tipo] = $total_personas > 0 ? ($cantidad / $total_personas) * 100 : 0;
				}
			}
		
			return json_encode( [
				'conteoUnitarioGeneral' => $totales,//Conteo de cada dato Ej: Aprendices => 4, funcionario => 5... etc
				'porcentajesPersonasVehiculos' => $porcentajes,//Posentajes de cada uno de los tipos de usuarios DENTRO del CAB Ej: de 1000 personas dentro el 15% son visitantes y del total general a que porcentaje pertenecen los vehiculos
				'totalGeneral' => $total_general, //Numero de personas dentro incluyendo los vehiculos
				'totalPersonasDentro' => $total_personas
			]);
        }

		public function listadoUltimosReportesController() {
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
		
				$sentencia = "SELECT num_identificacion_persona, 
									tipo_reporte, 
									fecha_hora_reporte,
									'No Aplica' AS placa_vehiculo,
									'No Aplica' AS rol_en_el_vehiculo,
									rol_usuario
								FROM reporte_entrada_salida

								UNION ALL

								SELECT num_identificacion_persona, 
									tipo_reporte AS tipo_reporte, 
									fecha_hora_reporte,
									COALESCE(placa_vehiculo, 'No Aplica') AS placa_vehiculo,
									COALESCE(rol_en_el_vehiculo, 'No Aplica') AS rol_en_el_vehiculo,
									rol_usuario
								FROM reporte_entrada_salida_vehicular

								ORDER BY fecha_hora_reporte DESC
								LIMIT 10;";
				$ejecucionSentencia = $this->ejecutarConsulta($sentencia);
		
				if (!$ejecucionSentencia) {
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
					if ($ejecucionSentencia->num_rows < 1) {
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
					} else {
						// Construcción de datos
						if ($tipo_listado == 'tabla') {
							$output['listado']= '
								<table class="table">
									<thead class="head-table">
										<tr>
											<th>Fecha y Hora</th>
											<th class="td-tipo-doc">Tipo Doc.</th>
											<th>Identificacion</th>
											<th>Nombres</th>
											<th>Apellidos</th>
											<th>Tipo Persona</th>
											<th>Vehiculo</th>
										</tr>
									</thead>
									<tbody class="body-table">';
							while ($datos = $ejecucionSentencia->fetch_object()) {
								$consultar_datos=$this->consultarDatosUsuario($datos->num_identificacion_persona, ["nombres","apellidos","tipo_documento"]);
								$output['listado'] .= '
													<tr>
														<td>'.$datos->fecha_hora_reporte.'</td>
														<td class="td-tipo-doc">'.$datos->tipo_reporte.'</td>
														<td>'.$datos->num_identificacion_persona.'</td>
														<td>'.$consultar_datos[2]["nombres"].'</td>
														<td>'.$consultar_datos[2]["apellidos"].'</td>
														<td>'.TIPOS_ROL_USUARIO["$datos->rol_usuario"].'</td>
														<td>'.$datos->placa_vehiculo.'</td>
													</tr>';
							}
							$output['listado'] .= '</tbody></table>';
						} elseif ($tipo_listado == 'card') {
							while ($datos = $ejecucionSentencia->fetch_object()) {
								$consultar_datos=$this->consultarDatosUsuario($datos->num_identificacion_persona,["nombres","apellidos","tipo_documento"]);

								$output['listado'] .= '
								<div class="document-card" onclick="toggleCard(this)">
									<div class="card-header">
										<div>
											<p class="document-title">'.$consultar_datos[2]["nombres"]." ".$consultar_datos[2]["apellidos"].'</p>
											<p class="document-meta">'.$consultar_datos[2]["tipo_documento"].': '.$datos->num_identificacion_persona. ' | ' .$datos->tipo_reporte.'</p>
										</div>
										<span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
									</div>
									<div class="card-details">
										<p><strong>Fecha y Hora: </strong>'.$datos->fecha_hora_reporte.'</p>
										<p><strong>Tipo Persona:</strong>'.TIPOS_ROL_USUARIO["$datos->rol_usuario"].'</p>
										<p><strong>Vehículo:</strong>'.$datos->placa_vehiculo.'</p>
										<p><strong>Rol:</strong>'.$datos->rol_en_el_vehiculo.'</p>
									</div>
								</div>';
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

		public function conteosGraficaController() {
			header('Content-Type: application/json; charset=UTF-8');
		
			// Obtener la fecha desde el POST o usar la fecha actual por defecto
			$fecha =  date('Y-m-d');
			$datosGrafica = [
				'etiquetas' => [],
				'datos' => []
			];
		
			// Consulta SQL para obtener los datos agrupados por hora
			$sentencia = "
			SELECT 
				h.hora AS hora,
				COALESCE(COUNT(r.fecha_hora_reporte), 0) + COALESCE(COUNT(rv.fecha_hora_reporte), 0) AS total
			FROM (
				SELECT 0 AS hora UNION ALL
				SELECT 1 UNION ALL
				SELECT 2 UNION ALL
				SELECT 3 UNION ALL
				SELECT 4 UNION ALL
				SELECT 5 UNION ALL
				SELECT 6 UNION ALL
				SELECT 7 UNION ALL
				SELECT 8 UNION ALL
				SELECT 9 UNION ALL
				SELECT 10 UNION ALL
				SELECT 11 UNION ALL
				SELECT 12 UNION ALL
				SELECT 13 UNION ALL
				SELECT 14 UNION ALL
				SELECT 15 UNION ALL
				SELECT 16 UNION ALL
				SELECT 17 UNION ALL
				SELECT 18 UNION ALL
				SELECT 19 UNION ALL
				SELECT 20 UNION ALL
				SELECT 21 UNION ALL
				SELECT 22 UNION ALL
				SELECT 23
			) h
			LEFT JOIN reporte_entrada_salida r 
				ON HOUR(r.fecha_hora_reporte) = h.hora 
				AND DATE(r.fecha_hora_reporte) = '2024-11-18'
			LEFT JOIN reporte_entrada_salida_vehicular rv
				ON HOUR(rv.fecha_hora_reporte) = h.hora
				AND DATE(rv.fecha_hora_reporte) = '2024-11-18'
			GROUP BY h.hora
			ORDER BY h.hora;
			";
		
			// Ejecutar la consulta
			$stmt = $this->ejecutarConsulta($sentencia);
		
			if (!$stmt) {
				// Manejo de error al ejecutar la consulta
				http_response_code(500);
				echo json_encode(['error' => 'Error al obtener los datos para la gráfica']);
				exit;
			}
		
			// Procesar los resultados y construir el formato AM/PM dentro del while
			while ($row = $stmt->fetch_assoc()) {
				$hora = (int) $row['hora'];
				$sufijo = $hora >= 12 ? 'PM' : 'AM';
				$horaFormateada = $hora % 12;
				if ($horaFormateada === 0) {
					$horaFormateada = 12; // Ajuste para las 12 AM/PM
				}
				$datosGrafica['etiquetas'][] = $horaFormateada . $sufijo; // Etiqueta con formato AM/PM
				$datosGrafica['datos'][] = (int) $row['total'];  // Total de reportes
			}
		
			echo json_encode($datosGrafica, JSON_UNESCAPED_UNICODE);
		}
		public function conteosGraficaPersonasController() {
			header('Content-Type: application/json; charset=UTF-8');
			if (isset($_POST['rol_usuario']) && $_POST['rol_usuario']) {
				$rol_user = $this->limpiarDatos($_POST['rol_usuario']);
			}else {
				$rol_user = 'AP';
			}
			// Obtener la fecha desde el POST o usar la fecha actual por defecto
			$fecha =  date('Y-m-d');
			$datosGrafica = [
				'etiquetas' => [],
				'datos' => []
			];
		
			// Consulta SQL para obtener los datos agrupados por hora
			if ($rol_user == 'VH') {
				$sentencia = "
						SELECT 
							h.hora AS hora,
							COALESCE(COUNT(r.fecha_hora_reporte), 0) AS total
						FROM (
							SELECT 0 AS hora UNION ALL
							SELECT 1 UNION ALL
							SELECT 2 UNION ALL
							SELECT 3 UNION ALL
							SELECT 4 UNION ALL
							SELECT 5 UNION ALL
							SELECT 6 UNION ALL
							SELECT 7 UNION ALL
							SELECT 8 UNION ALL
							SELECT 9 UNION ALL
							SELECT 10 UNION ALL
							SELECT 11 UNION ALL
							SELECT 12 UNION ALL
							SELECT 13 UNION ALL
							SELECT 14 UNION ALL
							SELECT 15 UNION ALL
							SELECT 16 UNION ALL
							SELECT 17 UNION ALL
							SELECT 18 UNION ALL
							SELECT 19 UNION ALL
							SELECT 20 UNION ALL
							SELECT 21 UNION ALL
							SELECT 22 UNION ALL
							SELECT 23
						) h
						LEFT JOIN reporte_entrada_salida_vehicular r 
							ON HOUR(r.fecha_hora_reporte) = h.hora 
						AND DATE(r.fecha_hora_reporte) = '2024-11-18'
						GROUP BY h.hora
						ORDER BY h.hora;
						";
			}else{
				$sentencia = "
					SELECT 
						h.hora AS hora,
						COALESCE(COUNT(r.fecha_hora_reporte), 0) + COALESCE(COUNT(rv.fecha_hora_reporte), 0) AS total
					FROM (
						SELECT 0 AS hora UNION ALL
						SELECT 1 UNION ALL
						SELECT 2 UNION ALL
						SELECT 3 UNION ALL
						SELECT 4 UNION ALL
						SELECT 5 UNION ALL
						SELECT 6 UNION ALL
						SELECT 7 UNION ALL
						SELECT 8 UNION ALL
						SELECT 9 UNION ALL
						SELECT 10 UNION ALL
						SELECT 11 UNION ALL
						SELECT 12 UNION ALL
						SELECT 13 UNION ALL
						SELECT 14 UNION ALL
						SELECT 15 UNION ALL
						SELECT 16 UNION ALL
						SELECT 17 UNION ALL
						SELECT 18 UNION ALL
						SELECT 19 UNION ALL
						SELECT 20 UNION ALL
						SELECT 21 UNION ALL
						SELECT 22 UNION ALL
						SELECT 23
					) h
					LEFT JOIN reporte_entrada_salida r 
						ON HOUR(r.fecha_hora_reporte) = h.hora 
						AND DATE(r.fecha_hora_reporte) = '$fecha'
						AND r.rol_usuario = '$rol_user'
					LEFT JOIN reporte_entrada_salida_vehicular rv
						ON HOUR(rv.fecha_hora_reporte) = h.hora
						AND DATE(rv.fecha_hora_reporte) = '$fecha'
						AND rv.rol_usuario = '$rol_user'
					GROUP BY h.hora
					ORDER BY h.hora;
				";

			}
			
		
			// Ejecutar la consulta
			$stmt = $this->ejecutarConsulta($sentencia);
		
			if (!$stmt) {
				// Manejo de error al ejecutar la consulta
				http_response_code(500);
				echo json_encode(['error' => 'Error al obtener los datos para la gráfica']);
				exit;
			}
		
			// Procesar los resultados y construir el formato AM/PM dentro del while
			while ($row = $stmt->fetch_assoc()) {
				$hora = (int) $row['hora'];
				$sufijo = $hora >= 12 ? 'PM' : 'AM';
				$horaFormateada = $hora % 12;
				if ($horaFormateada === 0) {
					$horaFormateada = 12; // Ajuste para las 12 AM/PM
				}
				$datosGrafica['etiquetas'][] = $horaFormateada . $sufijo; // Etiqueta con formato AM/PM
				$datosGrafica['datos'][] = (int) $row['total'];  // Total de reportes
			}
		
			echo json_encode($datosGrafica, JSON_UNESCAPED_UNICODE);
		}
		
    }
