<?php

    namespace app\controllers; 
	use app\models\mainModel;
	
	class NovedadController extends mainModel {
        public function listarNovedadesController(){
            header('Content-Type: application/json'); 
       
            $columnas = [
                "contador_id_novedad",
                "fecha_hora_novedad",
                "descripcion_agenda",
                "usuario_registro_novedad",
                "puerta_de_novedad",
                "tipo_novedad",
                "num_identificacion_causante",
                "id_reporte_ingreso_salida",
                "puerta_registro_novedad",
                "fecha_de_suceso"
            ];

            $tabla = "novedades_e_s";
            $id = 'contador_id_novedad';
            if (isset($_POST['tipo_novedad']) && $_POST['tipo_novedad'] !=  "" ) {
                if ($_POST['tipo_novedad'] == "ES") {
                    $tabla = "novedades_e_s";
                }elseif ($_POST['tipo_novedad'] == "PR") {
                    $tabla = "novedades_permanencia";	
                    $id = 'contador_novedades';
                    
       
                    $columnas = [
                         "contador_novedades",
                         "num_identificacion_persona",
                         "fecha_hora_novedad",
                         "descripcion_novedad",
                         "usuario_registro_novedad",
                         "puerta_registro_novedad",
                         "tipo_novedad",
                         "num_identificacion_causante",
                         "estado_novedad"
                    ];
                }else{
                    $tabla = "novedades_e_s";
                    $id = 'contador_id_novedad';
                }
            }
            
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
            $buscar_visitantes = $this->ejecutarConsulta($sentencia);
            $numero_registros = $buscar_visitantes->num_rows;

            
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
            if (!$buscar_visitantes){
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
                                                <th>Fecha y Hora Último Ingreso</th>
                                                <th>Permanencia</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body-table" id="listado_visitantes">
                                        <tr><td colspan="9">Error al cargar los visitantes</td></tr>
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
                if ($_POST['tipo_novedad'] == 'PR') {
                    /* Novedades de entrada y salida */
                    if ($buscar_visitantes->num_rows < 1) {
                        $output['data'] = $tipo_listado == 'tabla' 
                        ? '
                                        <table class="table">
                                            <thead class="head-table">
                                                <tr>
                                                    <th>Fecha Novedad</th>
                                                    <th>Descripcion</th>
                                                    <th>N. Identificacion Causante</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Tipo de Novedad</th>
                                                    <th>Num identidad Usuario</th>
                                                </tr>
                                            </thead>
                                            <tbody class="body-table" id="listado_visitantes">
                                            <tr><td colspan="7">No se encontraron Novedades</td></tr>
                                            </tbody>
                                            </table>'
                        :'
                        <div class="document-card">
                            <div class="card-header">
                                <div>
                                    <p class="document-meta">No se encontraron novedades</p>
                                </div>
                            </div>
                        </div>';
                    } else{
                        if ($tipo_listado == 'tabla') {
                            $output['data'] = '
                                        <table class="table">
                                            <thead class="head-table">
                                                <tr>
                                                    <th>Fecha Novedad</th>
                                                    <th>Descripcion</th>
                                                    <th>N. Identificacion Causante</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Tipo de Novedad</th>
                                                    <th>Num identidad Usuario</th>
                                                </tr>
                                            </thead>
                                            <tbody class="body-table" id="listado_visitantes">
                                        ';
        
                            while ($datos = $buscar_visitantes->fetch_object()) {
                                
                                $consultar_datos=$this->consultarDatosUsuario($datos->num_identificacion_causante, ["nombres","apellidos","tipo_documento", "num_identificacion", "permanencia", "telefono"]);

                                $output['data'].='
                                        <td>'.$datos->fecha_hora_novedad.'</td>
                                        <td>'.$datos->descripcion_novedad.'</td>
                                        <td>'.$datos->num_identificacion_causante.'</td>
                                        <td>'.$consultar_datos[2]["nombres"].'</td>
                                        <td>'.$consultar_datos[2]["apellidos"].'</td>
                                        <td>'.$datos->tipo_novedad.'</td>
                                        <td>'.$datos->usuario_registro_novedad.'</td>
                                        <td class="contenedor-colum-accion">
                                            <a href="'.APP_URL_BASE.'editar-visitante/'.$datos->contador_novedades.'/" class="button is-info is-rounded is-small">
                                                Editar
                                            </a>
                                        </td>
                                    </tr>
                                ';
                            }
                            $output['data'] .= '</tbody></table>';
                        }elseif ($tipo_listado == 'card') {
                            
                            while ($datos = $buscar_visitantes->fetch_object()) {
                                
                                $consultar_datos=$this->consultarDatosUsuario($datos->num_identificacion_causante, ["nombres","apellidos","tipo_documento", "num_identificacion", "permanencia", "telefono"]);
                                
    

                                $output['data'].= '
                                    <div class="document-card" onclick="toggleCard(this)">
                                        <div class="card-header">
                                            <div>
                                                <p class="document-title">'.$datos->tipo_novedad.'</p>
                                                <p class="document-meta">Causante: '.$datos->num_identificacion_causante. ' | ' .$consultar_datos[2]["nombres"].'</p>
                                            </div>
                                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                                        </div>
                                        <div class="card-details">
                                            <p><strong>Fecha y Hora: </strong>'.$datos->fecha_hora_novedad.'</p>
                                            <p><strong>Num id Usuario: </strong>'.$datos->usuario_registro_novedad.'</p>
                                            <p>Descripcion:</p>
                                            <p>'.$datos->descripcion_novedad.'</p>
                                        </div>
                                        
                                        
                                        <div class="contenedor-acciones">
                                            
                                            <a class="btn-cards" href="'.APP_URL_BASE.'editar-visitante/'.$datos->contador_novedades.'/" >
                                                <p>
                                                    Editar
                                                </p>
                                            </a>
                                        </div>
                                    </div>';
                            }
                        }
    
    
                    }
                }else {
                    /* Novedades de entrada y salida */
                    if ($buscar_visitantes->num_rows < 1) {
                        $output['data'] = $tipo_listado == 'tabla' 
                        ? '
                                        <table class="table">
                                            <thead class="head-table">
                                                <tr>
                                                    <th>Fecha Novedad</th>
                                                    
                                                    <th>Descripcion</th>
                                                    <th>N. Identificacion Causante</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Tipo de Novedad</th>
                                                    <th>Fecha de Suceso</th>
                                                    <th>Num identidad Usuario</th>
                                                </tr>
                                            </thead>
                                            <tbody class="body-table" id="listado_visitantes">
                                            <tr><td colspan="8">No se encontraron Novedades</td></tr>
                                            </tbody>
                                            </table>'
                        :'
                        <div class="document-card">
                            <div class="card-header">
                                <div>
                                    <p class="document-meta">No se encontraron novedades</p>
                                </div>
                            </div>
                        </div>';
                    } else{
                        if ($tipo_listado == 'tabla') {
                            $output['data'] = '
                                        <table class="table">
                                            <thead class="head-table">
                                                <tr>
                                                    <th>Fecha Novedad</th>
                                                    <th>Descripcion</th>
                                                    <th>N. Identificacion Causante</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Tipo de Novedad</th>
                                                    <th>Fecha de Suceso</th>
                                                    <th>Num identidad Usuario</th>
                                                </tr>
                                            </thead>
                                            <tbody class="body-table" id="listado_visitantes">
                                        ';
        
                            while ($datos = $buscar_visitantes->fetch_object()) {
                                
                                $consultar_datos=$this->consultarDatosUsuario($datos->num_identificacion_causante, ["nombres","apellidos","tipo_documento", "num_identificacion", "permanencia", "telefono"]);
    
                                $output['data'].='
                                        <td>'.$datos->fecha_hora_novedad.'</td>
                                        <td>'.$datos->descripcion_agenda.'</td>
                                        <td>'.$datos->num_identificacion_causante.'</td>
                                        <td>'.$consultar_datos[2]["nombres"].'</td>
                                        <td>'.$consultar_datos[2]["apellidos"].'</td>
                                        <td>'.$datos->tipo_novedad.'</td>
                                        <td>'.$datos->fecha_de_suceso.'</td>
                                        <td>'.$datos->usuario_registro_novedad.'</td>
                                        <td class="contenedor-colum-accion">
                                            <a href="'.APP_URL_BASE.'editar-visitante/'.$datos->contador_id_novedad.'/" class="button is-info is-rounded is-small">
                                                Editar
                                            </a>
                                        </td>
                                    </tr>
                                ';
                            }
                            $output['data'] .= '</tbody></table>';
                        }elseif ($tipo_listado == 'card') {
                            
                            while ($datos = $buscar_visitantes->fetch_object()) {
                                
                                $consultar_datos=$this->consultarDatosUsuario($datos->num_identificacion_causante, ["nombres","apellidos","tipo_documento", "num_identificacion", "permanencia", "telefono"]);
                                
                                $output['data'].= '
                                    <div class="document-card" onclick="toggleCard(this)">
                                        <div class="card-header">
                                            <div>
                                                <p class="document-title">'.$datos->tipo_novedad.'</p>
                                                <p class="document-meta">Causante: '.$datos->num_identificacion_causante. ' | ' .$consultar_datos[2]["nombres"].'</p>
                                            </div>
                                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                                        </div>
                                        <div class="card-details">
                                            <p><strong>Fecha y Hora: </strong>'.$datos->fecha_hora_novedad.'</p>
                                            <p><strong>Num id Usuario: </strong>'.$datos->usuario_registro_novedad.'</p>
                                            <p>Descripcion:</p>
                                            <p>'.$datos->descripcion_agenda.'</p>
                                        </div>
                                        
                                        
                                        <div class="contenedor-acciones">
                                            
                                            <a class="btn-cards" href="'.APP_URL_BASE.'editar-visitante/'.$datos->contador_id_novedad.'/" >
                                                <p>
                                                    Editar
                                                </p>
                                            </a>
                                        </div>
                                    </div>';
                            }
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
    }