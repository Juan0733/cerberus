const contenedorSpinner = document.getElementById("contenedor_spinner");

async function registrarEntradaPeatonal(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
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
export{registrarEntradaPeatonal}

async function registrarSalidaPeatonal(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
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
export{registrarSalidaPeatonal}

async function registrarEntradaVehicular(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
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
export{registrarEntradaVehicular}

async function registrarSalidaVehicular(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
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
export{registrarSalidaVehicular}

async function validarUsuarioAptoEntrada(documento, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('validar_usuario_apto_entrada')+'&documento='+encodeURI(documento), {
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
export{validarUsuarioAptoEntrada}

async function validarUsuarioAptoSalida(documento, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('validar_usuario_apto_salida')+'&documento='+encodeURI(documento), {
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
export{validarUsuarioAptoSalida}

async function consultarMovimientos(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('consultar_movimientos')+'&puerta='+encodeURI(parametros.puerta)+'&fecha_inicio='+encodeURI(parametros.fecha_inicio)+'&fecha_fin='+encodeURI(parametros.fecha_fin)+'&documento='+encodeURI(parametros.documento)+'&placa='+encodeURI(parametros.placa), {
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
export{consultarMovimientos}

async function consultarMovimiento(codigoMovimiento, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('consultar_movimiento')+'&codigo_movimiento='+encodeURI(codigoMovimiento), {
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
export{consultarMovimiento}

async function consultarMovimientosUsuarios(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('consultar_movimientos_usuarios')+'&puerta='+encodeURI(parametros.puerta)+'&fecha='+encodeURI(parametros.fecha)+'&jornada='+encodeURI(parametros.jornada)+'&tipo_movimiento='+encodeURI(parametros.tipo_movimiento)+'&puerta='+encodeURI(parametros.puerta), {
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
export{consultarMovimientosUsuarios}

async function consultarUltimoMovimientoUsuario(documento, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('consultar_ultimo_movimiento_usuario')+'&documento='+encodeURI(documento), {
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
export{consultarUltimoMovimientoUsuario}
