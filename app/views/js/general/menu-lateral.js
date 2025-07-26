import {cerrarSesion} from '../fetchs/usuarios-fetch.js';

let urlBase;

const logo_sena = document.getElementById("logo_sena");
const barraLateral = document.querySelector(".barra-lateral");
const spans = barraLateral.querySelectorAll("span");
const menu = document.querySelector(".cont-menu-icon");

if(window.innerWidth < 1024){
    barraLateral.classList.remove("mini-barra-lateral");
}

menu.addEventListener("click",()=>{
    barraLateral.classList.toggle("max-barra-lateral");
    if(barraLateral.classList.contains("max-barra-lateral")){
        menu.children[0].style.display = "none";
        menu.children[1].style.display = "block";
    }
    else{
        menu.children[0].style.display = "block";
        menu.children[1].style.display = "none";
    }
    if(window.innerWidth<=320){
        
        if (window.innerWidth > 1080) {
            
            barraLateral.classList.add("mini-barra-lateral");
        }
       
        spans.forEach((span)=>{
            span.classList.add("oculto");
        })
    }
});

barraLateral.addEventListener("mouseout", () => {
    if (window.innerWidth >= 1024) {
        
        barraLateral.classList.add("mini-barra-lateral");
        spans.forEach((span) => {
            span.classList.add("oculto");
        });
    }
});

barraLateral.addEventListener("mouseover", () => {
    barraLateral.classList.remove("mini-barra-lateral");
    spans.forEach((span) => {
        span.classList.remove("oculto");
    });
});


function eventoSubMenu(){
    const opciones = document.querySelectorAll(".sub-menu-link");
    const subMenus = document.querySelectorAll('.sub-menu-list');

    opciones.forEach((opcion, indice) => {    
        opcion.addEventListener("click", () => {
            if (subMenus[indice].classList.contains('desplegado')) {
                subMenus[indice].style.display = 'none';
                subMenus[indice].classList.remove('desplegado');
                opcion.classList.remove('inbox');
            }else{
                for(const subMenu of subMenus){
                    if(subMenu.classList.contains('desplegado')){
                        subMenu.classList.remove('desplegado');
                        subMenu.style.display = 'none';
                        break;
                    }
                };
                
                subMenus[indice].style.display = 'block';
                subMenus[indice].classList.add('desplegado');
                document.querySelector('.inbox')?.classList.remove('inbox');
                opcion.classList.add('inbox');
            }
        });
    });
}

function eventoCerrarSesion(){
    document.getElementById('cerrar_sesion').addEventListener('click', ()=>{
        cerrarSesion(urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                window.location.replace(urlBase+'login');
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

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    eventoSubMenu();
    eventoCerrarSesion();
    eventoAutor();
})