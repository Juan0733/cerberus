<?php
    date_default_timezone_set('America/Bogota');

    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');

    if(strtotime($horaActual) >= strtotime('00:00:00') && strtotime($horaActual) < strtotime('11:59:59')){
        $jornada = 'mañana';
    }elseif(strtotime($horaActual) > strtotime('11:59:59') && strtotime($horaActual) < strtotime('17:59:59')){
        $jornada = 'tarde';
    }elseif(strtotime($horaActual) > strtotime('17:59:59') && strtotime($horaActual) < strtotime('23:59:59')){
        $jornada = 'noche';
    }
?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
<div id="contenedor_principal">
    <div id="contenedor_filtros">
        <div class="caja-flex">
            <div class="filtro">
                <label class="fechas_input" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" max="<?php echo $fechaActual; ?>" value="<?php echo $fechaActual; ?>">
            </div>

            <div class="filtro">
                <label class="fechas_input" for="tipo_movimiento">Movimiento:</label>
                <select id="tipo_movimiento" name="tipo_movimiento">
                    <option value="ENTRADA">Entradas</option>
                    <option value="SALIDA">Salidas</option>
                </select>
            </div>
        </div>
            
        <div class="caja-flex" id="caja_02">
            <div class="filtro">
                <label class="fechas_input" for="jornada">Jornada:</label>
                <select id="jornada" name="jornada">
                    <option value="MAÑANA" <?php echo $jornada == 'mañana' ? 'selected' : ''; ?>>Mañana</option>
                    <option value="TARDE" <?php echo $jornada == 'tarde' ? 'selected' : ''; ?>>Tarde</option>
                    <option value="NOCHE" <?php echo $jornada == 'noche' ? 'selected' : ''; ?>>Noche</option>
                </select>
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
    </div>

    <div id="contenedor_graficas">
        <div id="contenedor_cards">
            <div class="card-grafica">
                <div class="titulo-card">
                    <ion-icon name="people-outline"></ion-icon>
                    <h3>Visitantes</h3>
                </div>
                <div class="contenedor-grafica">
                    <canvas id="grafica_visitantes"></canvas>
                </div>
            </div> 
                
            <div class="card-grafica">
                <div class="titulo-card">
                    <ion-icon name="people-outline"></ion-icon>
                    <h3>Aprendices</h3>
                </div>
                <div class="contenedor-grafica">
                    <canvas id="grafica_aprendices"></canvas>
                </div>
            </div>

            <div class="card-grafica">
                <div class="titulo-card">
                    <ion-icon name="people-outline"></ion-icon>
                    <h3>Funcionarios</h3>
                </div>
                <div class="contenedor-grafica">
                    <canvas id="grafica_funcionarios"></canvas>

                </div>
            </div>
            
            <div class="card-grafica">
                <div class="titulo-card">
                    <ion-icon name="people-outline"></ion-icon>
                    <h3>Vigilantes</h3>
                </div>
                <div class="contenedor-grafica">
                    <canvas id="grafica_vigilantes"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
