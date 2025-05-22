<?php
    date_default_timezone_set('America/Bogota');

    $fechaActual = date('Y-m-d');
    $horaActual = date('H:i:s');

    if(strtotime($horaActual > strtotime('23:59:59') && $horaActual < strtotime('11:59:59'))){
        $jornada = 'mañana';
    }elseif(strtotime($horaActual) > strtotime('11:59:59') && $horaActual < strtotime('17:59:59')){
        $jornada = 'tarde';
    }elseif(strtotime($horaActual) > strtotime('17:59:59') && $horaActual < strtotime('23:59:59')){
        $jornada = 'noche';
    }



?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">

<div class="contenedor-bienvenida">
    <div id="contenedor_ppal_panel_02" class="ppal-informes-2">
        <div id="contenedor_filtro_informes">
            <div class="contenedor_filtros_fechas">
                <div class="contenedor_fechas">

                    <div class="fecha_inicio_input_informes">
                        <label class="fechas_input" for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" max="<?php echo $fechaActual; ?>" value="<?php echo $fechaActual; ?>">
                    </div>

                    <div class="fecha_inicio_input_informes">
                        <label class="fechas_input" for="tipo_movimiento">Tipo movimiento:</label>
                        <select id="tipo_movimiento" name="tipo_movimiento">
                            <option value="entrada">Entradas</option>
                            <option value="salida">Salidas</option>
                        </select>
                    </div>

                    <div class="fecha_inicio_input_informes">
                        <label class="fechas_input" for="jornada">Jornada:</label>
                        <select id="jornada" name="jornada">
                            <option value="mañana" <?php echo $jornada == 'mañana' ? 'selected' : ''; ?>>Mañana</option>
                            <option value="tarde" <?php echo $jornada == 'tarde' ? 'selected' : ''; ?>>Tarde</option>
                            <option value="noche" <?php echo $jornada == 'noche' ? 'selected' : ''; ?>>Noche</option>
                        </select>
                    </div>

                    <div class="fecha_inicio_input_informes">
                        <label class="fechas_input" for="puerta">Puerta:</label>
                        <select id="puerta" name="puerta">
                            <option value="">Todas</option>
                            <option value="peatonal">Peatonal</option>
                            <option value="ganaderia">Vehicular ganaderia</option>
                            <option value="principal">Vehicular principal</option>
                        </select>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div id="contenedor-ppal-panel">
        <div id="contenedor_cartas_multitudes">
            <div class="caja">
                <div class="card card1 activada">
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Visitantes</h3>
                    </div>
                    <div class="contenedor-graficas">
                        <canvas id="grafica_visitantes" style="width:100%;"></canvas>
                    </div>
                </div> 
                    
                <div class="card card1 activada">
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Aprendices</h3>
                    </div>
                    <div class="contenedor-graficas">
                        <canvas id="grafica_aprendices"></canvas>

                    </div>
                </div>
                <div class="card card2 activada">
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Funcionarios</h3>
                    </div>
                    <div class="contenedor-graficas">
                        <canvas id="grafica_funcionarios"></canvas>

                    </div>
                </div>
                
                <div class="card card2 activada">
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Vigilantes</h3>
                    </div>
                    <div class="contenedor-graficas">
                        <canvas id="grafica_vigilantes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



