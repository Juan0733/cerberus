import {consultarMovimientosUsuarios} from '../fetchs/movimientos-fetch.js'

let jornada;
let fecha;
let tipoMovimiento;
let graficaVisitantes;
let graficaAprendices;
let graficaFuncionarios;
let graficaVigilantes;
let urlBase;

let instancias = [];

const parametros = {
    jornada: '',
    puerta: '',
    tipo_movimiento: '',
    fecha: ''
}


function eventoPuerta(){
    let selectPuerta = document.getElementById('puerta');

    selectPuerta.addEventListener('change', ()=>{
        parametros.puerta = selectPuerta.value;
       dibujarGraficas();
    })
}

function eventoFecha(){
   fecha.addEventListener('change', ()=>{
        parametros.fecha = fecha.value;
        dibujarGraficas();
    })
}

function eventoJornada(){
    jornada.addEventListener('change', ()=>{
        parametros.jornada = jornada.value;
        dibujarGraficas();
    })
}

function eventoTipoMovimiento(){
    tipoMovimiento.addEventListener('change', ()=>{
        parametros.tipo_movimiento = tipoMovimiento.value;
        dibujarGraficas();
    })
}

function dibujarGraficas() {
    consultarMovimientosUsuarios(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            let label = '# ' + formatearString(parametros.tipo_movimiento) + 's por hora'
            respuesta.movimientos.forEach((movimiento, indice) => {
                const configuracion = {
                    type: 'line',
                    data: {
                        labels: movimiento.rangos,
                        datasets: [{
                            label: label,  
                            data: movimiento.cantidades,
                            borderColor: "#001629",     
                            backgroundColor: '#01B401',     
                            borderWidth: 1.5, 
                            fill: false,                   
                            tension: 0.1                 
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                ticks: {
                                    stepSize: 1 
                                },
                                beginAtZero: true
                            }
                        }
                    }
                };

                if(instancias[indice]){
                    instancias[indice].destroy();
                }

                switch (movimiento.tipo_usuario) {
                    case 'visitantes':
                        instancias[indice] = new Chart(graficaVisitantes, configuracion)
                        break;

                    case 'aprendices':
                        instancias[indice] = new Chart(graficaAprendices, configuracion)
                        break;

                    case 'funcionarios':
                        instancias[indice] = new Chart(graficaFuncionarios, configuracion)
                        break;

                    case 'vigilantes':
                        instancias[indice] = new Chart(graficaVigilantes, configuracion)
                        break;
                }
            });
        }else if(respuesta.titulo == 'Sesión Expirada'){
            window.location.replace(urlBase+'sesion-expirada');
        }else{
            alertaError(respuesta);
        }
    })
}

function formatearString(cadena) { 
    cadena = cadena.toLowerCase();
    cadena = cadena.charAt(0).toUpperCase() + cadena.slice(1);
    return cadena; 
}

function alertaError(respuesta){
    Swal.fire({
        icon: "error",
        iconColor: "#fe0c0c",
        title: respuesta.titulo,
        text: respuesta.mensaje,
        confirmButtonText: 'Aceptar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar'
        }
    });
}

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    fecha = document.getElementById('fecha');
    jornada = document.getElementById('jornada');
    tipoMovimiento = document.getElementById('tipo_movimiento');
    graficaVisitantes = document.getElementById('grafica_visitantes');
    graficaAprendices = document.getElementById('grafica_aprendices');
    graficaFuncionarios = document.getElementById('grafica_funcionarios');
    graficaVigilantes = document.getElementById('grafica_vigilantes');

    parametros.fecha = fecha.value;
    parametros.jornada = jornada.value;
    parametros.tipo_movimiento = tipoMovimiento.value;

    eventoFecha();
    eventoJornada();
    eventoTipoMovimiento();
    eventoPuerta();
    dibujarGraficas();

})