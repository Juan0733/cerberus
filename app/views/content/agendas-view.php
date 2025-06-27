<?php
    $fecha = new DateTime();
    $diaActual = DIAS[$fecha->format('l')];
    $mesActual = MESES[$fecha->format('F')];
    $fechaFormateada = $fecha->format('j').' de '.$mesActual;
    $fechaActual = date('Y-m-d');
?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
<div id="contenedor_principal">
    <div id="contenedor_filtros">
        <div class="fecha filtro">
            <label class="label-fecha" for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fechaActual; ?>">
        </div>
        
        <div class="buscar filtro">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" name="buscador_documento" id="buscador_documento" placeholder="Buscar Documento">
        </div>

        <div class="buscar filtro">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" name="buscador_titulo" id="buscador_titulo" placeholder="Buscar Titulo Agenda">
        </div>

        <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR'): ?>
            <button class="btn-agenda" id="btn_crear_agenda">
                <ion-icon name="add-outline"></ion-icon>
            </button>
        <?php endif; ?>
    </div>

    <div id="contenedor_fecha_actual">
        <div>
            <h1 id="nombre_dia"><?php echo $diaActual; ?></h1>
            <p id="fecha_formateada"><?php echo $fechaFormateada; ?></p>
        </div>
        <ion-icon name="calendar-number-outline"></ion-icon>
    </div>
   
    <div id="contenedor_agendas">
        <div id="contenedor_cards">
        </div>
    </div>

    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR'): ?>
        <button class="btn-agenda" id="btn_crear_agenda_mobile">
            <ion-icon name="add-outline"></ion-icon>
        </button>
    <?php endif; ?>
    
</div>




