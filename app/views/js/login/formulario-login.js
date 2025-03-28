import {validarUsuarioLogin} from '../usuarios/usuarios-api.js'

let tablaOrigen = '';

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
            
        }

    })
}