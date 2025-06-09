<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Novedad Usuario</h2>
    <ion-icon name="close-outline" id="cerrar_modal_novedad_usuario" class="close-btn"></ion-icon>
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
                            <label for="documento_involucrado" class="label-input">Identificación del involucrado</label>
                            <input type="tel" class="campo validacion-campo-05" inputmode="numeric" name="documento_involucrado" id="documento_involucrado" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 15 numeros" placeholder="Ej: 123456" date="Numero de documento" tabindex="5" >
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
                                tabindex="6" 
                                required 
                                min="<?= $fechaMinimaFormatted ?>" 
                                max="<?= $fechaMaximaFormatted ?>"
                            >
                        </div>

                        <div class="input-caja-registro">
                            <label for="puerta_suceso" class="label-input">Puerta del suceso</label>
                            <select class="campo validacion-campo-05"  name="puerta_suceso" id="puerta_suceso" tabindex="7">
                                <option value="" disabled selected>Selecciona una puerta</option>
                                <option value="ganaderia">Puerta de ganaderia</option>
                                <option value="principal">Puerta principal</option>
                                <option value="peatonal">Puerta peatonal</option>
                            </select>
                        </div>

                        <div class="input-caja-registro">
                            <label for="descripcion" class="label-input">Descripcion</label>
                            <input 
                                class="campo validacion-campo-05" 
                                type="text" 
                                name="descripcion" 
                                id="descripcion" 
                                placeholder="Ej: Salio sin ser registrado por la puerta de ganaderia" 
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

