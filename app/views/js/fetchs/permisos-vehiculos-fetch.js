const contenedorSpinner = document.getElementById('contenedor_spinner');

async function registrarPermisoVehiculo(datos, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoVehiculoController.php', {
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

export{registrarPermisoVehiculo}

async function consultarPermisosVehiculos(parametros, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoVehiculoController.php?operacion='+encodeURI('consultar_permisos_vehiculos')+'&codigo_permiso='+encodeURI(parametros.codigo_permiso)+'&tipo_permiso='+encodeURI(parametros.tipo_permiso)+'&documento='+encodeURI(parametros.documento)+'&estado='+encodeURI(parametros.estado)+'&fecha='+encodeURI(parametros.fecha));

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
export{consultarPermisosVehiculos}

async function consultarPermisoVehiculo(codigoPermiso, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoVehiculoController.php?operacion='+encodeURI('consultar_permiso_vehiculo')+'&codigo_permiso='+encodeURI(codigoPermiso));

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
export{consultarPermisoVehiculo}

async function aprobarPermisoVehiculo(codigoPermiso, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoVehiculoController.php?operacion='+encodeURI('aprobar_permiso_vehiculo')+'&codigo_permiso='+encodeURI(codigoPermiso));

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
export{aprobarPermisoVehiculo}

async function desaprobarPermisoVehiculo(codigoPermiso, urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoVehiculoController.php?operacion='+encodeURI('desaprobar_permiso_vehiculo')+'&codigo_permiso='+encodeURI(codigoPermiso));

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
export{desaprobarPermisoVehiculo}

async function consultarNotificacionesPermisosVehiculo(urlBase) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/controllers/PermisoVehiculoController.php?operacion='+encodeURI('consultar_notificaciones_permisos_vehiculo'));

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
export{consultarNotificacionesPermisosVehiculo}

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