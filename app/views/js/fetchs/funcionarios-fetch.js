async function consultarFuncionarios(brigadista, ubicacion, documento, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/FuncionarioController.php?operacion='+encodeURI('consultar_funcionarios')+'&brigadista='+encodeURI(brigadista)+'&ubicacion='+encodeURI(ubicacion)+'&documento='+encodeURI(documento));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{consultarFuncionarios}