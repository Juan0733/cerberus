async function registrarEntradaPeatonal(datos, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();
        return data;

    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{registrarEntradaPeatonal}

async function registrarSalidaPeatonal(datos, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();
        return data;

    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{registrarSalidaPeatonal}

async function registrarEntradaVehicular(datos, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();
        return data;

    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{registrarEntradaVehicular}

async function registrarSalidaVehicular(datos, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();
        return data;

    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{registrarSalidaVehicular}

async function validarUsuarioAptoEntrada(documento, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('validar_usuario_apto_entrada')+'&documento='+encodeURI(documento));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{validarUsuarioAptoEntrada}

async function validarUsuarioAptoSalida(documento, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('validar_usuario_apto_salida')+'&documento='+encodeURI(documento));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{validarUsuarioAptoSalida}

async function consultarMovimientos(parametros, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/MovimientoController.php?operacion='+encodeURI('consultar_movimientos')+'&puerta='+encodeURI(parametros.puerta)+'&fecha_inicio='+encodeURI(parametros.fecha_inicio)+'&fecha_fin='+encodeURI(parametros.fecha_fin)+'&documento='+encodeURI(parametros.documento)+'&placa='+encodeURI(parametros.placa));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{consultarMovimientos}