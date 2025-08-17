import { consultarVigilantes } from '../fetchs/vigilantes-fetch.js';
import { modalDetalleVigilante } from '../modales/modal-detalle-vigilante.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;

const parametros = {
    documento: '',
    ubicacion: '',
    rol: ''
};

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaVigilantes();
    }else{
        dibujarCardsVigilantes();
    }
}

function dibujarTablaVigilantes(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_vigilantes">
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
                <tbody class="body-table" id="cuerpo_tabla_vigilantes">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_vigilantes');
    }
   
    consultarVigilantes(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            cuerpoTabla.innerHTML = '';
            respuesta.vigilantes.forEach(vigilante => {

                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${vigilante.tipo_documento}</td>
                        <td>${vigilante.numero_documento}</td>
                        <td>${vigilante.nombres}</td>
                        <td>${vigilante.apellidos}</td>
                        <td>${vigilante.telefono}</td>
                        <td>${vigilante.ubicacion}</td>
                        <td class="contenedor-colum-acciones">
                            <ion-icon name="eye" class="ver-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>
                        </td>
                    </tr>`;
            });
            eventoVerVigilante();

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

function dibujarCardsVigilantes(){
    cuerpoTabla = '';
    consultarVigilantes(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.vigilantes.forEach(vigilante => {
        
                contenedorTabla.innerHTML += `
                    <div class="document-card-vigilante">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${vigilante.nombres} | ${vigilante.apellidos}</p>
                                <p class="document-meta">${vigilante.tipo_documento}: ${vigilante.numero_documento}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Teléfono: </strong>${vigilante.telefono}</p>
                            <p><strong>Ubicación: </strong>${vigilante.ubicacion}</p>
                        </div>
                        <div class="contenedor-acciones">
                            <ion-icon name="eye" class="ver-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerVigilante();

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

function eventoVerVigilante(){
    const botonesVerVigilante = document.querySelectorAll('.ver-vigilante');
    
    botonesVerVigilante.forEach(boton => {
        let documento = boton.getAttribute('data-vigilante');
        boton.addEventListener('click', ()=>{
            modalDetalleVigilante(documento, urlBase);
        });
    });
}

function eventoRol(){
    let selectRol = document.getElementById('rol_filtro');

    selectRol.addEventListener('change', ()=>{
        parametros.rol = selectRol.value;
        validarResolucion();
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

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-vigilante');
    
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
    eventoRol();
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