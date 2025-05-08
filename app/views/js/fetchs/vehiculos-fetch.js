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