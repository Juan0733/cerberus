let contenedorModales;
let modalesExistentes;
let html5QrCode;
let inputDocumento;
let funcionCallback;
let audio;
let botonCerrarModal;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalScanerQr(url, input, callback) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-scaner-qr.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_scaner_qr';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        html5QrCode = new Html5Qrcode("reader");
        audio = new Audio(url+'app/views/audio/sonido-scaner.mp3');

        inputDocumento = input;
        funcionCallback = callback;
        urlBase = url;

        eventoCerrarModal();
        abrirCamara(); 

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");

        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal escanear QR.'
        });
    }
}
export{modalScanerQr}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_scaner_qr');

    botonCerrarModal.addEventListener('click', ()=>{
        html5QrCode.stop().then((ignore) => {
            modalesExistentes[modalesExistentes.length-1].remove();
            contenedorModales.classList.remove('mostrar');
        }).catch((error) => {
            alertaError({
                titulo: 'Error Cámara',
                mensaje: 'Se produjo un error al detener la cámara'
            })
            console.error('Hubo un error:', error)
        });
    });
}

function abrirCamara(){
    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

    Html5Qrcode.getCameras().then(camaras => {
        const camaraTrasera = camaras.find(camara => camara.label.toLowerCase().includes("back"));
        const camaraDisponible = camaraTrasera ? camaraTrasera : camaras[0];

        if (camaraDisponible) {
            html5QrCode.start(
                { deviceId: { exact: camaraDisponible.id } },
                config,
                lecturaExitosa
            ).then(() => {
                contenedorSpinner.classList.remove("mostrar_spinner");
                contenedorModales.classList.add('mostrar');

            }).catch(error=>{
                contenedorSpinner.classList.remove("mostrar_spinner");
                alertaError({
                    titulo: 'Error Cámara',
                    mensaje: 'Se produjo un error al abrir la cámara.'
                })
                console.error('Hubo un error:', error)
                botonCerrarModal.click();
            });

        } else {
            contenedorSpinner.classList.remove("mostrar_spinner");
            alertaError({
                titulo: 'Error Cámara',
                mensaje: 'No se encontro ninguna cámara disponibley.'
            })
            botonCerrarModal.click();
        }

    }).catch(error=>{
        contenedorSpinner.classList.remove("mostrar_spinner");
        alertaError({
            titulo: 'Error Cámara',
            mensaje: 'Se produjo un error al obtener las cámaras disponibles.'
        })
        console.error('Hubo un error:', error)
        botonCerrarModal.click();
    });
}

function lecturaExitosa(codigoTexto, codigoObjeto){
    audio.play();

    let cadenas = codigoTexto.split(' ');
    for(const cadena of cadenas) {
        if(/\d/.test(cadena)){
            inputDocumento.value = cadena.replace(/\D/g, '');
            inputDocumento.blur();
            funcionCallback();
            break;
        }
    };
    
    botonCerrarModal.click();
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


