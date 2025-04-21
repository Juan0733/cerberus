import {conteoTotalUsuarios} from '../fetchs/usuarios-fetch.js'

let urlBase;

function dibujarConteoMultitud(){
    conteoTotalUsuarios(urlBase).then(datos => {
        if(datos.tipo == 'OK'){
            document.getElementById("titulo_multitud").innerText = "Multitud: " + datos.total_usuarios;
            document.querySelector(".titulo_multi_detalle").innerHTML ="Multitud: " + datos.total_usuarios;
        }else{
            console.error(datos.mensaje);
        }
    })
}

document.addEventListener('DOMContentLoaded', () => {
    urlBase = document.getElementById('url_base').value;
    dibujarConteoMultitud();
    setInterval(() => {
        dibujarConteoMultitud();
    }, 60000);
})
// let modalEstadoActual = false;

// contador();

// const alertas = document.getElementById('cont_alertas');

// //Variable que controla el estado de la modal si esta visible o no
// let estadoModal = false; 


// document.getElementById('cont_icon_notificaciones-mobil').addEventListener('click', () => {
  
//     // Alternamos el estado del modal (true a false o false a true).
//     estadoModal = !estadoModal;
   
//     // Si el modal está activo (estadoModal es true), añadimos la clase 'mostrar' para hacerlo visible.
//     if (estadoModal) {
//         alertas.classList.add('mostrar');
//         document.getElementById('cont_icon_notificaciones-mobil').style.background = 'var(--color-primario)'
//         document.getElementById('cont_icon_notificaciones-mobil').style.color = 'var(--main-color)'
//     } else {
//         // Si el modal está inactivo, removemos la clase 'mostrar' para ocultarlo.
//         document.getElementById('cont_icon_notificaciones-mobil').style.background = 'none'
//         alertas.classList.remove('mostrar');
//     }
// });



// document.getElementById('cont_icon_notificaciones').addEventListener('click', () => {
  
//     // Alternamos el estado del modal (true a false o false a true).
//     estadoModal = !estadoModal;
   
//     // Si el modal está activo (estadoModal es true), añadimos la clase 'mostrar' para hacerlo visible.
//     if (estadoModal) {
//         alertas.classList.add('mostrar');
//     } else {
//         // Si el modal está inactivo, removemos la clase 'mostrar' para ocultarlo.
//         alertas.classList.remove('mostrar');
//     }
// });

// // Agregamos un evento al propio contenedor de alertas es decir la parte negra trasparente.
// document.getElementById('cont_alertas').addEventListener('click', () => {
//     // Si el modal está activo y el usuario hace clic en las alertas,
//     // cerramos el modal y cambiamos su estado a inactivo (false).
//     if (estadoModal) {
//         estadoModal = false;
//         document.getElementById('cont_icon_notificaciones-mobil').style.background = 'none'
//         document.getElementById('cont_icon_notificaciones-mobil').style.color = 'var(--color-primario)'
//         alertas.classList.remove('mostrar');
//     }
// });

// document.getElementById('close_modal').addEventListener('click', () => {
//     estadoModal = false; 
//     document.getElementById('cont_icon_notificaciones-mobil').style.background = 'none'
//     document.getElementById('cont_icon_notificaciones-mobil').style.color = 'var(--color-primario)'
//     alertas.classList.remove('mostrar');
// });


// // Agregamos un evento al botón de cierre del modal.
// document.getElementById("contenedor_tabla").addEventListener("scroll", function() {
//     // Cuando se hace clic en el botón de cerrar, cambiamos el estado a inactivo
//     // y removemos la clase 'mostrar' para ocultar el modal.
//     if (this.scrollTop > 0) {
//         this.classList.add("scrolled"); 
//     } else {
//         this.classList.remove("scrolled");
//     }
// });












// Configuramos un intervalo que ejecuta la función `contador` cada 40 segundos.
// setInterval(contador, 40000);


// // Función que realiza una solicitud a un servidor para obtener datos y actualiza la interfaz.
// function contador() {
//     let encabezados = new Headers();

//     fetch('../app/ajax/conteos-fetch.php', {
//         method: 'POST',
//         headers: encabezados, 
//         mode: 'cors', 
//         cache: 'no-cache', 
//     })
//     .then(respuesta => respuesta.json()) // Convertimos la respuesta en un objeto JSON.
//     .then(datos => {
//         document.getElementById("titulo_multitud").innerText = "Multitud: " + datos.totalPersonasDentro;       
//     })
//     .catch(error => {
//         // Manejo de errores en caso de que falle la solicitud o el procesamiento de datos.
//         console.error("Error al obtener los datos del servidor:", error);
//     });
// }









// function toggleCard(clickedCard) {
//     // Selecciona todas las tarjetas
//     const allCards = document.querySelectorAll('.document-card');
    
//     allCards.forEach(card => {
//       if (card !== clickedCard) {
//         card.classList.remove('active');
//       }
//     });
    
//     clickedCard.classList.toggle('active');
//   }

