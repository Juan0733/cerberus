<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
<main id="gran_padre_visitante">
    <section id="contenedor_ppal_visitante">
        <header id="contenedor_titulo_form">
            <div class="" id="cont_title">
                <h1 id="title_logo">Registro Visitante</h1>
                <h3 id="subtitle_logo">Bienvenido al CAB, por favor registrate</h3>
            </div>
        </header>
        <div id="contenedor_formulario_visitante">
            <form id="formulario_visitante" method="post">
                <div id="caja_01" class="caja">
                    <div class="input-caja-registro">
                        <label for="tipo_documento" class="label-input">Tipo de documento</label>
                        <select class="campo campo-seccion-01"  name="tipo_documento" id="tipo_documento" tabindex="8" date="Tipo de documento" required>
                            <option value="" selected disabled>Seleccionar</option>
                            <option value="CC">Cedula de ciudadanía</option>
                            <option value="CE">Cedula de extranjería</option>
                            <option value="TI">Tarjeta de identidad</option>
                            <option value="PP">Pasaporte</option>
                            <option value="PEP">Permiso especial de permanencia</option>
                        </select>
                    </div>

                    <div class="input-caja-registro">
                        <label for="documento_visitante" class="label-input">Número de documento</label>
                        <input type="text" class="campo campo-seccion-01" name="documento_visitante" id="documento_visitante"  pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y/o letras, mínimo 6 y máximo 15 caracteres" placeholder="Ej: 123456Dil" date="Numero de documento" tabindex="9" required>
                    </div>
                
                    <div class="input-caja-registro">
                        <label for="nombres" class="label-input">Nombre(s)</label>
                        <input type="text" class="campo campo-seccion-01" name="nombres" id="nombres" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2 y máximo 50" maxlength="50" minlength="2" placeholder="Ej: Oscar Alejandro" tabindex="4" date="Nombre(s)" required>
                    </div>

                    <div class="input-caja-registro">
                        <label for="apellidos" class="label-input">Apellido(s)</label>
                        <input type="text" class="campo campo-seccion-01" name="apellidos" id="apellidos" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2 y máximo 50" maxlength="50" minlength="2" placeholder="Ej: Alvarez" tabindex="5" date="Apellido(s)" required>
                    </div>
                </div>

                <div id="caja_02" class="caja">
                    <div class="input-caja-registro">
                        <label for="correo_electronico" class="label-input">Correo electrónico</label>
                        <input class="campo" type="email" name="correo_electronico" id="correo_electronico" pattern="[a-zA-Z0-9\._%+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,10}" maxlength="64" minlength="11" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electrónico." tabindex="6" date="Correo electronico" required>
                    </div>

                    <div class="input-caja-registro">
                        <label for="telefono" class="label-input">Número de teléfono</label>
                        <input type="tel" class="campo" inputmode="numeric" name="telefono" id="telefono" pattern="[0-9]{10}" title="Debes digitar solo 10 números, sin espacios ni caracteres especiales" maxlength="10" minlength="10" placeholder="Ej: 3104444333" date="Numero de telefono" tabindex="10" required>
                    </div>
                
                    <div class="input-caja-registro">
                        <label for="motivo_ingreso" class="label-input">Motivo ingreso</label>
                        <input class="campo" type="text" name="motivo_ingreso" id="motivo_ingreso" list="lista_motivos" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,150}" maxlength="100" minlength="5" placeholder="Ej: Matricula" title="Debes digitar solo letras y números, mínimo 5 y máximo 100 caracteres." tabindex="7" date="Motivo ingreso" required>
                        <datalist id="lista_motivos"></datalist>
                    </div>
                </div>

                <div id="contenedor_btns_visitante">
                    <button type="button" id="btn_atras_visitante">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                    </button>
                    <button type="button" id="btn_siguiente_visitante">Siguiente</button>
                    <button type="submit" id="btn_registrarme_visitante">Registrarme</button>
                </div>
            </form>
        </div>
    </section>
</main>
    