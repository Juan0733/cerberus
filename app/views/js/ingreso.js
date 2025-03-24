const formularios_ajax_ingreso=document.querySelectorAll(".formulario-ingreso-salida");

formularios_ajax_ingreso.forEach(formulario => {
formulario.addEventListener("submit",function(e){
    e.preventDefault();
        let data = new FormData(formulario);
        let method=formulario.getAttribute("method");
        let action= formulario.getAttribute("action");


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
                document.getElementById("num_identificacion").value = "";
                document.getElementById("observaciones").value = "";
                // Agregamos el enfoque al campo "num_identificacion"
                document.getElementById("num_identificacion").focus();
                if (datos.tipoMensaje=="normal_temporizada") {
                    infoListado(datos.tipo)
                }
                return manejo_de_alertas_ingreso(datos);
        });

})})

/* Tomar cedula tambien busca la placa */
function tomarCedulaQR(tipo) {
    console.log()
    let num_documento_peatonal_entrada = tipo !== "" ? 
    (tipo !== "pasajero" 
        ? document.getElementById("num_identificacion_vehiculo") 
        : document.getElementById("num_identificacion_pasajero"))
    : document.getElementById("num_identificacion");
    if (num_documento_peatonal_entrada.value.length>15) {
        identificacion=num_documento_peatonal_entrada.value
        let numeros = identificacion.match(/\d+/g);
        num_documento_peatonal_entrada.value=numeros[0]
    }
    if (tipo!="" && tipo !="pasajero") {
        console.log("placa")
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
                
                if (Array.isArray(datos)) {
                    document.getElementById("placa_vehiculo").value=datos[0]
                    if (Array.isArray(datos[1])) {
                        contenido.innerHTML=datos[1][1];
                        if (datos[1][2] !== undefined) {
                            let contenido=document.getElementById("tabla_body_pasajeros")
                            contenido.insertAdjacentHTML('beforeend', datos[1][2]);
                        }
                        if (datos[1][3] !== undefined) {
                            manejo_de_alertas_ingreso(datos[1][3])
                        }
                    }else{
                        contenido.innerHTML=datos[1];
                        if (datos[2] !== undefined) {
                            let contenido=document.getElementById("tabla_body_pasajeros")
                            contenido.insertAdjacentHTML('beforeend', datos[2]);
                        }
                        if (datos[3] !== undefined) {
                            manejo_de_alertas_ingreso(datos[3])
                        }
                    }
                } else {
                    contenido.innerHTML=datos;
                }
                
            });
        }
    }
    
}
/* function extraerNumeroDocumentoQR(data) {
    console.log(data)
    let ccIndex = data.indexOf('C.C');
    let ccIndex_final = data.indexOf('Rh');

    
    if (ccIndex === -1) {
        ccIndex = data.indexOf('T.I');
        if (ccIndex === -1) {
            return '';
        }
    }
    for (let i = ccIndex; i < ccIndex_final; i++){
        if (i) {
            
        }
       
    }
    const startIndex = ccIndex + 4; 
    console.log(startIndex)
    let endIndex = data.indexOf(' ', startIndex);
    endIndex=endIndex-2
    console.log(startIndex+ " "+endIndex)
    
    if (endIndex === -1) {
        return data.substring(startIndex);
    } else {
        return data.substring(startIndex, endIndex);
    }
}
 */

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
            confirmButtonText: 'Aceptare',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar',
                cancelButton: 'btn-cancelar' 
            }
        }).then((result) => {
            if (result.isConfirmed) {
            
                openModal(respuesta.tituloModal, respuesta.url, respuesta.adaptar ) 
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

/* ----listado reportes---- */

function infoListado(tipo) {/* 
    let contenido=document.getElementById("contenedor_tabla") */
    let formData = new FormData()
    if (window.innerWidth > 780) {
        formData.append('tipoListado', 'tabla')
    }else{
        formData.append('tipoListado', 'card')
    }
    formData.append('lista_reportes', tipo)
    url="../app/ajax/ingreso-ajax.php"
    
    let select=document.getElementById("cantidad_ver").value;
    if (select!="") {
        formData.append("select", select);
    }
    
    fetch(url,{
        method:"POST",
        body: formData
    }).then(response => response.json())
    .then(data => {
        contenedorListado.innerHTML = data.listado
    }).catch(err => console.log(err))

}

//----- funcionalidad del front----

document.addEventListener("DOMContentLoaded", function() {
    
    var tabla_body_pasajeros = document.getElementById  ('tabla_body_pasajeros');
    var filaExistente = null;
    // var fila = tabla_pasajeros.rows;
    // if (tabla_pasajeros.rows.length < 1) {
    //         tabla_body_pasajeros.innerHTML = '<tr><td colspan="5">Sin pasajeros registrados</td></tr>'
    // }
 
    const contCardPtn = document.querySelector(".cont-card-ptn");
    const formPtn = contCardPtn.nextElementSibling;
    
    const contCardVhl = document.querySelector(".cont_card-vhl");
    const formVhl = contCardVhl.nextElementSibling;

  

  
    contCardPtn.addEventListener("click", function() {


        if (contCardVhl.style.display == "none") {
            if (window.innerWidth >= 780) {
                contCardVhl.style.display = "flex"
            }
            formVhl.style.display = "none"
            document.querySelector(".contenedor_ppal_reporte").style.display = "none";
            contCardPtn.style.display = "none"
            formPtn.style.display = "flex"
            document.getElementById("num_identificacion").focus();

        }else{
            if (window.innerWidth <= 779) {
                contCardVhl.style.display = "none"
                document.querySelector('.cont-btn-volver').style.display = 'flex'
            }
            
            contCardVhl.style.background = 'red !important'
            document.querySelector(".contenedor_ppal_reporte").style.display = "none";
            contCardPtn.style.display = "none"
            formPtn.style.display = "flex"
            document.getElementById("num_identificacion").focus();
        }

    });

    contCardVhl.addEventListener("click", function() {
        if (contCardPtn.style.display == "none") {
            
            if (window.innerWidth >= 780) {
                contCardPtn.style.display = "flex"
            }
            formPtn.style.display = "none"
            document.querySelector(".contenedor_ppal_reporte").style.display = "none";
            contCardVhl.style.display = "none"
            formVhl.style.display = "flex"
            document.getElementById("num_identificacion_vehiculo").focus();
        }else{
            
            if (window.innerWidth <= 779) {
                contCardPtn.style.display = "none"
                document.querySelector('.cont-btn-volver').style.display = 'flex'
            }
            document.querySelector(".contenedor_ppal_reporte").style.display = "none";
            contCardVhl.style.display = "none"
            formVhl.style.display = "flex"
            document.getElementById("num_identificacion_vehiculo").focus();
        }
    });

    document.querySelector('.cont-btn-volver').addEventListener("click", function() {
        
        contCardPtn.style.display = "flex"
        formPtn.style.display = "none"
        contCardVhl.style.display = "flex"
        formVhl.style.display = "none"
        document.querySelector(".contenedor_ppal_reporte").style.display = "none";
        document.querySelector('.cont-btn-volver').style.display = 'none'
    });
});

function toggleCard(clickedCard) {
    // Selecciona todas las tarjetas
    const allCards = document.querySelectorAll('.document-card');
    
    allCards.forEach(card => {
      if (card !== clickedCard) {
        card.classList.remove('active');
      }
    });
    
    clickedCard.classList.toggle('active');
  }


