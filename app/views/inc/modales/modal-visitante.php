<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Visitante</h2>
    <ion-icon name="close-outline" id="cerrar_modal_visitante" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form action="" id="formulario_visitante" method="post" >
            <div id="contenedor_cajas_visitante">
                <div class="input-caja-registro seccion-01">
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

                <div class="input-caja-registro seccion-01">
                    <label for="documento_visitante" class="label-input">Número de documento</label>
                    <input type="text" inputmode="numeric" class="campo campo-seccion-01" name="documento_visitante" id="documento_visitante"  pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y como mínimo 6 numeros y máximo 15 numeros" placeholder="Ej: 123456Dil" date="Numero de documento" tabindex="9" >
                </div>
            
                <div class="input-caja-registro seccion-01">
                    <label for="nombres" class="label-input">Nombre(s)</label>
                    <input type="text" class="campo campo-seccion-01" name="nombres" id="nombres" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2 y máximo 50" maxlength="50" minlength="2" placeholder="Ej: Oscar Alejandro" tabindex="4" date="Nombre(s)" required>
                </div>

                <div class="input-caja-registro seccion-01">
                    <label for="apellidos" class="label-input">Apellido(s)</label>
                    <input type="text" class="campo campo-seccion-01" name="apellidos" id="apellidos" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}" title="Debes digitar solo letras y mínimo 2 y máximo 50" maxlength="50" minlength="2" placeholder="Ej: Alvarez" tabindex="5" date="Apellido(s)" required>
                </div>
            
                <div class="input-caja-registro seccion-02">
                    <label for="correo_electronico" class="label-input">Correo electrónico</label>
                    <input class="campo" type="email" name="correo_electronico" id="correo_electronico" pattern="[a-zA-Z0-9\._%+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,10}" maxlength="64" minlength="11" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electrónico." tabindex="6" date="Correo electronico" required>
                </div>

                <div class="input-caja-registro seccion-02">
                    <label for="telefono" class="label-input">Número de teléfono</label>
                    <input type="tel" class="campo" inputmode="numeric" name="telefono" id="telefono" pattern="[0-9]{10}" title="Debes digitar solo 10 números, sin espacios ni caracteres especiales" maxlength="10" minlength="10" placeholder="Ej: 3104444333" date="Numero de telefono" tabindex="10" >
                </div>
            
                <div class="input-caja-registro seccion-02">
                    <label for="motivo_ingreso" class="label-input">Motivo ingreso</label>
                    <input class="campo" type="text" name="motivo_ingreso" id="motivo_ingreso" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}" maxlength="100" minlength="5" placeholder="Ej: Matricula" title="Debes digitar solo letras y números, mínimo 5 y máximo 100 caracteres." tabindex="7" date="Motivo ingreso" required>
                </div>
            </div>
            
            <div id="contenedor_btns_visitante">
                <button type="button" id="btn_atras_visitante">Atras</button>
                <button type="button" id="btn_cancelar_visitante">Cancelar</button>
                <button type="button" id="btn_siguiente_visitante">Siguiente</button>
                <button type="submit" id="btn_registrar_visitante">Registrar</button>
            </div>
        </form>
    </div>
</div>
