const contenedorSpinner = document.getElementById('contenedor_spinner');

async function registrarNovedadUsuario(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/NovedadUsuarioController.php', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
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

export{registrarNovedadUsuario}

async function consultarNovedadesUsuario(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/NovedadUsuarioController.php?operacion='+encodeURI('consultar_novedades_usuario')+'&documento='+encodeURI(parametros.documento)+'&tipo_novedad='+encodeURI(parametros.tipo_novedad)+'&fecha='+encodeURI(parametros.fecha), {
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
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{consultarNovedadesUsuario}

async function consultarNovedadUsuario(codigoNovedad, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/NovedadUsuarioController.php?operacion='+encodeURI('consultar_novedad_usuario')+'&codigo_novedad='+encodeURI(codigoNovedad), {
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
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{consultarNovedadUsuario}

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