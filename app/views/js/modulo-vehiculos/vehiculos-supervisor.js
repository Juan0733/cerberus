import { consultarVehiculos } from '../fetchs/vehiculos-fetch.js';
import { modalPropietariosVehiculo } from '../modales/modal-propietarios-vehiculo-supervisor.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;

const parametros = {
    documento: '',
    placa: '',
    tipo: '',
    ubicacion: ''
}

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaVehiculos();
    }else{
        dibujarCardsVehiculos();
    }
}

function dibujarTablaVehiculos(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_vehiculos">
                <thead class="head-table">
                    <tr>
                        <th>Placa Vehículo</th>
                        <th>Tipo Vehículo</th>
                        <th>Ubicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="body-table" id="cuerpo_tabla_vehiculos">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_vehiculos');
    }
   
    consultarVehiculos(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            cuerpoTabla.innerHTML = '';
            respuesta.vehiculos.forEach(vehiculo => {
                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${vehiculo.numero_placa}</td>
                        <td>${vehiculo.tipo_vehiculo}</td>
                        <td>${vehiculo.ubicacion}</td>
                        <td class="contenedor-colum-acciones">
                            <ion-icon name="eye" class="ver-propietarios" data-vehiculo="${vehiculo.numero_placa}"></ion-icon>
                        </td>
                    </tr>`;
            });
            eventoVerPropietarios();

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

function dibujarCardsVehiculos(){
    cuerpoTabla = '';
    consultarVehiculos(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.vehiculos.forEach(vehiculo => {
                contenedorTabla.innerHTML += `
                    <div class="document-card-vehiculo">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${vehiculo.numero_placa} ${vehiculo.tipo_vehiculo}</p>
                                <p class="document-meta">Ubicación: ${vehiculo.ubicacion}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="contenedor-acciones">
                            <ion-icon name="eye" class="ver-propietarios" data-vehiculo="${vehiculo.numero_placa}"></ion-icon>
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerPropietarios();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                contenedorTabla.innerHTML = `<p class="mensaje-respuesta">${respuesta.mensaje}</p>`;

                if(respuesta.titulo != 'Datos No Encontrados'){
                    alertaError(respuesta);
                }
            }
        }
    })
}

function eventoVerPropietarios(){
    const botonesVerPropietarios = document.querySelectorAll('.ver-propietarios');
    
    botonesVerPropietarios.forEach(boton => {
        let placa = boton.getAttribute('data-vehiculo');
        boton.addEventListener('click', ()=>{
            modalPropietariosVehiculo(placa, urlBase);
        });
    });
}

function eventoTipoVehiculo(){
    let selectTipo = document.getElementById('tipo_filtro');

    selectTipo.addEventListener('change', ()=>{
        parametros.tipo = selectTipo.value;
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
    
    inputDocumento.addEventListener('input', ()=>{
        if(inputDocumento.value.length == 0 || inputDocumento.value.length > 5){
            parametros.documento = inputDocumento.value;
            validarResolucion();
        }
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
    const cards = document.querySelectorAll('.document-card-vehiculo');
    
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
    
    eventoTipoVehiculo();
    eventoUbicacion();
    eventoBuscarDocumento();
    eventoBuscarPlaca();
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
