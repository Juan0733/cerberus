import { consultarAprendices} from '../fetchs/aprendices-fetch.js';
import { modalDetalleAprendiz } from '../modales/modal-detalle-aprendiz.js';

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
   
    consultarAprendices(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            cuerpoTabla.innerHTML = '';
            respuesta.aprendices.forEach(aprendiz => { 
                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${aprendiz.tipo_documento}</td>
                        <td>${aprendiz.numero_documento}</td>
                        <td>${aprendiz.nombres}</td>
                        <td>${aprendiz.apellidos}</td>
                        <td>${formatearNumeroTelefono(aprendiz.telefono)}</td>
                        <td>${aprendiz.ubicacion}</td>
                        <td class="contenedor-colum-acciones">
                            <ion-icon name="eye" class="ver-aprendiz" data-aprendiz="${aprendiz.numero_documento}"></ion-icon>
                        </td>
                    </tr>`;
            });
            eventoVerAprendiz();

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

function dibujarCardsAprendices(){
    cuerpoTabla = '';
    consultarAprendices(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.aprendices.forEach(aprendiz => {
                contenedorTabla.innerHTML += `
                    <div class="document-card-aprendiz">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${aprendiz.nombres} ${aprendiz.apellidos}</p>
                                <p class="document-meta">${aprendiz.tipo_documento}: ${aprendiz.numero_documento}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Teléfono: </strong>${formatearNumeroTelefono(aprendiz.telefono)}</p>
                            <p><strong>Ubicación: </strong>${aprendiz.ubicacion}</p>
                        </div>
                        <div class="contenedor-acciones">
                            <ion-icon name="eye" class="ver-aprendiz" data-aprendiz="${aprendiz.numero_documento}"></ion-icon>
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerAprendiz();

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

function eventoVerAprendiz(){
    const botonesVerAprendiz = document.querySelectorAll('.ver-aprendiz');
    
    botonesVerAprendiz.forEach(boton => {
        let documento = boton.getAttribute('data-aprendiz');
        boton.addEventListener('click', ()=>{
            modalDetalleAprendiz(documento, urlBase);
        });
    });
}

function eventoBuscarFicha(){
    let inputFicha = document.getElementById('buscador_ficha');
    
    inputFicha.addEventListener('input', ()=>{
        if(inputFicha.value.length == 0 || inputFicha.value.length > 3){
            parametros.ficha = inputFicha.value;
            validarResolucion();
        }
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
    
    inputDocumento.addEventListener('input', ()=>{
        if(inputDocumento.value.length == 0 || inputDocumento.value.length > 5){
            parametros.documento = inputDocumento.value;
            validarResolucion();
        }
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

function formatearNumeroTelefono(numeroTelefono){
    let telefonoFormateado = '';

    for (let i = 0; i < numeroTelefono.length; i++) {
        telefonoFormateado += numeroTelefono[i];
        if(i == 2 || i == 5 || i == 7 ){
            telefonoFormateado += '-';
        }
    }

    return telefonoFormateado;
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
    eventoBuscarFicha();
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