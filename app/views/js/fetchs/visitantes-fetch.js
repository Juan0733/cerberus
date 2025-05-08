async function registrarVisitante(datos, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/VisitanteController.php', {
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
export{registrarVisitante}