// let contenedorListado = document.getElementById('contenedor_tabla');











// /* ------------------------Apertura y cierre de modales ---------------------------------- */



// function openModal(title, content, info, callbackFunction = null, callbackArgs = []) {

//     const modal = document.createElement('div');
//     modal.classList.add('contenedor-ppal-modal');
//     if (window.innerWidth > 780 && info === "adaptar") {
//         console.log('Anulando width definido en CSS');
//         modal.style.width = 'auto'; 
//     }else if (info === "adaptar-infor") {
        
//         modal.style.width = 'clamp(358px, 60%, 468px)'; 
//     }
//     if (window.innerWidth > 780 && info === "ptrVehi") {
        
//         console.log('Modificacion de width');
//         modal.style.width = 'clamp(272px, 60%, 900px)'; 
//     }
//     let urlfinal = content
//     fetch(urlfinal) 
//     .then(response => response.text()) 
//     .then(data => {
            
//             if (data.trim() === "") {
//             console.error("El archivo está vacío o no se ha cargado correctamente.");
//             } else {
//             modal.innerHTML = `
//                     <div class="contenedor-titulo-modal">
//                     <h2 class="titulo-modal">${title}</h2>
//                     <ion-icon name="close-outline" class="close-btn" onclick="closeModal(this)"></ion-icon>
//                     </div>
//                     <div class="contenedor-info-modal">
//                     ${data}
//                     </div>
//             `;
//             // Ejecuta la función de callback si se proporciona
//             if (callbackFunction && typeof callbackFunction === "function") {
//                 callbackFunction(...callbackArgs);
//             }
//             if (info !== undefined) {
//                 if (info[0]=="novedades") {
//                     let campoIdentificacion = document.getElementById("num_documento_causante");
//                     console.log(campoIdentificacion)
//                     campoIdentificacion.value = info[2];
//                     campoIdentificacion.readOnly = true;
//                     inputHidden=document.getElementById("modulo_ingreso_tipo")
//                     inputHidden.value=info[1]
//                     console.log(inputHidden.value);
//                 }
//             }
//             }
//     })
//     .catch(error => console.error('Error:', error));

//     // Agrega el modal al contenedor
//     document.getElementById('contenedor-modales').appendChild(modal);
  

//     // Mostrar el fondo del modal
//     modalEstadoActual = true;
//     document.getElementById('contenedor-modales').classList.add('mostrar');

    
// }

// function closeModal(closeBtn) {
//     const modal = closeBtn.closest('.contenedor-ppal-modal');
    

 
//         modal.remove();
    
//     const contenedorModales = document.getElementById('contenedor-modales');
//     const modalesRestantes = [...contenedorModales.children].filter(el =>
//         el.classList.contains('contenedor-ppal-modal')
//     );

//     if (modalesRestantes.length === 0) {
//         contenedorModales.classList.remove('mostrar');
//         modalEstadoActual = false;
//     }
// }

// function getMaxZIndex() {
//     const modals = document.querySelectorAll('.contenedor-ppal-modal');
//     let maxZIndex = 1000; 
//     modals.forEach((modal) => {
//         const zIndex = parseInt(window.getComputedStyle(modal).zIndex, 10);
//         if (!isNaN(zIndex)) {
//             maxZIndex = Math.max(maxZIndex, zIndex);
//         }
//     });
//     return maxZIndex;
// }



// /* ------------------------Fin Apertura y cierre de modales ---------------------------------- */

// /* ------------------------Funciones para cargar datos en modales ----------------------------- */



//     /*------------Funciones par datos de vehiculos --------------------- */
//     function cargarPropietarios(placa) {
        
//         var cuerpo = document.getElementById('contenedor_tabla_pro')

//         let formData = new FormData()
        
//         formData.append('modulo_vehiculo', 'lista_propietario')
//         formData.append('placa_vehiculo', placa)
        
//         if (window.innerWidth > 780) {
//             formData.append('tipoListado', 'tabla')
//         }else{
//             formData.append('tipoListado', 'card')
//         }
        
        

//         fetch('../app/ajax/vehiculo-ajax.php',{
//             method:"POST",
//             body: formData
//         }).then(response => {
//             if (!response.ok) {
//                 throw new Error("Error en la respuesta del servidor");
//             }
//             return response.json();
//         })
//         .then(data => {
//             console.log(data.data)
//             cuerpo.innerHTML = data.data
//         }).catch(err => console.log(err))

//     }
//     /*----------------Cargar los datos del un vehiculo a editar basado en su placa y propietario------------------------- */
//     function cargarDatosVehiculo(placa, numIdentificacion, tipoVehiculo) {
//         document.getElementById('num_documento_visitante').value = numIdentificacion;
//         document.getElementById('tipo_vehiculo_visitante').value = tipoVehiculo;
//         document.getElementById('placa_vehiculo_visitante').value = placa;
//         document.getElementById('placa_vahiculo_anterior').value = placa;
        

//     }
// /* ------------------------Fin funciones para cargar datos en modales ----------------------------- */