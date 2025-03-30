async function validarUsuarioLogin(datos, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/usuariosController.php', {
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
        const response = await fetch(urlBase+'app/controllers/usuariosController.php', {
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