<?php

    namespace app\controllers;
    use app\models\mainModel;
    class AprendizController extends mainModel{

        public function registrarAprendizControlador(){
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                $mensaje=[
                    "titulo"=>"Peticion incorrecta",
                    "mensaje"=>"Lo sentimos, la accion que intentas realizar no es correcta",
                    "icono"=> "error",
                    "tipoMensaje"=>"redireccionar",
                    "url"=>"http://localhost/Adso04/PROYECTOS/cerberus/"
                ];
                return json_encode($mensaje);
            }else {
                $error=[];
                if (!isset($_POST['nombre_a'])||$_POST['nombre_a']==""||strlen($_POST['nombre_a'])<2||strlen($_POST['nombre_a'])>64) {
                    
                    array_push($error,"nombre(s)");

                } if (!isset($_POST['apellido_a'])||$_POST['apellido_a']==""||strlen($_POST['apellido_a'])<2||strlen($_POST['apellido_a'])>64) {

                    array_push($error,"apellidos(s)");

                } if (!isset($_POST['tipo_documento_a'])||$_POST['tipo_documento_a']=="") {

                    array_push($error,"tipo de documento");

                } if (!isset($_POST['numero_documento_a'])||$_POST['numero_documento_a']==""||strlen($_POST['numero_documento_a'])<6||strlen($_POST['numero_documento_a'])>16||$_POST['numero_documento_a']/1!=$_POST['numero_documento_a']) {

                    array_push($error,"numero de documento");

                } if (!isset($_POST['numero_ficha'])||$_POST['numero_ficha']=="") {

                    array_push($error,"numero de ficha");

                } if (!isset($_POST['email_a'])||$_POST['email_a']==""||strlen($_POST['email_a'])<8||strlen($_POST['email_a'])>88||$this->verificarDatos("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $_POST['email_a'])) {

                    array_push($error,"correo de electronico");

                } if (!isset($_POST['numero_a'])||$_POST['numero_a']==""||strlen($_POST['numero_a'])!=10) {

                    array_push($error,"numero de telfono");

                }

                if (count($error)!=0) {
                    $mensaje_str="";
                    for ($i=0; $i < count($error); $i++) {
                        $mensaje_str=$mensaje_str.$error[$i].", ";
                    }
                    $mensaje=[
                        "titulo"=>"Error de datos",
                        "mensaje"=>"Lo sentimos, los campos ".$mensaje_str." NO cumplen con los requisitos",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    unset($mensaje_str,$error);
                    return json_encode($mensaje);
                }else{

                    $numero_documento = trim($_POST['numero_documento_a']);

                    $sentencia_verificar_estado= "SELECT 'aprendices' AS tabla, num_identificacion, estado 
                    FROM aprendices 
                    WHERE num_identificacion = '$numero_documento' 
                    UNION ALL

                    SELECT 'vigilantes' AS tabla, num_identificacion, estado
                    FROM vigilantes 
                    WHERE num_identificacion = '$numero_documento' 

                    UNION ALL

                    SELECT 'visitantes' AS tabla, num_identificacion, estado 
                    FROM visitantes 
                    WHERE num_identificacion = '$numero_documento' 

                    UNION ALL

                    SELECT 'funcionarios' AS tabla, num_identificacion, estado 
                    FROM funcionarios 
                    WHERE num_identificacion = '$numero_documento' ;";

                    $buscar_usuario_tabla = $this->ejecutarConsulta($sentencia_verificar_estado);
                    unset($sentencia_verificar_estado,$error);
                    if ($buscar_usuario_tabla == 'conexion-fallida') {
                        $mensaje=[
                            "titulo"=>"Error de Conexion",
                            "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        return json_encode($mensaje);

                    } else {

                        if ($buscar_usuario_tabla->num_rows > 0) {
                            $datos_completos=$buscar_usuario_tabla->fetch_assoc();
                            $error=false;
                            if ($buscar_usuario_tabla->num_rows > 1) {
                                for ($i=0; $i < $datos_completos; $i++) { 
                                    if ($datos_completos[$i]['estado']=="ACTIVO") {
                                        $datos=$datos_completos[$i];
                                    }
                                    if ($datos_completos[$i]['tabla']=="aprendices"&&$datos_completos[$i]['estado']=="INACTIVO") {
                                        $error=true;
                                    }
                                }
                        
                            }else{

                                if ($datos_completos['estado']=="ACTIVO") {
                                    $datos=$datos_completos;
                                }

                                if ($datos_completos['tabla']=="aprendices"&&$datos_completos['estado']=="INACTIVO") {
                                    $error=true;
                                }

                            }

                            if (isset($datos)) {

                                if ($datos['tabla']=='funcionarios'||$datos['tabla']=='vigilantes') {
                                    $mensaje_otra_tabla=[
                                        "titulo"=>"Error",
                                        "mensaje"=>"Este usuario ya se encuentra como ".$datos['tabla'],
                                        "icono"=> "error",
                                        "tipoMensaje"=>"normal"
                                    ];
                                    return json_encode($mensaje_otra_tabla);
                                }elseif ($datos['tabla']=='aprendiz') {
        
                                    $sentencia_estado_visitiante="UPDATE `visitantes` SET `estado`='INACTIVO' WHERE `num_identificacion`='$numero_documento'";
                                    $estado_visitante = $this->ejecutarInsert($sentencia_estado_visitiante);
                                    unset($sentencia_estado_visitiante);
                                    if ($estado_visitante != 1) {
                                        $mensaje=[
                                            "titulo"=>"Error de Conexion",
                                            "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                                            "icono"=> "error",
                                            "tipoMensaje"=>"normal"
                                        ];
                                        return json_encode($mensaje);

                                        }
        
                                    }
                            } if (isset($erSror)&&$error=true) {
                                    $mensaje=[
                                    "titulo"=>"Error",
                                    "mensaje"=>"Este usuario ya se encuentra como un aprendiz y su estado es INACTIVO",
                                    "icono"=> "error",
                                    "tipoMensaje"=>"normal"
                                    ];
                                    return json_encode($mensaje);
                            }}else {

                                $nombres_aprendiz = ucwords(strtolower(trim($_POST['nombre_a'])));
                                $apellidos_aprendiz=ucwords(strtolower(trim($_POST['apellido_a'])));
                                $tipo_doc_aprendiz=$_POST['tipo_documento_a'];
                                $num_documento_aprendiz=trim($_POST['numero_documento_a']);
                                $numero_ficha=$_POST['numero_ficha'];              
                                $correo_aprendiz=trim($_POST['email_a']);
                                $telefono_aprendiz=trim($_POST['numero_a']);

                                unset($_POST['nombre_a'],$_POST['apellido_a'],$_POST['tipo_documento_a'],$_POST['numero_documento_a'],$_POST['numero_ficha'],$_POST['email_a'],$_POST['numero_a']);

                                $sentencia = "INSERT INTO `aprendices`(`tipo_documento`, `num_identificacion`, `nombres`, `apellidos`, `correo`, `telefono`, `num_ficha_fk`, `estado`, `fecha_hora_ultimo_ingreso`, `permanencia`, `fecha_registro`) 
                                VALUES ('$tipo_doc_aprendiz', '$num_documento_aprendiz', '$nombres_aprendiz', '$apellidos_aprendiz', '$correo_aprendiz', '$telefono_aprendiz', '$numero_ficha', 'ACTIVO', '', 'FUERA', NOW())";
                        
                                $insertar_usuario = $this->ejecutarInsert($sentencia);
                                unset($sentencia);

                                if ($insertar_usuario != 1) {
                                    $mensaje=[
                                        "titulo"=>"Error de Conexion",
                                        "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                                        "icono"=> "error",
                                        "tipoMensaje"=>"normal"
                                    ];
                                    return json_encode($mensaje);
                                } else {         

                                    $mensaje=[
                                        "titulo"=>"Bien!",
                                        "mensaje"=>"Ha registrado un aprendiz con exito",
                                        "icono"=> "success",
                                        "tipoMensaje"=>"normal"
                                    ];
                                    echo json_encode($mensaje);
                                    exit();
                                }
                            }
                        }
                    }
                }
            }

    public function comprobarFichasControler($num_ficha) {
        $sentencia = "SELECT `estado_ficha` FROM `fichas` WHERE `num_ficha`=`$num_ficha`";

        $estado_ficha = $this->ejecutarConsulta($sentencia);

        if ($estado_ficha == 'conexion-fallida') {
            $mensaje=[
                "titulo"=>"Error de Conexion",
                "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                "icono"=> "error",
                "tipoMensaje"=>"normal"
            ];
            return json_encode($mensaje);
        } else {
            if($estado_ficha->num_rows == 0) {
                $mensaje=[
                    "titulo"=>"Error en las ficha",
                    "mensaje"=>"Lo sentimos, parece que la ficha no existe. Intentelo mas tarde",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                return json_encode($mensaje);
            } else {
                $estado_ficha = $estado_ficha->fetch_assoc();

                if ($estado_ficha == "ACTTIVA") {
                    return TRUE;
                } elseif($estado_ficha == "INACTIVO") {
                    return FALSE;
                } else {
                    return "error";
                }
            }
        }
    }

    public function obtenerFichasController($nombre_ficha = null) {
        if ($nombre_ficha != null){
            $sentencia = "SELECT num_ficha FROM fichas WHERE fecha_registro_ficha >= DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND nombre_programa = '$nombre_ficha';";

            $filtro_ficha = $this->ejecutarConsulta($sentencia);
            
            if ($filtro_ficha == 'conexion-fallida') {
                $mensaje=[
                    "titulo"=>"Error de Conexion",
                    "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                return json_encode($mensaje);
            } else {
                if($filtro_ficha->num_rows < 1) {
                    $mensaje=[
                        "titulo"=>"Error en las ficha",
                        "mensaje"=>"Lo sentimos, parece que la ficha no existe. Intentelo mas tarde",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                } else {
                    $tabla = [];
                    while ($datos = $filtro_ficha->fetch_object()) {
                        $tabla[] = [
                            'value' => $datos->num_ficha,
                            'text' => $datos->num_ficha,
                        ];
                    }
                    
                    $filtro_ficha->free();
                    unset($filtro_ficha);
                    
                    return json_encode($tabla);
                }
            }        
        } else {
            $tabla = [];
            return json_encode($tabla);
        }
    }

    public function obtenerNombresController() {
        $sentencia = "SELECT DISTINCT nombre_programa FROM fichas WHERE fecha_registro_ficha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY);";

        $filtro_nombre = $this->ejecutarConsulta($sentencia);

        if ($filtro_nombre == 'conexion-fallida'){
            $mensaje=[
                "titulo"=>"Errord de conexión",
                "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentalo mas tarde",
                "icono"=> "error",
                "tipoMensaje"=> "normal"
            ];
            return json_encode($mensaje);
        } else {
            if($filtro_nombre->num_rows < 1) {
                $mensaje=[
                    "titulo"=>"Error en las ficha",
                    "mensaje"=>"Lo sentimos, parece que la ficha no existe. Intentelo mas tarde",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                return json_encode($mensaje);
            } else {
                $tabla = '';
                while ($datos = $filtro_nombre->fetch_object()) {
                    $tabla.='
                        "<option value="'. $datos->nombre_programa . '">' . $datos->nombre_programa . '</option>"
                    ';
                }
                $filtro_nombre->free();
                unset($filtro_nombre);
                return $tabla;
            }
        }
    }

    

    public function listarAprendicesControler() {

            header('Content-Type: application/json'); 

            $columnas = [
                'tipo_documento',
                'num_identificacion',
                'nombres',
                'apellidos',
                'num_ficha_fk',
                'correo',
                'telefono',
                'estado',
                'fecha_hora_ultimo_ingreso',
                'permanencia'];

            $tabla = "aprendices";
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
            $buscar_aprendices = $this->ejecutarConsulta($sentencia);
            $numero_registros = $buscar_aprendices->num_rows;

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
            if (!$buscar_aprendices){
                $output['data'] = $tipo_listado == 'tabla' 
                ? '
                                <table class="table">
                                    <thead class="head-table">
                                        <tr>
                                            <th>Tipo de Documento</th>
                                            <th>Número de Identificación</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Ficha</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Fecha y Hora Último Ingreso</th>
                                            <th>Permanencia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-table" id="listado_aprendices">
                                    <tr><td colspan="9">Error al cargar los Aprendices</td></tr>
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
            if ($buscar_aprendices->num_rows < 1) {
                $output['data'] = $tipo_listado == 'tabla' 
                ? '
                                <table class="table">
                                    <thead class="head-table">
                                        <tr>
                                            <th>Tipo de Documento</th>
                                            <th>Número de Identificación</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Ficha</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Fecha y Hora Último Ingreso</th>
                                            <th>Permanencia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-table" id="listado_aprendices">
                                    <tr><td colspan="9">No se encontraron Aprendices</td></tr>
                                    </tbody>
                                    </table>'
                :'
                <div class="document-card">
                    <div class="card-header">
                        <div>
                            <p class="document-meta">No se encontro Aprendices</p>
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
                                            <th>Ficha</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Fecha y Hora Último Ingreso</th>
                                            <th>Permanencia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-table" id="listado_aprendices">
                                ';

                    while ($datos = $buscar_aprendices->fetch_object()) {
                        $output['data'].='
                            <tr >
                                <td>'.$datos->tipo_documento.'</td>
                                <td>'.$datos->num_identificacion.'</td>
                                <td>'.$datos->nombres.'</td>
                                <td>'.$datos->apellidos.'</td>
                                <td>'.$datos->num_ficha_fk.'</td>
                                <td>'.$datos->correo.'</td>
                                <td>'.$datos->telefono.'</td>
                                <td>'.$datos->fecha_hora_ultimo_ingreso.'</td>
                                <td>'.$datos->permanencia.'</td>
                            </tr>
                        ';
                    }
                    $output['data'] .= '</tbody></table>';
                }elseif ($tipo_listado == 'card') {
                    
                    while ($datos = $buscar_aprendices->fetch_object()) {
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
                                    <p><strong>Fecha y Hora: </strong>'.$datos->fecha_hora_ultimo_ingreso.'</p>
                                    <p><strong>Numero de Ficha: </strong>'.$datos->num_ficha_fk.'</p>
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

    public function inhabilitarAprendizController($id_aprendiz) {
        $id_aprendiz = (int) $id_aprendiz; 
        $consulta = "UPDATE aprendices SET estado = 'INACTIVO' WHERE num_identificacion = ? AND estado = 'ACTIVO'";
        $conexion = $this->conectar();

        if ($conexion == 'conexion-fallida') {
            return false;
        } else {
            $preparar = $conexion->prepare($consulta);
            $preparar->bind_param("i", $id_aprendiz);
            $resultado = $preparar->execute();

            if (!$resultado) {
                echo "ERROR " . $conexion->error;
                
                $mensaje=[
                    "titulo"=>"Fallo!",
                    "mensaje"=>"Ha ocurrido un error al inhabilitar el aprendiz",
                    "icono"=> "success",
                    "tipoMensaje"=>"recargar"
                ];
                return json_encode($mensaje);

            } else {

                $mensaje=[
                    "titulo"=>"Confirmacion!",
                    "mensaje"=>"Se ha inhabilitado el aprendiz con exito",
                    "icono"=> "success",
                    "tipoMensaje"=>"recargar"
                ];
                return json_encode($mensaje);

            }
            $conexion->close();
        }
    }

    public function habilitarAprendizController($id_aprendiz) {
        $id_aprendiz = (int) $id_aprendiz;
        $consulta = "UPDATE aprendices SET estado = 'ACTIVO' WHERE num_identificacion = ? AND estado = 'INACTIVO'";
        $conexion = $this->conectar();

        if ($conexion == 'conexion-fallida') {
            return false;
        } else {
            $preparar = $conexion->prepare($consulta);
            $preparar->bind_param("i", $id_aprendiz);
            $resultado = $preparar->execute();

            if (!$resultado) {
                echo "ERROR " . $conexion->error;
                $mensaje=[
                    "titulo"=>"Fallo!",
                    "mensaje"=>"Ha ocurrido un error al habilitar el aprendiz",
                    "icono"=> "success",
                    "tipoMensaje"=>"recargar"
                ];
                return json_encode($mensaje);
            } else {
                $mensaje=[
                    "titulo"=>"Confirmacion!",
                    "mensaje"=>"Se ha habilitado el aprendiz con exito",
                    "icono"=> "success",
                    "tipoMensaje"=>"recargar"
                ];
                return json_encode($mensaje);
            }
            $conexion->close();
        }
    }

    public function obtenerAprendizController($id_aprendiz) {

        $num_identificacion = $this->limpiarDatos($id_aprendiz);

        $consultar_aprendiz_query = "SELECT `tipo_documento`, `num_identificacion`, `nombres`, `apellidos`, `correo`, `telefono` FROM `aprendices` WHERE num_identificacion = '$num_identificacion';";
            $consultar_aprendiz = $this->ejecutarConsulta($consultar_aprendiz_query);
            unset($id_aprendiz,$num_identificacion,$consultar_aprendiz_query);
            
            if (!$consultar_aprendiz) {

                $mensaje=[
                    "titulo"=>"Error de Conexion",
                    "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                return json_encode($mensaje);
            } else {

                if ($consultar_aprendiz->num_rows < 1) {

                    $mensaje=[
                        "titulo"=>"Error de Consulta",
                        "mensaje"=>"Lo sentimos, parece que ha ocurrido un error, el aprendiz que intenta editar no existe. Intentelo mas tarde",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);

                } else {

                    $aprendiz = $consultar_aprendiz->fetch_assoc();
                    $consultar_aprendiz->free();
                    unset($consultar_aprendiz);
                    return $aprendiz;

                }

            }

    }

    public function editarAprendizController($id_aprendiz) {
        $id_aprendiz = (int) $id_aprendiz;

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $mensaje=[
                "titulo"=>"Peticion incorrecta",
                "mensaje"=>"Lo sentimos, la accion que intentas realizar no es correcta",
                "icono"=> "error",
                "tipoMensaje"=>"redireccionar",
                "url"=>"http://localhost/Adso04/PROYECTOS/cerberus/"
            ];
            return json_encode($mensaje);
        } else {

            $error=[];
            if (!isset($_POST['nombre_a'])||$_POST['nombre_a']==""||strlen($_POST['nombre_a'])<2||strlen($_POST['nombre_a'])>64) {
                
                array_push($error,"nombre(s)");

            } if (!isset($_POST['apellido_a'])||$_POST['apellido_a']==""||strlen($_POST['apellido_a'])<2||strlen($_POST['apellido_a'])>64) {

                array_push($error,"apellidos(s)");

            } if (!isset($_POST['tipo_documento_a'])||$_POST['tipo_documento_a']=="") {

                array_push($error,"tipo de documento");

            } if (!isset($_POST['numero_documento_a'])||$_POST['numero_documento_a']==""||strlen($_POST['numero_documento_a'])<6||strlen($_POST['numero_documento_a'])>16||$_POST['numero_documento_a']/1!=$_POST['numero_documento_a']) {

                array_push($error,"numero de documento");

            } if (!isset($_POST['numero_ficha'])||$_POST['numero_ficha']=="") {

                array_push($error,"numero de ficha");

            } if (!isset($_POST['email_a'])||$_POST['email_a']==""||strlen($_POST['email_a'])<8||strlen($_POST['email_a'])>88||$this->verificarDatos("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $_POST['email_a'])) {

                array_push($error,"correo de electronico");

            } if (!isset($_POST['numero_a'])||$_POST['numero_a']==""||strlen($_POST['numero_a'])!=10) {

                array_push($error,"numero de telfono");

            } 
            
            if (count($error)!=0) {
                $mensaje_str="";
                for ($i=0; $i < count($error); $i++) {
                    $mensaje_str=$mensaje_str.$error[$i].", ";
                }
                $mensaje=[
                    "titulo"=>"Error de datos",
                    "mensaje"=>"Lo sentimos, los campos ".$mensaje_str." NO cumplen con los requisitos",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                unset($mensaje_str,$error);
                return json_encode($mensaje);
            } else {

                $nombres_aprendiz = ucwords(strtolower(trim($_POST['nombre_a'])));
                $apellidos_aprendiz=ucwords(strtolower(trim($_POST['apellido_a'])));
                $tipo_doc_aprendiz=$_POST['tipo_documento_a'];
                $num_documento_aprendiz=trim($_POST['numero_documento_a']);
                $numero_ficha=$_POST['numero_ficha'];                      
                $correo_aprendiz=trim($_POST['email_a']);
                $telefono_aprendiz=trim($_POST['numero_a']);

                unset($_POST['nombre_a'],$_POST['apellido_a'],$_POST['tipo_documento_a'],$_POST['numero_documento_a'],$_POST['numero_ficha'],$_POST['email_a'],$_POST['numero_a']);


                $sentencia = "UPDATE `aprendices` SET `tipo_documento`='$tipo_doc_aprendiz',`num_identificacion`='$num_documento_aprendiz',`nombres`='$nombres_aprendiz',`apellidos`='$apellidos_aprendiz',`correo`='$correo_aprendiz',`telefono`='$telefono_aprendiz',`num_ficha_fk`='$numero_ficha' WHERE `num_identificacion` = '$id_aprendiz'";

                $actualizar_usuario = $this->ejecutarConsulta($sentencia);

                unset($sentencia);

                if ($actualizar_usuario != 1) {
                    $mensaje=[
                        "titulo"=>"Error de Conexion",
                        "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                } else {

                    $mensaje=[
                        "titulo"=>"Bien!",
                        "mensaje"=>"Ha actualizado un aprendiz con exito",
                        "icono"=> "success",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);

                }

            }
        }
    }
}
