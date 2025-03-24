<?php

    namespace app\controllers;
    use app\models\mainModel;

    class FuncionarioController extends mainModel{
        function llamarMetodo($num_identificacion, $rol){
            $this->cambioVisitante($num_identificacion, $rol);
        }
        function registrarFuncionarioControler(){
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
                $error=[]; //instancioamos una array para saber si el backend detecta algun campo con error
                if (!isset($_POST['num_documento_funcionario'])||$_POST['num_documento_funcionario']==""||strlen( $_POST['num_documento_funcionario'])<6||strlen( $_POST['num_documento_funcionario'])>15||$_POST['num_documento_funcionario']/1!=$_POST['num_documento_funcionario']) {
                    
                    array_push($error,'numero de documento'); //en caso de detectar algun error el backend guarare el nombre del campo en elq ue se detecta el error en el array error

                }if (!isset($_POST['nombres_funcionarios'])||$_POST['nombres_funcionarios']==""||$this->verificarDatos('[a-zA-Z\s]{2,64}', $_POST['nombres_funcionarios'])) {

                    array_push($error,'nombres');

                }if (!isset($_POST['tipo_doc_funcionario'])||$_POST['tipo_doc_funcionario']=="") {

                    array_push($error,'tipo de documento');

                }if (!isset($_POST['cargo_funcionario'])||$_POST['cargo_funcionario']=="") {

                    array_push($error,'cargo');

                }if (!isset($_POST['correo_funcionario'])||$_POST['correo_funcionario']==""||strlen( $_POST['correo_funcionario'])<8||strlen( $_POST['correo_funcionario'])>64||$this->verificarDatos("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $_POST['correo_funcionario'] )) {

                    array_push($error,'correo');
                    ;
                }if (!isset($_POST['apellidos_funcionarios'])||$_POST['apellidos_funcionarios']==""||$this->verificarDatos('[a-zA-Z\s]{2,64}', $_POST['apellidos_funcionarios'])) {
                    
                    array_push($error,'apellidos');

                }if (!isset($_POST['tipo_contrato_funcionario'])||$_POST['tipo_contrato_funcionario']=="") {
                    
                    array_push($error,'tipo de contrato');

                }if (!isset($_POST['telefono_funcionario'])||$_POST['telefono_funcionario']==""||strlen($_POST['telefono_funcionario'])<10||strlen($_POST['telefono_funcionario'])>14) {
                    
                    array_push($error,'telefono');

                }
                if ($_POST['tipo_contrato_funcionario']=="CT") { //se verifica la fecha del contrato cuando el tipo de contrato es contratista
                    $fecha_actual = date('Y-m-d');
                    $fecha_maxima = date('Y-m-d', strtotime('+5 years'));
                    if (!isset($_POST['fecha_finalizacion_contrato'])||$_POST['fecha_finalizacion_contrato']<$fecha_actual||$_POST['fecha_finalizacion_contrato']>$fecha_maxima) {
                        
                        array_push($error,'fecha de finalizacion');

                    }
                }

                /* ------------------------ vehiculo ------------------- */
                if (isset($_POST['tipo_vehiculo_funcionario'])||$_POST['placa_vehiculo_funcionario']!="") {
                    if (!isset($_POST['tipo_vehiculo_funcionario'])||$_POST['tipo_vehiculo_funcionario']==""||!isset($_POST['placa_vehiculo_funcionario'])||$_POST['placa_vehiculo_funcionario']=="") {
                    
                        if (!isset($_POST['tipo_vehiculo_funcionario'])||$_POST['tipo_vehiculo_funcionario']=="") {
    
                            array_push($error,'tipo de vehiculo');
        
                        }if (!isset($_POST['placa_vehiculo_funcionario'])||$_POST['placa_vehiculo_funcionario']==""||strlen($_POST['placa_vehiculo_funcionario'])<3||strlen($_POST['placa_vehiculo_funcionario'])>6) {
                            
                            array_push($error,'placa');
        
                        }
                    }
                }
                
                if (($_POST['cargo_funcionario']=="CO"||$_POST['cargo_funcionario']=="SB")&&(!isset($_POST['credenciales_funcionario'])||$_POST['credenciales_funcionario']==""||strlen($_POST['credenciales_funcionario'])<6||strlen($_POST['credenciales_funcionario'])>16)) { //solo se verifican las credenciales si cargo es coordinador o busdirector
                    
                    array_push($error,'credenciales');
                    
                }
                
                if (count($error)!=0) {//verificamos que la variable error tenga algo
                    $mensaje_str="";
                    for ($i=0; $i < count($error); $i++) {  //se forma el mensaje con la variable error
                        $mensaje_str=$mensaje_str.$error[$i].", ";
                    }
                    $mensaje=[
                        "titulo"=>"Error de datos",
                        "mensaje"=>"Lo sentimos, los campos ".$mensaje_str." NO cumplen con los requisitos",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    unset($mensaje_str,$error);
                    return json_encode($mensaje); //retornamos a alerta-formulario el error en json
                }


                else{
                    $num_documento_funcionario=trim($_POST['num_documento_funcionario']); //recogemos la cedula para verificar que no este en otras tablas
                    $sentencia_verificar_estado= "SELECT 'aprendices' AS tabla, num_identificacion, estado 
                        FROM aprendices 
                        WHERE num_identificacion = '$num_documento_funcionario' 
                        UNION ALL

                        SELECT 'vigilantes' AS tabla, num_identificacion, estado
                        FROM vigilantes 
                        WHERE num_identificacion = '$num_documento_funcionario' 

                        UNION ALL

                        SELECT 'visitantes' AS tabla, num_identificacion, estado 
                        FROM visitantes 
                        WHERE num_identificacion = '$num_documento_funcionario' 

                        UNION ALL

                        SELECT 'funcionarios' AS tabla, num_identificacion, estado 
                        FROM funcionarios 
                        WHERE num_identificacion = '$num_documento_funcionario' ;";

                    $buscar_usuario_tabla = $this->ejecutarConsulta($sentencia_verificar_estado); //verificamos que no tenga alun otro cargo activo
                    unset($sentencia_verificar_estado,$error);
                    if ($buscar_usuario_tabla == 'conexion-fallida') {

                        $mensaje=[
                            "titulo"=>"Error de Conexion",
                            "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                            "icono"=> "error",
                            "tipoMensaje"=>"normal"
                        ];
                        return json_encode($mensaje);
                        
                    }else{
                        if ($buscar_usuario_tabla->num_rows > 0) {//En caso de que este en otra tabla

                            $datos_completos=$buscar_usuario_tabla->fetch_assoc();
                            $error=false;  
                            if ($buscar_usuario_tabla->num_rows > 1) {
                                for ($i=0; $i < count($datos_completos); $i++) { 
                                    if ($datos_completos[$i]['tabla']!='visitante') {
                                        $datos=$datos_completos[$i];
                                    }
                                 }
                            }else{
                                if ($datos_completos['tabla']!='visitante') {
                                    $datos=$datos_completos;
                                }

                            }
                            if (isset($datos)) {
                                $cambio=false;
                                if ($datos['estado']=="ACTIVO") {
                                    $mensaje_otra_tabla=[
                                        "titulo"=>"Error",
                                        "mensaje"=>"Este usuario ya se encuentra en el grupo de ".$datos['tabla']." con un estado activo",
                                        "icono"=> "error",
                                        "tipoMensaje"=>"normal"
                                    ];
                                    return json_encode($mensaje_otra_tabla);
                                }else{
                                    $sentencia_estado_visitiante="DELETE FROM ".$datos['tabla']." WHERE `num_identificacion` = '$num_documento_funcionario'";
                                    $estado_visitante = $this->ejecutarInsert($sentencia_estado_visitiante);
                                    unset($sentencia_estado_visitiante);
                                    $cambio=true;
                                    if ($estado_visitante != 1) {
                                        $mensaje=[
                                            "titulo"=>"Error de Conexion",
                                            "mensaje"=>"Lo sentimos, parece que ha ocurrido un error al intentar borrar el funcionario del grupo ".$datos['tabla'].". Intentelo mas tarde",
                                            "icono"=> "error",
                                            "tipoMensaje"=>"normal"
                                        ];
                                        return json_encode($mensaje);
                                    }

                                }
                                unset($datos);

                            }
                            unset($datos_completos,$sentencia_verificar_estado,$buscar_usuario_tabla);
                        }

                        $nombres_funcionarios = ucwords(strtolower(trim($_POST['nombres_funcionarios'])));
                        $tipo_doc_funcionario=$_POST['tipo_doc_funcionario'];
                        $cargo_funcionario=$_POST['cargo_funcionario'];                      
                        $correo_funcionario=trim($_POST['correo_funcionario']);
                        $apellidos_funcionarios=ucwords(strtolower(trim($_POST['apellidos_funcionarios'])));
                        $num_documento_funcionario=trim($_POST['num_documento_funcionario']);
                        $tipo_contrato_funcionario=$_POST['tipo_contrato_funcionario'];
                        $telefono_funcionario=trim($_POST['telefono_funcionario']);
                        $usuario=$_SESSION['datos_usuario']['num_identificacion'];

                        if ($tipo_contrato_funcionario == "CT") {
                            // Si es contrato temporal, toma la fecha de finalización de contrato
                            $fecha_finalizacion_contrato = $_POST['fecha_finalizacion_contrato'];
                            $fecha_finalizacion_contrato = "'" . date('Y-m-d', strtotime($fecha_finalizacion_contrato)) . "'"; // Envolvemos en comillas simples
                            unset($_POST['fecha_finalizacion_contrato']);
                        } else {
                            // Si no es contrato temporal, establece el valor como NULL
                            $fecha_finalizacion_contrato = "NULL"; // No usamos comillas para NULL
                        }
                        if ($cargo_funcionario=="CO"||$cargo_funcionario=="SB") {
                            $credenciales_funcionario = trim($_POST['credenciales_funcionario']);
                            unset($_POST['credenciales_funcionario']);                          
                        } else{
                            $credenciales_funcionario = "NULL"; 
                        }
                        
                        unset($_POST['nombres_funcionarios'],$_POST['tipo_doc_funcionario'],$_POST['correo_funcionario'],$_POST['apellidos_funcionarios'],$_POST['cargo_funcionario'],$_POST['num_documento_funcionario'],$_POST['tipo_contrato_funcionario'],$_POST['telefono_funcionario'],);
                        

                        $sentencia = "INSERT INTO `funcionarios`(`tipo_documento`, `num_identificacion`, `nombres`, `apellidos`, `correo`, `telefono`, `tipo_contrato`, `rol_usuario`, `estado`, `fecha_hora_ultimo_ingreso`, `permanencia`, `fecha_hora_registro`, `num_id_usuario_que_registra`, `fecha_finalizacion_contrato`,`credencial`) 

                        VALUES ('$tipo_doc_funcionario', '$num_documento_funcionario', '$nombres_funcionarios', '$apellidos_funcionarios', '$correo_funcionario', '$telefono_funcionario', '$tipo_contrato_funcionario', '$cargo_funcionario', 'ACTIVO', '', 'FUERA', NOW(), '$usuario', $fecha_finalizacion_contrato,MD5('$credenciales_funcionario'))";
                        
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
                            
                        }else{ //solo se registran vehiculos si se registra el funcionario con exito
                            if (isset($_POST['tipo_vehiculo_funcionario'])||$_POST['placa_vehiculo_funcionario']!="") {

                                $tipo_vehiculo_funcionario=$_POST['tipo_vehiculo_funcionario'];
                                $placa_vehiculo_funcionario=trim($_POST['placa_vehiculo_funcionario']);

                                $registrar_vehiculo=$this->registrarNuevoVehiculo($placa_vehiculo_funcionario,$tipo_vehiculo_funcionario, $num_documento_funcionario, $usuario);

                                if ($registrar_vehiculo==false) {
                                    $mensaje=[
                                        "titulo"=>"Error de Conexion",
                                        "mensaje"=>"Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos. Intentelo mas tarde",
                                        "icono"=> "error",
                                        "tipoMensaje"=>"normal"
                                    ];
                                    return json_encode($mensaje);
                                }else if ($registrar_vehiculo == "") {
                                    return $registrar_vehiculo;
                                }

                            }
                              
                            $mensaje=[
                                "titulo"=>"Bien!",
                                "mensaje"=>"Ha registrado un funcionario con exito",
                                "icono"=> "success",
                                "tipoMensaje"=>"normal"
                            ];
                            return json_encode($mensaje);
                        
                        }
                    }
                }
            }
        }

        public function tipoContrato($tipo){
            switch ($tipo) {
                case 'CT':
                    return "Contratista";
                    break;
                
                case 'PT':
                    return "Planta";
                    break;
                default:
                    return "error";
                    break;
            }
        }

        public function vehiculosFuncionario($num_id){
            
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
                                window.location.href='http://localhost/Adso04/PROYECTOS/cerberus/listado-funcionario/';
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

        public function listarFuncionarioControler(){
            
            header('Content-Type: application/json'); 

            $columnas = [
                'tipo_documento',
                'num_identificacion',
                'nombres',
                'apellidos',
                'rol_usuario',
                'correo',
                'telefono',
                'estado',
                'fecha_hora_ultimo_ingreso',
                'permanencia'];

            $tabla = "funcionarios";
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
            $buscar_funcionarios = $this->ejecutarConsulta($sentencia);
            $numero_registros = $buscar_funcionarios->num_rows;

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
            if (!$buscar_funcionarios){
                $output['data'] = $tipo_listado == 'tabla' 
                ? '
                                <table class="table">
                                    <thead class="head-table">
                                        <tr>
                                            <th>Tipo de Documento</th>
                                            <th>Número de Identificación</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Cargo</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Fecha y Hora Último Ingreso</th>
                                            <th>Permanencia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-table" id="listado_funcionarios">
                                    <tr><td colspan="9">Error al cargar los Funcionarios</td></tr>
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
            if ($buscar_funcionarios->num_rows < 1) {
                $output['data'] = $tipo_listado == 'tabla' 
                ? '
                                <table class="table">
                                    <thead class="head-table">
                                        <tr>
                                            <th>Tipo de Documento</th>
                                            <th>Número de Identificación</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Cargo</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Fecha y Hora Último Ingreso</th>
                                            <th>Permanencia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-table" id="listado_funcionarios">
                                    <tr><td colspan="9">No se encontraron Funcionarios</td></tr>
                                    </tbody>
                                    </table>'
                :'
                <div class="document-card">
                    <div class="card-header">
                        <div>
                            <p class="document-meta">No se encontro Funcionarios</p>
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
                                            <th>Cargo</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Fecha y Hora Último Ingreso</th>
                                            <th>Permanencia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body-table" id="listado_funcionarios">
                                ';

                    while ($datos = $buscar_funcionarios->fetch_object()) {
                        $output['data'].='
                            <tr >
                                <td>'.$datos->tipo_documento.'</td>
                                <td>'.$datos->num_identificacion.'</td>
                                <td>'.$datos->nombres.'</td>
                                <td>'.$datos->apellidos.'</td>
                                <td>'.TIPOS_ROL_USUARIO["$datos->rol_usuario"].'</td>
                                <td>'.$datos->correo.'</td>
                                <td>'.$datos->telefono.'</td>
                                <td>'.$datos->fecha_hora_ultimo_ingreso.'</td>
                                <td>'.$datos->permanencia.'</td>
                            </tr>
                        ';
                    }
                    $output['data'] .= '</tbody></table>';
                }elseif ($tipo_listado == 'card') {
                    
                    while ($datos = $buscar_funcionarios->fetch_object()) {
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
                                    <p><strong>Cargo: </strong>'.TIPOS_ROL_USUARIO["$datos->rol_usuario"].'</p>
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

        function inhabilitarFuncionarioController($id_funcionario){
            $id_funcionario = (int) $id_funcionario; // aqui convertimos a un entero para evitar una posble inyeccion sql

            $consulta = "UPDATE funcionarios SET estado = 'INACTIVO' WHERE num_identificacion = ? AND estado = 'ACTIVO'";
            $conexion = $this->conectar();

            if ($conexion == 'conexion-fallida') {
                return false;
            } else {
                $preparar = $conexion->prepare($consulta);
                $preparar->bind_param("i", $id_funcionario);
                $resultado = $preparar->execute();
                if (!$resultado) {
                    echo "ERROR " . $conexion->error;
                    $conexion->close();
                    return false;
                } else {
                    $conexion->close();
                    return true;
                }
            }
        }

        function habilitarFuncionarioController($id_funcionario){
            $id_funcionario = (int) $id_funcionario; // aqui convertimos a un entero para evitar una posble inyeccion sql

            $consulta = "UPDATE funcionarios SET estado = 'ACTIVO' WHERE num_identificacion = ? AND estado = 'INACTIVO'";
            $conexion = $this->conectar();

            if ($conexion == 'conexion-fallida') {
                return false;
            } else {
                $preparar = $conexion->prepare($consulta);
                $preparar->bind_param("i", $id_funcionario);
                $resultado = $preparar->execute();

                if (!$resultado) {
                    echo "ERROR " . $conexion->error;
                    $conexion->close();
                    return false;
                } else {
                    $conexion->close();
                    return true;
                }

            }
        }

        // funcion que nos permite realizar la seleccion de los datos del funcionario selecionado 
        public function obtenerFuncionarioController($num_documento_funcionario) {

            $num_identificacion = $this->limpiarDatos($num_documento_funcionario);

            $consulta_funcionario_sql = "SELECT * FROM funcionarios WHERE num_identificacion = '$num_identificacion';";
            $consulta_funcionario = $this->ejecutarConsulta($consulta_funcionario_sql);
            unset($num_documento_funcionario, $num_identificacion, $consulta_funcionario_sql);

            if (!$consulta_funcionario) {
                
                $mensaje=[
                    "titulo"=>"Error de la conexion",
                    "mensaje"=>"Lo sentimos, ocurrio un error con la base de datos, Intentalo de nuevo mas tarde",
                    "icono"=> "error",
                    "tipoMensaje"=>"normal"
                ];
                return json_encode($mensaje);
                exit();

            } else {

                if ($consulta_funcionario->num_rows < 1) {
                    
                    $mensaje=[
                        "titulo"=>"Error de la conexion",
                        "mensaje"=>"Lo sentimos, el funcionaro que intentaste editar no existe en la base de datos",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                    exit();

                } else {

                    $funcionario = $consulta_funcionario->fetch_assoc();
                    $consulta_funcionario->free();
                    unset($consulta_funcionario);
                    return $funcionario;
                }
            }
        }

        public function editarFuncionarioController() {

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                $mensaje = [
                    "titulo" => "Error",
                    "mensaje" => "Solicitud denegada, Intente de nuevo mas tarde.",
                    "icono" => "error",
                    "tipoMensaje" => "normal"
                ];
                return json_encode($mensaje);

            } else {

                if (!isset($_POST['nombres_funcionario'], // campos obligatorios
                    $_POST['apellidos_funcionario'],
                    $_POST['num_documento_funcionario'],
                    $_POST['cargo_funcionario'],
                    $_POST['tipo_contrato_funcionario'],
                    $_POST['correo_funcionario'],
                    $_POST['telefono_funcionario'])
                    
                    || // nverificacion de los campos obligatorios no esten vacios para evitar errores
                    $_POST['nombres_funcionario'] == ""  ||
                    $_POST['apellidos_funcionario'] == ""  ||
                    $_POST['num_documento_funcionario'] == ""  ||
                    $_POST['cargo_funcionario'] == ""  ||
                    $_POST['tipo_contrato_funcionario']== "" ||
                    $_POST['correo_funcionario']== "" ||
                    $_POST['telefono_funcionario']== "" ) {
                    $mensaje=[
                        "titulo"=>"Error",
                        "mensaje"=>"Lo sentimos, ocurrido un error con alguno de los datos, intentalo de nuevo mas tarde.",
                        "icono"=> "error",
                        "tipoMensaje"=>"normal"
                    ];
                    return json_encode($mensaje);
                    exit();

                } else {
                    //limpiamos variables 
                    $nombre = $this->limpiarDatos($_POST['nombres_funcionario']); 
                    $apellidos = $this->limpiarDatos($_POST['apellidos_funcionario']);  
                    $num_documento = $this->limpiarDatos($_POST['num_documento_funcionario']);  
                    $cargo = $this->limpiarDatos($_POST['cargo_funcionario']);  
                    $tipo_contrato = $this->limpiarDatos($_POST['tipo_contrato_funcionario']);  
                    if ($_POST['fecha_finalizacion_contrato']!="" &&$tipo_contrato=="CT") {
                        $fecha_finalizacion = $this->limpiarDatos($_POST['fecha_finalizacion_contrato']);
                        $fecha_finalizacion =  date('Y-m-d H:i:s', strtotime($fecha_finalizacion)); 
                    }else{
                        $fecha_finalizacion = "NULL";
                    }
                    $correo = $this->limpiarDatos($_POST['correo_funcionario']);  
                    $telefono = $this->limpiarDatos($_POST['telefono_funcionario']);  
                    if ($_POST['credenciales_funcionario']!="") {
                        $credencial = $this->limpiarDatos($_POST['credenciales_funcionario']);  
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
                    
                    $timestamp = strtotime($_POST['fecha_registro']);

                    $fecha_minima = date('Y-m-d H:i:s', $timestamp);

                    $timestamp_mas_5_anos = strtotime('+5 years', $timestamp);

                    $fecha_maxima = date('Y-m-d H:i:s', $timestamp_mas_5_anos);

                    // verificamos los datos del formulario sea lo que se esta solicitando
                    if ($tipo_contrato=="CT"&&($fecha_finalizacion<$fecha_minima||$fecha_finalizacion>$fecha_maxima)) {
                        $mensaje = [
                            "titulo" => "Error",
                            "mensaje" => "Fecha de finalizacion de contrato No Valida",
                            "icono" => "error",
                            "tipoMensaje" => "normal"
                        ];
                        return json_encode($mensaje);
                    }

                    //aqui agrego las comillas libres para que en la consulta puedan ir 
                    $fecha_finalizacion="'".$fecha_finalizacion."'";

                    if ($this->verificarDatos('[a-zA-Z\s]{2,64}', $nombre)) {
                        $mensaje = [
                            "titulo" => "Error",
                            "mensaje" => "Nombres No Válidos",
                            "icono" => "error",
                            "tipoMensaje" => "normal"
                        ];
                        return json_encode($mensaje);
                    }
                    if ($this->verificarDatos('[a-zA-Z\ s]{2,64}', $apellidos)) {
                        $mensaje = [
                            "titulo" => "Error",
                            "mensaje" => "Apellidos No Validos",
                            "icono" => "error",
                            "tipoMensaje" => "normal"
                        ];
                        return json_encode($mensaje);
                    }
                    if ($this->verificarDatos('[0-9]{6,13}',$num_documento)) {
                        $mensaje = [
                            "titulo" => "Error",
                            "mensaje" => "Numero de documento No Valido",
                            "icono" => "error",
                            "tipoMensaje" => "normal"
                        ];
                        return json_encode($mensaje);
                    } 
                    
                    if ($this->verificarDatos('[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}',$correo)) {
                        $mensaje = [
                            "titulo" => "Error",
                            "mensaje" => "Correo No Valido",
                            "icono" => "error",
                            "tipoMensaje" => "normal"
                        ];
                        return json_encode($mensaje);
                        
                    }
                    if ($this->verificarDatos('\+?[0-9]{10,14}', $telefono)) {
                        $mensaje = [
                            "titulo" => "Error",
                            "mensaje" => "Telefono No Valido",
                            "icono" => "error",
                            "tipoMensaje" => "normal"
                        ];
                        return json_encode($mensaje);
                    }

                    // aqui llevamos a cabo la actualizacion de lo datos del funcionario seleccionado
                    if (isset($credencial)) {
                        $consulta_actualizar_sql = "UPDATE funcionarios SET nombres = '".$nombre."', apellidos = '".$apellidos."', credencial = MD5('".$credencial."'), correo = '".$correo."', telefono = '".$telefono."', rol_usuario = '".$cargo."' , tipo_contrato = '".$tipo_contrato."', fecha_finalizacion_contrato = ".$fecha_finalizacion." WHERE num_identificacion = '".$num_documento."'";
                    }
                    else{
                        $consulta_actualizar_sql = "UPDATE funcionarios SET nombres = '".$nombre."', apellidos = '".$apellidos."', correo = '".$correo."', telefono = '".$telefono."', rol_usuario = '".$cargo."' , tipo_contrato = '".$tipo_contrato."', fecha_finalizacion_contrato = ".$fecha_finalizacion." WHERE num_identificacion = '".$num_documento."'";
                    }
                    $consulta_actualizar_funcionario = $this->ejecutarInsert($consulta_actualizar_sql);
                    if ($consulta_actualizar_funcionario != 1) {
                        $mensaje = [
                            "titulo" => "error",
                            "mensaje" => "Ha ocurrido un error a la hora de actualizar el funcionario",
                            "icono" => "error",
                            "tipoMensaje" => "normal"
                        ];
                        return json_encode($mensaje);
                    }else {
                        $mensaje = [
                            "titulo" => "Funcionario Actualizado",
                            "mensaje" => "El funcionario se actualizo correctamente en la base de datos.",
                            "icono" => "success",
                            "tipoMensaje" => "normal"
                        ];
                        return json_encode($mensaje);
                    }

                }
            }
        }

        // public function obtenerFuncionarioController($id_funcionario){
        //     $sentencia = "SELECT * FROM `funcionarios` WHERE `num_identificacion`='$id_funcionario'";
        //     $buscar_funcionario = $this->ejecutarConsulta($sentencia);
        //     if ($buscar_funcionario === false) {
        //         return [];
        //     } else if ($buscar_funcionario->num_rows > 0) {
        //         return $buscar_funcionario->fetch_assoc();
        //     } else {
        //         return [];
        //     }
        // }

        // public function actualizarFuncionarioController()
        // {
        //     if (isset($_POST['nombres_funcionarios']) && isset($_POST['apellidos_funcionarios']) && isset($_POST['tipo_doc_funcionario']) && isset($_POST['num_documento_funcionario']) && isset($_POST['cargo_funcionario']) && isset($_POST['correo_funcionario']) && isset($_POST['telefono_funcionario']) && isset($_POST['tipo_contrato_funcionario'])) {
        //         // ... (tu código existente para validar los campos)

        //         $nombres_funcionarios = ucwords(strtolower(trim($_POST['nombres_funcionarios'])));
        //         $apellidos_funcionarios = ucwords(strtolower(trim($_POST['apellidos_funcionarios'])));
        //         $tipo_doc_funcionario = $_POST['tipo_doc_funcionario'];
        //         $num_documento_funcionario = trim($_POST['num_documento_funcionario']);
        //         $cargo_funcionario = $_POST['cargo_funcionario'];
        //         $correo_funcionario = trim($_POST['correo_funcionario']);
        //         $telefono_funcionario = trim($_POST['telefono_funcionario']);
        //         $tipo_contrato_funcionario = $_POST['tipo_contrato_funcionario'];

        //         if ($cargo_funcionario == "CO" || $cargo_funcionario == "SB") {
        //             $credenciales_funcionario = trim($_POST['credenciales_funcionario']);
        //         }

        //         if ($tipo_contrato_funcionario == "CT") {
        //             $fecha_finalizacion_contrato = $_POST['fecha_finalizacion_contrato'];
        //             $fecha_finalizacion_contrato = "'" . date('Y-m-d', strtotime($fecha_finalizacion_contrato)) . "'";
        //         } else {
        //             $fecha_finalizacion_contrato = "NULL";
        //         }

        //         $sentencia = "UPDATE `funcionarios` SET `nombres`='$nombres_funcionarios', `apellidos`='$apellidos_funcionarios', `tipo_documento`='$tipo_doc_funcionario', `correo`='$correo_funcionario', `telefono`='$telefono_funcionario', `tipo_contrato`='$tipo_contrato_funcionario', `rol_usuario`='$cargo_funcionario', `fecha_finalizacion_contrato`=$fecha_finalizacion_contrato WHERE `num_identificacion`='$num_documento_funcionario'";

        //         if ($cargo_funcionario == "CO" || $cargo_funcionario == "SB") {
        //             $sentencia_credenciales = "UPDATE `credenciales` SET `contrasena_usuario`=MD5('$credenciales_funcionario') WHERE `num_identificacion_usuario`='$num_documento_funcionario'";
        //             $actualizar_credenciales = $this->ejecutarInsert($sentencia_credenciales);
        //             if ($actualizar_credenciales != 1) {
        //                 $mensaje = [
        //                     "titulo" => "Error de Conexion",
        //                     "mensaje" => "Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos al actualizar las credenciales.",
        //                     "icono" => "error",
        //                     "tipoMensaje" => "normal"
        //                 ];
        //                 return json_encode($mensaje);
        //             }
        //         }

        //         $actualizar_funcionario = $this->ejecutarInsert($sentencia);
        //         if ($actualizar_funcionario != 1) {
        //             $mensaje = [
        //                 "titulo" => "Error de Conexion",
        //                 "mensaje" => "Lo sentimos, parece que ha ocurrido un error de conexion a la base de datos al actualizar el funcionario.",
        //                 "icono" => "error",
        //                 "tipoMensaje" => "normal"
        //             ];
        //             return json_encode($mensaje);
        //         } else {
        //             $mensaje = [
        //                 "titulo" => "Bien!",
        //                 "mensaje" => "Ha actualizado el funcionario con exito",
        //                 "icono" => "success",
        //                 "tipoMensaje" => "normal"
        //             ];
        //             return json_encode($mensaje);
        //         }
        //     } else {
        //         $mensaje = [
        //             "titulo" => "Error",
        //             "mensaje" => "Lo sentimos, parece que ha ocurrido un error al actualizar el funcionario.",
        //             "icono" => "error",
        //             "tipoMensaje" => "normal"
        //         ];
        //         return json_encode($mensaje);
        //     }
        // }
    }
