<div id="cont_info_modales">
    <div id="contenedor_modal_regis_vh">
        <form  class="formulario-fetch formulario_modal_03 "  action="../app/ajax/vehiculo-ajax.php" id="forma_acceso_03" method="post" >
        <input type="hidden" name="modulo_vehiculo" value="registrar">
            <div class="contenedor_de_cajas">
                <div id="caja_01_registro" class="rotado rotado caja_02_registro_03">
                    
                        <div class="input-caja-registro">
                            <label for="num_documento_visitante" class="label-input">Numero de documento</label>
                            <input type="tel" class="campo  validacion-campo-03" inputmode="numeric" name="num_documento_visitante" id="num_documento_visitante" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" tabindex="2">
                        </div>

                        <div class="input-caja-registro">
                            
                            <label for="tipo_vehiculo_visitante" class="label-input">Tipo de vehiculo</label>
                            <select class="campo"  name="tipo_vehiculo_visitante" id="tipo_vehiculo_visitante" tabindex="3">
                                <option value="">Selecciona el tipo de vehiculo.</option>
                                <option value="AT">Atomovil</option>
                                <option value="BS">Bus</option>
                                <option value="CM">Camion</option>
                                <option value="MT">Moto</option>
                            </select>
            
                        </div>
            
                        <div class="input-caja-registro">
                            
                            <label for="placa_vehiculo_visitante" class="label-input">Placa de vehiculo</label>
                            <input type="text" class="campo  validacion-campo-03"  name="placa_vehiculo_visitante" id="placa_vehiculo_visitante" pattern="[A-Z0-9]{6,7}" title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="4">
            
                        </div>
                   
                </div>

            </div>
            
      

            <div id="cont_btn_form_regis_visi">
                
                <button type="button" id="btn_cancelar_vehiculo" class="btn-cancelar-03" onclick="closeModal(this)">
                    Cancelar
                </button><!-- 
                <button type="button" id="btn-siguiente" onclick="motrarCampos()">Siguiente</button> -->
                <button type="button" id="btn_registrarme" class="btn-siguiente-03"  onclick="enviaFormulario('03')">Registrar</button>
            </div>
        </form>

    </div>
</div>

