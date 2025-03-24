
<form action="<?php echo APP_URL_BASE; ?>app/ajax/ingreso-ajax.php" method="post" id="formulario-novedad-persona">
    <?php
    /* if ($url[1]=="salida") {
       ?>
       <input type="hidden" name="modulo_ingreso" value="novedades_salida_personas">
       <?php
    } else if ($url[1]=="entrada"){
        ?>
        <input type="hidden" name="modulo_ingreso" value="novedades_entrada_personas">
        <?php
    } */

    ?>
    <input type="hidden" name="modulo_ingreso" id="modulo_ingreso" value="">
    <label for="num_identificacion_causante"># de documento del causante</label>
    <input type="tel" class="campo" inputmode="numeric" id="num_identificacion_causante" name="num_identificacion_causante"pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" tabindex="4" onchange="buscarPlaca('DENTRO')" readonly> 
    <label for="puerta">puerta</label>
    <input type="text" class="campo" id="puerta" name="puerta">
    <label for="fecha_suceso">Fecha del suceso</label>
    <?php
    $now = new DateTime();

    $fecha_minima = new DateTime();
    $fecha_minima->modify('-3 weeks');

    // Convierte las fechas a formato compatible con datetime-local (Y-m-d\TH:i)
    $fecha_actual = $now->format('Y-m-d\TH:i');
    $fecha_minima_format = $fecha_minima->format('Y-m-d\TH:i');
    ?>
    <input type="datetime-local" class="campo" inputmode="date" id="fecha_suceso" name="fecha_suceso" 
    min="<?php echo $fecha_minima_format; ?>" max="<?php echo $fecha_actual; ?>">

    <label for="descripcion">Descripcion</label>
    <input type="text" class="campo" id="descripcion" name="descripcion">
    <button type="submit">Enviar</button>
</form>
<script src="<?php echo APP_URL_BASE; ?>app/views/js/novedades.js"></script>
