import { consultarNovedadesVehiculo} from '../fetchs/novedades-vehiculos-fetch.js';
import { modalDetalleNovedadVehiculo } from '../modales/modal-detalle-novedad-vehiculo.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;
let inputFecha;
let selectTipoNovedad;

const parametros = {
    placa: '',
    tipo_novedad: '',
    fecha: ''
};

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaNovedades();
    }else{
        dibujarCardsNovedades();
    }
}

function dibujarTablaNovedades(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_novedades_vehiculo">
                <thead class="head-table">
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Tipo Novedad</th>
                        <th>Tipo Vehículo</th>
                        <th>Placa Vehículo</th>
                        <th>Tipo Doc.</th>
                        <th>Número Doc.</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="body-table" id="cuerpo_tabla_novedades_vehiculo">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_novedades_vehiculo');
    }
   
    cuerpoTabla.innerHTML = '';
    consultarNovedadesVehiculo(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.novedades.forEach(novedad => { 
                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${novedad.fecha_registro}</td>
                        <td>${novedad.tipo_novedad}</td>
                        <td>${novedad.tipo_vehiculo}</td>
                        <td>${novedad.fk_vehiculo}</td>
                        <td>${novedad.tipo_documento}</td>
                        <td>${novedad.fk_usuario_involucrado}</td>
                        <td>${novedad.nombres}</td>
                        <td>${novedad.apellidos}</td>
                        <td class="contenedor-colum-acciones">
                            <ion-icon name="eye" class="ver-novedad" data-novedad="${novedad.codigo_novedad}"></ion-icon>
                        </td>
                    </tr>`;
            });
            eventoVerNovedad();

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

function dibujarCardsNovedades(){
    cuerpoTabla = '';
    consultarNovedadesUsuario(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.novedades.forEach(novedad => {
                contenedorTabla.innerHTML += `
                    <div class="document-card-novedad-vehiculo">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${novedad.tipo_vehiculo} ${novedad.fk_vehiculo}</p>
                                <p class="document-meta">${novedad.tipo_documento}: ${novedad.fk_usuario_involucrado} | ${novedad.tipo_novedad}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Fecha y Hora: </strong>${novedad.fecha_registro}</p>
                            <p><strong>Nombres: </strong>${novedad.nombres}</p>
                            <p><strong>Apellidos: </strong>${novedad.apellidos}</p>
                        </div>
                        <div class="contenedor-acciones">
                            <ion-icon name="eye" class="ver-novedad" data-novedad="${novedad.codigo_novedad}"></ion-icon>
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerNovedad();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                contenedorTabla.innerHTML = `<p id="mensaje_respuesta">${respuesta.mensaje}</p>`;
            }
        }
    })
}

function eventoVerNovedad(){
    const botonesVerNovedad = document.querySelectorAll('.ver-novedad');
    
    botonesVerNovedad.forEach(boton => {
        let novedad = boton.getAttribute('data-novedad');
        boton.addEventListener('click', ()=>{
            modalDetalleNovedadVehiculo(novedad, urlBase);
        });
    });
}

function eventoFecha(){
    fecha.addEventListener('change', ()=>{
        parametros.fecha = inputFecha.value;
        validarResolucion();
    })
}

function eventoTipoNovedad(){
    selectTipoNovedad.addEventListener('change', ()=>{
        parametros.tipo_novedad = selectTipoNovedad.value;
        validarResolucion();
    })
}

function eventoBuscarPlaca(){
    let inputPlaca = document.getElementById('buscador_placa');
    let temporizador;
    
    inputPlaca.addEventListener('input', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            parametros.placa = inputPlaca.value;
            validarResolucion();
        }, 500)
    })
}

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-novedad_vehiculo');
    
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

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    contenedorTabla = document.getElementById('contenedor_tabla_cards');
    inputFecha = document.getElementById('fecha');
    selectTipoNovedad = document.getElementById('tipo_novedad_filtro');
    parametros.fecha = inputFecha.value;
    parametros.tipo_novedad = selectTipoNovedad.value;

    eventoBuscarPlaca();
    eventoTipoNovedad();
    eventoFecha();
    validarResolucion();

    window.addEventListener('resize', ()=>{
        if(window.innerWidth >= 1024 && document.querySelector('.document-card-novedad-vehiculo')){
            validarResolucion();

        }else if(window.innerWidth < 1024 && cuerpoTabla){
            validarResolucion();
        }
    });
})