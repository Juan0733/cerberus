const contenedorSpinner = document.getElementById('contenedor_spinner');

async function registrarPermisoUsuario(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoUsuarioController.php', {
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

export{registrarPermisoUsuario}

async function consultarPermisosUsuarios(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoUsuarioController.php?operacion='+encodeURI('consultar_permisos_usuarios')+'&codigo_permiso='+encodeURI(parametros.codigo_permiso)+'&tipo_permiso='+encodeURI(parametros.tipo_permiso)+'&documento='+encodeURI(parametros.documento)+'&estado='+encodeURI(parametros.estado)+'&fecha='+encodeURI(parametros.fecha), {
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
export{consultarPermisosUsuarios}

async function consultarPermisoUsuario(codigoPermiso, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoUsuarioController.php?operacion='+encodeURI('consultar_permiso_usuario')+'&codigo_permiso='+encodeURI(codigoPermiso), {
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
export{consultarPermisoUsuario}

async function aprobarPermisoUsuario(codigoPermiso, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoUsuarioController.php?operacion='+encodeURI('aprobar_permiso_usuario')+'&codigo_permiso='+encodeURI(codigoPermiso), {
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
export{aprobarPermisoUsuario}

async function desaprobarPermisoUsuario(codigoPermiso, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoUsuarioController.php?operacion='+encodeURI('desaprobar_permiso_usuario')+'&codigo_permiso='+encodeURI(codigoPermiso), {
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
export{desaprobarPermisoUsuario}

async function consultarNotificacionesPermisosUsuario(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/PermisoUsuarioController.php?operacion='+encodeURI('consultar_notificaciones_permisos_usuario'), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

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
export{consultarNotificacionesPermisosUsuario}

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