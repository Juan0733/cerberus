import { consultarNovedadesVehiculo} from '../fetchs/novedades-vehiculos-fetch.js';
import { modalDetalleNovedadVehiculo } from '../modales/modal-detalle-novedad-vehiculo.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;

const parametros = {
    placa: '',
    tipo_novedad: 'VEHICULO PRESTADO',
    fecha: '',
    cantidad: ''
};

function validarCantidadRegistros(){
    for(const clave of Object.keys(parametros)){
        if(clave != 'cantidad' && 'tipo_novedad'){
            if(parametros[clave]){
                parametros.cantidad = '';
                return;
            }
        }
    }

    if(window.innerWidth >= 768){
        parametros.cantidad = 10;
    }else{
        parametros.cantidad = 5;
    }
}

function validarResolucion(){
    validarCantidadRegistros();

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
   
    consultarNovedadesVehiculo(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            cuerpoTabla.innerHTML = '';
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
                   
                if(respuesta.titulo != 'Datos No Encontrados'){
                    alertaError(respuesta);
                }
            }
        }
    })
}

function dibujarCardsNovedades(){
    cuerpoTabla = '';
    consultarNovedadesVehiculo(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.novedades.forEach(novedad => {
                contenedorTabla.innerHTML += `
                    <div class="document-card-novedad-vehiculo">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${novedad.fk_vehiculo} | ${novedad.tipo_vehiculo}</p>
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
                
                if(respuesta.titulo != 'Datos No Encontrados'){
                    alertaError(respuesta);
                }
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
    const inputFecha = document.getElementById('fecha');

    inputFecha.addEventListener('change', ()=>{
        parametros.fecha = inputFecha.value;
        validarResolucion();
    })
}

function eventoBuscarPlaca(){
    let inputPlaca = document.getElementById('buscador_placa');
    
    inputPlaca.addEventListener('input', ()=>{
        if(inputPlaca.value.length == 0 || inputPlaca.value.length > 2){
            parametros.placa = inputPlaca.value;
            validarResolucion();
        }
    })
}

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-novedad-vehiculo');
    
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

    eventoBuscarPlaca();
    eventoFecha();
    validarResolucion();

    window.addEventListener('resize', ()=>{
        setTimeout(()=>{
            if((window.innerWidth >= 1024 && !cuerpoTabla) || (window.innerWidth < 1024 && cuerpoTabla)){
                validarResolucion();
            }
        }, 250)
    });
})