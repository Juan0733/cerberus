<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Vehiculo</h2>
    <ion-icon name="close-outline" id="cerrar_modal_vehiculo" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <div id="contenedor_modal_regis_vh">
            <form  class="formulario-fetch formulario_modal_03 "  action="" id="forma_acceso_03" method="post" >
            <input type="hidden" name="modulo_vehiculo" value="registrar">
                <div class="contenedor_de_cajas">
                    <div id="caja_01_registro" class="rotado rotado caja_02_registro_03">
                        
                            <div class="input-caja-registro">
                                <label for="propietario" class="label-input">Propietario del vehículo</label>
                                <input type="text" class="campo  validacion-campo-03" inputmode="numeric" name="propietario" id="propietario" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo numeros y letras, minimo 6 y maximo 15 caracteres" placeholder="Ej: 123456" tabindex="4">
                            </div>

                            <div class="input-caja-registro">
                                
                                <label for="tipo_vehiculo" class="label-input">Tipo de vehículo</label>
                                <select class="campo"  name="tipo_vehiculo" id="tipo_vehiculo" tabindex="5">
                                    <option value="">Selecciona el tipo de vehiculo.</option>
                                    <option value="AT">Automovil</option>
                                    <option value="BS">Bus</option>
                                    <option value="CM">Camion</option>
                                    <option value="MT">Moto</option>
                                </select>
                
                            </div>
                
                            <div class="input-caja-registro">
                                
                                <label for="numero_placa" class="label-input">Placa del vehículo</label>
                                <input type="text" class="campo  validacion-campo-03 input-placa"  name="numero_placa" id="numero_placa" pattern="[A-Za-z0-9]{5,6}" title="Debes digitar solo numeros y letras, minimo 5 y maximo 6 caracteres." placeholder="Ej: ABC123" tabindex="6">
                
                            </div>
                    
                    </div>

                </div>
                
        

                <div id="cont_btn_form_regis_visi">
                    
                    <button type="button" id="btn_cancelar_vehiculo" class="btn-cancelar-03">
                        Cancelar
                    </button><!-- 
                    <button type="button" id="btn-siguiente" onclick="motrarCampos()">Siguiente</button> -->
                    <button type="submit" id="btn_registrarme" class="btn-siguiente-03">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>


