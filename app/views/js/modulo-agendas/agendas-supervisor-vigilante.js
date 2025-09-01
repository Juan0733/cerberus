import {modalDetalleAgenda} from '../modales/modal-detalle-agenda.js'
import {consultarAgendas} from '../fetchs/agenda-fetch.js'

let urlBase;
let contenedorCards;

const parametros = {
    fecha: '',
    documento: '',
    titulo: ''
}

function dibujarAgendas(){
    consultarAgendas(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            contenedorCards.innerHTML = '';

            respuesta.agendas.forEach(agenda => {
                const fecha = formatearFecha(agenda.fecha_agenda);

                contenedorCards.innerHTML += `
                    <div class="card-agenda">
                        <div class="card-agenda-header">
                            <h1>${agenda.titulo}</h1>
                        </div>
                        <div class="card-agenda-body">
                            <strong><p class="nombre">Agendado:</p></strong> 
                            <p>${agenda.nombres_agendado} ${agenda.apellidos_agendado}</p>
                            
                            <div class="contenedor-fecha-agenda">
                                <div>
                                    <strong><p class="fecha-agenda">Fecha Agenda:</p></strong>
                                    <p>${fecha.fecha_español}</p>
                                </div>
                                
                                <div>
                                    <strong><p class="fecha-agenda">Hora Agenda:</p></strong>
                                    <p>${fecha.hora_español}</p>
                                </div>
                                
                            </div>
                            <div class="contenedor-icons">
                                <ion-icon class="ver" name="eye" data-codigo="${agenda.codigo_agenda}"></ion-icon>
                            </div>
                        </div>
                    </div>`;
            });

            eventoVerDetalleAgenda();

        }else if(respuesta.tipo == 'ERROR'){
            contenedorCards.innerHTML = `<p id="mensaje_respuesta">${respuesta.mensaje}</p>`;

            if(respuesta.titulo != 'Datos No Encontrados'){
                alertaError(respuesta);
            }
        }
    })
}

function eventoVerDetalleAgenda(){
    const botonesVer = document.querySelectorAll('.ver');

    botonesVer.forEach(boton => {
        let codigoAgenda = boton.getAttribute('data-codigo');
        boton.addEventListener('click', ()=>{
            modalDetalleAgenda(codigoAgenda, urlBase);
        })
    });
}

function formatearFecha(fechaHora){
    const [fecha, hora] = fechaHora.split(' ');
    const [anio, mes, dia] = fecha.split('-');

    let horas = '00';
    let minutos = '00';
    let segundos = '00';

    if(hora){
        [horas, minutos, segundos] = hora.split(':');
    }

    const objetoFecha = new Date(
        Number(anio),
        Number(mes) - 1,
        Number(dia),
        Number(horas),
        Number(minutos),
        Number(segundos)
    );

    let opciones = { weekday: 'long' };
    let diaEspañol = objetoFecha.toLocaleDateString('es-CO', opciones);
    diaEspañol = diaEspañol.charAt(0).toUpperCase() + diaEspañol.slice(1);

    opciones = { day: 'numeric', month: 'long' }
    const fechaEspañol = objetoFecha.toLocaleDateString('es-CO', opciones);

    opciones = { hour: 'numeric', minute: '2-digit', hour12: true };
    const horaEspañol = objetoFecha.toLocaleTimeString('es-CO', opciones);

    return {dia_español: diaEspañol, fecha_español: fechaEspañol, hora_español: horaEspañol};
}


function eventoBuscarDocumento(){
    const inputDocumento = document.getElementById('buscador_documento');
    let temporizador;
    
    inputDocumento.addEventListener('input', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            parametros.documento = inputDocumento.value;
            dibujarAgendas();
        }, 500)
    })
}

function eventoBuscarTitulo(){
    const inputTitulo = document.getElementById('buscador_titulo');
    let temporizador;
    
    inputTitulo.addEventListener('input', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            parametros.titulo = inputTitulo.value;
            dibujarAgendas();
        }, 500)
    })
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

document.addEventListener('DOMContentLoaded', function () {
    urlBase = document.getElementById('url_base').value;
    contenedorCards = document.getElementById('contenedor_cards');
    
    const inputFecha = document.getElementById('fecha');
    parametros.fecha = inputFecha.value;

    dibujarAgendas();
    eventoFecha();
    eventoBuscarDocumento();
    eventoBuscarTitulo();
})

