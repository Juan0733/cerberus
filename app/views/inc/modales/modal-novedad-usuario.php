<?php

    // Calcular las fechas max y min
    $fechaActual = new DateTime();
    $fechaMinima = (clone $fechaActual)->modify('-3 year'); 
    $fechaMaxima = $fechaActual;
    $fechaMinimaFormatted = $fechaMinima->format('Y-m-d\TH:i');
    $fechaMaximaFormatted = $fechaMaxima->format('Y-m-d\TH:i');
?>

<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Novedad Usuario</h2>
    <ion-icon name="close-outline" id="cerrar_modal_novedad_usuario" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form  id="formulario_novedad_usuario" method="post" >
            <div id="contenedor_cajas_novedad_usuario" >
                <div class="input-caja-registro">
                    <label for="tipo_novedad" class="label-input">Tipo de novedad</label>
                    <input type="text" class="campo" inputmode="numeric" name="tipo_novedad" id="tipo_novedad" tabindex="4" required>
                </div>
                
                <div class="input-caja-registro">
                    <label for="documento_involucrado" class="label-input">Identificación del involucrado</label>
                    <input type="text" class="campo" inputmode="numeric" name="documento_involucrado" id="documento_involucrado" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y como mínimo 6 numeros y máximo 15 numeros" placeholder="Ej: 123456" date="Numero de documento" tabindex="5" required>
                </div>

                <div class="input-caja-registro">
                    <label for="fecha_suceso" class="label-input">Fecha de suceso</label>
                    <input 
                        class="campo" 
                        type="datetime-local" 
                        name="fecha_suceso" 
                        id="fecha_suceso" 
                        placeholder="Selecciona una fecha" 
                        title="Selecciona la fecha del suceso." 
                        tabindex="6" 
                        required 
                        min="<?php echo $fechaMinimaFormatted; ?>" 
                        max="<? echo $fechaMaximaFormatted; ?>">
                </div>

                <div class="input-caja-registro">
                    <label for="puerta_suceso" class="label-input">Puerta del suceso</label>
                    <select class="campo"  name="puerta_suceso" id="puerta_suceso" tabindex="7" required>
                        <option value="" disabled selected>Selecciona una puerta</option>
                        <option value="GANADERIA">Vehicular ganaderia</option>
                        <option value="PEATONAL">Peatonal</option>
                        <option value="PRINCIPAL">Vehicular principal</option>
                    </select>
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
            
            <div id="contenedor_btns_novedad_usuario">
                <button type="button" id="btn_cancelar_novedad_usuario">Cancelar</button>
                <button type="submit" id="btn_registrar_novedad_usuario">Registrar</button>
            </div>
        </form>
    </div>
</div>

