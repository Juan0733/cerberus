
<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Vehículo</h2>
    <ion-icon name="close-outline" id="cerrar_modal_vehiculo" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form action="" id="formulario_vehiculo" method="post" >
            <div id="contenedor_cajas_vehiculo">
                <div class="input-caja-registro">
                    <label for="propietario" class="label-input">Propietario del vehículo</label>
                    <input type="text" class="campo" inputmode="numeric" name="propietario" id="propietario" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y letras, mínimo 6 y máximo 15 caracteres" placeholder="Ej: 123456" tabindex="4" required>
                </div>

                <div class="input-caja-registro">
                    <label for="tipo_vehiculo" class="label-input">Tipo de vehículo</label>
                    <select class="campo"  name="tipo_vehiculo" id="tipo_vehiculo" tabindex="5" required>
                        <option value="">Selecciona el tipo de vehiculo.</option>
                        <option value="AUTOMÓVIL">Automóvil</option>
                        <option value="BUS">Bus</option>
                        <option value="CAMIÓN">Camión</option>
                        <option value="MOTO">Moto</option>
                    </select>
                </div>
    
                <div class="input-caja-registro">
                    <label for="numero_placa" class="label-input">Placa del vehículo</label>
                    <input type="text" class="campo  validacion-campo-03 input-placa"  name="numero_placa" id="numero_placa" pattern="[A-Za-z0-9]{5,6}" title="Debes digitar solo números y letras, mínimo 5 y máximo 6 caracteres." placeholder="Ej: ABC123" tabindex="6" required>
    
                </div>
            </div>

            <div id="contenedor_btns_vehiculo">
                <button type="button" id="btn_cancelar_vehiculo">Cancelar</button>
                <button type="submit" id="btn_registrar_vehiculo">Registrar</button>
            </div>
        </form>
    </div>
</div>


