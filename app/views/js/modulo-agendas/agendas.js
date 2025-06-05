import {modalRegistroAgenda} from '../modales/modal-registro-agenda.js'
import {modalDetalleAgenda} from '../modales/modal-detalle-agenda.js'
import {consultarAgendas} from '../fetchs/agenda-fetch.js'

let urlBase;
let contenedorCards;
let inputFecha;

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
                contenedorCards.innerHTML += `
                    <div class="card-agenda">
                        <div class="card-agenda-header">
                            <h1>${agenda.titulo}</h1>
                        </div>
                        <div class="card-agenda-body">
                            <p class="nombre">${agenda.nombres_agendado} ${agenda.apellidos_agendado}</p>
                            <div class="contenedor-fecha-agenda">
                                <div>
                                    <strong><p class="fecha-agenda">Fecha Agenda:</p></strong>
                                    <p>${agenda.fecha}</p>
                                </div>
                                
                                <div>
                                    <strong><p class="fecha-agenda">Hora Agenda:</p></strong>
                                    <p>${agenda.hora}</p>
                                </div>
                                
                            </div>
                            <div class="contenedor-icons">
                                
                                <ion-icon class="eliminar" name="trash-outline" data-codigo="${agenda.codigo_agenda}"></ion-icon>
                                <ion-icon class="editar" name="create-outline" data-codigo="${agenda.codigo_agenda}"></ion-icon>
                                <ion-icon class="ver" name="reader-outline" data-codigo="${agenda.codigo_agenda}"></ion-icon>
                                
                            </div>
                        </div>
                    </div>`;
            });

            eventoVerDetalle();
        }else if(respuesta.tipo == 'ERROR'){
            contenedorCards.innerHTML = `<h2 id="mensaje_respuesta">${respuesta.mensaje}</h2>`
        }
    })
}

function eventoVerDetalle(){
    const botonesVer = document.querySelectorAll('.ver');

    botonesVer.forEach(boton => {
        let codigoAgenda = boton.getAttribute('data-codigo');
        boton.addEventListener('click', ()=>{
            modalDetalleAgenda(codigoAgenda, urlBase);
        })
    });
}

function eventoFecha(){
    const nombreDia = document.getElementById('nombre_dia');
    const fechaFormateada = document.getElementById('fecha_formateada');

    inputFecha.addEventListener('change', ()=>{
        const fechaDividida = inputFecha.value.split('-');
        const objetoFecha = new Date(parseInt(fechaDividida[0]), parseInt(fechaDividida[1]) - 1, parseInt(fechaDividida[2]));
        let opciones = { weekday: 'long' };
        let dia = objetoFecha.toLocaleDateString('es-ES', opciones);
        dia = dia.charAt(0).toUpperCase() + dia.slice(1);
        opciones = { day: 'numeric', month: 'long' }
        const fechaEspañol = objetoFecha.toLocaleDateString('es-ES', opciones);

        nombreDia.textContent = dia;
        fechaFormateada.textContent = fechaEspañol;

        parametros.fecha = inputFecha.value;
        dibujarAgendas();
    })
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

function eventoCrearAgenda(){
    document.getElementById('btn_crear_agenda').addEventListener('click', ()=>{
        modalRegistroAgenda(urlBase, dibujarAgendas);
    })
}

document.addEventListener('DOMContentLoaded', function () {
    urlBase = document.getElementById('url_base').value;
    contenedorCards = document.getElementById('contenedor_cards');
    inputFecha = document.getElementById('fecha');

    parametros.fecha = inputFecha.value;

    dibujarAgendas();
    eventoFecha();
    eventoBuscarDocumento();
    eventoBuscarTitulo();
    eventoCrearAgenda();
})

