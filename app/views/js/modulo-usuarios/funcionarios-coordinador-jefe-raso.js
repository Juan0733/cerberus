import { consultarFuncionarios } from '../fetchs/funcionarios-fetch.js';
import { modalDetalleFuncionario } from '../modales/modal-detalle-funcionario.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;

const parametros = {
    documento: '',
    brigadista: '',
    ubicacion: '',
    rol: ''
};

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaFuncionarios();
    }else{
        dibujarCardsFuncionarios();
    }
}

function dibujarTablaFuncionarios(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_funcionarios">
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
                <tbody class="body-table" id="cuerpo_tabla_funcionarios">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_funcionarios');
    }
   
    consultarFuncionarios(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            cuerpoTabla.innerHTML = '';
            respuesta.funcionarios.forEach(funcionario => {
                
                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${funcionario.tipo_documento}</td>
                        <td>${funcionario.numero_documento}</td>
                        <td>${funcionario.nombres}</td>
                        <td>${funcionario.apellidos}</td>
                        <td>${funcionario.telefono}</td>
                        <td>${funcionario.ubicacion}</td>
                        <td class="contenedor-colum-acciones">
                            <ion-icon name="eye" class="ver-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>
                        </td>
                    </tr>`;
            });
            eventoVerFuncionario();

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

function dibujarCardsFuncionarios(){
    cuerpoTabla = '';
    consultarFuncionarios(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.funcionarios.forEach(funcionario => {
                
                contenedorTabla.innerHTML += `
                    <div class="document-card-funcionario">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${funcionario.nombres} | ${funcionario.apellidos}</p>
                                <p class="document-meta">${funcionario.tipo_documento}: ${funcionario.numero_documento}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Teléfono: </strong>${funcionario.telefono}</p>
                            <p><strong>Ubicación: </strong>${funcionario.ubicacion}</p>
                        </div>
                        <div class="contenedor-acciones">
                            <ion-icon name="eye" class="ver-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerFuncionario();
        
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

function eventoVerFuncionario(){
    const botonesVerFuncionario = document.querySelectorAll('.ver-funcionario');
    
    botonesVerFuncionario.forEach(boton => {
        let documento = boton.getAttribute('data-funcionario');
        boton.addEventListener('click', ()=>{
            modalDetalleFuncionario(documento, urlBase);
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
    const cards = document.querySelectorAll('.document-card-funcionario');
    
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
            if(window.innerWidth >= 1024 && document.querySelector('.document-card-funcionario')){
            validarResolucion();

            }else if(window.innerWidth < 1024 && cuerpoTabla){
                validarResolucion();
            }
        }, 250)
    });
})