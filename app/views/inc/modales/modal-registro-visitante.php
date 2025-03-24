<div id="cont_info_modales">
    <div id="contenedor_modal_regis_vs">
        <form  class="formulario-fetch formulario_modal_04 "  action="../app/ajax/visitantes-ajax.php" id="forma_acceso_04" method="post" >

            <input type="hidden" name="modulo_visitante" value="registrar">
            <div class="contenedor_de_cajas">
                <div id="caja_01_registro" class="rotado caja_01_registro_04">
                    
                    <div class="input-caja-registro">
                        <label for="nombres_visitante" class="label-input">Nombre(s)</label>
                        <input type="text" class="campo validacion-campo-04" name="nombres_visitante" id="nombres_visitante" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{1,64}" title="Debes digitar solo letras y minimo dos letras" placeholder="Ej: Oscar Alejandro" tabindex="1" date="Nombre(s)" required>
                    </div>

                    <div class="input-caja-registro">
                        <label for="apellidos_visitante" class="label-input">Apellido(s)</label>
                        <input type="text" class="campo validacion-campo-04" name="apellidos_visitante" id="apellidos_visitante" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,64}" title="Debes digitar solo letras y minimo dos letras" placeholder="Ej: Alvarez" tabindex="2" date="Apellido(s)" required>

                    </div>

                    <div class="input-caja-registro">

                        <label for="correo_visitante" class="label-input">Correo electronico</label>
                        <input class="campo validacion-campo-04" type="email" name="correo_visitante" id="correo_visitante" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}" maxlength="88" minlength="6" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electronico." tabindex="3" date="Correo electronico" required>
                    </div>
                </div>
                

                <div id="caja_02_registro" class="rotado caja_02_registro_04">

                    <div class="input-caja-registro">

                        <label for="tipo_doc_visitante" class="label-input">Tipo de documento</label>
                        <select class="campo validacion-campo-04"  name="tipo_doc_visitante" id="tipo_doc_visitante" tabindex="4" date="Tipo de documento" required>
                            <option value="" >Selecciona el tipo de documento.</option>
                            <option value="CC">Cedula</option>
                            <option value="TI">Tarjeta de identidad</option>
                            <option value="PS">Pasaporte</option>
                            <option value="OT">Otro</option>
                        </select>
                        
                    </div>

                    <div class="input-caja-registro">
                        <label for="num_documento_visitante" class="label-input">Numero de documento</label>
                        <input type="tel" class="campo validacion-campo-04" inputmode="numeric" name="num_documento_visitante" id="num_documento_visitante" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456Dil" date="Numero de documento" tabindex="5" >
                        
                    </div>

                    <div class="input-caja-registro">
                        
                        <label for="telefono_visitante" class="label-input">Numero de telefono</label>
                        <input type="tel" class="campo validacion-campo-04" inputmode="numeric" name="telefono_visitante" id="telefono_visitante" pattern="[0-9]{10}" title="Debes digitar solo numeros y como minimo y maximo 10 numeros" placeholder="Ej: 3104444333" date="Numero de telefono" tabindex="6" >

                    </div>
                    
                    <h3 id="subtitulo_no_obligatorio">(No Obligatorios)</h3>
                    <div class="contenedor_campos_no_obl_mobile">
                        <div class="input-caja-registro">      
                            <label for="tipo_vehiculo_visitante" class="label-input">Tipo de vehiculo</label>
                            <select class="campo"  name="tipo_vehiculo_visitante" id="tipo_vehiculo_visitante" tabindex="7">
                                <option value="">Selecciona el tipo de vehiculo.</option>
                                <option value="AT">Atomovil</option>
                                <option value="BS">Bus</option>
                                <option value="CM">Camion</option>
                                <option value="MT">Moto</option>
                            </select>
                        </div>

                        <div class="input-caja-registro">
                            
                            <label for="placa_vehiculo_visitante" class="label-input">Placa de vehiculo</label>
                            <input type="tel" class="campo"  name="placa_vehiculo_visitante" id="placa_vehiculo_visitante" pattern="[A-Z0-9]{5,}" title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="8">

                        </div>

                    </div>
                </div>

            </div>
            
            <h3 id="subtitulo_no_obligatorio_desk">(No Obligatorios)</h3>
            <div class="contenedor_campos_no_obl">
                <div class="input-caja-registro input-caja-registro-vehiculo modal-reg-v-01">      
                    <label for="tipo_vehiculo_visitante" class="label-input">Tipo de vehiculo</label>
                    <select class="campo"  name="tipo_vehiculo_visitante" id="tipo_vehiculo_visitante" tabindex="7">
                        <option value="">Selecciona el tipo de vehiculo.</option>
                        <option value="AT">Atomovil</option>
                        <option value="BS">Bus</option>
                        <option value="CM">Camion</option>
                        <option value="MT">Moto</option>
                    </select>
                </div>

                <div class="input-caja-registro input-caja-registro-vehiculo modal-reg-v-02">
                    
                    <label for="placa_vehiculo_visitante" class="label-input">Placa de vehiculo</label>
                    <input type="tel" class="campo"  name="placa_vehiculo_visitante" id="placa_vehiculo_visitante" pattern="[A-Z0-9]{5,}" title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="8">

                </div>

            </div>

            <div id="cont_btn_form_regis_visi">
                <button type="button" id="btn_atras" class="btn_atras_04"  onclick="volverCampos('04')">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                   
                </button>
                
                <button type="button" id="btn-cancelar" class="btn-cancelar-04" onclick="closeModal(this)">
                    Cancelar
                </button>
                <button type="button" id="btn-siguiente" class="btn-siguiente-04" onclick="motrarCampos('04')">Siguiente</button>
                <button type="button" id="btn_registrarme" class="btn_registrarme-04" onclick="enviaFormulario('04')">Registrar</button>
            </div>
        </form>

    </div>
</div>