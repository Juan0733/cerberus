const contenedorSpinner = document.getElementById("contenedor_spinner");

async function consultarFuncionarios(brigadista, ubicacion, documento, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/FuncionarioController.php?operacion='+encodeURI('consultar_funcionarios')+'&brigadista='+encodeURI(brigadista)+'&ubicacion='+encodeURI(ubicacion)+'&documento='+encodeURI(documento));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{consultarFuncionarios}

async function conteoTotalBrigadistas(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/FuncionarioController.php?operacion='+encodeURI('conteo_total_brigadistas'));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Petición',
            mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
        })
    }
}
export{conteoTotalBrigadistas}

function alertaError(respuesta){
    Swal.fire({
        icon: "error",
        iconColor: "#fe0c0c",
        title: respuesta.titulo,
        text: respuesta.mensaje,
        confirmButtonText: 'Aceptar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar'
        }
    });
}