let documentoPropietario;
let documentoPasajero;
let placaVehiculo
let formularioPasajeros;
let formularioVehicular;
let botonPeatonal;
let botonVehicular;
let urlBase;

function mostrarFormularioVehicular(){
    if (botonPeatonal.style.display == "none") {
        if (window.innerWidth >= 780) {
            botonPeatonal.style.display = "flex"
        }
        document.getElementById('formulario_peatonal').style.display = "none"
        botonVehicular.style.display = "none"
        formularioVehicular.style.display = "flex"
        placaVehiculo.focus();
    }else{
        
        if (window.innerWidth <= 779) {
            botonPeatonal.style.display = "none"
            document.querySelector('.cont-btn-volver').style.display = 'flex'
        }
        
        botonVehicular.style.display = "none"
        formularioVehicular.style.display = "flex"
        placaVehiculo.focus();
    }
}

function eventoBotonVehicular() {
    botonVehicular.addEventListener('click', function() {
        mostrarFormularioVehicular();
    });
}

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    formularioPasajeros = document.getElementById('formulario_pasajeros');
    formularioVehicular = document.getElementById('formulario_vehicular');
    botonPeatonal = document.getElementById('btn_peatonal');
    botonVehicular = document.getElementById('btn_vehicular');
    documentoPropietario = document.getElementById('documento_propietario');
    documentoPasajero = document.getElementById('documento_pasajero');
    placaVehiculo = document.getElementById('placa_vehiculo');

    eventoBotonVehicular();
})