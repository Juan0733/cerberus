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