import { consultarVisitantes } from '../fetchs/visitantes-fetch.js';
import { modalDetalleVisitante } from '../modales/modal-detalle-visitante.js';
import { modalRegistroVisitante } from '../modales/modal-registro-visitante.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;

const parametros = {
    documento: '',
    ubicacion: ''
}

function validarResolucion(){
    
    if(window.innerWidth >= 1024){
        dibujarTablaVisitantes();
    }else{
        dibujarCardsVisitantes();
    }
}

function dibujarTablaVisitantes(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_visitantes">
                <thead class="head-table">
                    <tr>
                        <th>Tipo Doc.</th>
                        <th>Número Doc.</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Ubicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="body-table" id="cuerpo_tabla_visitantes">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_visitantes');
    }
   
    consultarVisitantes(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            cuerpoTabla.innerHTML = '';
            respuesta.visitantes.forEach(visitante => {
                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${visitante.tipo_documento}</td>
                        <td>${visitante.numero_documento}</td>
                        <td>${visitante.nombres}</td>
                        <td>${visitante.apellidos}</td>
                        <td>${visitante.telefono}</td>
                        <td>${visitante.ubicacion}</td>
                        <td class="contenedor-colum-acciones">
                            <ion-icon name="eye" class="ver-visitante" data-visitante="${visitante.numero_documento}"></ion-icon>
                        </td>
                    </tr>`;
            });
            eventoVerVisitante();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');
            }else{
                cuerpoTabla.innerHTML = `
                    <tr>
                        <td colspan="9">${respuesta.mensaje}</td>
                    </tr>`;
                    
                if(respuesta.titulo != 'Datos No Encontrados'){
                    alertaError(respuesta);
                }
            }
        }
    })
}

function dibujarCardsVisitantes(){
    cuerpoTabla = '';
    consultarVisitantes(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.visitantes.forEach(visitante => {
                contenedorTabla.innerHTML += `
                    <div class="document-card-visitante">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${visitante.nombres} | ${visitante.apellidos}</p>
                                <p class="document-meta">${visitante.tipo_documento}: ${visitante.numero_documento}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Teléfono: </strong>${visitante.telefono}</p>
                            <p><strong>Ubicación: </strong>${visitante.ubicacion}</p>
                        </div>
                        <div class="contenedor-acciones">
                            <ion-icon name="eye" class="ver-visitante" data-visitante="${visitante.numero_documento}"></ion-icon>
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerVisitante();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                contenedorTabla.innerHTML = `<p id="mensaje_respuesta">${respuesta.mensaje}</p>`;
               
                if(respuesta.titulo != 'Datos No Encontrados'){
                    alertaError(respuesta);
                }
            }
        }
    })
}

function eventoVerVisitante(){
    const botonesVerVisitante = document.querySelectorAll('.ver-visitante');
    
    botonesVerVisitante.forEach(boton => {
        let documento = boton.getAttribute('data-visitante');
        boton.addEventListener('click', ()=>{
            modalDetalleVisitante(documento, urlBase);
        });
    });
}

function eventoUbicacion(){
    let selectUbicacion = document.getElementById('ubicacion');

    selectUbicacion.addEventListener('change', ()=>{
        parametros.ubicacion = selectUbicacion.value;
        validarResolucion();
    })
}

function eventoBuscarDocumento(){
    let inputDocumento = document.getElementById('buscador_documento');
    let temporizador;
    
    inputDocumento.addEventListener('input', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            parametros.documento = inputDocumento.value;
            validarResolucion();
        }, 500)
    })
}

function eventoCrearVisitante(){
    const botonCrearVisitante = document.getElementById('btn_crear_visitante');

    botonCrearVisitante.addEventListener('click', ()=>{
        modalRegistroVisitante(urlBase, '', validarResolucion);
    })

    document.getElementById('btn_crear_visitante_mobile').addEventListener('click', ()=>{
        botonCrearVisitante.click();
    })
}

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-visitante');
    
    cards.forEach(card => {
        card.addEventListener('click', function() {
            if(card.classList.contains('active')){
                card.classList.remove('active');
            }else{
                document.querySelector('.active')?.classList.remove('active');
                card.classList.toggle('active');
            }
        });
    });
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
    contenedorTabla = document.getElementById('contenedor_tabla_cards');
    
    eventoBuscarDocumento();
    eventoUbicacion();
    eventoCrearVisitante();
    validarResolucion();

    window.addEventListener('resize', ()=>{
        setTimeout(()=>{
            if(window.innerWidth >= 1024 && !cuerpoTabla){
                validarResolucion();

            }else if(window.innerWidth < 1024 && cuerpoTabla){
                validarResolucion();
            }
        }, 250)
    });
})