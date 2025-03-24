<div id="cont_info_modales">
    <div id="contenedor_modal_regis_nv">
        <form  class="formulario-fetch formulario_modal_05 "  action="../app/ajax/ingreso-ajax.php" id="forma_acceso_05" method="post" >
        
         <input type="hidden" name="modulo_ingreso" value="novedades_entrada_salida">
         <input type="hidden" name="modulo_ingreso_tipo" id="modulo_ingreso_tipo" value="">

            <div class="contenedor_de_cajas">
                <div id="caja_01_registro" class="rotado caja_01_registro_05">
                    
                    <div class="input-caja-registro">
                        <label for="num_documento_causante" class="label-input"># Identificación Causante</label>
                        <input type="tel" class="campo validacion-campo-05" inputmode="numeric" name="num_documento_causante" id="num_documento_causante" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" date="Numero de documento" tabindex="1" >
                        
                    </div>


                   
                </div>
                

                <div id="caja_02_registro" class="rotado caja_02_registro_05">

                    
                    <div class="contenedor_campos_no_obl_mobile">
                        
                        <div class="input-caja-registro">
                            <label for="puerta_de_suceso" class="label-input">Puerta de suceso</label>
                            <input type="text" class="campo validacion-campo-05" name="puerta_de_suceso" id="puerta_de_suceso" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{2,64}" title="Debes digitar solo letras y minimo 9 letras" placeholder="Ej: Puerta de Ganaderia" tabindex="2" date="Puerta de suceso" required>

                        </div>
                        <?php
                            // Calcular las fechas max y min
                            $fechaActual = new DateTime();
                            $fechaMinima = (clone $fechaActual)->modify('-3 year'); 
                            $fechaMaxima = $fechaActual;
                            $fechaMinimaFormatted = $fechaMinima->format('Y-m-d\TH:i');
                            $fechaMaximaFormatted = $fechaMaxima->format('Y-m-d\TH:i');
                        ?>

                        <div class="input-caja-registro">
                            <label for="fecha_suceso" class="label-input">Fecha de suceso</label>

                            <input 
                                class="campo validacion-campo-05" 
                                type="datetime-local" 
                                name="fecha_suceso" 
                                id="fecha_suceso" 
                                placeholder="Selecciona una fecha" 
                                title="Selecciona la fecha del suceso." 
                                tabindex="3" 
                                required 
                                min="<?= $fechaMinimaFormatted ?>" 
                                max="<?= $fechaMaximaFormatted ?>"
                            >
                        </div>
                    
                        <h3 id="subtitulo_no_obligatorio">(No Obligatorios)</h3>

                    </div>
                </div>

            </div>
            
            <h3 id="subtitulo_no_obligatorio_desk">(No Obligatorios)</h3>
            <div class="contenedor_campos_no_obl">
                <div class="input-caja-registro">
                    
                    <label for="placa_vehiculo" class="label-input">Placa de vehiculo</label>
                    <input type="tel" class="campo"  name="placa_vehiculo" id="placa_vehiculo" pattern="[A-Z0-9]{6}" title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="4">

                </div>
                

                <div class="input-caja-registro ">
                   
                    <label for="observaciones" class="label-input">Observacion</label>
                    <textarea class="campo" inputmode="numeric" name="observaciones" id="observaciones" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Escribe aquí..." tabindex="5" ></textarea>
                

                </div>

            </div>

            <div id="cont_btn_form_regis_visi">
                <button type="button" id="btn_atras" class="btn_atras_05"   onclick="volverCampos('05')">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                   
                </button>
                
                <button type="button" id="btn-cancelar" class="btn-cancelar-05" onclick="closeModal(this)">
                    Cancelar
                </button><!-- 
                <button type="button" id="btn-siguiente" onclick="motrarCampos()">Siguiente</button> -->
                <button type="button" id="btn_registrarme" class="btn_registrarme-05"  onclick="enviaFormulario('05')">Registrar</button>
            </div>
        </form>

    </div>
</div>