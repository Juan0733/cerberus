<?php
    require_once "../../../../config/app.php";
    $fechaActual = date('Y-m-d');
?>

<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Funcionario</h2>
    <ion-icon name="close-outline" id="cerrar_modal_visitante" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form action="" id="formulario_funcionarios" method="post" >
            <div id="contenedor_cajas_visitante">
                <div id="caja_01" class="caja">
                    <div class="input-caja-registro">
                        <label for="tipo_documento" class="label-input">Tipo de documento</label>
                        <select class="campo campo-seccion-01"  name="tipo_documento" id="tipo_documento" tabindex="8" date="Tipo de documento" required>
                            <option value="" selected disabled>Seleccionar</option>
                            <option value="CC">Cedula de ciudadanía</option>
                            <option value="CE">Cedula de extranjería</option>
                            <option value="TI">Tarjeta de identidad</option>
                            <option value="PS">Pasaporte</option>
                            <option value="PEP">Permiso especial de permanencia</option>
                        </select>
                    </div>

                    <div class="input-caja-registro">
                        <label for="documento_visitante" class="label-input">Numero de documento</label>
                        <input type="tel" class="campo campo-seccion-01" inputmode="numeric" name="documento_visitante" id="documento_visitante" pattern="[0-9]{6,15}" title="Debes digitar solo números y como mínimo 6 y máximo 10" placeholder="Ej: 123456Dil" date="Numero de documento" tabindex="9" >
                    </div>
                </div>

                <div id="caja_02" class="caja">
                    
                    <div class="input-caja-registro">
                        <label for="nombres" class="label-input">Nombre(s)</label>
                        <input type="text" class="campo campo-seccion-01" name="nombres" id="nombres" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,64}" title="Debes digitar solo letras y mínimo 2" placeholder="Ej: Oscar Alejandro" tabindex="4" date="Nombre(s)" required>
                    </div>

                    <div class="input-caja-registro">
                        <label for="apellidos" class="label-input">Apellido(s)</label>
                        <input type="text" class="campo campo-seccion-01" name="apellidos" id="apellidos" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,64}" title="Debes digitar solo letras y mínimo 2" placeholder="Ej: Alvarez" tabindex="5" date="Apellido(s)" required>
                    </div>
                </div>

                <div id="caja_03" class="caja">
                    <div class="input-caja-registro">
                        <label for="correo_electronico" class="label-input">Correo electrónico</label>
                        <input class="campo" type="email" name="correo_electronico" id="correo_electronico" pattern="[a-zA-Z0-9\._%+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,10}" maxlength="64" minlength="11" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electrónico." tabindex="6" date="Correo electronico" required>
                    </div>

                    <div class="input-caja-registro">
                        <label for="telefono" class="label-input">Numero de teléfono</label>
                        <input type="tel" class="campo" inputmode="numeric" name="telefono" id="telefono" pattern="[0-9]{10}" title="Debes digitar solo 10 números, sin espacios ni caracteres especiales" placeholder="Ej: 3104444333" date="Numero de telefono" tabindex="10" >
                    </div>
                </div>

                <div id="caja_04" class="caja">
                    <div class="input-caja-registro">
                        <label for="tipo_contrato" class="label-input">Tipo contrato</label>
                        <select class="campo campo-seccion-01"  name="tipo_contrato" id="tipo_contrato" tabindex="8" required>
                            <option value="" selected disabled>Seleccionar</option>
                            <option value="planta">Planta</option>
                            <option value="contratista">Contratista</option>
                        </select>
                    </div>

                    <div class="input-caja-registro">
                        <label for="rol" class="label-input">Rol</label>
                        <select class="campo campo-seccion-01"  name="rol" id="rol" tabindex="8" required>
                            <option value="" selected disabled>Seleccionar</option>
                            <option value="coordinador">Coordinador</option>
                            <option value="instructor">Instructor</option>
                            <option value="personal administrativo">Personal Administrativo</option>
                            <option value="personal aseo">Personal Aseo</option>
                            <option value="soporte tecnico">Soporte Tecnico</option>
                        </select>
                    </div>
                </div>

                <div id="caja_05" class="caja">
                    <div class="input-caja-registro">
                        <label for="brigadista" class="label-input">Brigadista</label>
                        <select class="campo campo-seccion-01"  name="brigadista" id="brigadista" tabindex="8" required>
                            <option value="" selected disabled>Seleccionar</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>

                
                    <div class="input-caja-registro">
                        <label for="fecha_fin_contrato" class="label-input">Fecha de suceso</label>
                        <input 
                            class="campo" 
                            type="datetime" 
                            name="fecha_fin_contrato" 
                            id="fecha_fin_contrato" 
                            placeholder="Selecciona una fecha" 
                            tabindex="6" 
                            required 
                            min="<?php echo $fechaActual; ?>">
                    </div>
                    
                </div>

                <div id="caja_06" class="caja">
                    <div class="input-caja-registro">
                        <label for="contrasena" class="label-input">Contraseña</label>
                        <input type="text" class="campo campo-seccion-01" name="contrasena" id="contrasena" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{8,}" title="Debes digitar solo letras y números, mínimo 8" tabindex="4" required>
                    </div>
                     <div class="input-caja-registro">
                        <label for="confirmacion_contrasena" class="label-input">Confirmar contraseña</label>
                        <input type="text" class="campo campo-seccion-01" name="confirmacion_contrasena" id="confirmacion_contrasena" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{8,}" title="Debes digitar solo letras y númerors, mínimo 8" tabindex="4" required>
                    </div>
                </div>
            </div>
            
            <div id="contenedor_btns_visitante">
                <button type="button" id="btn_atras_visitante">Atras</button>
                <button type="button" id="btn_cancelar_visitante" >Cancelar</button>
                <button type="button" id="btn_siguiente_visitante" >Siguiente</button>
                <button type="submit" id="btn_registrar_visitante" >Registrar</button>
            </div>
        </form>
    </div>
</div>
