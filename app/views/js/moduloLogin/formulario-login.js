import {validarUsuarioLogin, validarContrasenaLogin} from '../fetchs/usuarios-fetch.js'

let tablaOrigen;
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
            data.append('accion', 'validarUsuario');    
            validarUsuarioLogin(data, urlBase).then((datos)=>{
                if(datos.tipo == 'OK'){
                    caja01.style.display = 'none';
                    caja02.style.display = 'block';
                    caja02.focus();
                    tablaOrigen = datos.tabla;
                }else if(datos.tipo == 'ERROR'){
                    manejoAlertasLogin(datos);
                };

            });
        }else if(caja01.style.display == 'none' && caja02.style.display == 'block'){
            data.append('usuario', usuario.value);
            data.append('contrasena', contrasena.value);
            data.append('tabla', tablaOrigen);
            data.append('accion', 'validarContrasena');
            validarContrasenaLogin(data, urlBase).then((datos)=>{
                if(datos.tipo == 'OK'){
                    window.location.href = datos.ruta;
                }else if(datos.tipo == 'ERROR'){
                    manejoAlertasLogin(datos);
                };
            });
        };

    });
};

function manejoAlertasLogin(respuesta){
   
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
    };
};

document.addEventListener('DOMContentLoaded', () => {
    urlBase = document.getElementById('url_base').value;
    eventoFormulario();
});
