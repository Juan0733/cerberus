
<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Vehículo</h2>
    <ion-icon name="close-outline" id="cerrar_modal_vehiculo" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <div id="contenedor_modal_vehiculo">
            <form action="" id="formulario_vehiculo" method="post" >
                <div id="contenedor_cajas_vehiculo">
                    <div id="caja_01">
                        
                        <div class="input-caja-registro">
                            <label for="propietario" class="label-input">Propietario del vehículo</label>
                            <input type="text" class="campo" inputmode="numeric" name="propietario" id="propietario" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo numeros y letras, minimo 6 y maximo 15 caracteres" placeholder="Ej: 123456" tabindex="4" required>
                        </div>

                        <div class="input-caja-registro">
                            <label for="tipo_vehiculo" class="label-input">Tipo de vehículo</label>
                            <select class="campo"  name="tipo_vehiculo" id="tipo_vehiculo" tabindex="5" required>
                                <option value="">Selecciona el tipo de vehiculo.</option>
                                <option value="Automóvil">Automóvil</option>
                                <option value="Bud">Bus</option>
                                <option value="Camión">Camión</option>
                                <option value="Moto">Moto</option>
                            </select>
                        </div>
            
                        <div class="input-caja-registro">
                            
                            <label for="numero_placa" class="label-input">Placa del vehículo</label>
                            <input type="text" class="campo  validacion-campo-03 input-placa"  name="numero_placa" id="numero_placa" pattern="[A-Za-z0-9]{5,6}" title="Debes digitar solo numeros y letras, minimo 5 y maximo 6 caracteres." placeholder="Ej: ABC123" tabindex="6" required>
            
                        </div>
                    
                    </div>

                </div>

                <div id="contenedor_btns_vehiculo">
                    <button type="button" id="btn_cancelar_vehiculo" class="btn-cancelar-03">Cancelar</button>
                    <button type="submit" id="btn_registrar_vehiculo" class="btn-siguiente-03">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>


