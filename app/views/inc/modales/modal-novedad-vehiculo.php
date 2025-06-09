<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Novedad Vehículo</h2>
    <ion-icon name="close-outline" id="cerrar_modal_novedad_vehiculo" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <div id="contenedor_modal_regis_nv">
            <form  class="formulario-fetch formulario_modal_05 "  action="" id="forma_acceso_05" method="post" >

                <div class="contenedor_de_cajas">
                    <div id="caja_01_registro" class="rotado caja_01_registro_05">

                        <div class="input-caja-registro">
                            <label for="tipo_novedad" class="label-input">Tipo de novedad</label>
                            <input type="tel" class="campo validacion-campo-05" inputmode="numeric" name="tipo_novedad" id="tipo_novedad" tabindex="4">
                        </div>

                        <div class="input-caja-registro">
                            <label for="numero_placa" class="label-input">Placa del vehículo</label>
                            <input type="text" class="campo  validacion-campo-03 input-placa"  name="numero_placa" id="numero_placa" pattern="[A-Za-z0-9]{5,6}" title="Debes digitar solo numeros y letras, minimo 5 y maximo 6 caracteres." placeholder="Ej: ABC123" tabindex="6">
                        </div>
                        
                        <div class="input-caja-registro">
                            <label for="documento_involucrado" class="label-input">Identificación del involucrado</label>
                            <input type="tel" class="campo validacion-campo-05" inputmode="numeric" name="documento_involucrado" id="documento_involucrado" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 15 numeros" placeholder="Ej: 123456" date="Numero de documento" tabindex="5" >
                        </div>
                        
                        <div class="input-caja-registro">
                            <label for="propietario" class="label-input">Propietario que autoriza</label>
                            <select class="campo validacion-campo-05" name="propietario" id="propietario" tabindex="6" ></select>
                        </div>
                        
                        <div class="input-caja-registro">
                            <label for="descripcion" class="label-input">Descripcion</label>
                            <input 
                                class="campo validacion-campo-05" 
                                type="text" 
                                name="descripcion" 
                                id="descripcion" 
                                placeholder="Ej: Usuario es autorizado por el propietario, para salir en un vehículo que no esta a su nombre." 
                                tabindex="8" 
                                required
                            >
                        </div>
                    </div>
                </div>
                
                <div id="cont_btn_form_regis_visi">                    
                    <button type="button" id="btn_cancelar_novedad" class="btn-cancelar-05">
                        Cancelar
                    </button>
                    <button type="submit" id="btn_registrarme" class="btn_registrarme-05">Registrar</button>
                </div>
            </form>

        </div>
    </div>
</div>

