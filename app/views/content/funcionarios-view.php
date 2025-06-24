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
            <label class="fechas_input" for="rol_filtro">Rol:</label>
            <select class="campo"  name="rol_filtro" id="rol_filtro" tabindex="8" required>
                <option value="">Todos</option>
                <option value="coordinador">Coordinador</option>
                <option value="instructor">Instructor</option>
                <option value="personal administrativo">Personal Administrativo</option>
                <option value="personal aseo">Personal Aseo</option>
                <option value="soporte tecnico">Soporte Tecnico</option>
            </select>
        </div>

        <div class="filtro">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" name="buscador_documento" id="buscador_documento" placeholder="Buscar Documento">
        </div> 

        <button class="btn-funcionario" id="btn_crear_funcionario">
            <ion-icon name="add-outline"></ion-icon>
        </button>
    </div>

    <div id="contenedor_tabla_cards">
    </div>

    <button class="btn-funcionario" id="btn_crear_funcionario_mobile">
        <ion-icon name="add-outline"></ion-icon>
    </button>
</div>