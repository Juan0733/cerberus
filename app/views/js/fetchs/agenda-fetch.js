async function registrarAgenda(datos, urlBase) {
   
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
export{registrarAgenda}

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