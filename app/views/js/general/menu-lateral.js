import {cerrarSesion} from '../fetchs/usuarios-fetch.js';

let urlBase;
let opciones;
let subMenus;
let barraLateral;
let spans;

function eventoAbrirMenu(){
    const menu = document.querySelector(".cont-menu-icon");

    menu.addEventListener("click",()=>{
        barraLateral.classList.toggle("max-barra-lateral");
        if(barraLateral.classList.contains("max-barra-lateral")){
            barraLateral.classList.remove("mini-barra-lateral");
            menu.children[0].style.display = "none";
            menu.children[1].style.display = "block";
        }else{
            menu.children[0].style.display = "block";
            menu.children[1].style.display = "none";
        }
        
    });
}

function eventoDesenfocarMenu(){
    barraLateral.addEventListener("mouseout", () => {
        if (window.innerWidth >= 1024) {
            for (let i = 0; i < subMenus.length; i++) {
                if(subMenus[i].classList.contains('desplegado')){
                    const opcionesSubmenu = subMenus[i].querySelectorAll('a');
                    opcionesSubmenu.forEach(opcion => {
                        if(opcion.classList.contains('inbox')){
                            opciones[i].classList.add('inbox');
                        }
                    });

                    break;
                }
            }
            
            barraLateral.classList.add("mini-barra-lateral");
            spans.forEach((span) => {
                span.classList.add("oculto");
            });
        }
    });

    if (window.innerWidth >= 1024) {
        for (let i = 0; i < subMenus.length; i++) {
            if(subMenus[i].classList.contains('desplegado')){
                const opcionesSubmenu = subMenus[i].querySelectorAll('a');
                opcionesSubmenu.forEach(opcion => {
                    if(opcion.classList.contains('inbox')){
                        opciones[i].classList.add('inbox');
                    }
                });

                break;
            }
        }
    }
}

function eventoEnfocarMenu(){
    barraLateral.addEventListener("mouseover", () => {
        if(window.innerWidth >= 1024){
            for (let i = 0; i < subMenus.length; i++) {
                if(subMenus[i].classList.contains('desplegado')){
                    const opcionesSubmenu = subMenus[i].querySelectorAll('a');
                    opcionesSubmenu.forEach(opcion => {
                        if(opcion.classList.contains('inbox')){
                            opciones[i].classList.remove('inbox');
                        }
                    });
                    
                    break;
                }
            }

            barraLateral.classList.remove("mini-barra-lateral");
            spans.forEach((span) => {
                span.classList.remove("oculto");
            });
        }
    });
}

function eventoDesplegarSubMenu(){
    const opciones = document.getElementsByClassName("sub-menu-link");
    const subMenus = document.getElementsByClassName('sub-menu-list');

    for (let i = 0; i < opciones.length; i++) {
        opciones[i].addEventListener("click", () => {
            if (subMenus[i].classList.contains('desplegado')) {
                subMenus[i].style.display = 'none';
                subMenus[i].classList.remove('desplegado');
                opciones[i].classList.remove('inbox');
            }else{
                for (let e = 0; e < subMenus.length; e++) {
                    if(subMenus[e].classList.contains('desplegado')){
                        subMenus[e].classList.remove('desplegado');
                        subMenus[e].style.display = 'none';
                        break;
                    }
                }
                
                subMenus[i].style.display = 'block';
                subMenus[i].classList.add('desplegado');
            }
        });
    }

    for (let a = 0; a < subMenus.length; a++) {
        if(subMenus[a].classList.contains('desplegado')){
            subMenus[a].style.display = 'block';
            break;
        }
    }
}

function eventoCerrarSesion(){
    document.getElementById('cerrar_sesion').addEventListener('click', ()=>{
        cerrarSesion(urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                window.location.replace(urlBase+'login');

            }else if(respuesta.tipo == 'ERROR'){
                alertaError(respuesta);
            }
        })
    })
}

function eventoAutor(){
    const botonAutor = document.getElementById('btn_autor');
    const informacionAutor = document.getElementById('informacion_autor');

    botonAutor.addEventListener('click', ()=>{
        botonAutor.style.display = 'none';
        informacionAutor.style.display = 'flex';
    })

    informacionAutor.addEventListener('click', ()=>{
        informacionAutor.style.display = 'none';
        botonAutor.style.display = 'flex';
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

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    opciones = document.getElementsByClassName("sub-menu-link");
    subMenus = document.getElementsByClassName('sub-menu-list');
    barraLateral = document.querySelector(".barra-lateral");
    spans = barraLateral.querySelectorAll("span");

    if(window.innerWidth < 1024){
        barraLateral.classList.remove("mini-barra-lateral");
    }

    eventoAbrirMenu();
    eventoEnfocarMenu();
    eventoDesenfocarMenu();
    eventoDesplegarSubMenu();
    eventoCerrarSesion();
    eventoAutor();
})