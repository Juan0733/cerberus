async function registrarVehiculo(datos, urlBase) {
   
    try {
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php', {
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
export{registrarVehiculo}

async function conteoTipoVehiculo(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('conteo_tipo_vehiculo'));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{conteoTipoVehiculo}

async function consultarVehiculos(parametros, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('consultar_vehiculos')+'&placa='+encodeURI(parametros.placa)+'&documento='+encodeURI(parametros.documento));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{consultarVehiculos}

async function consultarVehiculo(placa, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('consultar_vehiculo')+'&placa='+encodeURI(placa));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{consultarVehiculo}

async function consultarPropietarios(placa, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('consultar_propietarios')+'&placa='+encodeURI(placa));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{consultarPropietarios}

async function eliminarPropietarioVehiculo(placa, documento, urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?operacion='+encodeURI('eliminar_propietario_vehiculo')+'&placa='+encodeURI(placa)+'&documento='+encodeURI(documento));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
        console.error('Hubo un error:', error);
    }
}
export{eliminarPropietarioVehiculo}




