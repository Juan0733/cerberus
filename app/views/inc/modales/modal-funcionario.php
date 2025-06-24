<?php
    require_once "../../../../config/app.php";
    $fechaActual = date('Y-m-d');
?>

<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal" id="titulo_modal_funcionario">Registrar Funcionario</h2>
    <ion-icon name="close-outline" id="cerrar_modal_funcionario" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form action="" id="formulario_funcionario" method="post" >
            <div id="contenedor_cajas_funcionario">
                
                <div class="input-caja-registro seccion-01">
                    <label for="tipo_documento" class="label-input">Tipo de documento</label>
                    <select class="campo campo-seccion-01"  name="tipo_documento" id="tipo_documento" tabindex="1" required>
                        <option value="" selected disabled>Seleccionar</option>
                        <option value="CC">Cedula de ciudadanía</option>
                        <option value="CE">Cedula de extranjería</option>
                        <option value="TI">Tarjeta de identidad</option>
                        <option value="PP">Pasaporte</option>
                        <option value="PEP">Permiso especial de permanencia</option>
                    </select>
                </div>

                <div class="input-caja-registro seccion-01">
                    <label for="numero_documento" class="label-input">Número de documento</label>
                    <input type="text" inputmode="numeric" class="campo campo-seccion-01" name="numero_documento" id="numero_documento" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y como mínimo 6 y máximo 10" placeholder="Ej: 123456Dil" tabindex="2" >
                </div>
            
                <div class="input-caja-registro seccion-01">
                    <label for="nombres" class="label-input">Nombre(s)</label>
                    <input type="text" class="campo campo-seccion-01" name="nombres" id="nombres" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2" maxlength="50" minlength="2" placeholder="Ej: Oscar Alejandro" tabindex="3" required>
                </div>

                <div class="input-caja-registro seccion-01">
                    <label for="apellidos" class="label-input">Apellido(s)</label>
                    <input type="text" class="campo campo-seccion-01" name="apellidos" id="apellidos" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2" maxlength="50" minlength="2" placeholder="Ej: Alvarez" tabindex="4" required>
                </div>
            
                <div class="input-caja-registro seccion-02">
                    <label for="correo_electronico" class="label-input">Correo electrónico</label>
                    <input class="campo campo-seccion-02" type="email" name="correo_electronico" id="correo_electronico" pattern="[a-zA-Z0-9\._%+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,10}" maxlength="64" minlength="11" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electrónico." tabindex="5" required>
                </div>

                <div class="input-caja-registro seccion-02">
                    <label for="telefono" class="label-input">Número de teléfono</label>
                    <input type="tel" class="campo campo-seccion-02" inputmode="numeric" name="telefono" id="telefono" pattern="[0-9]{10}" title="Debes digitar solo 10 números, sin espacios ni caracteres especiales" maxlength="10" minlength="10" placeholder="Ej: 3104444333" tabindex="6" >
                </div>
            
                <div class="input-caja-registro seccion-02">
                    <label for="brigadista" class="label-input">Brigadista</label>
                    <select class="campo campo-seccion-02" name="brigadista" id="brigadista" tabindex="9" required>
                        <option value="" selected disabled>Seleccionar</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>

                <div class="input-caja-registro seccion-02">
                    <label for="tipo_contrato" class="label-input">Tipo contrato</label>
                    <select class="campo campo-seccion-02"  name="tipo_contrato" id="tipo_contrato" tabindex="7" required>
                        <option value="" selected disabled>Seleccionar</option>
                        <option value="planta">Planta</option>
                        <option value="contratista">Contratista</option>
                    </select>
                </div>
            
                <div class="input-caja-registro seccion-03">
                    <label for="rol" class="label-input">Rol</label>
                    <select class="campo"  name="rol" id="rol" tabindex="8" required>
                        <option value="" selected disabled>Seleccionar</option>
                        <option value="coordinador">Coordinador</option>
                        <option value="instructor">Instructor</option>
                        <option value="personal administrativo">Personal Administrativo</option>
                        <option value="personal aseo">Personal Aseo</option>
                        <option value="soporte tecnico">Soporte Tecnico</option>
                    </select>
                </div>

                <div class="input-caja-registro oculta" id="input_caja_fecha">
                    <label for="fecha_fin_contrato" class="label-input">Fecha fin contrato</label>
                    <input class="campo" type="date" name="fecha_fin_contrato" id="fecha_fin_contrato" tabindex="10" min="<?php echo $fechaActual; ?>">
                </div>

                <div class="input-caja-registro input-caja-contrasena oculta">
                    <label for="contrasena" class="label-input">Contraseña</label>
                    <input type="password" class="campo" name="contrasena" id="contrasena" pattern="[A-Za-z0-9]{8,}" title="Debes digitar solo letras y números, mínimo 8" minlength="8" tabindex="11">
                </div>

                <div class="input-caja-registro input-caja-contrasena oculta">
                    <label for="confirmacion_contrasena" class="label-input">Confirmar contraseña</label>
                    <input type="password" class="campo" name="confirmacion_contrasena" id="confirmacion_contrasena" pattern="[A-Za-z0-9]{8,}" title="Debes digitar solo letras y númerors, mínimo 8" minlength="8" tabindex="12">
                </div>
            </div>
            
            <div id="contenedor_btns_funcionario">
                <button type="button" id="btn_atras_funcionario">Atras</button>
                <button type="button" id="btn_cancelar_funcionario">Cancelar</button>
                <button type="button" id="btn_siguiente_funcionario">Siguiente</button>
                <button type="submit" id="btn_registrar_funcionario">Registrar</button>
            </div>
        </form>
    </div>
</div>
