<?php
    $fechaActual = date('Y-m-d');
?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">

<?php if(($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'SUPERVISOR') && count($url) > 1): ?>
    <input type="hidden" id="codigo_permiso" value="<?php echo $url[1]; ?>">
<?php endif; ?>


<div id="contenedor_principal">
    <div id="contenedor_filtros">
        <div class="filtro">
            <label for="tipo_permiso_filtro">Tipo:</label>
            <select id="tipo_permiso_filtro" name="tipo_permiso_filtro">
                <option value="">Todos</option>
                <option value="PERMANENCIA">Permanencia</option>
            </select>
        </div>

        <div class="filtro">
            <label for="estado_permiso_filtro">Estado</label>
            <select id="estado_permiso_filtro" name="estado_permiso_filtro">
                <option value="">Todos</option>
                <option value="APROBADO">Aprobado</option>
                <option value="DESAPROBADO">Desaprobado</option>
                <option value="PENDIENTE">Pendiente</option>
            </select>
        </div>

        <div class="filtro">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" max="<?php echo $fechaActual; ?>">
        </div>

        <div class="filtro">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" name="buscador_placa" id="buscador_placa" placeholder="Buscar Placa" maxlength="6">
        </div> 

        <?php if($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR'): ?>
            <button class="btn-permiso-vehiculo" id="btn_crear_permiso_vehiculo">
                <ion-icon name="add"></ion-icon>
            </button>
        <?php endif; ?>
    </div>

    <div id="contenedor_tabla_cards">
    </div>

    <?php if($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR'): ?>
        <button class="btn-permiso-vehiculo" id="btn_crear_permiso_vehiculo_mobile">
            <ion-icon name="add"></ion-icon>
        </button>
    <?php endif; ?>

</div>