async function registrarAgenda(datos, urlBase) {
    try {
        document.getElementById("contenedor_spinner").classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/AgendaController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();
        document.getElementById("contenedor_spinner").classList.remove("mostrar_spinner");
        return data;

    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{registrarAgenda}

async function actualizarAgenda(datos, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/AgendaController.php', {
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
export{actualizarAgenda}

async function consultarAgendas(parametros, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/AgendaController.php?operacion='+encodeURI('consultar_agendas')+'&fecha='+encodeURI(parametros.fecha)+'&documento='+encodeURI(parametros.documento)+'&titulo='+encodeURI(parametros.titulo));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{consultarAgendas}

async function consultarAgenda(codigo, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/AgendaController.php?operacion='+encodeURI('consultar_agenda')+'&codigo_agenda='+encodeURI(codigo));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{consultarAgenda}

async function eliminarAgenda(codigo, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/AgendaController.php?operacion='+encodeURI('eliminar_agenda')+'&codigo_agenda='+encodeURI(codigo));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{eliminarAgenda}