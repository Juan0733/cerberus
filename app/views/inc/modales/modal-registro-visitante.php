<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Visitante</h2>
    <ion-icon name="close-outline" id="cerrar_modal_visitante" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <div id="contenedor_modal_regis_vs">
            <form  class="formulario-fetch formulario_modal_04 "  action="" id="forma_acceso_04" method="post" >

                <div class="contenedor_de_cajas">
                    <div id="caja_01_registro" class="rotado caja_01_registro_04">
                        
                        <div class="input-caja-registro">
                            <label for="nombres" class="label-input">Nombre(s)</label>
                            <input type="text" class="campo validacion-campo-04" name="nombres" id="nombres" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,64}" title="Debes digitar solo letras y minimo dos letras" placeholder="Ej: Oscar Alejandro" tabindex="1" date="Nombre(s)" required>
                        </div>

                        <div class="input-caja-registro">
                            <label for="apellidos" class="label-input">Apellido(s)</label>
                            <input type="text" class="campo validacion-campo-04" name="apellidos" id="apellidos" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,64}" title="Debes digitar solo letras y minimo dos letras" placeholder="Ej: Alvarez" tabindex="2" date="Apellido(s)" required>

                        </div>

                        <div class="input-caja-registro">
                            <label for="correo_electronico" class="label-input">Correo electronico</label>
                            <input class="campo validacion-campo-04" type="email" name="correo_electronico" id="correo_electronico" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{11,64}" maxlength="64" minlength="11" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electronico." tabindex="3" date="Correo electronico" required>
                        </div>

                        <div class="input-caja-registro">
                            <label for="motivo_ingreso" class="label-input">Motivo ingreso</label>
                            <input class="campo validacion-campo-04" type="text" name="motivo_ingreso" id="motivo_ingreso" pattern="[a-zA-Z0-9 ]{4,100}" maxlength="100" minlength="4" placeholder="Ej: Matricula" title="Debes digitar solo letras y numeros." tabindex="4" date="Motivo ingreso" required>
                        </div>

                    </div>
                    

                    <div id="caja_02_registro" class="rotado caja_02_registro_04">

                        <div class="input-caja-registro">

                            <label for="tipo_documento" class="label-input">Tipo de documento</label>
                            <select class="campo validacion-campo-04"  name="tipo_documento" id="tipo_documento" tabindex="4" date="Tipo de documento" required>
                                <option value="" >Selecciona el tipo de documento.</option>
                                <option value="CC">Cedula de ciudadanía</option>
                                <option value="CE">Cedula de extranjería</option>
                                <option value="TI">Tarjeta de identidad</option>
                                <option value="PS">Pasaporte</option>
                                <option value="PEP">Permiso especial de permanencia</option>
                            </select>
                            
                        </div>

                        <div class="input-caja-registro">
                            <label for="documento_visitante" class="label-input">Numero de documento</label>
                            <input type="tel" class="campo validacion-campo-04" inputmode="numeric" name="documento_visitante" id="documento_visitante" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456Dil" date="Numero de documento" tabindex="5" >
                            
                        </div>

                        <div class="input-caja-registro">
                            
                            <label for="telefono" class="label-input">Numero de telefono</label>
                            <input type="tel" class="campo validacion-campo-04" inputmode="numeric" name="telefono" id="telefono" pattern="[0-9]{10}" title="Debes digitar solo numeros y como minimo y maximo 10 numeros" placeholder="Ej: 3104444333" date="Numero de telefono" tabindex="6" >

                        </div>
                    </div>

                </div>
                
                <div id="cont_btn_form_regis_visi">
                    <button type="button" id="btn_atras" class="btn_atras_04"  onclick="volverCampos('04')">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                    
                    </button>
                    
                    <button type="button" id="btn-cancelar" class="btn-cancelar-04">
                        Cancelar
                    </button>
                    <button type="button" id="btn-siguiente" class="btn-siguiente-04" onclick="motrarCampos('04')">Siguiente</button>
                    <button type="submit" id="btn_registrarme" class="btn_registrarme-04">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
