async function conteoTipoVehiculo(urlBase) {
    try {
        const response = await fetch(urlBase+'app/controllers/VehiculoController.php?accion='+encodeURI('conteoTipoVehiculo'));

        if(!response.ok) throw new Error("Error en la solicitud");

        const data = await response.json();

        return data;
        
    } catch (error) {
    }
}
export{conteoTipoVehiculo}