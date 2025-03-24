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
        <div class="contenedor_grafica">
            <h3 class="titulo_multi_detalle_02">Multitud</h3>
            <div  id="cont_multi">
                
                <canvas id="myChart" style="width:100%;"></canvas>
            </div>
        </div>
        <?php
            // Establece la zona horaria (opcional, ajusta según tu ubicación)
            date_default_timezone_set('America/Bogota');

            // Obtén la fecha actual en el formato deseado
            $fecha = date('M d Y');

            // Muestra la fecha
            
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
                    <h5 class="cantidad" id="conteo_aprendices">0 Aprendices en el CAB</h5>
                    
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_01"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_01">71% De los Aprendices registrados</p>
                </div>
                <div class="card card2 activada"><!-- Card Funcionarios -->
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Funcionarios</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_funcionarios">0 Funcionarios en el CAB</h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_02"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_02">91% De los Funcionarios registrados</p>
                </div>
                <div class="card card1 card-vs activada"><!-- Card Visitantes -->
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Visitantes</h3>
                    </div>
                    <h4 class="cantidad-titulo">Cantidad</h4>
                    <h5 class="cantidad" id="conteo_visitante">0 Visitantes en el CAB</h5>
                    <div class="cantidad-barra">
                        <div class="barra" id="barra_03"></div>
                    </div>
                    <p class="subtitle" id="subtitle_barra_03">0% De los Visitantes registrados</p>
                </div>
                <div class="card card2 activada"><!-- Card Vehiculos -->
                    <p class="fecha-card"><?php echo $fecha;?></p>
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
                </div>
            </div>
        </div>
    </div>
    <div id="contenedor_ppal_panel_02">

        <div style="display:flex;">
            
            <h3 id="titulo_ppal_02">Ultimos Reportes</h3>
           
           

        </div>
        
        
        <div id="contenedor_tabla">
                            
        </div>

    </div>
 
    <script>
    
  </script>
</div>
<script src="<?php echo APP_URL_BASE; ?>app/views/js/panel-ppal.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 