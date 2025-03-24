<div class="contenedor-bienvenida">
    <div id="contenedor-ppal-panel">
        <div class="contenedor_grafica">
            <h3 class="titulo_multi_detalle_02">Multitud</h3>
            <div  id="cont_multi">
                
                <div class="titulo-card">
                    <ion-icon name="people-outline"></ion-icon>
                    <h3>Visitantes</h3>
                </div>
                <canvas id="myChart1" style="width:100%;"></canvas>
            </div>
        </div>


        <h3 class="titulo_multi_detalle">Multitud Detallada</h3>
        <div id="contenedor_cartas_multitudes">
            <h3 class="titulo_multi_detalle_02">Multitud Detallada</h3>
            <div class="caja">
            <?php
            // Establece la zona horaria (opcional, ajusta según tu ubicación)
            date_default_timezone_set('America/Bogota');

            // Obtén la fecha actual en el formato deseado
            $fecha = date('M d Y');

            // Muestra la fecha
            
            ?>

                <!-- Carta aprendices -->
                <div class="card card1 activada">
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Aprendices</h3>
                    </div>
                    <div class="contenedor-graficas">
                        <canvas id="myChart2"></canvas>

                    </div>
                    <p class="subtitle">900 Aprendices en el CAB</p>
                </div>
                <!-- Carta funcionario -->
                <div class="card card2 activada">
                    <p class="fecha-card"><?php echo $fecha;?></p>

                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Funcionarios</h3>
                    </div>
                    <div class="contenedor-graficas">
                        <canvas id="myChart3"></canvas>

                    </div>
                    <p class="subtitle">190 Funcionarios en el CAB</p>
                </div>
               
                <!-- Carta vehiculos -->
                <div class="card card2 activada">
                    <p class="fecha-card"><?php echo $fecha;?></p>
                    <div class="titulo-card">
                        <ion-icon name="people-outline"></ion-icon>
                        <h3>Vehiculos</h3>
                    </div>
                    <div class="contenedor-graficas">
                        <canvas id="myChart4"></canvas>
                    </div>
                    <p class="subtitle">150 Vehiculos en el CAB</p>

                </div>
            </div>
        </div>
    </div>
    <div id="contenedor_ppal_panel_02" class="ppal-informes-2">
        
    <div id="contenedor_filtro_informes">
        <div class="contendor_titulo_informes" style="display: flex;">
            <h3 id="titulo_panel_02">Informes</h3>
        </div>
        <div class="contenedor_filtros_fechas">
            <div class="contenedor_fechas">
                <div class="fecha_inicio_input_informes">
                    <label class="fechas_input" for="fecha_inicio_input">Fecha Inicio:</label>
                    <input type="date" id="fecha_inicio_input" name="fecha_inicio" title="Fecha Inicio" placeholder="Fecha Inicio">
                </div>
                <div class="fecha_final_input_informes">
                    <label class="fechas_input" for="fecha_final_input">Fecha Final:</label>
                    <input type="date" id="fecha_final_input" name="fecha_final" title="Fecha Final" placeholder="Fecha Final">
                </div>
            </div>
            <div class="input-buscador-filtro" id="buscador-filtro-informes">
                <ion-icon class="icon_buscador_informes" id="icon_buscador_informes" name="search-outline"></ion-icon>
                <input type="text" name="buscador_filtro" id="buscador_filtro" placeholder="BUSCAR">
            </div>
            
            <button class="btn generar-informes-web" onclick="openModal('Generar Informe', '../app/views/inc/modales/modal-generar-informe.php', 'adaptar-infor')">
                <ion-icon id="icon_filtro" name="arrow-down-outline"></ion-icon>
            </button>
        </div>
    </div>


    
    <div id="contenedor_tabla" class="contenedor-tabla-informes">
                            
    </div>
       
</div>

<script src="<?php echo APP_URL_BASE; ?>app/views/js/informes.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

generarGraficoPersonas()

function generarGraficoPersonas() {
    
    let formData = new FormData()
    
    for (let i = 1; i < 5; i++) {
        

        switch (i) {
            case 1:
                formData.append('modulo_conteo', 'conteosGrafica')
                break;
            case 2:
                formData.append('modulo_conteo', 'conteosGraficaPersonas')
                formData.append('rol_usuario', 'AP')
                break;
        
            case 3:
                formData.append('modulo_conteo', 'conteosGraficaPersonas')
                formData.append('rol_usuario', 'FU')
            break;
        
            case 4:
                formData.append('modulo_conteo', 'conteosGraficaPersonas')
                formData.append('rol_usuario', 'VH')
                break;
        
            default:
                break;
        }

        fetch('../app/ajax/conteos-fetch.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(datosGrafica => {
            
            if (datosGrafica.datos[0]== '0') {
                new Chart(document.getElementById('myChart'+ i), {
                    type: 'line',
                    data: {
                        labels: datosGrafica.etiquetas, // Etiquetas de las horas AM/PM
                        datasets: [{
                            label: '# Reportes por Hora',  
                            data: datosGrafica.datos,     
                            backgroundColor: '#01B401',       
                            fill: false,                   
                            tension: 0.1                 
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,    // No mantener la proporción automática
                        scales: {
                            y: {
                                beginAtZero: true       // Comenzar el eje Y desde cero
                            }
                        }
                    }
                });
                
            }else{
                document.getElementById('myChart').innerText ="hOLA"
            }
        })
        .catch(error => {
            console.error('Error al obtener los datos:', error);
        });
    }
    
}



</script>