import {consultarMovimientos} from '../fetchs/movimientos-fetch.js'
import { modalDetalleMovimiento } from '../modales/modal-detalle-movimiento.js';


let fechaInicio;
let fechaFin;
let contenedorTabla;
let cuerpoTabla;
let urlBase;

const parametros = {
    puerta: '',
    fecha_inicio: '',
    fecha_fin: '',
    documento: '',
    placa: ''
}

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaMovimientos();
    }else{
        dibujarCardsMovimientos();
    }
}

function dibujarTablaMovimientos(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_movimientos">
                <thead class="head-table">
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Movimiento</th>
                        <th class="td-tipo-doc">Tipo Doc.</th>
                        <th>Número Doc.</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Vehiculo</th>
                        <th>Relacion vehículo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="body-table" id="cuerpo_tabla_movimientos">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_movimientos');
    }
   
    consultarMovimientos(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            cuerpoTabla.innerHTML = '';
            respuesta.movimientos.forEach(movimiento => {
                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${movimiento.fecha_registro}</td>
                        <td>${movimiento.tipo_movimiento}</td>
                        <td class="td-tipo-doc">${movimiento.tipo_documento}</td>
                        <td>${movimiento.fk_usuario}</td>
                        <td>${movimiento.nombres}</td>
                        <td>${movimiento.apellidos}</td>
                        <td>${movimiento.fk_vehiculo}</td>
                        <td>${movimiento.relacion_vehiculo}</td>
                        <td class="contenedor-colum-acciones">
                            <ion-icon name="eye" class="ver-movimiento" data-movimiento="${movimiento.codigo_movimiento}"></ion-icon>
                        </td>
                    </tr>`;
            });

           eventoVerMovimiento(); 

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

function dibujarCardsMovimientos(){
    cuerpoTabla = '';
    consultarMovimientos(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.movimientos.forEach(movimiento => {
                contenedorTabla.innerHTML += `
                    <div class="document-card-movimiento">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${movimiento.nombres} ${movimiento.apellidos}</p>
                                <p class="document-meta">${movimiento.tipo_documento}: ${movimiento.fk_usuario} | ${movimiento.tipo_movimiento}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Fecha y Hora: </strong>${movimiento.fecha_registro}</p>
                            <p><strong>Vehículo: </strong>${movimiento.fk_vehiculo}</p>
                            <p><strong>Relacion Vehículo: </strong>${movimiento.relacion_vehiculo}</p>
                        </div>
                        <div class="contenedor-acciones">
                            <ion-icon name="eye" class="ver-movimiento" data-movimiento="${movimiento.codigo_movimiento}"></ion-icon>
                        </div>
                    </div>`;
            });

            toggleCard();
            eventoVerMovimiento();

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

function eventoVerMovimiento(){
    const botonesVerMovimiento = document.querySelectorAll('.ver-movimiento');
    
    botonesVerMovimiento.forEach(boton => {
        let movimiento = boton.getAttribute('data-movimiento');
        boton.addEventListener('click', ()=>{
            modalDetalleMovimiento(movimiento, urlBase);
        });
    });
}

function eventoPuerta(){
    let selectPuerta = document.getElementById('puerta');

    selectPuerta.addEventListener('change', ()=>{
        parametros.puerta = selectPuerta.value;
        validarResolucion();
    })
}

function eventoFechaInicio(){
    let selectFechaInicio = document.getElementById('fecha_inicio');

    selectFechaInicio.addEventListener('change', ()=>{
        fechaFin.min = fechaInicio.value;
        parametros.fecha_inicio = selectFechaInicio.value;
        validarResolucion();
    })
}

function eventoFechaFin(){
    let selectFechaFin = document.getElementById('fecha_fin');

    selectFechaFin.addEventListener('change', ()=>{
        parametros.fecha_fin = selectFechaFin.value;
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

function eventoGenerarInforme(){
    const botonInforme = document.getElementById('btn_informe');

    if(botonInforme){
        botonInforme.addEventListener('click', ()=>{
            window.location.href = urlBase+'app/pdf/GenerarPdfMovimientos.php?puerta='+encodeURI(parametros.puerta)+'&fecha_inicio='+encodeURI(parametros.fecha_inicio)+'&fecha_fin='+encodeURI(parametros.fecha_fin)+'&documento='+encodeURI(parametros.documento)+'&placa='+encodeURI(parametros.placa);
        })

        document.getElementById('btn_informe_mobile').addEventListener('click', ()=>{
            botonInforme.click();
        })
    }
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
    const cards = document.querySelectorAll('.document-card-movimiento');
    
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
    fechaInicio = document.getElementById('fecha_inicio');
    fechaFin = document.getElementById('fecha_fin');
    contenedorTabla = document.getElementById('contenedor_tabla_cards');
    parametros.fecha_inicio = fechaInicio.value;
    parametros.fecha_fin = fechaFin.value;

    eventoPuerta();
    eventoFechaInicio();
    eventoFechaFin();
    eventoBuscarDocumento();
    eventoBuscarPlaca();
    eventoGenerarInforme();
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
