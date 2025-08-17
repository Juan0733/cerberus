const contenedorSpinner = document.getElementById("contenedor_spinner");

async function consultarFichas(urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/FichaController.php?operacion='+encodeURI('consultar_fichas'), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        if(!navigator.onLine){
            alertaError({
                titulo: 'Error Internet',
                mensaje: 'Lo sentimos, pero parece que no tienes conexión a internet.'
            });

        }else{
            alertaError({
                titulo: 'Error Petición',
                mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
            });
        }
    }
}
export{consultarFichas}

async function consultarFicha(ficha, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/FichaController.php?operacion='+encodeURI('consultar_ficha')+'&ficha='+encodeURI(ficha), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        if(!navigator.onLine){
            alertaError({
                titulo: 'Error Internet',
                mensaje: 'Lo sentimos, pero parece que no tienes conexión a internet.'
            });

        }else{
            alertaError({
                titulo: 'Error Petición',
                mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
            });
        }
    }
}
export{consultarFicha}

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