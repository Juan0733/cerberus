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
        console.error('Hubo un error:', error);
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
        console.error('Hubo un error:', error);
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
    }
}
export{conteoTipoUsuario}

async function cerrarSesion(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/UsuarioController.php?operacion='+encodeURI('cerrar_sesion'));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{cerrarSesion}