const contenedorSpinner = document.getElementById("contenedor_spinner");

async function registrarAgenda(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/AgendaController.php', {
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
export{registrarAgenda}

async function actualizarAgenda(datos, urlBase) {
    contenedorSpinner.classList.add("mostrar_spinner");
    try {
        const response = await fetch(urlBase+'app/controllers/AgendaController.php', {
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
export{actualizarAgenda}

async function consultarAgendas(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/AgendaController.php?operacion='+encodeURI('consultar_agendas')+'&fecha='+encodeURI(parametros.fecha)+'&documento='+encodeURI(parametros.documento)+'&titulo='+encodeURI(parametros.titulo), {
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
export{consultarAgendas}

async function consultarAgenda(codigo, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/AgendaController.php?operacion='+encodeURI('consultar_agenda')+'&codigo_agenda='+encodeURI(codigo), {
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
export{consultarAgenda}

async function eliminarAgenda(codigo, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/AgendaController.php?operacion='+encodeURI('eliminar_agenda')+'&codigo_agenda='+encodeURI(codigo), {
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
export{eliminarAgenda}
