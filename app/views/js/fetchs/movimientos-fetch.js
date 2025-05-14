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