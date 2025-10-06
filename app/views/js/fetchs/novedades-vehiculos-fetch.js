const contenedorSpinner = document.getElementById('contenedor_spinner');

async function registrarNovedadVehiculo(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/NovedadVehiculoController.php', {
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

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Petición';
            respuesta.mensaje = 'Lo sentimos, parece que se produjo un error con la petición.';
        }

        return respuesta;
    }
}

export{registrarNovedadVehiculo}

async function consultarNovedadesVehiculo(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/NovedadVehiculoController.php?operacion='+encodeURI('consultar_novedades_vehiculo')+'&placa='+encodeURI(parametros.placa)+'&tipo_novedad='+encodeURI(parametros.tipo_novedad)+'&fecha='+encodeURI(parametros.fecha), {
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

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Petición';
            respuesta.mensaje = 'Lo sentimos, parece que se produjo un error con la petición.';
        }

        return respuesta;
    }
}
export{consultarNovedadesVehiculo}

async function consultarNovedadVehiculo(codigoNovedad, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/NovedadVehiculoController.php?operacion='+encodeURI('consultar_novedad_vehiculo')+'&codigo_novedad='+encodeURI(codigoNovedad), {
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

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Petición';
            respuesta.mensaje = 'Lo sentimos, parece que se produjo un error con la petición.';
        }

        return respuesta;
    }
}
export{consultarNovedadVehiculo}
