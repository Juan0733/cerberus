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
            <input type="text" name="buscador_documento" id="buscador_documento" placeholder="Buscar Documento" maxlength="15">
        </div> 

        <button class="btn-visitante" id="btn_crear_visitante">
            <ion-icon name="add"></ion-icon>
        </button>
    </div>

    <div id="contenedor_tabla_cards">
    </div>

    <button class="btn-visitante" id="btn_crear_visitante_mobile">
        <ion-icon name="add"></ion-icon>
    </button>
</div>