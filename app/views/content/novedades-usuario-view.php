<?php
    $fechaActual = date('Y-m-d');
?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
<div id="contenedor_principal">
    <div id="contenedor_filtros">
        <div class="filtro">
            <label for="tipo_novedad_filtro">Tipo:</label>
            <select id="tipo_novedad_filtro" name="tipo_novedad_filtro">
                <option value="">Todas</option>
                <option value="ENTRADA NO REGISTRADA">Entrada No Registrada</option>
                <option value="SALIDA NO REGISTRADA">Salida No Registrada</option>
            </select>
        </div>

        <div class="filtro">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" max="<?php echo $fechaActual; ?>">
        </div>

        <div class="filtro">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" name="buscador_documento" id="buscador_documento" placeholder="Buscar Documento" maxlength="15">
        </div> 
    </div>

    <div id="contenedor_tabla_cards">
    </div>

</div>