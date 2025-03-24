let paginaActual = 1

getDataVehiculo(paginaActual)

document.getElementById("filtro").addEventListener("keyup", function() {
    getDataVehiculo(1)    
}, false)
document.getElementById("num_registros").addEventListener("change", function() {
    getDataVehiculo(paginaActual)    
}, false)




function getDataVehiculo(pagina) {
    let input = document.getElementById("filtro").value
    let num_registros = document.getElementById("num_registros").value


    let cuerpo = document.getElementById("contenedor_tabla")
    let url = document.getElementById('url').value
    let formData = new FormData()
    
    formData.append('filtro', input)
    formData.append('registros', num_registros)
    formData.append('pagina', pagina)
    
    if (window.innerWidth > 780) {
        formData.append('tipoListado', 'tabla')
    }else{
        formData.append('tipoListado', 'card')
    }
    
    

    fetch(url,{
        method:"POST",
        body: formData
    }).then(response => {
        if (!response.ok) {
            throw new Error("Error en la respuesta del servidor");
        }
        return response.json();
    })
    .then(data => {
        cuerpo.innerHTML = data.data
    }).catch(err => console.log(err))

    
}



function mostrarModalVehi(modal) {
    
    if (modal == 1) {
        openModal('Listado de propietarios de', '../app/views/inc/modales/modal-listado-ptr-vh.php', 'adaptar')
       
    }else{
        openModal('Registrar Vehiculos', '../app/views/inc/modales/modal-registro-vehiculo.php', 'adaptar', 'ninguna') 
    }
}


function eliminarVehiculoPropietario(placa, numIdentidad, nombrePropietario) {
    
    let formData = new FormData()
    if (window.innerWidth > 780) {
        formData.append('tipoListado', 'tabla')
    }else{
        formData.append('tipoListado', 'card')
    }
    
    formData.append('modulo_vehiculo', 'eliminar')
    formData.append('placa_vahiculo_anterior', placa)
    formData.append('num_identidad', numIdentidad)
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Quieres eliminar el propietario " + nombrePropietario + ' de este vehiculo.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, realizar',
        cancelButtonText: 'No, cancelar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar',
            cancelButton: 'btn-cancelar'
        }
    }).then((result) => {
        
        if (result.isConfirmed){
            fetch('../app/ajax/vehiculo-ajax.php',{
                method: 'POST',
                body: formData,
                mode: 'cors', 
                cache: 'no-cache',
            }).then(response => {
                if (!response.ok) {
                    throw new Error("Error en la respuesta del servidor");
                }
                return response.json();
            })
            .then(resultado => {
                manejo_de_alertas(resultado)
                cargarPropietarios(placa)

                if (window.innerWidth < 780) {
                    
                    const elementos = document.querySelectorAll('.propietarios');

                    if (elementos.length > 1) {
                        console.log('Hay más de un elemento con la clase "mi-clase".');
                    } else {
                        document.getElementById(placa).style.display = 'none'
                    }
                }else{
                    
                    const elementos = document.querySelectorAll('.propietarios');

                    if (elementos.length > 1) {
                        console.log('Hay más de un elemento con la clase "mi-clase".');
                    } else {
                        document.getElementById(placa).style.display = 'none'
                    }
                }
            }).catch(err => console.log(err))

        }
    })
/*  C:\xampp\htdocs\Adso04\PROYECTOS\cerberus\app\views\js\listado-vehiculos.js*/
}
function modalEditarVehiculoPropietario(placa, numIdentidad, tipoVehiculo) {
    openModal('Editar vehiculo de ' + numIdentidad, '../app/views/inc/modales/modal-editar-vehiculo.php', 'adaptar',cargarDatosVehiculo, [placa, numIdentidad, tipoVehiculo])

}
function mostrarModalVehiPropietarios(placa) {

    openModal('Listado de propietarios de '+placa, '../app/views/inc/modales/modal-listado-ptr-vh.php','ptrVehi', cargarPropietarios, [placa])
       
}