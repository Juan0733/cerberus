/* Novedades */

const formulario_novedad=document.querySelectorAll(".formulario-novedad-persona");

formulario_novedad.forEach(formulario => {
formulario.addEventListener("submit",function(e){
    e.preventDefault();
        let data = new FormData(formulario);
        let method=formulario.getAttribute("method");
        let action= formulario.getAttribute("action");


        let encabezados= new Headers();
    
        fetch(action, {
            method: method,
            body: data,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
        })
        .then(respuesta => respuesta.json())
        .then(datos => {
                return manejo_de_alertas_ingreso(datos);
        });

})})

function manejo_de_alertas_ingreso(respuesta){
   
    if(respuesta.tipoMensaje =="normal"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar'
            }
        });
    }else if(respuesta.tipoMensaje =="normal_temporizada"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar',
            timer: 5000,  // 5 segundos en milisegundos
            timerProgressBar: true,
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar'
            }
        });
    }else if(respuesta.tipoMensaje =="normal_redireccion"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar',
                cancelButton: 'btn-cancelar' 
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = respuesta.url;
            } 
        });
    }else if(respuesta.tipoMensaje =="redireccionar"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                    window.location.href=respuesta.url;
            }
        });
    }
}