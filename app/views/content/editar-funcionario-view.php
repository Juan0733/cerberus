<!-- <?php

use app\controllers\FuncionarioController;

    $funcionario = new FuncionarioController();

    $datos_funcionario = $funcionario->obtenerFuncionarioController($url[1]);

?> -->
<div class="contenedor-editar-funcionario">
    <form class="formulario-fetch" action="<?php echo APP_URL_BASE; ?>app/ajax/funcionario-ajax.php" method="POST">
    <script src="<?php echo APP_URL_BASE; ?>app/views/js/registro-vigilantes.js"></script>
        <input type="hidden" name="modulo_funcionario" value="actualizar">
                

                 <div class="grupo_1234" id="contenedor_campos">

                 <article id="grupo_1"  class="grupo_formularios_editar">
                    <div class="fila_formularios"  >


                            <div class="input-caja">

                                <label for="nombres_funcionarios">Nombre(s)</label>
                                <input type="text" class="campo_nombres" id="nombres_funcionario" name="nombres_funcionario"  pattern="[a-zA-Z\ s]{2,64}" maxlength="64" minlength="2" title="Por favor, solo se debe ingresar letras en minusculas o mayusculas y como minimo dos(2)" placeholder="Digita tu(s) nombre(s)." value="<?php echo $datos_funcionario['nombres']; ?>"  required tabindex="1">

                                </div>

                                <div class="input-caja">

                                <label for="apellidos_funcionarios">Apellido(s)</label>
                                <input type="text" class="campo_apellidos" id="apellidos_funcionario" name="apellidos_funcionario" pattern="[a-zA-Z\ s]{2,64}" maxlength="64" minlength="2" title="Por favor, solo se debe ingresar letras en minusculas o mayusculas y como minimo dos(2)" placeholder="Digita tu(s) apellido(s)." value="<?php echo $datos_funcionario['apellidos']; ?>" required tabindex="2">

                            </div>
                    </div>
                

                    <div class="fila_formularios"  > 
                        <div class="input-caja">

                            <label for="tipo_doc_funcionario">Tipo de documento</label>
                            <select class="campo_documento" name="tipo_doc_funcionario" id="tipo_doc_funcionario" required tabindex="3">
                                <option value="CC" <?php echo ($datos_funcionario['tipo_documento'] == 'CC') ? 'selected' : ''; ?>>Cedula Ciudadania</option>
                                <option value="TI" <?php echo ($datos_funcionario['tipo_documento'] == 'TI') ? 'selected' : ''; ?>>Tarjeta Identidad</option>
                                <option value="PAS" <?php echo ($datos_funcionario['tipo_documento'] == 'PAS') ? 'selected' : ''; ?>>Pasaporte</option>
                                <option value="OT" <?php echo ($datos_funcionario['tipo_documento'] == 'OT') ? 'selected' : ''; ?>>Otro</option>
                            </select>

                        </div>

                         <div class="input-caja">

                            <label for="num_documento_funcionario">Número de documento</label>
                            <input class="campo_documento" type="numeric" name="num_documento_funcionario" id="num_documento_funcionario" inputmode="numeric" title="Por favor ingresa tu número de documento con números" pattern="[0-9]{6,13}" minlength="6" maxlength="13" readonly placeholder="Digita número de identificacion" value="<?php echo $datos_funcionario['num_identificacion']; ?>" required tabindex="4"> 

                         </div>
                    </div>
                    <div class="contenedor_btn_continuar_formularios">
                 
                 <button class="btn_enviar_form_formularios" id="btn_continuar">CONTINUAR</button>
             </div>

                    </article>

                    <article id="grupo_2_formularios" class="grupo_formularios_editar">

                    <div class="fila_formularios"  >
                    
                   
                <div class="input-caja">

                        <div id="cargo-container">
                            <label for="cargo_funcionario">Cargo</label>
                            <select class="campo_cargo" name="cargo_funcionario" id="cargo_funcionario" required tabindex="5" onchange="mostrarCampoCredenciales()">
                                <?php
                                    if ($_SESSION['datos_usuario']['rol_usuario']=='SB') {
                                        ?>
                                <option value="CO" <?php echo ($datos_funcionario['rol_usuario'] == 'CO') ? 'selected' : ''; ?>>Coordinador</option>
                                <option value="SB" <?php echo ($datos_funcionario['rol_usuario'] == 'SB') ? 'selected' : ''; ?>>Subdirector</option> 
                                    <?php

                                    }
                                ?>
                            
                            <option value="IE" <?php echo ($datos_funcionario['rol_usuario'] == 'IE') ? 'selected' : ''; ?>>Instructor</option>
                            <option value="AD" <?php echo ($datos_funcionario['rol_usuario'] == 'AD') ? 'selected' : ''; ?>>Administrativo</option>
                            <option value="OT" <?php echo ($datos_funcionario['rol_usuario'] == 'OT') ? 'selected' : ''; ?>>Otro</option>             
                            </select>
                        </div>    
                        <?php
                                    if ($_SESSION['datos_usuario']['rol_usuario']=='SB') {
                                        ?>
                                        <div id="credenciales-container" >
                                            <label for="credenciales_funcionario">Credenciales</label>
                                            <input type="text" class="campo_cargo" name="credenciales_funcionario" id="credenciales_funcionario" pattern="[0-9a-zA-Z]{6,16}" placeholder="Digita tus credenciales" minlength="6" maxlength="16" title="Ingresa tus credenciales" <?php echo $datos_funcionario['credencial'] ?> <?php echo $datos_funcionario['rol_usuario'] == 'CO' ||  $datos_funcionario['rol_usuario'] == 'SB'? '' : 'readonly'; ?>> 
                                        </div>
                                    <?php

                                    }
                                ?>


                        </div>  
                        <div class="input-caja">

                            <label for="tipo_contrato_funcionario">Tipo del contrato</label>
                            <select class="campo_contrato" name="tipo_contrato_funcionario" id="tipo_contrato_funcionario" required tabindex="6" onchange="mostrarCampoFecha()">
                                <option value="CT" <?php echo ($datos_funcionario['tipo_contrato'] == 'CT') ? 'selected' : ''; ?>>Contratista</option>
                                <option value="PT" <?php echo ($datos_funcionario['tipo_contrato'] == 'PT') ? 'selected' : ''; ?>>Planta</option>
                            </select>
                            <?php

                            $timestamp = strtotime($datos_funcionario['fecha_hora_registro']);

                            $fecha_minima = date('Y-m-d', $timestamp);

                            $timestamp_mas_5_anos = strtotime('+5 years', $timestamp);

                            $fecha_maxima = date('Y-m-d', $timestamp_mas_5_anos);

                            $fecha_finalizacion = date('Y-m-d', strtotime($datos_funcionario['fecha_finalizacion_contrato']));


                            ?>  
                            <input type="hidden" name="fecha_registro" value="<?php echo $datos_funcionario['fecha_hora_registro'] ?>">
                            <label for="fecha_finalizacion_contrato">Fecha de finalización de contrato</label>
                            <input type="date" class="campo_cargo" name="fecha_finalizacion_contrato" id="fecha_finalizacion_contrato" 
                                placeholder="Digita la fecha de finalización" 
                                min="<?php echo $fecha_minima; ?>" 
                                <?php echo $datos_funcionario['tipo_contrato']!='CT'? 'readonly' : ''; ?>
                                max="<?php echo $fecha_maxima; ?>" value="<?php echo $datos_funcionario['fecha_finalizacion_contrato']? $fecha_finalizacion : ''; ?>">

                            </div>  
                    </div>


                    <div class="fila_formularios"  > 
                    <div class="input-caja">

                            <label for="correo_funcionario">Correo electronico</label>
                            <input type="email" class="campo_correo" name="correo_funcionario" id="correo_funcionario" inputmode="email" placeholder="Digita tu correo electronico" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Por favor, ingresa una dirección de correo electrónico válida" maxlength="64" minlength="8" value="<?php echo $datos_funcionario['correo']; ?>" required tabindex="7">

                            </div>

                            <div class="input-caja">

                            <label for="telefono_funcionario">Número de telefono</label>
                            <input type="tel" class="campo_telefono" name="telefono_funcionario" id="telefono_funcionario" pattern="\+?[0-9]{10,14}" maxlength="15" minlength="10" placeholder="Digita número de telefono" title="Por favor, ingresa un número de teléfono válido incluyendo el código de país si es necesario" value="<?php echo $datos_funcionario['telefono']; ?>" required tabindex="8">

                            </div>


            </div>
            <div class="contenedor_btn" id="btn_enviar_media">
            <button class="btn_enviar_form_formularios" id="btn_anterior_formularios"><ion-icon name="arrow-back-outline" id="icono-atras"></ion-icon></button>

            <button id="btn_guardar_form" type="submit" class="btn_enviar_form_formularios">Guardar</button>
        </div>
        
         </article>

        
         </div>
       
    </form>

    <article id="grupo_3">
    <div class="contenedor-campos-opcionales">
            
            <h1>Tabla De vehiculos asocioados a el funionario</h1>
            
            <table>
                
                <thead>
                    <tr>
                        <th class=""># identificacion</th>
                        <th class="">Tipo vehiculo</th>
                        <th class="">Placa Vehiculo</th>
                        <th class="">Estado</th>
                        <th class="">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    echo $funcionario->vehiculosFuncionario($url[1]);
                ?>
                </tbody>
                
            </table>
        </div>
        </article>
 <script src="<?php echo APP_URL_BASE; ?>app/views/js/registro-funcionario.js"></script>
</div>