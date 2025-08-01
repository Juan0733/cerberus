<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
<div id="contenedor_principal">
    <div id="contenedor_filtros">
        <div class="filtro">
            <label class="fechas_input" for="ubicacion">Ubicación:</label>
            <select id="ubicacion" name="ubicacion">
                <option value="">Todas</option>
                <option value="DENTRO">Dentro</option>
                <option value="FUERA">Fuera</option>
            </select>
        </div>

        <div class="filtro">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" name="buscador_ficha" id="buscador_ficha" placeholder="Buscar Ficha" maxlength="7">
        </div> 

        <div class="filtro">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" name="buscador_documento" id="buscador_documento" placeholder="Buscar Documento" maxlength="15">
        </div> 

        <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR'): ?>
            <button class="btn-aprendiz" id="btn_crear_aprendiz">
                <ion-icon name="add"></ion-icon>
            </button>
        <?php endif; ?>
        
    </div>

    <div id="contenedor_tabla_cards">
    </div>

     <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR'): ?>
        <button class="btn-aprendiz" id="btn_crear_aprendiz_mobile">
            <ion-icon name="add"></ion-icon>
        </button>
    <?php endif; ?>
    
</div>