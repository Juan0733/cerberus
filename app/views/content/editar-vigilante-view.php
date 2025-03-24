<!-- <?php

use app\controllers\VigilanteController;

    $vigilante = new VigilanteController();

    $datos_vigilante = $vigilante->obtenerVigilanteController($url[1]);

?> -->
<div class="contenedor-editar-vigilante">
    <form class="formulario-fetch" action="<?php echo APP_URL_BASE; ?>app/ajax/vigilanteAjax.php" method="POST">
	<script src="<?php echo APP_URL_BASE; ?>app/views/js/registro-vigilantes.js"></script>
        <input type="hidden" name="modulo_vigilante" value="actualizar">
        

            <div class="grupo_1234" id="contenedor_campos">


            <article id="grupo_1"  class="grupo_formularios_editar">
                <div class="fila_formularios"  >
                        <div class="input-caja">

                        <label for="nombres">Nombre(s)</label>
                        <input type="text" class="campo_nombres" id="nombres" name="nombres"  pattern="[a-zA-Z\ s]{2,64}" maxlength="64" minlength="2" title="Por favor, solo se debe ingresar letras en minusculas o mayusculas y como minimo dos(2)" placeholder="Digita tu(s) nombre(s)." value="<?php echo $datos_vigilante['nombres']; ?>"  required tabindex="1">

                        </div>

                        <div class="input-caja">

                        <label for="apellidos">Apellido(s)</label>
                        <input type="text" class="campo_apellidos" id="apellidos" name="apellidos" pattern="[a-zA-Z\ s]{2,64}" maxlength="64" minlength="2" title="Por favor, solo se debe ingresar letras en minusculas o mayusculas y como minimo dos(2)" placeholder="Digita tu(s) apellido(s)." value="<?php echo $datos_vigilante['apellidos']; ?>" required tabindex="2">

                        </div>
                </div>
                <div class="fila_formularios">
                        <div class="input-caja">

                        <label for="tipo_documento">Tipo de documento</label>
                        <select class="campo_documento" name="tipo_documento" id="tipo_documento" required tabindex="3">
                            <option value="CC" <?php echo ($datos_vigilante['tipo_documento'] == 'CC') ? 'selected' : ''; ?>>Cedula Ciudadania</option>
                            <option value="TI" <?php echo ($datos_vigilante['tipo_documento'] == 'TI') ? 'selected' : ''; ?>>Tarjeta Identidad</option>
                            <option value="PAS" <?php echo ($datos_vigilante['tipo_documento'] == 'PAS') ? 'selected' : ''; ?>>Pasaporte</option>
                            <option value="OT" <?php echo ($datos_vigilante['tipo_documento'] == 'OT') ? 'selected' : ''; ?>>Otro</option>
                        </select>

                        </div>

                        <div class="input-caja">

                        <label for="num_identificacion">Número de documento</label>
                        <input class="campo_documento" type="numeric" name="num_identificacion" id="num_identificacion" inputmode="numeric" title="Por favor ingresa tu número de documento con números" pattern="[0-9]{6,13}" minlength="6" maxlength="13" readonly placeholder="Digita número de identificacion" value="<?php echo $datos_vigilante['num_identificacion']; ?>" required tabindex="4"> 

                        </div>

                </div>
                <div class="contenedor_btn_continuar_formularios">
                 
					<button class="btn_enviar_form_formularios" id="btn_continuar">CONTINUAR</button>
                </div>


                </article>


                <article id="grupo_2_formularios" class="grupo_formularios_editar">
                        <div class="fila_formularios"   id="fila_edit_cargo_credenciales">
                                <div class="input-caja">

                                <div id="cargo-container">
                                <label for="rol_usuario">Cargo</label>
                                <select class="campo_cargo" name="rol_usuario" id="rol_usuario" required tabindex="5" onchange="mostrarCampoCredenciales()">
                                    <?php
                                        if ($_SESSION['datos_usuario']['rol_usuario']=='JV') {
                                            ?>
                                    <option value="JV" <?php echo ($datos_vigilante['rol_usuario'] == 'JV') ? 'selected' : ''; ?>>Jefe vigilante</option> 
                                        <?php

                                        }
                                    ?>
                                
                                <option value="VR" <?php echo ($datos_vigilante['rol_usuario'] == 'VR') ? 'selected' : ''; ?>>Vigilante rico</option>
                                <option value="VN" <?php echo ($datos_vigilante['rol_usuario'] == 'VN') ? 'selected' : ''; ?>>Vigilante normal</option>            
                                </select>
                            </div>    
                            </div>
                            <div class="input-caja">
                            <?php
                                    if ($_SESSION['datos_usuario']['rol_usuario'] == 'JV') {
                                    ?>
                                    <div id="credenciales-container">
                                        <label for="credencial">Credenciales</label>
                                        <?php
                                        $credencial = isset($_SESSION['datos_usuario']['credencial']) ? $_SESSION['datos_usuario']['credencial'] : '';
                                        ?>
                                        <input type="text" class="campo_cargo" name="credencial" id="credencial" pattern="[0-9a-zA-Z]{6,16}" placeholder="Digita tus credenciales" minlength="6" maxlength="16" title="Ingresa tus credenciales" value="<?php echo htmlspecialchars($credencial); ?>" <?php echo $_SESSION['datos_usuario']['rol_usuario'] == 'JV'? '' : 'readonly'; ?>>
                                    </div>
                                <?php
                                }
                                ?>


                        </div>
                </div>

                <div class="fila_formularios">
                 <div class="input-caja">

                <label for="correo">Correo electronico</label>
                <input type="email" class="campo_correo" name="correo" id="correo" inputmode="email" placeholder="Digita tu correo electronico" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Por favor, ingresa una dirección de correo electrónico válida" maxlength="64" minlength="8" value="<?php echo $datos_vigilante['correo']; ?>" required tabindex="7">

                </div>

                <div class="input-caja">

                <label for="telefono">Número de telefono</label>
                <input type="tel" class="campo_telefono" name="telefono" id="telefono" pattern="\+?[0-9]{10,14}" maxlength="15" minlength="10" placeholder="Digita número de telefono" title="Por favor, ingresa un número de teléfono válido incluyendo el código de país si es necesario" value="<?php echo $datos_vigilante['telefono']; ?>" required tabindex="8">

                </div>

            </div>
            <div class="contenedor_btn" id="btn_enviar_media">
                 <button class="btn_enviar_form_formularios" id="btn_anterior_formularios"><ion-icon name="arrow-back-outline" id="icono-atras"></ion-icon></button>
                 <button id="btn_guardar_form" type="submit" class="btn_enviar_form_formularios">Guardar</button>
             </div>
              
            </article>

        </div>
         
        

    </form>

    <article id="grupo_3" class="grupo_formularios" >
    <div class="contenedor-campos-opcionales">
            
            <h1>Tabla De vehiculos asocioados a el vigilante</h1>
            
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
                    echo $vigilante->vehiculosVigilante($url[1]);
                ?>
                </tbody>
                
            </table>
        </div>
        </article>
 <script src="<?php echo APP_URL_BASE; ?>app/views/js/registro-vigilante.js"></script>
</div>