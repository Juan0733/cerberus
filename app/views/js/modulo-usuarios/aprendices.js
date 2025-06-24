import { consultarAprendices} from '../fetchs/aprendices-fetch.js';
import { modalDetalleAprendiz } from '../modales/modal-detalle-aprendiz.js';
import { modalRegistroAprendiz } from '../modales/modal-registro-aprendiz.js';
import { modalActualizacionAprendiz } from '../modales/modal-actualizacion-aprendiz.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;

const parametros = {
    documento: '',
    ubicacion: '',
    ficha: ''
};

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaAprendices();
    }else{
        dibujarCardsAprendices();
    }
}

function dibujarTablaAprendices(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_aprendices">
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
                <tbody class="body-table" id="cuerpo_tabla_aprendices">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_aprendices');
    }
   
    cuerpoTabla.innerHTML = '';
    consultarAprendices(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.aprendices.forEach(aprendiz => { 
                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${aprendiz.tipo_documento}</td>
                        <td>${aprendiz.numero_documento}</td>
                        <td>${aprendiz.nombres}</td>
                        <td>${aprendiz.apellidos}</td>
                        <td>${aprendiz.telefono}</td>
                        <td>${aprendiz.ubicacion}</td>
                        <td class="contenedor-colum-acciones">
                            <ion-icon name="eye" class="ver-aprendiz" data-aprendiz="${aprendiz.numero_documento}"></ion-icon>
                            <ion-icon name="create" class="editar-aprendiz" data-aprendiz="${aprendiz.numero_documento}"></ion-icon>
                        </td>
                    </tr>`;
            });
            eventoVerAprendiz();
            eventoEditarAprendiz();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');
            }else{
                cuerpoTabla.innerHTML = `
                    <tr>
                        <td colspan="9">${respuesta.mensaje}</td>
                    </tr>`;
            }
        }
    })
}

function dibujarCardsAprendices(){
    consultarAprendices(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.aprendices.forEach(aprendiz => {
                contenedorTabla.innerHTML += `
                    <div class="document-card-aprendiz">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${aprendiz.nombres} | ${aprendiz.apellidos}</p>
                                <p class="document-meta">${aprendiz.tipo_documento}: ${aprendiz.numero_documento}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Teléfono: </strong>${aprendiz.telefono}</p>
                            <p><strong>Ubicación:</strong>${aprendiz.ubicacion}</p>
                        </div>
                        <div class="contenedor-acciones">
                            <ion-icon name="eye" class="ver-aprendiz" data-aprendiz="${aprendiz.numero_documento}"></ion-icon>
                            <ion-icon name="create" class="editar-aprendiz" data-aprendiz="${aprendiz.numero_documento}"></ion-icon>
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerAprendiz();
            eventoEditarAprendiz();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                contenedorTabla.innerHTML = `<p id="mensaje_respuesta">${respuesta.mensaje}</p>`;
            }
        }
    })
}

function eventoVerAprendiz(){
    const botonesVerAprendiz = document.querySelectorAll('.ver-aprendiz');
    
    botonesVerAprendiz.forEach(boton => {
        let documento = boton.getAttribute('data-aprendiz');
        boton.addEventListener('click', ()=>{
            modalDetalleAprendiz(documento, urlBase);
        });
    });
}

function eventoEditarAprendiz(){
    const botonesEditarAprendiz = document.querySelectorAll('.editar-aprendiz');

    botonesEditarAprendiz.forEach(boton=>{
        let documento = boton.getAttribute('data-aprendiz');
        boton.addEventListener('click', ()=>{
            modalActualizacionAprendiz(documento, validarResolucion, urlBase);
        })
    })
}

function eventoBuscarFicha(){
    let inputFicha = document.getElementById('buscador_ficha');
    let temporizador;
    
    inputFicha.addEventListener('input', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            parametros.ficha = inputFicha.value;
            validarResolucion();
        }, 500)
    })
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

function eventoCrearAprendiz(){
    const botonCrearAprendiz = document.getElementById('btn_crear_aprendiz');

    botonCrearAprendiz.addEventListener('click', ()=>{
        modalRegistroAprendiz(validarResolucion, urlBase);
    })

    document.getElementById('btn_crear_aprendiz_mobile').addEventListener('click', ()=>{
        botonCrearAprendiz.click();
    })
}

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-aprendiz');
    
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
        }
    });
}

function alertaAdvertencia(respuesta){
    Swal.fire({
        icon: "warning",
        iconColor: "#feb211",
        title: respuesta.titulo,
        text: respuesta.mensaje,
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
            if(respuesta.titulo == "Inhabilitar Usuario"){
                inhabilitarVigilante(respuesta.documento, urlBase).then(datos=>{
                    if(datos.tipo == 'OK'){
                        alertaExito(datos);
                        validarResolucion();
                    }else if(datos.tipo == 'ERROR'){
                        alertaError(datos);
                    }
                });
                
            }
        } 
    });
}


document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    contenedorTabla = document.getElementById('contenedor_tabla_cards');
    
    eventoBuscarDocumento();
    eventoUbicacion();
    eventoBuscarFicha();
    eventoCrearAprendiz();
    validarResolucion();
    
})