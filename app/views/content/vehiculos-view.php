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
            <label class="fechas_input" for="tipo_filtro">Tipo:</label>
            <select class="campo"  name="tipo_filtro" id="tipo_filtro" required>
                <option value="">Todos</option>
                <option value="AUTOMÓVIL">Automóvil</option>
                <option value="BUSETA">Buseta</option>
                <option value="CAMIÓN">Camión</option>
                <option value="MOTO">Moto</option>
            </select>
        </div>
        <div class="filtro">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" name="buscador_documento" id="buscador_documento" placeholder="Buscar Propietario" maxlength="15">
        </div>

        <div class="filtro">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" class="input-placa" name="buscador_placa" id="buscador_placa" placeholder="Buscar Placa" maxlength="6">
        </div> 
    </div>

    <div id="contenedor_tabla_cards">
    </div>
</div>












