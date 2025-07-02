<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Novedad Vehículo</h2>
    <ion-icon name="close-outline" id="cerrar_modal_novedad_vehiculo" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form  action="" id="formulario_novedad_vehiculo" method="post" >
            <div id="contenedor_cajas_novedad_vehiculo">
                <div class="input-caja-registro">
                    <label for="tipo_novedad" class="label-input">Tipo de novedad</label>
                    <select class="campo campo-seccion-01"  name="tipo_novedad" id="tipo_novedad" tabindex="4" required>
                        <option value="" selected disabled>Seleccionar</option>
                        <option value="VEHICULO PRESTADO">Vehiculo prestado</option>
                    </select>
                </div>

                <div class="input-caja-registro">
                    <label for="numero_placa" class="label-input">Placa del vehículo</label>
                    <input type="text" class="campo input-placa"  name="numero_placa" id="numero_placa" pattern="[A-Za-z0-9]{5,6}" title="Debes digitar solo números y letras, mínimo 5 y máximo 6 caracteres." placeholder="Ej: ABC123" tabindex="5">
                </div>
                
                <div class="input-caja-registro">
                    <label for="documento_involucrado" class="label-input">Identificación del involucrado</label>
                    <input type="text" class="campo" inputmode="numeric" name="documento_involucrado" id="documento_involucrado" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y como mínimo 6 y máximo 15" placeholder="Ej: 123456" date="Numero de documento" tabindex="6" >
                </div>
                
                <div class="input-caja-registro">
                    <label for="propietario" class="label-input">Propietario que autoriza</label>
                    <select class="campo" name="propietario" id="propietario" tabindex="7" required></select>
                </div>
                
                <div class="input-caja-registro">
                    <label for="descripcion" class="label-input">Descripción</label>
                    <textarea
                        class="campo" 
                        name="descripcion" 
                        id="descripcion" 
                        placeholder="Escribe aquí..." 
                        tabindex="8" 
                        required></textarea>
                </div>
            </div>
            
            <div id="contenedor_btns_novedad_vehiculo">                    
                <button type="button" id="btn_cancelar_novedad_vehiculo">Cancelar</button>
                <button type="submit" id="btn_registrar_novedad_vehiculo">Registrar</button>
            </div>
        </form>
    </div>
</div>

