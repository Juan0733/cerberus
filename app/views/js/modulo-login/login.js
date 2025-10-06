import {validarUsuarioLogin, validarContrasenaLogin} from '../fetchs/usuarios-fetch.js'

let urlBase;

function eventoFormulario(){
    const formularioLogin = document.getElementById('forma_acceso');

    formularioLogin.addEventListener('submit', (e)=>{
        e.preventDefault();
        
        let data = new FormData();
        const usuario = document.getElementById('num_id_usuario');
        const contrasena = document.getElementById('psw_usuario');
        const caja01 = document.getElementById('caja_01');
        const caja02 = document.getElementById('caja_02');

        if(caja01.style.display != 'none' && caja02.style.display != 'block'){

            data.append('usuario', usuario.value);
            data.append('operacion', 'validar_usuario');    
            validarUsuarioLogin(data, urlBase).then((respuesta)=>{
                if(respuesta.tipo == 'OK'){
                    caja01.style.display = 'none';
                    caja02.style.display = 'block';
                    setTimeout(()=>{
                        contrasena.focus();
                    }, 250)
                }else if(respuesta.tipo == 'ERROR'){
                    alertaError(respuesta);
                };
            });

        }else if(caja01.style.display == 'none' && caja02.style.display == 'block'){
            data.append('usuario', usuario.value);
            data.append('contrasena', contrasena.value);
            data.append('operacion', 'validar_contrasena');
            validarContrasenaLogin(data, urlBase).then((respuesta)=>{
                if(respuesta.tipo == 'OK'){
                    window.location.replace(respuesta.ruta);
                }else if(respuesta.tipo == 'ERROR'){
                    alertaError(respuesta);
                };
            });
        };

    });
};

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


document.addEventListener('DOMContentLoaded', () => {
    urlBase = document.getElementById('url_base').value;
    eventoFormulario();
});
