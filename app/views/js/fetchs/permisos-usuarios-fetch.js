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

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Petición';
            respuesta.mensaje = 'Lo sentimos, parece que se produjo un error con la petición.';
        }

        return respuesta;
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

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Petición';
            respuesta.mensaje = 'Lo sentimos, parece que se produjo un error con la petición.';
        }

        return respuesta;
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

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Petición';
            respuesta.mensaje = 'Lo sentimos, parece que se produjo un error con la petición.';
        }

        return respuesta;
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

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Petición';
            respuesta.mensaje = 'Lo sentimos, parece que se produjo un error con la petición.';
        }

        return respuesta;
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

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Petición';
            respuesta.mensaje = 'Lo sentimos, parece que se produjo un error con la petición.';
        }

        return respuesta;
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

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Petición';
            respuesta.mensaje = 'Lo sentimos, parece que se produjo un error con la petición.';
        }

        return respuesta;
    }
}
export{consultarNotificacionesPermisosUsuario}
