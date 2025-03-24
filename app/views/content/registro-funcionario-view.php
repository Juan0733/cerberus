<div class="contenedor-funcionario">
    <form class="formulario-fetch" action="<?php echo APP_URL_BASE; ?>app/ajax/funcionario-ajax.php" method="post">
        <input type="hidden" name="modulo_funcionario" value="registro">

        <article class="grupo_formularios" id="grupo_1">

            <div class="fila_formularios" id="fila_1">

                <div class="input-caja">
                    <label for="nombres_funcionarios">Nombre(s)</label>
                    <input type="text" class="campo_nombres" id="nombres_funcionarios" name="nombres_funcionarios" required tabindex="1" pattern="[a-zA-Z\s]{2,64}" maxlength="64" minlength="2" title="Por favor, solo se debe ingresar letras en minusculas o mayusculas y como minimo dos(2)" placeholder="Digita tu(s) nombre(s).">
                </div>

                <div class="input-caja">
                    <label for="apellidos_funcionarios">Apellido(s)</label>
                    <input type="text" class="campo_apellidos" id="apellidos_funcionarios" name="apellidos_funcionarios" pattern="[a-zA-Z\s]{2,64}" maxlength="64" minlength="2" title="Por favor, solo se debe ingresar letras en minusculas o mayusculas y como minimo dos(2)" placeholder="Digita tu(s) apellido(s)." required tabindex="2">
                </div>

            </div>

            <div class="fila_formularios">

                <div class="input-caja">
                    <label for="tipo_doc_funcionario">Tipo de documento</label>
                         <select class="campo" name="tipo_doc_funcionario" id="tipo_doc_funcionario" required tabindex="3">
                                <option disabled selected>Selecciona tu tipo de documento</option>
                                <option value="CC">Cedula Ciudadania</option>
                                <option value="TI">Tarjeta Identidad</option>
                                <option value="PAS">Pasaporte</option>
                                <option value="OT">Otro</option>
                    </select>
                </div>

                <div class="input-caja">
                        <label for="num_documento_funcionario">Número de documento</label>
                    <input class="campo_documento" type="numeric" name="num_documento_funcionario" id="num_documento_funcionario" inputmode="numeric" title="Por favor ingresa tu número de documento con números" pattern="[0-9]{6,13}" minlength="6" maxlength="13" placeholder="Digita número de identificacion" required tabindex="4"> 
                </div>

            </div>

            <div class="contenedor_btn_continuar_formularios">
                <button class="btn_enviar_form" id="btn_continuar_1">SIGUIENTE</button>
            </div>

        </article>

        <article class="grupo_formularios" id="grupo_2">
            <div class="fila_formularios">
                <div class="input-caja">
                    <div id="cargo-container">
                        <label for="cargo_funcionario">Cargo</label>
                        <select class="campo" name="cargo_funcionario" id="cargo_funcionario" required tabindex="5" onchange="mostrarCampoCredenciales()">
                            <option disabled selected>Selecciona tu tipo de documento</option>
                                <?php
                                    if ($_SESSION['datos_usuario']['rol_usuario']=='SB') {
                                        ?>
                            <option value="CO">Coordinador</option>
                            <option value="SB">Subdirector</option> 
                                    <?php
                    }       
                                ?>
                            <option value="IE">Instructor</option>
                            <option value="AD">Administrativo</option>
                            <option value="OT">Otro</option>             
                        </select>
                    </div>    
                    <div id="credenciales-container">
                        <label for="credenciales_funcionario" id="label-credenciales">Credenciales</label>
                        <input type="text" class="campo_cargo" name="credenciales_funcionario" id="credenciales_funcionario" pattern="[0-9a-zA-Z]{6,16}" placeholder="Digita tus credenciales" minlength="6" maxlength="16" title="Ingresa tus credenciales" readonly> 
                    </div>
                </div>
                
                <div class="input-caja">
                    <label for="tipo_contrato_funcionario">Tipo del contrato</label>
                    <select class="campo" name="tipo_contrato_funcionario" id="tipo_contrato_funcionario" required tabindex="6" onchange="mostrarCampoFecha()">
                        <option disabled selected>Selecciona tu tipo de contrato</option>
                        <option value="CT">Contratista</option>
                        <option value="PT">Planta</option>
                    </select>
                        <?php
                        $fecha_actual = time();
                        $fecha_actual = date('Y-m-d',$fecha_actual);

                        $fecha_maxima = date('Y-m-d', strtotime('+5 years'));
                        ?>
                    <label for="fecha_finalizacion_contrato" id="label-FContrato">Fecha de finalización de contrato</label>
                    <input type="date" class="campo_cargo" name="fecha_finalizacion_contrato" id="fecha_finalizacion_contrato" 
                            placeholder="Digita la fecha de finalización" 
                            readonly 
                            min="<?php echo $fecha_actual; ?>" 
                            max="<?php echo $fecha_maxima; ?>">
                </div>
            </div>

            <div class="contenedor_btn" id="btn_a_s">
                <button class="btn_enviar_form_formularios" id="btn_anterior"><ion-icon name="arrow-back-outline" class="icono-atras"></ion-icon></button>
                <button class="btn_enviar_form_formularios" id="btn_continuar_2">SIGUIENTE</button>
            </div>

            <!-- <div class="contenedor_btn" id="btn_enviar_media">

                <button class="btn_enviar_form_formularios" id="btn_anterior_2"><ion-icon name="arrow-back-outline" class="icono-atras"></ion-icon></button>

                <button type="submit" class="btn_enviar_form_formularios" id="btn_envia_form">Enviar</button>    

            </div> -->
            <!-- _______________ -->

        </article>

        <article class="grupo_formularios" id="grupo_3">
            <div class="fila_formularios" >
                <div class="input-caja">
                    <label for="correo_funcionario">Correo electronico</label>
                    <input type="email" class="campo_correo" name="correo_funcionario" id="correo_funcionario" placeholder="Digita tu correo electronico" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Por favor, ingresa una dirección de correo electrónico válida" maxlength="64" minlength="8" required tabindex="7">
                </div>
                <div class="input-caja">
                    <label for="telefono_funcionario">Número de telefono</label>
                    <input type="tel" class="campo_telefono" name="telefono_funcionario" id="telefono_funcionario" pattern="\+?[0-9]{10,14}" maxlength="15" minlength="10" placeholder="Digita número de telefono" title="Por favor, ingresa un número de teléfono válido incluyendo el código de país si es necesario" required tabindex="8">
                </div>
            </div>
            <h3 class="formularios-h">(NO OBLIGATORIOS)</h3>
            <div class="fila_formularios" id="ultima_fila">
                <div class="input-caja">
                    <label for="tipo_vehiculo_funcionario">Tipo de vehiculo</label>
                    <select class="campo" name="tipo_vehiculo_funcionario" id="tipo_vehiculo_funcionario" tabindex="9">
                        <option disabled selected>Selecciona el tipo de vehiculo</option>
                        <option value="AU">Automovil</option>
                        <option value="MT">Motocicleta</option>
                        <option value="BS">Bus</option>
                        <option value="CMN">Camion</option>
                    </select>
                </div>
                <div class="input-caja">
                    <label for="placa_vehiculo_funcionario">Placa del vehiculo</label>
                    <input type="text" class="campo_placa" name="placa_vehiculo_funcionario" id="placa_vehiculo_funcionario" pattern="[A-Z0-9\ s]{3,6}" title="Solo debes ingresar numero y letras en mayusculas" placeholder="Digita la placa">
                </div>

                <div class="contenedor_btn" id="btn_enviar_media">

                <button class="btn_enviar_form_formularios" id="btn_anterior_2"><ion-icon name="arrow-back-outline" class="icono-atras"></ion-icon></button>

                <button type="submit" class="btn_enviar_form_formularios" id="btn_envia_form">Enviar</button>    

            </dil>
            </div>

            
        </article>

       
    </form>
</div>
<script src="<?php echo APP_URL_BASE; ?>app/views/js/registro-funcionario.js"></script>