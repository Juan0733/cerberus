<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
<main id="gran_padre_vigilante">
    <section id="contenedor_ppal_vigilante">
        <header id="contenedor_titulo_form">
            <div class="" id="cont_title">
                <h1 id="title_logo">Registro Vigilante</h1>
                <h3 id="subtitle_logo">Bienvenido al CAB, por favor registrate</h3>
            </div>
        </header>
        <div id="contenedor_formulario_vigilante">
            <form id="formulario_vigilante" method="post">
                <div id="caja_01" class="caja">
                     <div class="input-caja-registro">
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

                    <div class="input-caja-registro">
                        <label for="numero_documento" class="label-input">Número de documento</label>
                        <input type="text" inputmode="numeric" class="campo campo-seccion-01" name="numero_documento" id="numero_documento" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y como mínimo 6 y máximo 10" placeholder="Ej: 123456Dil" tabindex="2" >
                    </div>
                
                    <div class="input-caja-registro">
                        <label for="nombres" class="label-input">Nombre(s)</label>
                        <input type="text" class="campo campo-seccion-01" name="nombres" id="nombres" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2" maxlength="50" minlength="2" placeholder="Ej: Oscar Alejandro" tabindex="3" required>
                    </div>

                    <div class="input-caja-registro">
                        <label for="apellidos" class="label-input">Apellido(s)</label>
                        <input type="text" class="campo campo-seccion-01" name="apellidos" id="apellidos" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2" maxlength="50" minlength="2" placeholder="Ej: Alvarez" tabindex="4" required>
                    </div>
                </div>

                <div id="caja_02" class="caja">
                    <div class="input-caja-registro">
                        <label for="correo_electronico" class="label-input">Correo electrónico</label>
                        <input class="campo" type="email" name="correo_electronico" id="correo_electronico" pattern="[a-zA-Z0-9\._%+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,10}" maxlength="64" minlength="11" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electrónico." tabindex="5" required>
                    </div>

                    <div class="input-caja-registro">
                        <label for="telefono" class="label-input">Número de teléfono</label>
                        <input type="tel" class="campo" inputmode="numeric" name="telefono" id="telefono" pattern="[0-9]{10}" title="Debes digitar solo 10 números, sin espacios ni caracteres especiales" maxlength="10" minlength="10" placeholder="Ej: 3104444333" tabindex="6" >
                    </div>
                
                    <div class="input-caja-registro">
                        <label for="rol" class="label-input">Rol</label>
                        <select class="campo"  name="rol" id="rol" tabindex="7" required>
                            <option value="" selected disabled>Seleccionar</option>
                            <option value="JEFE VIGILANTES">Jefe Vigilantes</option>
                            <option value="VIGILANTE RASO">Vigilante Raso</option>
                        </select>
                    </div>
                </div>

                <div id="contenedor_btns_vigilante">
                    <button type="button" id="btn_atras_vigilante">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                    </button>
                    <button type="button" id="btn_siguiente_vigilante">Siguiente</button>
                    <button type="submit" id="btn_registrarme_vigilante">Registrarme</button>
                </div>
            </form>
        </div>
    </section>
</main>
    