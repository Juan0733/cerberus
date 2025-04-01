<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
<div class="contenedor-bienvenida">
    <div class="cont_saludo">
        <h1 id="saludo_home">Hola <?php echo $_SESSION['datos_usuario']['nombres']?>!</h1>
        <p id="bienvenida">Bienvenido a Cerberus</p>
    </div>
    <div id="buscar-persona">
        <form action="post">
            <div class="cont_buscador">
                

                <ion-icon name="search-outline"></ion-icon>
                
                <input type="text" name="input_buscar_persona" id="input_buscar_persona" placeholder="Buscar Persona" list="listaPersonas">
                
                            
                <datalist id="listaPersonas">
                    <option value="Dilan Adrian Zapata"></option>
                    <option value="Nombre persona 02"></option>
                    <option value="Nombre persona 02"></option>
                </datalist>

            </div>
        </form>
    </div>
    <div id="contenedor-ppal-panel">
        <!-- <div class="contenedor_grafica">
            <h3 class="titulo_multi_detalle_02">Multitud</h3>
            <div  id="cont_multi">
                
                <canvas id="myChart" style="width:100%;"></canvas>
            </div>
        </div> -->
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
        <h3 class="titulo_multi_detalle">Multitud Detallada</h3>
        <div id="contenedor_cartas_multitudes">
            <h3 class="titulo_multi_detalle_02">Multitud Detallada</h3>
            <div class="caja">

                <div class="card card1 activada"><!-- Card Aprendices -->
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

                <div class="card card2 activada"><!-- Card Funcionarios Comunes -->
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Funcionarios Comúnes</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_funcionarios_comunes"></h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_funcionarios_comunes"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_funcionarios_comunes"></p>
                </div>

                <div class="card card1 activada"><!-- Card Funcionarios Brigadistas -->
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Funcionarios Brigadistas</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_funcionarios_brigadistas"></h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_funcionarios_brigadistas"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_funcionarios_brigadistas"></p>
                </div>

                <div class="card card1 activada"><!-- Card Visitantes -->
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

                <div class="card card1 card-vs activada"><!-- Card Vigilantes -->
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

                <!-- <div class="card card2 activada">
                    <p class="fecha-card"></p>
                    <div class="titulo-card">
                        <ion-icon name="car-outline"></ion-icon>
                        <h3>Vehiculos</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_vehiculos">0 Vehiculos en el CAB</h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_04"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_04">61% De los Vehiculos registrados</p>
                </div> -->
            </div>
        </div>
    </div>
    <!-- <div id="contenedor_ppal_panel_02">

        <div style="display:flex;">
            
            <h3 id="titulo_ppal_02">Ultimos Reportes</h3>
           
           

        </div>
        
        
        <div id="contenedor_tabla">
                            
        </div>

    </div>
  -->
    <script>
    
  </script>
</div>
<script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/moduloPrincipal/principal.js"></script>
<script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/general/general.js"></script>