

var formulario = document.getElementById("forma_acceso");

formulario.addEventListener("submit",function(e){
    e.preventDefault();
        let data = new FormData(formulario);
        let method=formulario.getAttribute("method");
        let action= formulario.getAttribute("action");

        let encabezados= new Headers();
    
        fetch(action, {
            method: "POST",
            body: data,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
        })
            .then(respuesta => respuesta.json())
            .then(datos => {

                if (datos['titulo'] == "pw" && datos['cod_error'] == 200) {

                    const caja02 = document.getElementById('caja_02')
                    caja02.style.display = "block"
                    document.getElementById('caja_01').style.display = "none";
                    document.getElementById('psw_usuario').focus()


                } else if (datos['titulo'] == "OK" && datos['cod_error'] == 250) {
                    window.location.href= datos.url;

                }
                if (datos.tipo == "ERROR" && datos['cod_error'] == 350) {
               
                    return manejo_de_alertas_login(datos);
                }

            });

})






function manejo_de_alertas_login(respuesta){
   
    if(respuesta.tipo =="ERROR"){

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
    }
}
