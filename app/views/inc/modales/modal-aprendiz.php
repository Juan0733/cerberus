<?php
    require_once "../../../../config/app.php";
    $fechaActual = date('Y-m-d');
?>

<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal" id="titulo_modal_aprendiz">Registrar Aprendiz</h2>
    <ion-icon name="close-outline" id="cerrar_modal_aprendiz" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form action="" id="formulario_aprendiz" method="post" >
            <div id="contenedor_cajas_aprendiz">
                
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
                    <input type="text" class="campo campo-seccion-01" name="numero_documento" id="numero_documento" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y/o letras, mínimo 6 y máximo 15 caracteres" placeholder="Ej: 123456Dil" tabindex="2" >
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
                    <input class="campo" type="email" name="correo_electronico" id="correo_electronico" pattern="[a-zA-Z0-9\._%+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,10}" maxlength="64" minlength="11" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electrónico." tabindex="5" required>
                </div>

                <div class="input-caja-registro seccion-02">
                    <label for="telefono" class="label-input">Número de teléfono</label>
                    <input type="tel" class="campo" inputmode="numeric" name="telefono" id="telefono" pattern="[0-9]{10}" title="Debes digitar solo 10 números, sin espacios ni caracteres especiales" maxlength="10" minlength="10" placeholder="Ej: 3104444333" tabindex="6" required>
                </div>
            
                <div class="input-caja-registro seccion-02">
                    <label for="numero_ficha" class="label-input">Número ficha</label>
                    <input type="text" class="campo" name="numero_ficha" id="numero_ficha" list="lista_fichas" pattern="[0-9]{7}" title="Debes digitar solo números, mínimo y máximo 7" placeholder="Ej: 1234567" maxlength="7" minlength="7" tabindex="7" required>
                    <datalist id="lista_fichas"></datalist>
                </div>
               
                <div class="input-caja-registro seccion-02">
                    <label for="nombre_programa" class="label-input">Nombre programa</label>
                    <input type="text" class="campo" name="nombre_programa" id="nombre_programa" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}" title="Debes digitar solo letras y números, mínimo 5" placeholder="Ej: Tecnico en programación" minlength="8" tabindex="8" required>
                </div>

                <div class="input-caja-registro seccion-02">
                    <label for="fecha_fin_ficha" class="label-input">Fecha finalización ficha</label>
                    <input type="date" class="campo" name="fecha_fin_ficha" id="fecha_fin_ficha" min=<?php echo $fechaActual; ?> tabindex="9" required>
                </div>
            </div>
            
            <div id="contenedor_btns_aprendiz">
                <button type="button" id="btn_atras_aprendiz">Atras</button>
                <button type="button" id="btn_cancelar_aprendiz">Cancelar</button>
                <button type="button" id="btn_siguiente_aprendiz">Siguiente</button>
                <button type="submit" id="btn_registrar_aprendiz">Registrar</button>
            </div>
        </form>
    </div>
</div>
