const contenedorSpinner = document.getElementById('contenedor_spinner');

async function registrarVehiculo(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
            body: datos
        });

        if(!response.ok) throw new Error("Hubo un error en la solicitud");
        
        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        if(!navigator.onLine){
            alertaError({
                titulo: 'Error Internet',
                mensaje: 'Lo sentimos, pero parece que no tienes conexión a internet.'
            });

        }else{
            alertaError({
                titulo: 'Error Petición',
                mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
            });
        }
    }
}
export{registrarVehiculo}

async function conteoTipoVehiculo(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('conteo_tipo_vehiculo'), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);

        if(!navigator.onLine){
            alertaError({
                titulo: 'Error Internet',
                mensaje: 'Lo sentimos, pero parece que no tienes conexión a internet.'
            });

        }else{
            alertaError({
                titulo: 'Error Petición',
                mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
            });
        }
    }
}
export{conteoTipoVehiculo}

async function consultarVehiculos(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('consultar_vehiculos')+'&placa='+encodeURI(parametros.placa)+'&documento='+encodeURI(parametros.documento)+'&tipo='+encodeURI(parametros.tipo)+'&ubicacion='+encodeURI(parametros.ubicacion), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        if(!navigator.onLine){
            alertaError({
                titulo: 'Error Internet',
                mensaje: 'Lo sentimos, pero parece que no tienes conexión a internet.'
            });

        }else{
            alertaError({
                titulo: 'Error Petición',
                mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
            });
        }
    }
}
export{consultarVehiculos}

async function consultarVehiculo(placa, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('consultar_vehiculo')+'&placa='+encodeURI(placa), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        if(!navigator.onLine){
            alertaError({
                titulo: 'Error Internet',
                mensaje: 'Lo sentimos, pero parece que no tienes conexión a internet.'
            });

        }else{
            alertaError({
                titulo: 'Error Petición',
                mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
            });
        }
    }
}
export{consultarVehiculo}

async function consultarPropietarios(placa, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('consultar_propietarios')+'&placa='+encodeURI(placa), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        if(!navigator.onLine){
            alertaError({
                titulo: 'Error Internet',
                mensaje: 'Lo sentimos, pero parece que no tienes conexión a internet.'
            });

        }else{
            alertaError({
                titulo: 'Error Petición',
                mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
            });
        }
    }
}
export{consultarPropietarios}

async function eliminarPropietarioVehiculo(placa, documento, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('eliminar_propietario_vehiculo')+'&placa='+encodeURI(placa)+'&documento='+encodeURI(documento), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        contenedorSpinner.classList.remove("mostrar_spinner");
        return data;
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        if(!navigator.onLine){
            alertaError({
                titulo: 'Error Internet',
                mensaje: 'Lo sentimos, pero parece que no tienes conexión a internet.'
            });

        }else{
            alertaError({
                titulo: 'Error Petición',
                mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
            });
        }
    }
}
export{eliminarPropietarioVehiculo}

async function consultarNotificacionesVehiculo(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('consultar_notificaciones_vehiculo'), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();
        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);

        if(!navigator.onLine){
            alertaError({
                titulo: 'Error Internet',
                mensaje: 'Lo sentimos, pero parece que no tienes conexión a internet.'
            });

        }else{
            alertaError({
                titulo: 'Error Petición',
                mensaje: 'Lo sentimos, parece que se produjo un error con la petición.'
            });
        }
    }
}
export{consultarNotificacionesVehiculo}

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




