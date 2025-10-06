<?php require_once '../../../../config/app.php' ?>

<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal" id="titulo_modal_vigilante">Registrar Vigilante</h2>
    <ion-icon name="close-outline" id="cerrar_modal_vigilante" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form action="" id="formulario_vigilante" method="post" >
            <div id="contenedor_cajas_vigilante">

                <div class="caja-checkbox seccion-principal">
                    <ion-icon id="icono_individual" class="icono-tipo-registro" name="person"></ion-icon>
                    <input type="checkbox" class="checkbox" id="individual" name="individual" value="individual">
                    <label for="individual" class="label-input">Individual</label>
                </div>
                <div class="caja-checkbox seccion-principal">
                    <ion-icon id="icono_carga_masiva" class="icono-tipo-registro" name="people"></ion-icon>
                    <input type="checkbox" class="checkbox" id="carga_masiva" name="carga_masiva" value="carga_masiva">
                    <label for="carga_masiva" class="label-input">Carga masiva</label>
                </div>

                <div class="seccion-masiva" id="caja_excel">
                    <div class="input-caja-registro">
                        <label class="label-input">Excel de vigilantes</label>
                        <label class="campo" for="plantilla_excel">
                            <input type="file" name="plantilla_excel" id="plantilla_excel" accept=".xlsx, .xls, .xlsm">
                            <span id="nombre_archivo">Seleccionar archivo</span>
                        </label>
                    </div>
                    <a id="btn_plantilla_excel" href="<?php echo $urlBaseVariable; ?>app/excel/<?php echo strtolower($_SESSION['datos_usuario']['rol']); ?>/carga_masiva_vigilantes.xlsm" download="carga_masiva_vigilantes.xlsm"><ion-icon name="download"></ion-icon></a>
                </div>

                <div class="input-caja-registro seccion-individual seccion-individual-01">
                    <label for="tipo_documento" class="label-input">Tipo de documento</label>
                    <select class="campo campo-individual campo-individual-01"  name="tipo_documento" id="tipo_documento" tabindex="1">
                        <option value="" selected disabled>Seleccionar</option>
                        <option value="CC">Cédula de ciudadanía</option>
                        <option value="CE">Cédula de extranjería</option>
                        <option value="TI">Tarjeta de identidad</option>
                        <option value="PP">Pasaporte</option>
                        <option value="PEP">Permiso especial de permanencia</option>
                    </select>
                </div>

                <div class="input-caja-registro seccion-individual seccion-individual-01">
                    <label for="numero_documento" class="label-input">Número de documento</label>
                    <input type="text" class="campo campo-individual campo-individual-01" name="numero_documento" id="numero_documento" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y/o letras, mínimo 6 y máximo 15 caracteres" placeholder="Ej: 123456Dil" tabindex="2">
                </div>
            
                <div class="input-caja-registro seccion-individual seccion-individual-01">
                    <label for="nombres" class="label-input">Nombre(s)</label>
                    <input type="text" class="campo campo-individual campo-individual-01" name="nombres" id="nombres" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2" maxlength="50" minlength="2" placeholder="Ej: Oscar Alejandro" tabindex="3">
                </div>

                <div class="input-caja-registro seccion-individual seccion-individual-01">
                    <label for="apellidos" class="label-input">Apellido(s)</label>
                    <input type="text" class="campo campo-individual campo-individual-01" name="apellidos" id="apellidos" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2" maxlength="50" minlength="2" placeholder="Ej: Alvarez" tabindex="4">
                </div>
            
                <div class="input-caja-registro seccion-individual seccion-individual-02">
                    <label for="correo_electronico" class="label-input">Correo electrónico</label>
                    <input class="campo campo-individual" type="email" name="correo_electronico" id="correo_electronico" pattern="[a-zA-Z0-9\._%+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,10}" maxlength="64" minlength="11" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electrónico." tabindex="5">
                </div>

                <div class="input-caja-registro seccion-individual seccion-individual-02">
                    <label for="telefono" class="label-input">Número de teléfono</label>
                    <input type="tel" class="campo campo-individual" inputmode="numeric" name="telefono" id="telefono" pattern="[0-9]{10}" title="Debes digitar solo 10 números, sin espacios ni caracteres especiales" maxlength="10" minlength="10" placeholder="Ej: 3104444333" tabindex="6">
                </div>
            
                <div class="input-caja-registro seccion-individual seccion-individual-02">
                    <label for="rol" class="label-input">Rol</label>
                    <select class="campo campo-individual"  name="rol" id="rol" tabindex="7">
                        <option value="" selected disabled>Seleccionar</option>
                        <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
                            <option value="SUPERVISOR">Supervisor</option>
                        <?php endif; ?>
                        <option value="VIGILANTE">Vigilante</option>
                    </select>
                </div>
               
                <div class="input-caja-registro seccion-individual seccion-individual-02">
                    <label for="contrasena" class="label-input">Contraseña</label>
                    <input type="password" class="campo campo-individual" name="contrasena" id="contrasena" pattern="[A-Za-z0-9*_@\-]{8,}" title="Debes digitar solo letras, números y/o caracteres especiales(*_-@), mínimo 8" minlength="8" tabindex="8">
                </div>

                <div class="input-caja-registro seccion-individual seccion-individual-02">
                    <label for="confirmacion_contrasena" class="label-input">Confirmar contraseña</label>
                    <input type="password" class="campo campo-individual" name="confirmacion_contrasena" id="confirmacion_contrasena" pattern="[A-Za-z0-9*_@\-]{8,}" title="Debes digitar solo letras, números y/o caracteres especiales(*_-@), mínimo 8" minlength="8" tabindex="9">
                </div>
            </div>
            
            <div id="contenedor_btns_vigilante">
                <button type="button" id="btn_atras_vigilante">Atras</button>
                <button type="button" id="btn_cancelar_vigilante">Cancelar</button>
                <button type="button" id="btn_siguiente_vigilante">Siguiente</button>
                <button type="submit" id="btn_registrar_vigilante">Registrar</button>
            </div>
        </form>
    </div>
</div>
