async function validarUsuarioLogin(datos, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();

        return data;
    } catch (error) {
    }
}
export{validarUsuarioLogin}

async function validarContrasenaLogin(datos, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();

        return data;
    } catch (error) {
    }
}
export{validarContrasenaLogin}

async function conteoTotalUsuarios(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?accion='+encodeURI('conteoTotalUsuarios'));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
    }
}
export{conteoTotalUsuarios}

async function conteoTipoUsuario(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?accion='+encodeURI('conteoTipoUsuario'));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
    }
}
export{conteoTipoUsuario}