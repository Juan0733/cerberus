const contenedorSpinner = document.getElementById('contenedor_spinner');

async function validarUsuarioLogin(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php', {
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
export{validarUsuarioLogin}

async function validarContrasenaLogin(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php', {
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
export{validarContrasenaLogin}

async function conteoTotalUsuarios(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?operacion='+encodeURI('conteo_total_usuarios'));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{conteoTotalUsuarios}

async function conteoTipoUsuario(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?operacion='+encodeURI('conteo_tipo_usuario'));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{conteoTipoUsuario}

async function cerrarSesion(urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?operacion='+encodeURI('cerrar_sesion'));

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
export{cerrarSesion}

async function consultarNotificacionesUsuario(urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?operacion='+encodeURI('consultar_notificaciones_usuario'));

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
export{consultarNotificacionesUsuario}

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