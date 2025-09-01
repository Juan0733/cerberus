<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Habilitar Usuario</h2>
    <ion-icon name="close-outline" id="cerrar_modal_habilitar_usuario" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form action="" id="formulario_habilitar_usuario" method="post" >
           <div id="contenedor_cajas_habilitar">
                <div class="input-caja-registro">
                    <label for="contrasena" class="label-input">Nueva contraseña</label>
                    <input type="password" class="campo campo-seccion-01" name="contrasena" id="contrasena" pattern="[A-Za-z0-9*_@-]{8,}" title="Debes digitar solo letras, números y/o caracteres especiales(*_-@), mínimo 8" minlength="8" tabindex="11" required>
                </div>

                    <div class="input-caja-registro">
                    <label for="confirmacion_contrasena" class="label-input">Confirmar contraseña</label>
                    <input type="password" class="campo campo-seccion-01" name="confirmacion_contrasena" id="confirmacion_contrasena" pattern="[A-Za-z0-9*_@\-]{8,}" title="Debes digitar solo letras, números y/o caracteres especiales(*_-@), mínimo 8" minlength="8" tabindex="12" required>
                </div>
            </div>
            
            <div id="contenedor_btns_habilitar_usuario">
                <button type="button" id="btn_cancelar_habilitacion">Cancelar</button>
                <button type="submit" id="btn_habilitar">Habilitar</button>
            </div>
        </form>
    </div>
</div>
