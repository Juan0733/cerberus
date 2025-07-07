import {modalRegistroAgenda} from '../modales/modal-registro-agenda.js'
import {modalActualizarAgenda} from '../modales/modal-actualizacion-agenda.js'
import {modalDetalleAgenda} from '../modales/modal-detalle-agenda.js'
import {consultarAgendas, eliminarAgenda} from '../fetchs/agenda-fetch.js'

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
                const fecha = formatearFecha(agenda.fecha_agenda);

                contenedorCards.innerHTML += `
                    <div class="card-agenda">
                        <div class="card-agenda-header">
                            <h1>${agenda.titulo}</h1>
                        </div>
                        <div class="card-agenda-body">
                            <strong><p class="nombre">Nombre:</p></strong> 
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
                                <ion-icon class="eliminar" name="trash" data-codigo="${agenda.codigo_agenda}"></ion-icon>
                                <ion-icon class="editar" name="create" data-codigo="${agenda.codigo_agenda}"></ion-icon>
                                <ion-icon class="ver" name="reader" data-codigo="${agenda.codigo_agenda}"></ion-icon>
                                
                            </div>
                        </div>
                    </div>`;
            });

            eventoVerDetalleAgenda();
            eventoEditarAgenda();
            eventoEliminarAgenda();

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

function eventoEditarAgenda(){
    const botonesEditar = document.querySelectorAll('.editar');

    botonesEditar.forEach(boton => {
        let codigoAgenda = boton.getAttribute('data-codigo');
        boton.addEventListener('click', ()=>{
            modalActualizarAgenda(codigoAgenda, dibujarAgendas, urlBase);
        })
    });
}

function eventoEliminarAgenda(){
    const botonesEliminar = document.querySelectorAll('.eliminar');

    botonesEliminar.forEach(boton=>{
        let codigoAgenda = boton.getAttribute('data-codigo');
        boton.addEventListener('click', ()=>{
            let mensaje = {
                titulo: 'Eliminar Agenda',
                mensaje: '¿Estas seguro que deseas eliminar esta agenda?',
                codigo_agenda: codigoAgenda
            };

            alertaAdvertencia(mensaje);
        })
    })
}

function eventoFecha(){
    const nombreDia = document.getElementById('nombre_dia');
    const fechaFormateada = document.getElementById('fecha_formateada');

    inputFecha.addEventListener('change', ()=>{
        const fecha = formatearFecha(inputFecha.value);
        nombreDia.textContent = fecha.dia_español;
        fechaFormateada.textContent = fecha.fecha_español;

        parametros.fecha = inputFecha.value;
        dibujarAgendas();
    })
}

function formatearFecha(fecha){
   
    const objetoFecha = new Date(fecha.replace(' ', 'T'));

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

function eventoCrearAgenda(){
    const botonCrearAgenda = document.getElementById('btn_crear_agenda');

    botonCrearAgenda.addEventListener('click', ()=>{
        modalRegistroAgenda(urlBase, dibujarAgendas);
    })

    document.getElementById('btn_crear_agenda_mobile').addEventListener('click', ()=>{
        botonCrearAgenda.click();
    })
}

function alertaExito(respuesta){
    Swal.fire({
        toast: true, 
        position: 'top-end', 
        icon: 'success',
        iconColor: "#2db910",
        color: '#F3F4F4',
        background: '#001629',
        timer: 5000,
        timerProgressBar: true,
        title: respuesta.mensaje,
        showConfirmButton: false,   
        customClass: {
            popup: 'alerta-contenedor',
        }
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
        },
        didOpen: (toast) => {
            toast.addEventListener('click', () => {
                Swal.close();
            });
        }
    });
}

function alertaAdvertencia(datos){
    Swal.fire({
        icon: "warning",
        iconColor: "#feb211",
        title: datos.titulo,
        text: datos.mensaje,
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar',
            cancelButton: 'btn-cancelar' 
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if(datos.titulo == "Eliminar Agenda"){
                eliminarAgenda(datos.codigo_agenda, urlBase).then(respuesta=>{
                    if(respuesta.tipo == 'OK'){
                        alertaExito(respuesta);
                        dibujarAgendas();

                    }else if(respuesta.tipo == 'ERROR'){
                        if(respuesta.titulo == 'Sesión Expirada'){
                            window.location.replace(urlBase+'sesion-expirada');
                        }else{
                            alertaError(respuesta);
                        }
                    }
                });   
            }
        } 
    });
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

