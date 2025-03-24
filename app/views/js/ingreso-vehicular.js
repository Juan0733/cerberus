const formularios_pasajero=document.querySelectorAll(".formulario-ingreso-salida-pasajeros");
const formularios_ajax_ingreso_vehiculo=document.getElementById("formulario-vehiculo");


    formularios_ajax_ingreso_vehiculo.addEventListener("click",function(){
        let num_identificacion_vehiculo=document.getElementById("num_identificacion_vehiculo").value;
        let placa_vehiculo=document.getElementById("placa_vehiculo").value;
        let observaciones_vehiculo=document.getElementById("observaciones_vehiculo").value;
        let modulo_ingreso=document.getElementById("modulo_ingreso").value;
        let data = new FormData();
        let method = 'POST'; // Método especificado
        let action = '../app/ajax/ingreso-ajax.php'; 
        data.append("num_identificacion_vehiculo", num_identificacion_vehiculo);
        data.append("placa_vehiculo", placa_vehiculo);
        data.append("observaciones_vehiculo", observaciones_vehiculo);
        data.append("modulo_ingreso", modulo_ingreso);
        let encabezados= new Headers();
        let pasajeros = document.querySelectorAll(".eliminar");


        if (pasajeros.length > 0) {
            let idsPasajeros = [];
            pasajeros.forEach(boton => {
                if (boton.id) { 
                    idsPasajeros.push(boton.id);
                }
            });
            data.append("ids_pasajeros", JSON.stringify(idsPasajeros));
            
        }
            
        fetch(action, {
            method: method,
            body: data,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
        })
        .then(respuesta => respuesta.json())
        .then(datos => {
            document.getElementById("num_identificacion_vehiculo").value=""
            document.getElementById("placa_vehiculo").value=""
            document.getElementById("observaciones_vehiculo").value=""
            document.getElementById("num_identificacion_pasajero").value=""
            document.getElementById("tabla_body_pasajeros").innerHTML=""
            document.getElementById("num_identificacion_vehiculo").focus();
            return manejo_de_alertas_ingreso(datos);
         });

    })
    formularios_pasajero.forEach(formulario => {
        formulario.addEventListener("submit",function(e){
            e.preventDefault();
            let num_documento_conductor=document.getElementById("num_identificacion_vehiculo").value;
            let numIdentificacionPasajero = document.getElementById("num_identificacion_pasajero").value;
            let tipo = document.getElementById("modulo_ingreso").value;
            if (numIdentificacionPasajero!=num_documento_conductor) {    
                
                let data = new FormData(formulario);
                let method=formulario.getAttribute("method");
                let action= formulario.getAttribute("action");

                if (tipo=="salida_vehicular_registro") {
                    data.append("modulo_ingreso_extra", "salida_pasajero_registro");
                } else if (tipo=="ingreso_vehicular_registro") {
                    data.append("modulo_ingreso_extra", "ingreso_pasajero_registro");
                }

                let contenido=document.getElementById("tabla_body_pasajeros")
                let encabezados= new Headers();
            
                fetch(action, {
                    method: method,
                    body: data,
                    headers: encabezados,
                    mode: 'cors',
                    cache: 'no-cache',
                })
                .then(respuesta => respuesta.json())
                .then(datos => {

                        // Limpiamos los campos de entrada
                        document.getElementById("num_identificacion_pasajero").value = "";
        
                        // Agregamos el enfoque al campo "num_identificacion"
                        document.getElementById("num_identificacion_pasajero").focus();
                        if (typeof datos === 'string') {
                            let tempContainer = document.createElement('div');
                            tempContainer.innerHTML = datos;
                        
                            let newRow = tempContainer.querySelector('button');
                            let newId = newRow ? newRow.getAttribute('id') : null;
                        
                            if (newId && !document.getElementById(newId)) {
                                contenido.insertAdjacentHTML('beforeend', datos);
                            } else {

                                return manejo_de_alertas_ingreso({
                                    tipoMensaje:"normal_temporizada",
                                    icono:"info",
                                    title:"Usuario ya listado como pasajero",
                                    mensaje:"Este usuario ya esta listado como pasajero en este vehiculo",

                                });
                            }
                        }else{
                            return manejo_de_alertas_ingreso(datos);
                        }
                });
            }else{
                document.getElementById("num_identificacion_pasajero").value = "";
                return manejo_de_alertas_ingreso({
                    tipoMensaje:"normal_temporizada",
                    icono:"info",
                    title:"Usuario ya listado como pasajero",
                    mensaje:"Este usuario ya esta listado como pasajero en este vehiculo",

                });
            }

        })
    })
    


function eliminarPasajero(num_documento) {
    let fila = document.getElementById(num_documento);

    if (fila) {
        fila.remove();
    } 
}

/* Buscar placas de los conductores */

/* function buscarPlaca(tipo) {
    let num_documento_conductor=document.getElementById("num_identificacion_vehiculo").value;
    if (num_documento_conductor.length>=6) {
        let data = new FormData();
        let method = 'POST'; // Método especificado
        let action = '../app/ajax/ingreso-ajax.php'; 

        data.append("modulo_ingreso_extra", "placa_conductor");
        data.append("tipo", tipo);
        data.append("num_identificacion", num_documento_conductor);

        let contenido=document.getElementById("placa_lista")
        let encabezados= new Headers();
    
        fetch(action, {
            method: method,
            body: data,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
        })
        .then(respuesta => respuesta.json())
        .then(datos => {
            console.log(datos)
            if (Array.isArray(datos)) {
                document.getElementById("placa_vehiculo").value=datos[0]
                contenido.innerHTML=datos[1];
                if (datos[1] !== undefined) {
                    let contenido=document.getElementById("tabla_body_pasajeros")
                    contenido.insertAdjacentHTML('beforeend', datos[2]);
                }
                if (datos[2] !== undefined) {
                    manejo_de_alertas_ingreso(datos[3])
                }
            } else {
                contenido.innerHTML=datos;
            }
            
        });
    }
} */

function manejo_de_alertas_ingreso(respuesta){
   
    if(respuesta.tipoMensaje =="normal"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar'
            }
        });
    }else if(respuesta.tipoMensaje =="normal_temporizada_agenda"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar',
            timer: 20000,  // 5 segundos en milisegundos
            
            timerProgressBar: true,
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar'
            }
        });
    }else if(respuesta.tipoMensaje =="normal_temporizada"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar',
            timer: 3000,  // 5 segundos en milisegundos
            timerProgressBar: true,
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar'
            }
        });
    }else if(respuesta.tipoMensaje =="normal_redireccion"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar',
                cancelButton: 'btn-cancelar' 
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(respuesta.adaptar)
                openModal(respuesta.tituloModal, respuesta.url, respuesta.adaptar) 
            } 
        });
    }else if(respuesta.tipoMensaje =="redireccionar"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                    window.location.href=respuesta.url;
            }
        });
    }
}
