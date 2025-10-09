<?php
    $fechaActual = date('Y-m-d');
?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
<div id="contenedor_principal">
    <div id="contenedor_filtros">
        <div class="caja-flex" id="caja_01">
            <div class="fecha filtro">
                <label class="fechas_input" for="fecha_inicio">Desde:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" title="Fecha Inicio" placeholder="Fecha Inicio" max="<?php echo $fechaActual; ?>" value="<?php echo $fechaActual; ?>">
            </div>

            <div class="fecha filtro">
                <label class="fechas_input" for="fecha_fin">Hasta:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" title="Fecha Final" placeholder="Fecha Final" max="<?php echo $fechaActual; ?>" min="<?php echo $fechaActual; ?>" value="<?php echo $fechaActual; ?>">
            </div>

            <div class="filtro">
                <label class="fechas_input" for="puerta">Puerta:</label>
                <select id="puerta" name="puerta">
                    <option value="">Todas</option>
                    <option value="PEATONAL">Peatonal</option>
                    <option value="GANADERIA">Vehicular ganaderia</option>
                    <option value="PRINCIPAL">Vehicular principal</option>
                </select>
            </div>
        </div>

        <div class="caja-flex" id="caja_02">
            <div class="buscar filtro" id="contendor_documento">
                <ion-icon class="icon_buscador_informes" name="search-outline"></ion-icon>
                <input type="text" name="buscador_documento" id="buscador_documento" placeholder="Buscar Documento">
            </div>

            <div class="buscar filtro" id="contenedor_placa">
                <ion-icon class="icon_buscador_informes" name="search-outline"></ion-icon>
                <input type="text" class="input-placa" name="buscador_placa" id="buscador_placa" placeholder="Buscar Placa">
            </div>

            <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
                <button type="button" id="btn_informe" class="btn-informe">
                    <ion-icon name="document-text"></ion-icon>
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div id="contenedor_tabla_cards">
    </div>

    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
        <button type="button" id="btn_informe_mobile" class="btn-informe">
            <ion-icon name="document-text"></ion-icon>
        </button>        
    <?php endif; ?> 
</div>


