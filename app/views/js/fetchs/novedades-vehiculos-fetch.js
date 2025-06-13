const contenedorSpinner = document.getElementById('contenedor_spinner');

async function registrarNovedadVehiculo(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/NovedadVehiculoController.php', {
            method: 'POST',
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
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

export{registrarNovedadVehiculo}

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