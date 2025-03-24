
contador()
generarGraficoPorHora()

setInterval(contador, 40000);

function contador() {
    let encabezados = new Headers();

    fetch('../app/ajax/conteos-fetch.php', {
        method: 'POST',
        headers: encabezados, 
        mode: 'cors', 
        cache: 'no-cache', 
    })
    .then(respuesta => respuesta.json()) // Convertimos la respuesta en un objeto JSON.
    .then(datos => {
        document.getElementById("titulo_multitud").innerText = "Multitud: " + datos.totalPersonasDentro;
        document.querySelector(".titulo_multi_detalle").innerHTML ="Multitud: " + datos.totalPersonasDentro;

        // Actualizamos el conteo de aprendices y su porcentaje visual.
        document.getElementById("conteo_aprendices").innerText = datos.conteoUnitarioGeneral['aprendices'] + " Aprendices dentro";
        document.getElementById("barra_01").style.width = datos.porcentajesPersonasVehiculos['aprendices'] + "%";
        document.getElementById("subtitle_barra_01").innerText = parseInt(datos.porcentajesPersonasVehiculos['aprendices']) + "% Son Aprendices";

        // Actualizamos el conteo de funcionarios y su porcentaje visual.
        document.getElementById("conteo_funcionarios").innerText = datos.conteoUnitarioGeneral['funcionarios'] + " Funcionarios dentro";
        document.getElementById("barra_02").style.width = datos.porcentajesPersonasVehiculos['funcionarios'] + "%";
        document.getElementById("subtitle_barra_02").innerText = parseInt(datos.porcentajesPersonasVehiculos['funcionarios'])+ "% Son Funcionarios";

        // Actualizamos el conteo de visitantes y su porcentaje visual.
        document.getElementById("conteo_visitante").innerText = datos.conteoUnitarioGeneral['visitantes'] + " Visitantes dentro";
        document.getElementById("barra_03").style.width = datos.porcentajesPersonasVehiculos['visitantes'] + "%";
        document.getElementById("subtitle_barra_03").innerText = parseInt(datos.porcentajesPersonasVehiculos['visitantes']) + "% Son Visitantes";

        // Actualizamos el conteo de vehículos y su porcentaje visual.
        document.getElementById("conteo_vehiculos").innerText = datos.conteoUnitarioGeneral['vehiculos_personas'] + " Vehículos dentro";
        document.getElementById("barra_04").style.width = datos.porcentajesPersonasVehiculos['vehiculos_personas'] + "%";
        document.getElementById("subtitle_barra_04").innerText = parseInt(datos.porcentajesPersonasVehiculos['vehiculos_personas']) + "% Son Vehículos";

        
        getListadoUltimosRegistros()
    })
    .catch(error => {
        // Manejo de errores en caso de que falle la solicitud o el procesamiento de datos.
        console.error("Error al obtener los datos del servidor:", error);
    });
}

function generarGraficoPorHora() {
    let formData = new FormData()
   
    
    formData.append('modulo_conteo', 'conteosGrafica')

    fetch('../app/ajax/conteos-fetch.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(datosGrafica => {
        // Crear el gráfico con los datos recibidos
        new Chart(document.getElementById('myChart'), {
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
    })
    .catch(error => {
        console.error('Error al obtener los datos:', error);
    });
}


function getListadoUltimosRegistros() {
    let formData = new FormData()
    if (window.innerWidth > 780) {
        formData.append('tipoListado', 'tabla')
    }else{
        formData.append('tipoListado', 'card')
    }
    
    formData.append('modulo_conteo', 'listadoUltimosRegistros')
    fetch('../app/ajax/conteos-fetch.php',{
        method: 'POST',
        body: formData,
        mode: 'cors', 
        cache: 'no-cache',
    }).then(response => {
        if (!response.ok) {
            throw new Error("Error en la respuesta del servidor");
        }
        return response.json();
    })
    .then(resultado => {
        contenedorListado.innerHTML = resultado.listado
    }).catch(err => console.log(err))

    
}