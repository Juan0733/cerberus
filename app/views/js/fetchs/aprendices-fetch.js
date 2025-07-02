const contenedorSpinner = document.getElementById("contenedor_spinner");

async function registrarAprendiz(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/AprendizController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{registrarAprendiz}

async function actualizarAprendiz(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/AprendizController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{actualizarAprendiz}

async function consultarAprendices(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/AprendizController.php?operacion='+encodeURI('consultar_aprendices')+'&ubicacion='+encodeURI(parametros.ubicacion)+'&documento='+encodeURI(parametros.documento)+'&ficha='+encodeURI(parametros.ficha));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{consultarAprendices}

async function consultarAprendiz(documento, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/AprendizController.php?operacion='+encodeURI('consultar_aprendiz')+'&documento='+encodeURI(documento));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{consultarAprendiz}

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