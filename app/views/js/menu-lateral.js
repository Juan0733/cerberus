
const logo_sena = document.getElementById("logo_sena");
const barraLateral = document.querySelector(".barra-lateral");
const spans = document.querySelectorAll("span");
const menu = document.querySelector(".cont-menu-icon");

var lista = document.querySelector(".sub-menu-list");
const menuLinks = document.querySelectorAll(".navegacion a"); // Selecciona todos los enlaces del menú


if(window.innerWidth<=1080){
    barraLateral.classList.remove("mini-barra-lateral");
}
menuLinks.forEach(link => {
    link.addEventListener("click", function() {
        // Remover la clase 'inbox' de cualquier enlace que la tenga
        document.querySelector(".navegacion .inbox")?.classList.add("desactivado");
        document.querySelector(".navegacion .inbox")?.classList.remove("inbox");
        this.classList.add("inbox");
    });
});

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
    if (window.innerWidth > 1080) {
        
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



document.querySelectorAll(".sub-menu-link").forEach((link) => {     
    link.addEventListener("click", () => {
        if (lista.classList.contains('desplegado')) {
            lista.style.display = 'none';
            lista.classList.remove('desplegado');
        }else{
            lista.style.display = 'block';
            lista.classList.add('desplegado');
        }
       
    });
});


function cerrarSesion(url) {  
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Quieres cerrar sesión?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, cerrar',
        cancelButtonText: 'No, volver',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar',
            cancelButton: 'btn-cancelar'
        }
    }).then((result) => {
        if (result.isConfirmed){  
            window.location.href= url;
        }
    })
}
 