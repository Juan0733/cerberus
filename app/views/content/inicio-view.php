<?php
    date_default_timezone_set('America/Bogota');
    $meses = [
        'January' => 'enero',
        'February' => 'febrero',
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre'
    ];
    $fecha = new DateTime();

    $mes = $meses[$fecha->format('F')];
    $fecha = $mes . ' ' . $fecha->format('d').' '.$fecha->format('Y'); 
?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
<div class="contenedor-bienvenida">
    <div class="cont_saludo">
        <h1 id="saludo_home">Hola <?php echo $_SESSION['datos_usuario']['nombres']?>!</h1>
        <p id="bienvenida">Bienvenido a Cerberus</p>
    </div>
    <div id="contenedor-ppal-panel">
        <h3 class="titulo_multi_detalle">Multitud Detallada</h3>
        <div id="contenedor_cartas_multitudes">
            <h3 class="titulo_multi_detalle_02">Multitud Detallada</h3>
            <div class="caja">

                <div class="card activada"><!-- Card Aprendices -->
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Aprendices</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_aprendices"></h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_aprendices"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_aprendices"></p>
                </div>

                <div class="card activada"><!-- Card Funcionarios Comunes -->
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Funcionarios</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_funcionarios"></h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_funcionarios"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_funcionarios"></p>
                </div>
                
                <div class="card activada"><!-- Card Visitantes -->
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Visitantes</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_visitantes"></h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_visitantes"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_visitantes"></p>
                </div>

                <div class="card activada"><!-- Card Vigilantes -->
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Vigilantes</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_vigilantes"></h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_vigilantes"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_vigilantes"></p>
                </div>

                <div class="card activada">"><!-- Card Carros -->
                    <p class="fecha-card"></p>
                    <div class="titulo-card">
                        <ion-icon name="car-outline"></ion-icon>
                        <h3>Carros</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_carros"></h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_carros"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_carros"></p>
                </div>

                <div class="card activada">"><!-- Card Motos -->
                    <p class="fecha-card"></p>
                    <div class="titulo-card">
                        <ion-icon name="car-outline"></ion-icon>
                        <h3>Motos</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_motos"></h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_motos"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_motos"></p>
                </div>
            </div>
        </div>
    </div>
    <script>
    
  </script>
</div>
