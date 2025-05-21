<?php
    date_default_timezone_set('America/Bogota');
    $fechaActual = date('Y-m-d');
?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">

<div class="contenedor-bienvenida">
    <div id="contenedor_ppal_panel_02" class="ppal-informes-2">
        <div id="contenedor_filtro_informes">
            <div class="contenedor_filtros_fechas">
                <div class="contenedor_fechas">

                    <div class="fecha_inicio_input_informes">
                        <label class="fechas_input" for="fecha_inicio">Fecha Inicio:</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" title="Fecha Inicio" placeholder="Fecha Inicio" max="<?php echo $fechaActual; ?>" value="<?php echo $fechaActual; ?>">
                    </div>

                    <div class="fecha_final_input_informes">
                        <label class="fechas_input" for="fecha_fin">Fecha Final:</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" title="Fecha Final" placeholder="Fecha Final" max="<?php echo $fechaActual; ?>" min="<?php echo $fechaActual; ?>" value="<?php echo $fechaActual; ?>">
                    </div>

                    <div class="fecha_inicio_input_informes">
                        <label class="fechas_input" for="puerta">Puerta:</label>
                        <select id="puerta" name="puerta">
                            <option value="">Todas</option>
                            <option value="peatonal">Peatonal</option>
                            <option value="ganaderia">Vehicular ganaderia</option>
                            <option value="principal">Vehicular principal</option>
                        </select>
                    </div>
                    
                </div>

                <div class="input-buscador-filtro" id="contendor_documento">
                    <ion-icon class="icon_buscador_informes" name="search-outline"></ion-icon>
                    <input type="text" name="buscador_documento" id="buscador_documento" placeholder="BUSCAR DOCUMENTO">
                </div>

                <div class="input-buscador-filtro" id="contenedor_placa">
                    <ion-icon class="icon_buscador_informes" name="search-outline"></ion-icon>
                    <input type="text" class="input-placa" name="buscador_placa" id="buscador_placa" placeholder="BUSCAR PLACA">
                </div>

                <button id="generar_informe" class="btn generar-informes-web">
                    <ion-icon id="icon_filtro" name="arrow-down-outline"></ion-icon>
                </button>
                
            </div>
        </div>

    
        <div id="contenedor_tabla" class="contenedor-tabla-informes">
                  
        </div>
       
    </div>
</div>

