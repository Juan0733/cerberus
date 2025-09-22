const contenedorSpinner = document.getElementById('contenedor_spinner');

async function validarUsuarioLogin(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php', {
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
export{validarUsuarioLogin}

async function validarContrasenaLogin(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php', {
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
export{validarContrasenaLogin}

async function actualizarContrasenaUsuario(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php', {
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
export{actualizarContrasenaUsuario}

async function conteoTotalUsuarios(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?operacion='+encodeURI('conteo_total_usuarios'), {
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
export{conteoTotalUsuarios}

async function conteoTipoUsuario(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?operacion='+encodeURI('conteo_tipo_usuario'), {
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
export{conteoTipoUsuario}

async function cerrarSesion(urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?operacion='+encodeURI('cerrar_sesion'), {
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
export{cerrarSesion}

async function consultarNotificacionesUsuario(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?operacion='+encodeURI('consultar_notificaciones_usuario'), {
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
export{consultarNotificacionesUsuario}
