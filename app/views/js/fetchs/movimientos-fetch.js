const contenedorSpinner = document.getElementById("contenedor_spinner");

async function registrarEntradaPeatonal(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
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
export{registrarEntradaPeatonal}

async function registrarSalidaPeatonal(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
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
export{registrarSalidaPeatonal}

async function registrarEntradaVehicular(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
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
export{registrarEntradaVehicular}

async function registrarSalidaVehicular(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
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
export{registrarSalidaVehicular}

async function validarUsuarioAptoEntrada(documento, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('validar_usuario_apto_entrada')+'&documento='+encodeURI(documento));

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
export{validarUsuarioAptoEntrada}

async function validarUsuarioAptoSalida(documento, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('validar_usuario_apto_salida')+'&documento='+encodeURI(documento));

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
export{validarUsuarioAptoSalida}

async function consultarMovimientos(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('consultar_movimientos')+'&puerta='+encodeURI(parametros.puerta)+'&fecha_inicio='+encodeURI(parametros.fecha_inicio)+'&fecha_fin='+encodeURI(parametros.fecha_fin)+'&documento='+encodeURI(parametros.documento)+'&placa='+encodeURI(parametros.placa));

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
export{consultarMovimientos}

async function consultarMovimientosUsuarios(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('consultar_movimientos_usuarios')+'&puerta='+encodeURI(parametros.puerta)+'&fecha='+encodeURI(parametros.fecha)+'&jornada='+encodeURI(parametros.jornada)+'&tipo_movimiento='+encodeURI(parametros.tipo_movimiento)+'&puerta='+encodeURI(parametros.puerta));

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
export{consultarMovimientosUsuarios}

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